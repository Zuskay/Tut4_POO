<?php
// Controlador que redirige a la vista de detalles
session_start();
require_once '../modelos/conexion.php';

if (!isset($_GET['id'])) {
    header('Location: ../vistas/listado.php');
    exit;
}

$id = intval($_GET['id']);
$venta = new Venta($conexion);
$datos = $venta->obtenerVentaPorId($id);

if (!$datos) {
    $_SESSION['mensaje'] = 'Venta no encontrada';
    $_SESSION['tipo'] = 'error';
    header('Location: ../vistas/listado.php');
    exit;
}

// Pasar los datos a la vista
include '../vistas/ver.php';
?>
