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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../backend/css/dashboard/dashboard.css">
    <link rel="stylesheet" href="../../backend/css/dashboard/modal.css">

    <!-- jQuery (necesario para DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

</head>

<body>

    <header>
        <h2>Consulta de Precios</h2>
        <a href="../logout.php">Salir</a>
    </header>

    <div class="container">

        <div class="search-box">
            <input type="text" id="buscador" placeholder="Buscar producto por nombre o código">
            <button id="btnAgregar" class="btn-agregar">Agregar Producto</button>
        </div>

        <table id="tablaProductos">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="resultado"></tbody>
        </table>
    </div>

    <!-- MODAL AGREGAR -->
    <div id="modalAgregar" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Agregar Nuevo Producto</h3>
            <form id="formAgregar" enctype="multipart/form-data">
                <label>Nombre del producto</label>
                <input type="text" name="Nombre" required>

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

    <!-- MODAL EDITAR -->
    <div id="modalEditar" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Editar Producto</h3>
            <form id="formEditar" enctype="multipart/form-data">
                <input type="hidden" name="IdProducto" id="editarIdProducto">

                <label>Nombre del producto</label>
                <input type="text" name="Nombre" id="editarNombre" required>

                <label>Precio</label>
                <input type="number" name="Precio" id="editarPrecio" step="0.01" required>

                <label>Stock</label>
                <input type="number" name="Stock" id="editarStock" required>

                <label>Imagen</label>
                <input type="file" name="imagen" accept="image/*">

                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>


    <script src="../../backend/js/desk/dashboard.js"></script>
</body>

</html>