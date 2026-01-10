<?php
session_start();
require __DIR__ . "/../../db/conexion.php";

if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    exit;
}

$busqueda = $_GET['q'] ?? '';

$sql = "SELECT Nombre, Precio, Stock, imagen
        FROM tb_productos 
        WHERE Nombre LIKE ? OR Codigo LIKE ?
        LIMIT 10";

$like = "%$busqueda%";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $like, $like);
$stmt->execute();

$result = $stmt->get_result();

$productos = [];

while ($row = $result->fetch_assoc()) {
    $row['imagen'] = '../../backend/img/' . (isset($row['imagen']) && $row['imagen'] ? $row['imagen'] : 'default.png');
    $productos[] = $row;
}

header("Content-Type: application/json");
echo json_encode($productos);

