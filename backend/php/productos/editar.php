<?php
session_start();
require __DIR__ . "/../../db/conexion.php";

if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    exit;
}

// Validar que recibimos el ID
if (!isset($_POST['IdProducto']) || empty($_POST['IdProducto'])) {
    echo "ID de producto no proporcionado";
    exit;
}

$id = trim($_POST['IdProducto']);
$nombre = trim($_POST['Nombre']);
$precio = trim($_POST['Precio']);
$stock  = trim($_POST['Stock']);

// Primero, obtener la imagen actual del producto
$sql = "SELECT imagen FROM tb_productos WHERE IdProducto = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Producto no encontrado";
    exit;
}

$row = $result->fetch_assoc();
$imagen = $row['imagen']; // imagen actual

// Si subieron nueva imagen, reemplazarla
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
    $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
    $imagenNueva = uniqid() . "." . $ext;
    $uploadPath = __DIR__ . "/../../img/" . $imagenNueva;

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadPath)) {
        // Opcional: borrar imagen antigua si no es default
        if ($imagen !== 'default.png' && file_exists(__DIR__ . "/../../img/" . $imagen)) {
            unlink(__DIR__ . "/../../img/" . $imagen);
        }
        $imagen = $imagenNueva;
    } else {
        echo "No se pudo guardar la nueva imagen";
        exit;
    }
}

// Actualizar datos en la base de datos
$sqlUpdate = "UPDATE tb_productos SET  Nombre = ?, Precio = ?, Stock = ?, imagen = ? WHERE IdProducto = ?";
$stmtUpdate = $conexion->prepare($sqlUpdate);
$stmtUpdate->bind_param("sdssi", $nombre, $precio, $stock, $imagen, $id);

if ($stmtUpdate->execute()) {
    echo "Producto actualizado correctamente";
} else {
    echo "Error al actualizar producto: " . $conexion->error;
}
