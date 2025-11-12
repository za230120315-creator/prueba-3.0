<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$contrasena'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['usuario'] = $row['usuario'];
        $_SESSION['rol'] = $row['rol'];

        if ($row['rol'] == 'Director') {
            header("Location: panelDirector.php");
        } elseif ($row['rol'] == 'Supervisor') {
            header("Location: panelSupervisor.php");
        } else {
            header("Location: panelEmpleado.php");
        }
        exit;
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location='index.html';</script>";
    }
}
?>

