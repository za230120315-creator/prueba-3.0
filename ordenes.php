<?php
include("conexion.php");
session_start();

$rol = $_SESSION['rol'];
if (!in_array($rol, ['Director', 'Supervisor', 'Empleado'])) {
    header("Location: login.php");
    exit();
}

// === AGREGAR ORDEN ===
if (isset($_POST['agregar']) && $rol != 'empleado') {
    $cliente_id = $_POST['cliente_id'];
    $numero_pieza = $_POST['numero_pieza'];
    $fecha = $_POST['fecha'];
    $ultima_modificacion = $_SESSION['nombre'];

    $conn->query("INSERT INTO ordenes (cliente_id, numero_pieza, fecha, ultima_modificacion)
                      VALUES ('$cliente_id', '$numero_pieza', '$fecha', '$ultima_modificacion')");
}

// === EDITAR ORDEN ===
if (isset($_POST['editar']) && $rol != 'empleado') {
    $id = $_POST['id'];
    $cliente_id = $_POST['cliente_id'];
    $numero_pieza = $_POST['numero_pieza'];
    $fecha = $_POST['fecha'];
    $estado = $_POST['estado'];
    $ultima_modificacion = $_SESSION['nombre'];

    $conn->query("UPDATE ordenes SET cliente_id='$cliente_id', numero_pieza='$numero_pieza',
                      fecha='$fecha', estado='$estado', ultima_modificacion='$ultima_modificacion' 
                      WHERE id=$id");
}

// === ELIMINAR ORDEN ===
if (isset($_GET['eliminar']) && $rol != 'empleado') {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM ordenes WHERE id=$id");
}

// === LISTAR CLIENTES Y ÓRDENES ===
$clientes = $conn->query("SELECT * FROM clientes");
$ordenes = $conn->query("SELECT o.*, c.nombre AS cliente 
                             FROM ordenes o 
                             INNER JOIN clientes c ON o.cliente_id = c.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Órdenes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Gestión de Órdenes</h2>
    <a href="<?php echo 'panel' . $rol . '.php'; ?>">← Regresar</a>
    <hr>

    <?php if ($rol != 'empleado'): ?>
    <form method="POST">
        <input type="hidden" name="id" id="id">
        <label>Cliente:</label>
        <select name="cliente_id" required>
            <option value="">Seleccione</option>
            <?php while ($cli = $clientes->fetch_assoc()) { ?>
                <option value="<?= $cli['id'] ?>"><?= $cli['nombre'] ?></option>
            <?php } ?>
        </select>
        <input type="text" name="numero_pieza" placeholder="Número de pieza" required>
        <input type="date" name="fecha" required>
        <select name="estado">
            <option value="activa">Activa</option>
            <option value="espera">En espera</option>
            <option value="cancelada">Cancelada</option>
            <option value="liberada">Liberada</option>
        </select>
        <button type="submit" name="agregar">Agregar</button>
        <button type="submit" name="editar">Editar</button>
    </form>
    <hr>
    <?php endif; ?>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>N° Pieza</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Última modificación</th>
            <?php if ($rol != 'empleado'): ?><th>Acciones</th><?php endif; ?>
        </tr>
        <?php while ($row = $ordenes->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['cliente'] ?></td>
            <td><?= $row['numero_pieza'] ?></td>
            <td><?= $row['fecha'] ?></td>
            <td><?= $row['estado'] ?></td>
            <td><?= $row['ultima_modificacion'] ?></td>
            <?php if ($rol != 'empleado'): ?>
            <td>
                <a href="?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar orden?')">Eliminar</a>
            </td>
            <?php endif; ?>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
