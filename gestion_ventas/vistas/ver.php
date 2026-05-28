<?php
session_start();
require_once '../modelos/conexion.php';

if (!isset($_GET['id'])) {
    header('Location: ../vistas/listado.php');
    exit;
}

$venta = new Venta($conexion);
$datos = $venta->obtenerVentaPorId($_GET['id']);

if (!$datos) {
    $_SESSION['mensaje'] = 'Venta no encontrada';
    $_SESSION['tipo'] = 'error';
    header('Location: ../vistas/listado.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Venta - Gestión de Ventas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }
        
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }
        
        .detail-group {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .detail-label {
            color: #667eea;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .detail-value {
            color: #333;
            font-size: 18px;
            font-weight: 500;
        }
        
        .detail-value.amount {
            color: #27ae60;
            font-size: 24px;
            font-weight: 700;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        button, a {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
            display: block;
        }
        
        .btn-delete {
            background: #e74c3c;
            color: white;
        }
        
        .btn-delete:hover {
            background: #c0392b;
        }
        
        .btn-back {
            background: #f0f0f0;
            color: #333;
        }
        
        .btn-back:hover {
            background: #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>👁️ Detalles de Venta</h1>
        
        <div class="detail-group">
            <div class="detail-label">ID de Venta</div>
            <div class="detail-value">#<?php echo $datos['id']; ?></div>
        </div>
        
        <div class="detail-group">
            <div class="detail-label">Fecha</div>
            <div class="detail-value"><?php echo date('d de F de Y \a \l\a\s H:i', strtotime($datos['fecha_venta'])); ?></div>
        </div>
        
        <div class="detail-group">
            <div class="detail-label">Cliente</div>
            <div class="detail-value"><?php echo htmlspecialchars($datos['cliente_nombre']); ?></div>
        </div>
        
        <div class="detail-group">
            <div class="detail-label">Producto</div>
            <div class="detail-value"><?php echo htmlspecialchars($datos['producto_nombre']); ?></div>
        </div>
        
        <div class="detail-group">
            <div class="detail-label">Cantidad</div>
            <div class="detail-value"><?php echo $datos['cantidad']; ?> unidad(es)</div>
        </div>
        
        <div class="detail-group">
            <div class="detail-label">Precio Unitario</div>
            <div class="detail-value">$<?php echo number_format($datos['precio_unitario'], 2); ?></div>
        </div>
        
        <div class="detail-group">
            <div class="detail-label">Total</div>
            <div class="detail-value amount">$<?php echo number_format($datos['total'], 2); ?></div>
        </div>
        
        <div class="button-group">
            <a href="../controladores/eliminar.php?id=<?php echo $datos['id']; ?>" class="btn-delete"
               onclick="return confirm('¿Estás seguro de eliminar esta venta? El stock será recuperado.');">
                🗑️ Eliminar Venta
            </a>
            <a href="../vistas/listado.php" class="btn-back">← Volver</a>
        </div>
    </div>
</body>
</html>
