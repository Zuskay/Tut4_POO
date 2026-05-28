<?php
session_start();
require_once '../modelos/conexion.php';

$venta = new Venta($conexion);
$clientes = $venta->obtenerClientes();
$productos = $venta->obtenerProductos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta - Gestión de Ventas</title>
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
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .form-row.full {
            grid-template-columns: 1fr;
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
        input[type="number"],
        select,
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
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 8px rgba(102, 126, 234, 0.2);
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
        
        .btn-cancel {
            background: #f0f0f0;
            color: #333;
        }
        
        .btn-cancel:hover {
            background: #e0e0e0;
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
        
        .price-display {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            font-weight: 600;
            color: #667eea;
            font-size: 18px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>💰 Registrar Nueva Venta</h1>
        
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?php echo $_SESSION['tipo']; ?>">
                <?php echo $_SESSION['mensaje']; ?>
            </div>
            <?php unset($_SESSION['mensaje'], $_SESSION['tipo']); ?>
        <?php endif; ?>
        
        <form method="POST" action="../controladores/insertar.php" id="formVenta">
            <div class="form-row full">
                <div class="form-group">
                    <label for="cliente">Cliente *</label>
                    <select id="cliente" name="cliente_id" required>
                        <option value="">-- Seleccionar cliente --</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['id']; ?>">
                                <?php echo htmlspecialchars($cliente['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row full">
                <div class="form-group">
                    <label for="producto">Producto *</label>
                    <select id="producto" name="producto_id" required onchange="actualizarPrecio()">
                        <option value="">-- Seleccionar producto --</option>
                        <?php foreach ($productos as $producto): ?>
                            <option value="<?php echo $producto['id']; ?>" 
                                    data-precio="<?php echo $producto['precio']; ?>">
                                <?php echo htmlspecialchars($producto['nombre']) . ' - $' . number_format($producto['precio'], 2); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="cantidad">Cantidad *</label>
                    <input type="number" id="cantidad" name="cantidad" min="1" required 
                           placeholder="Ej: 5" onchange="actualizarPrecio()">
                </div>
                
                <div class="form-group">
                    <label for="precio_unitario">Precio Unitario $</label>
                    <input type="number" id="precio_unitario" name="precio_unitario" 
                           step="0.01" readonly placeholder="Se calcula automáticamente">
                </div>
            </div>
            
            <div class="price-display" id="totalDisplay">
                Total: $0.00
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn-submit">💾 Guardar Venta</button>
                <button type="button" class="btn-cancel" onclick="window.location.href='../vistas/listado.php'">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
    
    <script>
        function actualizarPrecio() {
            const selectProducto = document.getElementById('producto');
            const cantidadInput = document.getElementById('cantidad');
            const precioUnitarioInput = document.getElementById('precio_unitario');
            const totalDisplay = document.getElementById('totalDisplay');
            
            const selectedOption = selectProducto.options[selectProducto.selectedIndex];
            const precio = parseFloat(selectedOption.dataset.precio) || 0;
            const cantidad = parseInt(cantidadInput.value) || 0;
            
            precioUnitarioInput.value = precio.toFixed(2);
            const total = precio * cantidad;
            totalDisplay.textContent = 'Total: $' + total.toFixed(2);
        }
    </script>
</body>
</html>
