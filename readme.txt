
PRUEBA TÉCNICA - GERARD DE HARO RAMIREZ - gerard.deharo@gmail.com

Instalación:

Este proyecto se ha pensado para ser instalado en un Apache y en una BBDD MySQL.

1. Ejecutar archivo database.sql

	-> Crea la base de datos 'proba_gdh'
	-> Crea la tabla 'users'
	
	//opcional//
	->Crea usuario 'user_gdh' con password 'user_gdh'
	->Le da permisos a user_gdh para la base de datos 'proba_gdh'

2. Configurar en la classe DBmanager los datos de conexión, presente en el directorio 
	
	PruebaTecnica\src\DataBase\DBmanager.php


3. Esta aplicación tiene composer como gestor de dependencias. 
	
	Descargar->https://getcomposer.org/

4. Instalar dependencias

	comanda-> composer install