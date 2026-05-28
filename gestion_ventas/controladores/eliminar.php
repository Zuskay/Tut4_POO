<?php
session_start();
require_once '../modelos/conexion.php';

// Validar que el ID venga por GET
if (!isset($_GET['id'])) {
    header('Location: ../vistas/listado.php');
    exit;
}

$id = intval($_GET['id']);

// Eliminar venta usando el Modelo
$venta = new Venta($conexion);
if ($venta->eliminarVenta($id)) {
    $_SESSION['mensaje'] = '✅ Venta eliminada exitosamente y stock recuperado';
    $_SESSION['tipo'] = 'success';
} else {
    $_SESSION['mensaje'] = '❌ Error al eliminar la venta';
    $_SESSION['tipo'] = 'error';
}

header('Location: ../vistas/listado.php');
exit;
?>
