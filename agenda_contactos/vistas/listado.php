<?php
session_start();
require_once '../modelos/conexion.php';

$contacto = new Contacto($conexion);
$contactos = $contacto->obtenerTodos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Contactos - Agenda</title>
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
            max-width: 1000px;
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
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            margin-bottom: 15px;
        }
        
        .card-name {
            font-size: 20px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        
        .card-body {
            margin-bottom: 20px;
        }
        
        .card-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
            font-size: 14px;
        }
        
        .card-label {
            font-weight: 600;
            color: #667eea;
            min-width: 90px;
            margin-right: 10px;
        }
        
        .card-value {
            color: #666;
            word-break: break-all;
        }
        
        .card-footer {
            display: flex;
            gap: 10px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
        }
        
        .btn-small {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
            display: block;
        }
        
        .btn-edit {
            background: #667eea;
            color: white;
        }
        
        .btn-edit:hover {
            background: #5568d3;
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
        
        .empty-message-icon {
            font-size: 50px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📱 Mis Contactos</h1>
            <a href="formulario.php" class="btn-add">+ Agregar Contacto</a>
        </div>
        
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?php echo $_SESSION['tipo']; ?>">
                <?php echo $_SESSION['mensaje']; ?>
            </div>
            <?php unset($_SESSION['mensaje'], $_SESSION['tipo']); ?>
        <?php endif; ?>
        
        <?php if (empty($contactos)): ?>
            <div class="empty-message">
                <div class="empty-message-icon">📭</div>
                <p>No hay contactos registrados. ¡Agrega tu primer contacto!</p>
            </div>
        <?php else: ?>
            <div class="cards-grid">
                <?php foreach ($contactos as $contacto): ?>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-name"><?php echo htmlspecialchars($contacto['nombre']); ?></div>
                        </div>
                        <div class="card-body">
                            <div class="card-item">
                                <span class="card-label">📞</span>
                                <span class="card-value"><?php echo htmlspecialchars($contacto['telefono']); ?></span>
                            </div>
                            <div class="card-item">
                                <span class="card-label">📧</span>
                                <span class="card-value"><?php echo htmlspecialchars($contacto['correo']); ?></span>
                            </div>
                            <div class="card-item">
                                <span class="card-label">📍</span>
                                <span class="card-value"><?php echo htmlspecialchars($contacto['direccion']); ?></span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="../controladores/editar.php?id=<?php echo $contacto['id']; ?>" class="btn-small btn-edit">
                                ✏️ Editar
                            </a>
                            <a href="../controladores/eliminar.php?id=<?php echo $contacto['id']; ?>" class="btn-small btn-delete" 
                               onclick="return confirm('¿Estás seguro de que deseas eliminar este contacto?');">
                                🗑️ Eliminar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
