<?php
include("../modelos/conexion.php");

$id = $_GET['id'];

$sql = "DELETE FROM cursos WHERE id = $id";
$conexion->query($sql);

header("Location: ../vistas/listado.php");
?>