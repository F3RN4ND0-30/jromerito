<?php
session_start();
require __DIR__ . "/../../db/conexion.php";

if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    exit;
}

$nombre = trim($_POST['Nombre']);
$codigo = trim($_POST['Codigo']);
$precio = trim($_POST['Precio']);
$stock  = trim($_POST['Stock']);

$imagen = 'default.png';
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
    $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
    $imagen = uniqid() . "." . $ext;
    $uploadPath = __DIR__ . "/../../img/" . $imagen;
    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadPath)) {
        echo json_encode(['status' => 'error', 'mensaje' => 'No se pudo guardar la imagen']);
        exit;
    }
}

$sql = "INSERT INTO tb_productos (Codigo, Nombre, Precio, Stock, imagen) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssdss", $codigo, $nombre, $precio, $stock, $imagen);
$stmt->execute();
