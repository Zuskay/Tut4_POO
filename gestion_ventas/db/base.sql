-- Crear base de datos
CREATE DATABASE IF NOT EXISTS ventas_db;
USE ventas_db;

-- Crear tabla productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(100),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla ventas
CREATE TABLE IF NOT EXISTS ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    fecha_venta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

-- Insertar datos de ejemplo
INSERT INTO productos (nombre, precio, stock) VALUES
('Laptop Dell', 1200.00, 15),
('Mouse Logitech', 25.00, 50),
('Teclado Mecánico', 120.00, 30);

INSERT INTO clientes (nombre, telefono, email) VALUES
('Empresa Tech', '3001234567', 'empresa@tech.com'),
('Juan Desarrollador', '3007654321', 'juan@dev.com'),
('María Diseñadora', '3102345678', 'maria@design.com');

INSERT INTO ventas (cliente_id, producto_id, cantidad, precio_unitario, total) VALUES
(1, 1, 2, 1200.00, 2400.00),
(2, 2, 1, 25.00, 25.00),
(3, 3, 1, 120.00, 120.00);
