<?php
session_start();
require_once 'modelos/conexion.php';

$venta = new Venta($conexion);
$ventas = $venta->obtenerVentas();
$totalVentas = $venta->obtenerTotalVentas();
$cantidadVentas = $venta->obtenerCantidadVentas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ventas MVC</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 50px;
            max-width: 600px;
            text-align: center;
        }
        
        h1 {
            color: #333;
            margin-bottom: 15px;
            font-size: 36px;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 40px;
            font-size: 16px;
        }
        
        .stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .stat {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        
        .stat-label {
            color: #999;
            font-size: 12px;
            margin-bottom: 5px;
        }
        
        .stat-value {
            color: #667eea;
            font-size: 20px;
            font-weight: 700;
        }
        
        .btn {
            display: inline-block;
            padding: 14px 32px;
            margin: 10px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: white;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .info {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            text-align: left;
            margin-top: 30px;
            border-radius: 6px;
        }
        
        .info h3 {
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .info p {
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>💰 Gestión de Ventas</h1>
        <p class="subtitle">Aplicación MVC con PHP y MySQL</p>
        
        <div class="stats">
            <div class="stat">
                <div class="stat-label">Total de Ventas</div>
                <div class="stat-value"><?php echo $cantidadVentas; ?></div>
            </div>
            <div class="stat">
                <div class="stat-label">Ingresos Totales</div>
                <div class="stat-value">$<?php echo number_format($totalVentas, 0); ?></div>
            </div>
        </div>
        
        <a href="vistas/listado.php" class="btn btn-primary">Ver Ventas</a>
        <a href="vistas/formulario.php" class="btn btn-primary">+ Nueva Venta</a>
        
        <div class="info">
            <h3>📚 Estructura MVC:</h3>
            <p>✅ <strong>Modelo:</strong> modelos/conexion.php - Lógica de base de datos</p>
            <p>✅ <strong>Vista:</strong> vistas/formulario.php, listado.php, ver.php - Interfaz usuario</p>
            <p>✅ <strong>Controlador:</strong> controladores/insertar.php, eliminar.php, ver.php - Lógica de negocio</p>
        </div>
    </div>
</body>
</html>
