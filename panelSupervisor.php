<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'Supervisor'){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel Supervisor</title>
<link rel="stylesheet" href="estilos.css">
</head>
<body>
<h2>Bienvenido Supervisor, <?php echo $_SESSION['usuario']; ?></h2>

<nav>
    <ul>
        <li><a href="ordenes.php">Órdenes</a></li>
        <li><a href="piezas.php">Piezas</a></li>
        <li><a href="inventario.php">Inventario</a></li>
        <li><a href="notificaciones.php">Notificaciones</a></li>
        <li><a href="reportes.php">Reportes</a></li>
        <li><a href="logout.php">Cerrar sesión</a></li>
    </ul>
</nav>
</body>
</html>
