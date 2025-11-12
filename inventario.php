<?php
include("conexion.php");

// Agregar producto al inventario
if(isset($_POST['guardar'])){
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $ubicacion = $_POST['ubicacion'];
    $estado = $_POST['estado'];

    $query = "INSERT INTO inventario (nombre, cantidad, ubicacion, estado) VALUES ('$nombre', '$cantidad', '$ubicacion', '$estado')";
    mysqli_query($conn, $query);
}

// Editar inventario
if(isset($_POST['editar'])){
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $ubicacion = $_POST['ubicacion'];
    $estado = $_POST['estado'];

    $query = "UPDATE inventario SET nombre='$nombre', cantidad='$cantidad', ubicacion='$ubicacion', estado='$estado' WHERE id='$id'";
    mysqli_query($conn, $query);
}

// Eliminar registro
if(isset($_GET['eliminar'])){
    $id = $_GET['eliminar'];
    mysqli_query($conn, "DELETE FROM inventario WHERE id='$id'");
}

$result = mysqli_query($conn, "SELECT * FROM inventario");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Inventario</title>
<link rel="stylesheet" href="estilos.css">
</head>
<body>
<h2> Inventario</h2>


<form method="POST">
    <input type="hidden" name="id" id="id">
    Nombre del Material: <input type="text" name="nombre" required><br>
    Cantidad: <input type="number" name="cantidad" required><br>
    Ubicación: <input type="text" name="ubicacion" required><br>
    Estado: 
    <select name="estado">
        <option value="Disponible">Disponible</option>
        <option value="Agotado">Agotado</option>
        <option value="En pedido">En pedido</option>
    </select><br>
    <button type="submit" name="guardar">Guardar</button>
    <button type="submit" name="editar">Editar</button>
</form>

<table border="1">
    <tr>
        <th>ID</th><th>Nombre</th><th>Cantidad</th><th>Ubicación</th><th>Estado</th><th>Acciones</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['nombre'] ?></td>
        <td><?= $row['cantidad'] ?></td>
        <td><?= $row['ubicacion'] ?></td>
        <td><?= $row['estado'] ?></td>
        <td>
            <a href="inventario.php?eliminar=<?= $row['id'] ?>">Eliminar</a>
        </td>
    </tr>
    <?php } ?>
</table>
</body>
</html>
