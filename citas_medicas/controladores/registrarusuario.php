<?php
include("../modelos/conexion.php");

$paciente = trim($_POST['paciente']);
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$motivo = trim($_POST['motivo']);

if(empty($paciente) || empty($fecha) || empty($hora) || empty($motivo)){
    die("Todos los campos son obligatorios.");
}

if($fecha > date("Y-m-d")){
    die("La fecha no puede ser anterior al día actual.");
}

$stmt = $conexion->prepare(
"INSERT INTO citas(paciente, fecha, hora, motivo)
VALUES (?, ?, ?, ?)"
);

$stmt->bind_param("ssss",
$paciente,
$fecha,
$hora,
$motivo
);

if(!$stmt->execute()){
    die("Error: " . $conexion->error);
}

header("Location: ../vistas/listaUsuarios.php");
?>