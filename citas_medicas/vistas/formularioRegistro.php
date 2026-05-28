<?php include("../modelos/conexion.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Reserva de Citas Médicas</title>
</head>
<body>

<h2>Registro de Cita Médica</h2>

<form action="../controladores/registrarusuario.php" method="POST">

    <label>Paciente:</label><br>
    <input type="text" name="paciente" required><br><br>

    <label>Fecha:</label><br>
    <input type="date" name="fecha" required><br><br>

    <label>Hora:</label><br>
    <input type="time" name="hora" required><br><br>

    <label>Motivo:</label><br>
    <textarea name="motivo" required></textarea><br><br>

    <button type="submit">Guardar Cita</button>

</form>

</body>
</html>