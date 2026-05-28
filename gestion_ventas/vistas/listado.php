<?php
session_start();
require_once '../modelos/conexion.php';

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
    <title>Historial de Ventas - Gestión de Ventas</title>
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
            padding: 40px 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        h1 {
            color: white;
            font-size: 32px;
        }
        
        .btn-add {
            background: white;
            color: #667eea;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #667eea;
        }
        
        .stat-label {
            color: #999;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .stat-value {
            color: #667eea;
            font-size: 28px;
            font-weight: 700;
        }
        
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        tbody tr:hover {
            background: #f8f9fa;
        }
        
        .btn-small {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            margin-right: 5px;
        }
        
        .btn-view {
            background: #3498db;
            color: white;
        }
        
        .btn-view:hover {
            background: #2980b9;
        }
        
        .btn-delete {
            background: #e74c3c;
            color: white;
        }
        
        .btn-delete:hover {
            background: #c0392b;
        }
        
        .empty-message {
            background: white;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            color: #999;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💰 Gestión de Ventas</h1>
            <a href="formulario.php" class="btn-add">+ Nueva Venta</a>
        </div>
        
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?php echo $_SESSION['tipo']; ?>">
                <?php echo $_SESSION['mensaje']; ?>
            </div>
            <?php unset($_SESSION['mensaje'], $_SESSION['tipo']); ?>
        <?php endif; ?>
        
        <div class="stats">
            <div class="stat-card">
                <div class="stat-label">Total de Ventas</div>
                <div class="stat-value"><?php echo $cantidadVentas; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Ingresos Totales</div>
                <div class="stat-value">$<?php echo number_format($totalVentas, 2); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Promedio por Venta</div>
                <div class="stat-value">$<?php echo $cantidadVentas > 0 ? number_format($totalVentas / $cantidadVentas, 2) : '0.00'; ?></div>
            </div>
        </div>
        
        <?php if (empty($ventas)): ?>
            <div class="empty-message">
                <p>No hay ventas registradas. ¡Comienza a registrar ventas!</p>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ventas as $v): ?>
                            <tr>
                                <td>#<?php echo $v['id']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($v['fecha_venta'])); ?></td>
                                <td><?php echo htmlspecialchars($v['cliente_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($v['producto_nombre']); ?></td>
                                <td><?php echo $v['cantidad']; ?></td>
                                <td>$<?php echo number_format($v['precio_unitario'], 2); ?></td>
                                <td><strong>$<?php echo number_format($v['total'], 2); ?></strong></td>
                                <td>
                                    <a href="../controladores/ver.php?id=<?php echo $v['id']; ?>" class="btn-small btn-view">
                                        👁️ Ver
                                    </a>
                                    <a href="../controladores/eliminar.php?id=<?php echo $v['id']; ?>" class="btn-small btn-delete" 
                                       onclick="return confirm('¿Estás seguro de eliminar esta venta?');">
                                        🗑️ Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
