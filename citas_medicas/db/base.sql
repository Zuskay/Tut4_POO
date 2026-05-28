CREATE DATABASE citas_medicas;
USE citas_medicas;

CREATE TABLE citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    motivo TEXT NOT NULL
);