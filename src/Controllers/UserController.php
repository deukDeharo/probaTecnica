<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\User;
use App\DataBase\DBmanager;

class UserController
{
    public function getAllUsers($request, $response, $args)
    {
        //ABRIR CONEXION A BASE DE DATOS
        $db = new DBmanager();
        $connection = $db->connect();
        if (!$connection) {
            //500 : CONEXION A BASE DE DATOS FALLIDA
            $message = array('message' => "Conexión a base de datos fallida");
            return $this->createResponse($response, 500, $message);
        }
        //SELECCIONAR TODOS LOS USUARIO
        $result =$this->selectAllUsers($connection);
        if (!$result) {
            //500: ERROR AL SELECCIONAR
            $db->disconnect($connection);
            $message = array('message' => "Error en el servidor");
            return $this->createResponse($response, 500, $message);
        }
        $this->fetchUsers($result);



    }

    public function create($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $isValid = $this->validateData($data);
        if ($isValid !== true) {
            //422: ERROR DE VALIDACION
            $message = array('message' => 'Datos inválidos', 'data' => $isValid);
            return $this->createResponse($response, 422, $message);
        }

        //INSTANCIAR USUARIO CON LOS DATOS VALIDADOS
        $newUser = $this->setUserByParsedBody($data);

        //ABRIR CONEXION A BASE DE DATOS
        $db = new DBmanager();
        $connection = $db->connect();
        if (!$connection) {
            //500 : CONEXION A BASE DE DATOS FALLIDA
            $message = array('message' => "Conexión a base de datos fallida");
            return $this->createResponse($response, 500, $message);
        }

        //COMPROBAR EMAIL
        if (!$this->isUniqueEmail($newUser, $connection)) {
            //400: USUARIO YA EXISTE
            $db->disconnect($connection);
            $message = array('message' => "Usuario ya existe");
            return $this->createResponse($response, 400, $message);
        }

        //INSERTAR USUARIO
        if (!$this->insertUser($newUser, $connection)) {
            //500: INSERCION FALLIDA
            $db->disconnect($connection);
            $message = array('message' => "Inserción fallida");
            return $this->createResponse($response, 500, $message);
        }

        //CERRAR CONEXION
        $db->disconnect($connection);

        //201: USUARIO CREADO 
        $message = array('message' => "Usuario creado correctamente");
        return $this->createResponse($response, 201, $message);
    }

    function createResponse($response, $status, $message)
    {
        $payload = json_encode($message);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }

    // CONEXION A BASE DE DATOS

    function insertUser($user, $connection)
    {
        $query = "INSERT INTO users (nombre,apellido,email,dni,movil) VALUES (?,?,?,?,?)";
        if ($stmt = mysqli_prepare($connection, $query)) {
            $nombre = $user->getNombre();
            $apellido = $user->getApellido();
            $email = $user->getEmail();
            $dni = $user->getDni();
            $movil = $user->getMovil();

            mysqli_stmt_bind_param($stmt, 'sssss', $nombre, $apellido, $email, $dni, $movil);
            if (mysqli_stmt_execute($stmt)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function isUniqueEmail($user, $connection)
    {
        $query = "SELECT id FROM users where email ='" . $user->getEmail() . "'";
        if ($result = mysqli_query($connection, $query)) {
            if (mysqli_num_rows($result) > 0) {
                return false;
            } else {
                return true;
            }
        }
    }

    function selectAllUsers($connection)
    {
        $query = "SELECT * FROM users";
        $result = mysqli_query($connection, $query);
        return $result;
            
    }
    function fetchUsers($result){
        $users = [];
        while($registro = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            var_dump($registro);
            die();
        }
    }

    //INSTANCIAR UN USUARIO A PARTIR DEL BODY DE LA REQUEST
    public function setUserByParsedBody($data)
    {
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $email = $data['email'];
        $dni = $data['dni'];
        $movil = $data['movil'];

        $user = new User($nombre, $apellido, $email, $dni, $movil);

        return $user;
    }






    //FUNCIONES DE VALIDACION
    function validateData($data)
    {
        $errorMessages = [];
        if (!isset($data['nombre']) || !$data['nombre']) {
            $errorMessages["nombre"] = "ERROR: FALTAN CAMPOS DE FORMULARIO POR RELLENAR";
        }
        if (!isset($data['apellido']) || !$data['apellido']) {
            $errorMessages["apellido"] = "ERROR: FALTAN CAMPOS DE FORMULARIO POR RELLENAR";
        }
        if (!isset($data['email']) || !$this->isValidEmail($data['email'])) {
            $errorMessages["email"] = "ERROR: EMAIL INVALIDO";
        }
        if ($data['email'] != $data['rep_email']) {
            $errorMessages["rep_email"] = "ERROR: LOS DOS CORREOS SON DIFERENTES";
        }
        if (!isset($data['dni']) || !$this->isValidDNI($data['dni'])) {
            $errorMessages["dni"] = "ERROR: DNI INVALIDO";
        }
        if (!isset($data['movil']) || !$this->isValidMovil($data['movil'])) {
            $errorMessages["movil"] = "ERROR: NÚMERO DE TELÉFONO INVALIDO";
        }

        if (count($errorMessages) == 0) {
            return true;
        } else {
            return $errorMessages;
        }
    }

    function isValidDNI($dni)
    {
        $letra = substr($dni, -1);
        $numeros = substr($dni, 0, -1);

        if (
            substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros % 23, 1) == $letra
            && strlen($letra) == 1 && strlen($numeros) == 8
        ) {
            return  true;
        } else {

            return false;
        }
    }


    function isValidLength($data)
    {
        if (count($data) == 6) {
            return true;
        } else {
            return false;
        }
    }

    function isValidMovil($movil)
    {
        $expresion_regular_telefono = '~^[6-7][0-9]{8}$~';
        if (preg_match($expresion_regular_telefono, $movil)) {
            return true;
        } else {
            return false;
        }
    }
    function isValidEmail($email)
    {
        $expresion_regular_email = "~^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$~";
        if (preg_match($expresion_regular_email, $email)) {
            return true;
        } else {
            return false;
        }
    }
}
