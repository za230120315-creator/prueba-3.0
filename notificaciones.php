<?php
include("conexion.php");

// Enviar notificación
if(isset($_POST['guardar'])){
    $para = $_POST['para'];
    $asunto = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];

    $query = "INSERT INTO notificaciones (para, asunto, mensaje, fecha_envio) VALUES ('$para', '$asunto', '$mensaje', NOW())";
    mysqli_query($conn, $query);

    // Simulación de envío por correo
    echo "<script>alert('Notificación enviada a $para');</script>";
}

// Eliminar notificación
if(isset($_GET['eliminar'])){
    $id = $_GET['eliminar'];
    mysqli_query($conn, "DELETE FROM notificaciones WHERE id='$id'");
}

$result = mysqli_query($conn, "SELECT * FROM notificaciones");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Notificaciones</title>
<link rel="stylesheet" href="estilos.css">
</head>
<body>
<h2>Notificaciones</h2>

<form method="POST">
    Para (correo): <input type="email" name="para" required><br>
    Asunto: <input type="text" name="asunto" required><br>
    Mensaje: <textarea name="mensaje" required></textarea><br>
    <button type="submit" name="guardar">Enviar Notificación</button>
</form>

<h3>Historial de Notificaciones</h3>
<table border="1">
    <tr>
        <th>ID</th><th>Para</th><th>Asunto</th><th>Mensaje</th><th>Fecha</th><th>Acciones</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['para'] ?></td>
        <td><?= $row['asunto'] ?></td>
        <td><?= $row['mensaje'] ?></td>
        <td><?= $row['fecha_envio'] ?></td>
        <td>
            <a href="notificaciones.php?eliminar=<?= $row['id'] ?>">Eliminar</a>
        </td>
    </tr>
    <?php } ?>
</table>
</body>
</html>
