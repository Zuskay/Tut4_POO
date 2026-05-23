CREATE DATABASE IF NOT EXISTS cursos_db;
USE cursos_db;

CREATE TABLE docentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100)
);

CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    creditos INT,
    docente_id INT,
    FOREIGN KEY (docente_id) REFERENCES docentes(id)
);