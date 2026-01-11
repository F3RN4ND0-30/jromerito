// ------------------------------
// VARIABLES GLOBALES
// ------------------------------
let productos = []; // Array global para almacenar resultados del buscador

const buscador = document.getElementById("buscador");
const resultado = document.getElementById("resultado");

// Modales
const modalAgregar = document.getElementById("modalAgregar");
const modalEditar = document.getElementById("modalEditar");

// Formularios
const formAgregar = document.getElementById("formAgregar");
const formEditar = document.getElementById("formEditar");

// ------------------------------
// FUNCION PARA CARGAR PRODUCTOS
// ------------------------------
function cargarProductos() {
    const texto = buscador.value;

    fetch(`../../backend/php/productos/buscar.php?q=${texto}`)
        .then(res => res.json())
        .then(data => {
            productos = data; // Guardamos globalmente

            // Limpiar tabla
            resultado.innerHTML = "";

            // Agregar filas
            data.forEach(p => {
                resultado.innerHTML += `
                    <tr>
                        <td>
                            <img src="${p.imagen}" alt="${p.Nombre}" class="prod-img">
                            ${p.Nombre}
                        </td>
                        <td>$${p.Precio}</td>
                        <td>${p.Stock}</td>
                        <td>
                            <button class="btn-editar" data-id="${p.IdProducto}">Editar</button>
                        </td>
                    </tr>
                `;
            });

            // Inicializar o refrescar DataTables
            if ($.fn.DataTable.isDataTable('#tablaProductos')) {
                $('#tablaProductos').DataTable().destroy();
            }

            $('#tablaProductos').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                pageLength: 10,
                responsive: true,
                columnDefs: [
                    // Centrar todas las columnas menos la primera en el body
                    { className: "dt-center", targets: [1, 2, 3] }
                ],
                initComplete: function () {
                    // Centrar todo el header
                    $('#tablaProductos thead th').css('text-align', 'center');
                }
            });
        });
}

// Ejecutar al cargar la página
cargarProductos();

// ------------------------------
// BUSCADOR
// ------------------------------
buscador.addEventListener("keyup", () => {
    cargarProductos();
});

// ------------------------------
// MODAL AGREGAR
// ------------------------------
document.getElementById("btnAgregar").onclick = () => {
    modalAgregar.style.display = "flex";
    setTimeout(() => modalAgregar.classList.add("show"), 10);
};

document.querySelector("#modalAgregar .close").onclick = () => {
    modalAgregar.classList.remove("show");
    setTimeout(() => modalAgregar.style.display = "none", 300);
};

window.addEventListener("click", (e) => {
    if (e.target === modalAgregar) {
        modalAgregar.classList.remove("show");
        setTimeout(() => modalAgregar.style.display = "none", 300);
    }
});

// ------------------------------
// Enviar formulario editar
// ------------------------------
$(formEditar).off('submit').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(formEditar);

    $.ajax({
        url: '../../backend/php/productos/editar.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {

            const id = $('#editarIdProducto').val();
            const index = productos.findIndex(p => p.IdProducto == id);

            if (index !== -1) {
                // Actualizar array global
                productos[index].Nombre = $('#editarNombre').val();
                productos[index].Precio = $('#editarPrecio').val();
                productos[index].Stock = $('#editarStock').val();

                // Si subieron nueva imagen, actualizarla también
                const newImg = $('#formEditar input[name="imagen"]')[0].files[0];
                if (newImg) {
                    productos[index].imagen = URL.createObjectURL(newImg);
                }

                // Actualizar fila en DataTable
                const tabla = $('#tablaProductos').DataTable();
                const fila = tabla.row($(`button[data-id='${id}']`).closest('tr'));
                fila.data([
                    `<img src="${productos[index].imagen}" alt="${productos[index].Nombre}" class="prod-img"> ${productos[index].Nombre}`,
                    `$${productos[index].Precio}`,
                    `${productos[index].Stock}`,
                    `<button class="btn-editar" data-id="${id}">Editar</button>`
                ]).draw(false);
            }

            // Cerrar modal
            modalEditar.classList.remove("show");
            setTimeout(() => modalEditar.style.display = "none", 300);
        },
        error: function (err) {
            console.error(err);
        }
    });
});



// ------------------------------
// MODAL EDITAR
// ------------------------------
$(document).on('click', '.btn-editar', function () {
    const id = $(this).data('id');
    const producto = productos.find(p => p.IdProducto == id);

    if (!producto) return alert("Producto no encontrado");

    // Llenar formulario
    $('#editarIdProducto').val(producto.IdProducto);
    $('#editarNombre').val(producto.Nombre);
    $('#editarPrecio').val(producto.Precio);
    $('#editarStock').val(producto.Stock);

    // Mostrar modal
    modalEditar.style.display = "flex";
    setTimeout(() => modalEditar.classList.add("show"), 10);
});

// Cerrar modal editar
document.querySelector('#modalEditar .close').onclick = () => {
    modalEditar.classList.remove("show");
    setTimeout(() => modalEditar.style.display = "none", 300);
};

window.addEventListener("click", (e) => {
    if (e.target === modalEditar) {
        modalEditar.classList.remove("show");
        setTimeout(() => modalEditar.style.display = "none", 300);
    }
});

// Enviar formulario editar
formEditar.addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(formEditar);

    $.ajax({
        url: '../../backend/php/productos/editar.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (res) {
            alert(res); // Mensaje de éxito
            modalEditar.classList.remove("show");
            setTimeout(() => modalEditar.style.display = "none", 300);
            cargarProductos(); // Actualizar tabla inmediatamente
        },
        error: function (err) {
            console.error(err);
        }
    });
});
