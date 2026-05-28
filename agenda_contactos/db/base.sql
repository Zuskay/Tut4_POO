-- Crear base de datos
CREATE DATABASE IF NOT EXISTS agenda_db;
USE agenda_db;

-- Crear tabla contactos
CREATE TABLE IF NOT EXISTS contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar datos de ejemplo
INSERT INTO contactos (nombre, telefono, direccion, correo) VALUES
('Juan Pérez', '3001234567', 'Calle 10 #20-30, Bogotá', 'juan@example.com'),
('María García', '3007654321', 'Carrera 5 #15-45, Medellín', 'maria@example.com'),
('Carlos López', '3102345678', 'Avenida 7 #50-60, Cali', 'carlos@example.com');
