<?php
include("../modelos/conexion.php");

$id = $_GET['id'];

$sql = "DELETE FROM citas WHERE id=$id";

if ($conexion->query($sql) === TRUE) {
    header("Location: ../vistas/listaUsuarios.php");
} else {
    echo "Error: " . $conexion->error;
}
?>