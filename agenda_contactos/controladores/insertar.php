<?php
session_start();
require_once '../modelos/conexion.php';

// Validar que los datos vengan por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../vistas/formulario.php');
    exit;
}

// Obtener y validar datos
$nombre = trim($_POST['nombre'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$correo = trim($_POST['correo'] ?? '');

// Validaciones básicas
if (empty($nombre) || empty($telefono) || empty($direccion) || empty($correo)) {
    $_SESSION['mensaje'] = 'Todos los campos son obligatorios';
    $_SESSION['tipo'] = 'error';
    header('Location: ../vistas/formulario.php');
    exit;
}

// Validar email
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['mensaje'] = 'El correo electrónico no es válido';
    $_SESSION['tipo'] = 'error';
    header('Location: ../vistas/formulario.php');
    exit;
}

// Insertar en la base de datos usando el Modelo
$contacto = new Contacto($conexion);
if ($contacto->insertar($nombre, $telefono, $direccion, $correo)) {
    $_SESSION['mensaje'] = '✅ Contacto guardado exitosamente';
    $_SESSION['tipo'] = 'success';
} else {
    $_SESSION['mensaje'] = '❌ Error al guardar el contacto';
    $_SESSION['tipo'] = 'error';
}

// Redirigir al listado
header('Location: ../vistas/listado.php');
exit;
?>
