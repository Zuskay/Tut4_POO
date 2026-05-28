<?php
// Configuración de conexión a la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'agenda_db');

// Crear conexión
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configurar charset
$conexion->set_charset("utf8");

// Clase para operaciones CRUD
class Contacto {
    private $conexion;
    
    public function __construct($conn) {
        $this->conexion = $conn;
    }
    
    // Insertar contacto
    public function insertar($nombre, $telefono, $direccion, $correo) {
        $sql = "INSERT INTO contactos (nombre, telefono, direccion, correo) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $telefono, $direccion, $correo);
        return $stmt->execute();
    }
    
    // Obtener todos los contactos
    public function obtenerTodos() {
        $sql = "SELECT * FROM contactos ORDER BY fecha_creacion DESC";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Obtener contacto por ID
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM contactos WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    // Actualizar contacto
    public function actualizar($id, $nombre, $telefono, $direccion, $correo) {
        $sql = "UPDATE contactos SET nombre = ?, telefono = ?, direccion = ?, correo = ? 
                WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $telefono, $direccion, $correo, $id);
        return $stmt->execute();
    }
    
    // Eliminar contacto
    public function eliminar($id) {
        $sql = "DELETE FROM contactos WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
