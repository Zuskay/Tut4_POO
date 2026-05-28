<?php
session_start();
require_once '../modelos/conexion.php';

// Validar que el ID venga por GET
if (!isset($_GET['id'])) {
    header('Location: ../vistas/listado.php');
    exit;
}

$id = intval($_GET['id']);

// Eliminar usando el Modelo
$contacto = new Contacto($conexion);
if ($contacto->eliminar($id)) {
    $_SESSION['mensaje'] = '✅ Contacto eliminado exitosamente';
    $_SESSION['tipo'] = 'success';
} else {
    $_SESSION['mensaje'] = '❌ Error al eliminar el contacto';
    $_SESSION['tipo'] = 'error';
}

header('Location: ../vistas/listado.php');
exit;
?>
