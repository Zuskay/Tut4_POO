<?php include("../modelos/conexion.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registrar Curso</title>

<style>
* {
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Arial, sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
}

.form-container {
    background: white;
    padding: 30px;
    border-radius: 15px;
    width: 350px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.input-group {
    margin-bottom: 15px;
}

label {
    font-size: 13px;
    color: #555;
    display: block;
    margin-bottom: 5px;
}

input, select {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ddd;
    outline: none;
    transition: 0.2s;
    font-size: 14px;
}

input:focus, select:focus {
    border-color: #667eea;
    box-shadow: 0 0 5px rgba(102,126,234,0.3);
}

button {
    width: 100%;
    padding: 12px;
    background: #667eea;
    border: none;
    color: white;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #5a67d8;
}

.back-btn {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #667eea;
    text-decoration: none;
    font-size: 14px;
}

.back-btn:hover {
    text-decoration: underline;
}
</style>
</head>

<body>

<div class="form-container">
    <h2>Registrar Curso</h2>

    <form action="../controladores/insertar.php" method="POST">

        <div class="input-group">
            <label>Nombre del curso</label>
            <input type="text" name="curso" placeholder="Ej: Programación Web" required>
        </div>

        <div class="input-group">
            <label>Créditos</label>
            <input type="number" name="creditos" placeholder="Ej: 3" min="1" max="5" required>
        </div>

        <div class="input-group">
            <label>Docente</label>
            <select name="docente" required>
                <option value="" disabled selected>Seleccione un docente</option>

                <?php
                $res = $conexion->query("SELECT * FROM docentes");

                if ($res->num_rows == 0) {
                    echo "<option disabled>No hay docentes registrados</option>";
                } else {
                    while($row = $res->fetch_assoc()){
                        echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                    }
                }
                ?>
            </select>
        </div>

        <button type="submit">Guardar Curso</button>

    </form>

    <a class="back-btn" href="listado.php">← Volver al listado</a>
</div>

</body>
</html>