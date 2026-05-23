<?php
include("../modelos/conexion.php");

$curso = $_POST['curso'];
$creditos = $_POST['creditos'];
$docente_id = $_POST['docente'];

$sql = "INSERT INTO cursos (nombre, creditos, docente_id)
        VALUES ('$curso', '$creditos', '$docente_id')";
        if ($creditos < 1 || $creditos > 10) {
        die("Los créditos deben estar entre 1 y 5");
        }

$conexion->query($sql);

header("Location: ../vistas/listado.php");
?>