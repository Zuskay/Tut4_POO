<?php
session_start();
require_once 'modelos/conexion.php';

$contacto = new Contacto($conexion);
$contactos = $contacto->obtenerTodos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Contactos MVC</title>
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
        
        .count {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📱 Agenda de Contactos</h1>
        <p class="subtitle">Aplicación MVC con PHP y MySQL</p>
        
        <div class="count">
            <?php echo count($contactos); ?> Contactos registrados
        </div>
        
        <a href="vistas/listado.php" class="btn btn-primary">Ver Contactos</a>
        <a href="vistas/formulario.php" class="btn btn-primary">+ Agregar Contacto</a>
        
        <div class="info">
            <h3>📚 Estructura MVC:</h3>
            <p>✅ <strong>Modelo:</strong> modelos/conexion.php - Lógica de base de datos</p>
            <p>✅ <strong>Vista:</strong> vistas/formulario.php, listado.php, editar.php - Interfaz usuario</p>
            <p>✅ <strong>Controlador:</strong> controladores/insertar.php, actualizar.php, eliminar.php, editar.php - Lógica de negocio</p>
        </div>
    </div>
</body>
</html>
