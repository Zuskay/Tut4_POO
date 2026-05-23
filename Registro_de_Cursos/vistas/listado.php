<?php
include("../modelos/conexion.php");

$sql = "SELECT cursos.id, cursos.nombre, cursos.creditos, docentes.nombre AS docente
        FROM cursos
        LEFT JOIN docentes ON cursos.docente_id = docentes.id";

$result = $conexion->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cursos Registrados</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      background: #fafafa;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    h2 {
      margin: 30px 0 10px 0;
      color: #262626;
    }
    .curso-list {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 20px;
      width: 90%;
      max-width: 1000px;
    }
    .card {
      background: white;
      border: 1px solid #dbdbdb;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      transition: 0.2s;
    }
    .card:hover {
      transform: scale(1.02);
    }
    .btn-delete {
      margin-top: 10px;
      display: inline-block;
      padding: 8px 14px;
      background: #ed4956;
      color: white;
      border-radius: 5px;
      text-decoration: none;
    }
    .btn-add {
      margin: 20px;
      padding: 10px 18px;
      background: #0095f6;
      color: white;
      border-radius: 5px;
      text-decoration: none;
    }
  </style>
</head>

<body>

<h2>Cursos Registrados</h2>

<div class="curso-list">

<?php
if ($result->num_rows == 0) {
    echo "<h3>No hay cursos registrados</h3>";
} else {
    while ($fila = $result->fetch_assoc()) {
?>
        <div class="card">
            <h3><?= htmlspecialchars($fila['nombre']) ?></h3>
            <p>Docente: <?= htmlspecialchars($fila['docente'] ?? 'Sin docente') ?></p>
            <p>Créditos: <?= htmlspecialchars($fila['creditos']) ?></p>

            <a class="btn-delete"
               href="../controladores/eliminar.php?id=<?= $fila['id'] ?>"
               onclick="return confirm('¿Seguro que quieres eliminar este curso?')">
               Eliminar
            </a>
        </div>
<?php
    }
}
?>

</div>

<a class="btn-add" href="formulario.php">➕ Agregar curso</a>

</body>
</html>