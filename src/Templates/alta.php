<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALTA DE USUARIOS</title>
    <style>
        body {
            background-color: #61C9A8;
            width: 80%;
            margin: auto;
            font-family: system-ui;
            color: #1b2021;
        }

        #content {
            background-color: white;
            display: flex;
            flex-direction: column;
            text-align: center;
            margin-top: 5%;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        #body-form {
            margin-left: 10%;
            margin-right: 10%;
        }

        .row input {
            width: 45%;
            height: 5vh;
            margin-bottom: 1rem;
            border: 2px solid transparent;
            border-bottom: 2px solid #1b2021;
        }

        input[type=text]:focus {
            border: 2px solid #1b2021;
        }

        input[type=email]:focus {
            border: 2px solid #1b2021;
        }

        #submit {
            background-color: #3A86FF;
            border: none;
            color: white;
            cursor: pointer;
            width: 30vw;
            height: 5vh;
            font-size: 1rem;
        }

        #submit:hover {
            background-color: #70a7ff;
            border: 2px solid #3a86ff;
        }

        #submit:active {
            background-color: #0056e0;
        }

        #footer-form {
            padding: 1rem;
        }

        #logo {
            width: 50%;
        }

        @media only screen and (max-width: 600px) {
            body {
                width: 95%;
            }

            #logo {
                width: 100%;
            }

            .row {
                flex-direction: column;
            }

            .row input {
                width: 100%;
                height: 8vh;
            }

            #submit {
                width: 60vw;
                height: 6vh;
                font-size: 1rem;
            }
        }
    </style>
    <script>
        function getValues() {
            let form_values = document.getElementsByClassName("form_control");
            let values = [];
            for (var i = 0; i < form_values.length; i++) {
                values[form_values[i].name] = form_values[i].value;
            }
            return values;
        }

        function testForm() {
            let form_values = document.getElementsByClassName("form_control");
            form_values[0].value = "Nombre_Test";
            form_values[1].value = "Apellido_Test";
            form_values[2].value = "test@mail.xxx";
            form_values[3].value = "test@mail.xxx";
            form_values[4].value = "18014236S";
            form_values[5].value = "645558912";
        }

        function validarNIF(dni) {
            var numero;
            var letr;
            var letra;
            var expresion_regular_dni;

            expresion_regular_dni = /^\d{8}[a-zA-Z]$/;

            if (expresion_regular_dni.test(dni) == true) {
                numero = dni.substr(0, dni.length - 1);
                letr = dni.substr(dni.length - 1, 1);
                numero = numero % 23;
                letra = 'TRWAGMYFPDXBNJZSQVHLCKET';
                letra = letra.substring(numero, numero + 1);
                if (letra != letr.toUpperCase()) {
                    //Dni erroneo, la letra del NIF no se corresponde
                    return false;
                } else {
                    //Dni correcto
                    return true;
                }
            } else {
                //Dni erroneo, formato no válido
                return false;
            }
        }

        function validarLength(values) {
            let valuesLength = 0;
            let form_values_length = document.getElementsByClassName("form_control").length;
            for (const key in values) {
                if (values[key]) {
                    valuesLength++;
                }

            }
            if (valuesLength == form_values_length) {
                return true;
            } else {
                return false;
            }
        }

        function validarMobil(movil) {
            expresion_regular_telefono = /^[6-7][0-9]{8}$/;
            if (expresion_regular_telefono.test(movil)) {
                return true;
            } else {
                return false;
            }
        }

        function validarMail(mail) {
            expresion_regular_mail = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
            if (expresion_regular_mail.test(mail)) {
                return true;
            } else {
                return false;
            }
        }

        function validarForm(formValues) {
            //validar todas las funciones
            if (!validarLength(formValues)) {
                return "ERROR: Campos vacíos en el formulario";
            }
            if (!validarNIF(formValues['dni'])) {
                return "ERROR: DNI Invalido";
            }
            if (!validarMail(formValues['email'])) {
                return "ERROR: Email Invalido";
            }
            if (formValues['email'] !== formValues['rep_email']) {
                return "ERROR: Email Diferente";
            }
            if (!validarMobil(formValues['movil'])) {
                return "ERROR: Numero de telefono invalido";
            }
            //si todas dan true, devolvemos true como respuesta a la validación
            return true;

        }

        function loadDoc() {
            var xhttp = new XMLHttpRequest();
            var url = '/user';

            xhttp.open('POST', url, true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                   let json_response =  JSON.parse(this.responseText);
                    
                   messageBox(json_response.message);

                } 
            };
            var formValues = getValues();
            var params = 'nombre=' + formValues['nombre'] + '&';
            params += 'apellido=' + formValues['apellido'] + '&';
            params += 'email=' + formValues['email'] + '&';
            params += 'rep_email=' + formValues['rep_email'] + '&';
            params += 'dni=' + formValues['dni'] + '&';
            params += 'movil=' + formValues['movil'];
            xhttp.send(params);
        }

        function submitForm() {
            messageBox(false);
            let isValid = validarForm(getValues());
            if (isValid === true) {
                loadDoc();
            } else {
                messageBox(isValid);
            }
        }

        function messageBox(message) {
            if (message) {
                let p = "<p><b>" + message + "</b></p>";
                document.getElementById("messageBox").innerHTML = p;
            } else {
                document.getElementById("messageBox").innerHTML = "";
            }


        }
    </script>
</head>

<body>


    <div id="content">
        <form id="alta_users">
            <div id="header_form">
                <img src="img/logo.png" id="logo">
                <p>Por favor, rellena los campos siguientes</p>
            </div>
            <div id="body-form">
                <div class="row">
                    <input type="text" name="nombre" placeholder="Nombre" id="nombre" class="form_control">
                    <input type="text" name="apellido" placeholder="Apellido" id="apellido" class="form_control">
                </div>
                <div class="row">
                    <input type="email" name="email" placeholder="Email" id="email" class="form_control">
                    <input type="email" name="rep_email" placeholder="Repetir email" id="rep_email" class="form_control">
                </div>
                <div class="row">
                    <input type="text" name="dni" placeholder="DNI" id="dni" class="form_control">
                    <input type="text" name="movil" placeholder="Movil" id="movil" class="form_control">
                </div>
            </div>
            <div id="footer-form">
                <input type="button" name="submit" id="submit" value="Enviar" onclick="submitForm()">
            </div>

        </form>
        <div id="messageBox">

        </div>
    </div>

    <script>
        testForm();
    </script>
</body>

</html>