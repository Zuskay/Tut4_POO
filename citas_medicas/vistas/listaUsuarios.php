<?php
include("../modelos/conexion.php");

$resultado = $conexion->query("SELECT * FROM citas");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listado de Citas</title>
</head>
<body>

<h2>Citas Registradas</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Paciente</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Motivo</th>
        <th>Acciones</th>
    </tr>

<?php while($fila = $resultado->fetch_assoc()){ ?>

<tr>
    <td><?= $fila['id']; ?></td>
    <td><?= $fila['paciente']; ?></td>
    <td><?= $fila['fecha']; ?></td>
    <td><?= $fila['hora']; ?></td>
    <td><?= $fila['motivo']; ?></td>

    <td>
        <a href="../controladores/eliminarusuario.php?id=<?= $fila['id']; ?>"
        onclick="return confirm('¿Eliminar esta cita?')">
        Eliminar
        </a>
    </td>
</tr>

<?php } ?>

</table>
<button onclick="window.location.href='../vistas/formularioRegistro.php'">
    Registrar Nueva Cita
</button>
</body>
</html>