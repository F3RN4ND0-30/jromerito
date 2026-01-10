<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../backend/css/dashboard/dashboard.css">
    <link rel="stylesheet" href="../../backend/css/dashboard/modal.css">
</head>

<body>

    <header>
        <h2>Consulta de Precios</h2>
        <!-- BOTÓN AGREGAR -->
        <button id="btnAgregar" class="btn-agregar">Agregar Producto</button>
        <a href="../logout.php">Salir</a>
    </header>

    <!-- MODAL -->
    <div id="modalAgregar" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Agregar Nuevo Producto</h3>
            <form id="formAgregar" enctype="multipart/form-data">
                <label>Nombre del producto</label>
                <input type="text" name="Nombre" required>

                <label>Código</label>
                <input type="text" name="Codigo" required>

                <label>Precio</label>
                <input type="number" name="Precio" step="0.01" required>

                <label>Stock</label>
                <input type="number" name="Stock" required>

                <label>Imagen</label>
                <input type="file" name="imagen" accept="image/*">

                <button type="submit">Agregar Producto</button>
            </form>
        </div>
    </div>

    <div class="container">

        <div class="search-box">
            <input type="text" id="buscador" placeholder="Buscar producto por nombre o código">
        </div>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody id="resultado"></tbody>
        </table>

    </div>

    <script src="../../backend/js/desk/dashboard.js"></script>
</body>

</html>