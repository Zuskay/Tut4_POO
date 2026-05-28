<?php
session_start();
require_once '../modelos/conexion.php';

// Validar que el ID venga por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    header('Location: ../vistas/listado.php');
    exit;
}

// Obtener y validar datos
$id = intval($_POST['id']);
$nombre = trim($_POST['nombre'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$correo = trim($_POST['correo'] ?? '');

// Validaciones
if (empty($nombre) || empty($telefono) || empty($direccion) || empty($correo)) {
    $_SESSION['mensaje'] = 'Todos los campos son obligatorios';
    $_SESSION['tipo'] = 'error';
    header('Location: ../vistas/editar.php?id=' . $id);
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['mensaje'] = 'El correo electrónico no es válido';
    $_SESSION['tipo'] = 'error';
    header('Location: ../vistas/editar.php?id=' . $id);
    exit;
}

// Actualizar usando el Modelo
$contacto = new Contacto($conexion);
if ($contacto->actualizar($id, $nombre, $telefono, $direccion, $correo)) {
    $_SESSION['mensaje'] = '✅ Contacto actualizado exitosamente';
    $_SESSION['tipo'] = 'success';
} else {
    $_SESSION['mensaje'] = '❌ Error al actualizar el contacto';
    $_SESSION['tipo'] = 'error';
}

header('Location: ../vistas/listado.php');
exit;
?>
