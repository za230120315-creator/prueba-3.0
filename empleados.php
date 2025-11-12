<?php
include("conexion.php");
session_start();
if ($_SESSION['rol'] != 'Director') {
    header("Location: login.php");
    exit();
}

// === AGREGAR EMPLEADO ===
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    $sql = "INSERT INTO usuarios (nombre, usuario, contrasena, rol)
            VALUES ('$nombre', '$usuario', '$contrasena', '$rol')";
    $conn->query($sql);
}

// === EDITAR EMPLEADO ===
if (isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    $sql = "UPDATE usuarios 
            SET nombre='$nombre', usuario='$usuario', contrasena='$contrasena', rol='$rol' 
            WHERE id=$id";
    $conn->query($sql);
}

// === ELIMINAR EMPLEADO ===
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM usuarios WHERE id=$id");
}

$resultado = $conn->query("SELECT * FROM usuarios");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Empleados</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Gestión de Empleados</h2>
    <a href="panelDirector.php">← Regresar</a>
    <hr>

    <form method="POST">
        <input type="hidden" name="id" id="id">
        <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
        <input type="text" name="usuario" id="usuario" placeholder="Usuario" required>
        <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña" required>
        <select name="rol" id="rol" required>
            <option value="empleado">Empleado</option>
            <option value="supervisor">Supervisor</option>
            <option value="director">Director</option>
        </select>
        <button type="submit" name="agregar">Agregar</button>
        <button type="submit" name="editar">Editar</button>
    </form>

    <hr>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php while($row = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nombre'] ?></td>
            <td><?= $row['usuario'] ?></td>
            <td><?= $row['rol'] ?></td>
            <td>
                <a href="?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar empleado?')">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
