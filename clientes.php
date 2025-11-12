<?php
include("conexion.php");
session_start();
if ($_SESSION['rol'] != 'Director') {
    header("Location: login.php");
    exit();
}

// === AGREGAR CLIENTE ===
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    $conn->query("INSERT INTO clientes (nombre, correo, telefono) 
                      VALUES ('$nombre', '$correo', '$telefono')");
}

// === EDITAR CLIENTE ===
if (isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    $conn->query("UPDATE clientes 
                      SET nombre='$nombre', correo='$correo', telefono='$telefono' 
                      WHERE id=$id");
}

// === ELIMINAR CLIENTE ===
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM clientes WHERE id=$id");
}

$resultado = $conn->query("SELECT * FROM clientes");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Gestión de Clientes</h2>
    <a href="panelDirector.php">← Regresar</a>
    <hr>

    <form method="POST">
        <input type="hidden" name="id" id="id">
        <input type="text" name="nombre" placeholder="Nombre del cliente" required>
        <input type="email" name="correo" placeholder="Correo electrónico" required>
        <input type="text" name="telefono" placeholder="Teléfono" required>
        <button type="submit" name="agregar">Agregar</button>
        <button type="submit" name="editar">Editar</button>
    </form>

    <hr>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php while($row = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nombre'] ?></td>
            <td><?= $row['correo'] ?></td>
            <td><?= $row['telefono'] ?></td>
            <td>
                <a href="?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar cliente?')">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
