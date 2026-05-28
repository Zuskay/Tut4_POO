<?php
session_start();
require_once '../modelos/conexion.php';

if (!isset($_GET['id'])) {
    header('Location: listado.php');
    exit;
}

$contacto = new Contacto($conexion);
$datos = $contacto->obtenerPorId($_GET['id']);

if (!$datos) {
    $_SESSION['mensaje'] = 'Contacto no encontrado';
    $_SESSION['tipo'] = 'error';
    header('Location: listado.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contacto - Agenda</title>
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
            max-width: 500px;
            width: 100%;
        }
        
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
            font-family: inherit;
        }
        
        input:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 8px rgba(102, 126, 234, 0.2);
        }
        
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-submit:active {
            transform: translateY(0);
        }
        
        .btn-cancel {
            background: #f0f0f0;
            color: #333;
        }
        
        .btn-cancel:hover {
            background: #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>✏️ Editar Contacto</h1>
        
        <form method="POST" action="../controladores/actualizar.php">
            <input type="hidden" name="id" value="<?php echo $datos['id']; ?>">
            
            <div class="form-group">
                <label for="nombre">Nombre Completo *</label>
                <input type="text" id="nombre" name="nombre" required 
                       value="<?php echo htmlspecialchars($datos['nombre']); ?>">
            </div>
            
            <div class="form-group">
                <label for="telefono">Teléfono *</label>
                <input type="tel" id="telefono" name="telefono" required 
                       value="<?php echo htmlspecialchars($datos['telefono']); ?>">
            </div>
            
            <div class="form-group">
                <label for="direccion">Dirección *</label>
                <textarea id="direccion" name="direccion" required><?php echo htmlspecialchars($datos['direccion']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="correo">Correo Electrónico *</label>
                <input type="email" id="correo" name="correo" required 
                       value="<?php echo htmlspecialchars($datos['correo']); ?>">
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn-submit">Guardar Cambios</button>
                <button type="button" class="btn-cancel" onclick="window.location.href='listado.php'">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</body>
</html>
