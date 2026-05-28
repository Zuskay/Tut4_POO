<?php
// Controlador que redirige a la vista de edición
// Sirve como intermediario para mantener la arquitectura MVC

session_start();
require_once '../modelos/conexion.php';

if (!isset($_GET['id'])) {
    header('Location: ../vistas/listado.php');
    exit;
}

$id = intval($_GET['id']);
$contacto = new Contacto($conexion);
$datos = $contacto->obtenerPorId($id);

if (!$datos) {
    $_SESSION['mensaje'] = 'Contacto no encontrado';
    $_SESSION['tipo'] = 'error';
    header('Location: ../vistas/listado.php');
    exit;
}

// Pasar los datos a la vista
include '../vistas/editar.php';
?>
