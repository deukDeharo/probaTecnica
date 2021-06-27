<?php

namespace App\Models;

class User{

    private $nombre;
    private $apellido;
    private $email;
    private $dni;
    private $movil;

    public function __construct($nombre,$apellido,$email,$dni,$movil){
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->dni = $dni;
        $this->movil = $movil;
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getDni(){
        return $this->dni;
    }
    public function getMovil(){
        return $this->movil;
    }

    public function setNombre($param){
        $this->nombre = $param;
    }
    public function setApellido($param){
        $this->apellido = $param;
    }
    public function setEmail($param){
        $this->email = $param;
    }
    public function setDni($param){
        $this->dni = $param;
    }
    public function setMovil($param){
        $this->movil = $param;
    }


    

    

}

