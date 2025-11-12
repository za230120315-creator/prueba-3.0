<?php
include("conexion.php");

$result = mysqli_query($conn, "SELECT * FROM ordenes");

// Exportar a Excel
if(isset($_POST['excel'])){
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=reporte_ordenes.xls");
    echo "ID\tCliente\tPieza\tFecha\tEstado\tÚltimo Cambio\n";
    while($row = mysqli_fetch_assoc($result)){
        echo "{$row['id']}\t{$row['cliente']}\t{$row['pieza']}\t{$row['fecha']}\t{$row['estado']}\t{$row['ultimo_cambio']}\n";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reportes de Órdenes</title>
<link rel="stylesheet" href="estilos.css">
</head>
<body>
<h2>Reportes de Órdenes</h2>

<form method="POST">
    <button type="submit" name="excel">Descargar Reporte en Excel</button>
</form>

<table border="1">
    <tr>
        <th>ID</th><th>Cliente</th><th>Pieza</th><th>Fecha</th><th>Estado</th><th>Último Cambio</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['cliente'] ?></td>
        <td><?= $row['pieza'] ?></td>
        <td><?= $row['fecha'] ?></td>
        <td><?= $row['estado'] ?></td>
        <td><?= $row['ultimo_cambio'] ?></td>
    </tr>
    <?php } ?>
</table>
</body>
</html>
