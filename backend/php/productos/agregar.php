<?php
session_start();
require __DIR__ . "/../../db/conexion.php";

if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    exit;
}

$nombre = trim($_POST['Nombre']);
$precio = floatval($_POST['Precio']);
$stock  = intval($_POST['Stock']);

$imagen = 'default.png';

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
    $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
    $imagen = uniqid() . "." . $ext;
    $uploadPath = __DIR__ . "/../../img/" . $imagen;

    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadPath)) {
        echo json_encode([
            'status' => 'error',
            'mensaje' => 'No se pudo guardar la imagen'
        ]);
        exit;
    }
}

$sql = "INSERT INTO tb_productos (Nombre, Precio, Stock, imagen)
        VALUES (?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die("Error prepare: " . $conexion->error);
}

$stmt->bind_param("sdis", $nombre, $precio, $stock, $imagen);

if (!$stmt->execute()) {
    die("Error execute: " . $stmt->error);
}

echo json_encode(['status' => 'ok']);
