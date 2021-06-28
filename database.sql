CREATE DATABASE IF NOT EXISTS proba_gdh;

USE proba_gdh;

CREATE TABLE users (
  id int UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre varchar(50) NOT NULL,
  apellido varchar(50) NOT NULL,
  email varchar(255) NOT NULL,
  dni varchar(9) NOT NULL,
  movil varchar(9) NOT NULL,
  PRIMARY KEY (id)
);

CREATE USER IF NOT EXISTS 'user_gdh'@'%' IDENTIFIED BY 'user_gdh';
GRANT ALL PRIVILEGES ON proba_gdh.* TO 'user_gdh'@'%';