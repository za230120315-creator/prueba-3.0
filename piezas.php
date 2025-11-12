<?php
include("conexion.php");
session_start();

$rol = $_SESSION['rol'];
if (!in_array($rol, ['Director', 'Supervisor', 'Empleado'])) {
    header("Location: login.php");
    exit();
}

// === AGREGAR PIEZA ===
if (isset($_POST['agregar']) && $rol != 'empleado') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $conn->query("INSERT INTO piezas (nombre, descripcion, estado) VALUES ('$nombre', '$descripcion', '$estado')");
}

// === EDITAR PIEZA ===
if (isset($_POST['editar']) && $rol != 'empleado') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $conn->query("UPDATE piezas SET nombre='$nombre', descripcion='$descripcion', estado='$estado' WHERE id=$id");
}

// === ELIMINAR PIEZA ===
if (isset($_GET['eliminar']) && $rol != 'empleado') {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM piezas WHERE id=$id");
}

$piezas = $conn->query("SELECT * FROM piezas");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Piezas</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h2>Gestión de Piezas</h2>
    <a href="<?php echo 'panel' . $rol . '.php'; ?>">← Regresar</a>
    <hr>

    <?php if ($rol != 'empleado'): ?>
    <form method="POST">
        <input type="hidden" name="id" id="id">
        <input type="text" name="nombre" placeholder="Nombre de la pieza" required>
        <input type="text" name="descripcion" placeholder="Descripción" required>
        <select name="estado">
            <option value="buena">Buena</option>
            <option value="defectuosa">Defectuosa</option>
            <option value="retrabajo">Retrabajo</option>
        </select>
        <button type="submit" name="agregar">Agregar</button>
        <button type="submit" name="editar">Editar</button>
    </form>
    <hr>
    <?php endif; ?>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Estado</th>
            <?php if ($rol != 'empleado'): ?><th>Acciones</th><?php endif; ?>
        </tr>
        <?php while ($row = $piezas->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nombre'] ?></td>
            <td><?= $row['descripcion'] ?></td>
            <td><?= $row['estado'] ?></td>
            <?php if ($rol != 'empleado'): ?>
            <td>
                <a href="?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar pieza?')">Eliminar</a>
            </td>
            <?php endif; ?>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
