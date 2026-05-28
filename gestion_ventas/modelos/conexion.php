<?php
// Configuración de conexión a la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ventas_db');

// Crear conexión
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configurar charset
$conexion->set_charset("utf8");

// Clase para operaciones de Ventas
class Venta {
    private $conexion;
    
    public function __construct($conn) {
        $this->conexion = $conn;
    }
    
    // Obtener todos los clientes
    public function obtenerClientes() {
        $sql = "SELECT * FROM clientes ORDER BY nombre ASC";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Obtener todos los productos
    public function obtenerProductos() {
        $sql = "SELECT * FROM productos WHERE stock > 0 ORDER BY nombre ASC";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Insertar nueva venta
    public function insertarVenta($cliente_id, $producto_id, $cantidad, $precio_unitario) {
        $total = $cantidad * $precio_unitario;
        $sql = "INSERT INTO ventas (cliente_id, producto_id, cantidad, precio_unitario, total) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iiidy", $cliente_id, $producto_id, $cantidad, $precio_unitario, $total);
        
        if ($stmt->execute()) {
            // Actualizar stock del producto
            $this->actualizarStock($producto_id, -$cantidad);
            return true;
        }
        return false;
    }
    
    // Obtener todas las ventas con detalles
    public function obtenerVentas() {
        $sql = "SELECT v.*, c.nombre as cliente_nombre, p.nombre as producto_nombre 
                FROM ventas v
                JOIN clientes c ON v.cliente_id = c.id
                JOIN productos p ON v.producto_id = p.id
                ORDER BY v.fecha_venta DESC";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Obtener venta por ID
    public function obtenerVentaPorId($id) {
        $sql = "SELECT v.*, c.nombre as cliente_nombre, p.nombre as producto_nombre 
                FROM ventas v
                JOIN clientes c ON v.cliente_id = c.id
                JOIN productos p ON v.producto_id = p.id
                WHERE v.id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    // Eliminar venta
    public function eliminarVenta($id) {
        // Obtener la venta primero para recuperar el stock
        $sql = "SELECT producto_id, cantidad FROM ventas WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $venta = $stmt->get_result()->fetch_assoc();
        
        if ($venta) {
            // Recuperar stock
            $this->actualizarStock($venta['producto_id'], $venta['cantidad']);
            
            // Eliminar venta
            $sql = "DELETE FROM ventas WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }
    
    // Actualizar stock del producto
    private function actualizarStock($producto_id, $cantidad) {
        $sql = "UPDATE productos SET stock = stock + ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ii", $cantidad, $producto_id);
        return $stmt->execute();
    }
    
    // Obtener total de ventas
    public function obtenerTotalVentas() {
        $sql = "SELECT SUM(total) as total FROM ventas";
        $result = $this->conexion->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }
    
    // Obtener cantidad de ventas
    public function obtenerCantidadVentas() {
        $sql = "SELECT COUNT(*) as cantidad FROM ventas";
        $result = $this->conexion->query($sql);
        $row = $result->fetch_assoc();
        return $row['cantidad'] ?? 0;
    }
}
?>
