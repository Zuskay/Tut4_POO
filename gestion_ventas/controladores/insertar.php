<?php
session_start();
require_once '../modelos/conexion.php';

// Validar que los datos vengan por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../vistas/formulario.php');
    exit;
}

// Obtener y validar datos
$cliente_id = intval($_POST['cliente_id'] ?? 0);
$producto_id = intval($_POST['producto_id'] ?? 0);
$cantidad = intval($_POST['cantidad'] ?? 0);
$precio_unitario = floatval($_POST['precio_unitario'] ?? 0);

// Validaciones básicas
if ($cliente_id <= 0 || $producto_id <= 0 || $cantidad <= 0 || $precio_unitario <= 0) {
    $_SESSION['mensaje'] = 'Todos los campos son requeridos y válidos';
    $_SESSION['tipo'] = 'error';
    header('Location: ../vistas/formulario.php');
    exit;
}

// Insertar venta usando el Modelo
$venta = new Venta($conexion);
if ($venta->insertarVenta($cliente_id, $producto_id, $cantidad, $precio_unitario)) {
    $_SESSION['mensaje'] = '✅ Venta registrada exitosamente';
    $_SESSION['tipo'] = 'success';
} else {
    $_SESSION['mensaje'] = '❌ Error al registrar la venta';
    $_SESSION['tipo'] = 'error';
}

// Redirigir al listado
header('Location: ../vistas/listado.php');
exit;
?>
