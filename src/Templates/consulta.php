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
    <title>CONSULTA DE USUARIOS</title>
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
            padding: 1em;
        }

        #table-container {
            overflow-x: auto;
        }

        #logo {
            width: 50%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #80808036;
        }


        @media only screen and (max-width: 600px) {
            body {
                width: 95%;
            }

            #logo {
                width: 100%;
            }


        }
    </style>
    <script>
        function loadDoc() {
            var xhttp = new XMLHttpRequest();
            var url = '/users';

            xhttp.open('GET', url, true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    let json_response = JSON.parse(this.responseText);
                    let data = json_response.data;
                    for (let i = 0; i < data.length; i++) {
                        let row = "<tr>" +
                            "<td>" + data[i].nombre + "</td>" +
                            "<td>" + data[i].apellido + "</td>" +
                            "<td>" + data[i]['email'] + "</td>" +
                            "<td>" + data[i]['dni'] + "</td>" +
                            "<td>" + data[i]['movil'] + "</td>" +
                            "</tr>";

                        document.getElementById("usersTable").innerHTML += row;
                    }

                }
            };
            xhttp.send();
        }
    </script>
</head>

<body onload="loadDoc()">
    <div id="content">
        <div id="table-container">
            <table id="usersTable">
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>DNI</th>
                    <th>Teléfono</th>
                </tr>

            </table>
            <a href="/">Alta de usuarios</a>
        </div>
    </div>
</body>

</html>