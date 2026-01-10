<?php
session_start();
require __DIR__ . "/db/conexion.php";

$usuario = trim($_POST['Usuario']);
$password = trim($_POST['Contra']);

$sql = "SELECT * FROM tb_usuarios WHERE Usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $row = $resultado->fetch_assoc();

    if (password_verify($password, $row['Contra'])) {
        $_SESSION['usuario'] = $row['Usuario'];
        header("Location: ../frontend/desk/dashboard.php");
        exit;
    }
}

header("Location: login.php?error=1");
exit;
