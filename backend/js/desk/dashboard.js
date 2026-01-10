const buscador = document.getElementById("buscador");
const resultado = document.getElementById("resultado");

buscador.addEventListener("keyup", () => {
    const texto = buscador.value;

    fetch(`../../backend/php/productos/buscar.php?q=${texto}`)
        .then(res => res.json())
        .then(data => {
            resultado.innerHTML = "";

            data.forEach(p => {
                resultado.innerHTML += `
        <tr>
            <td>
                <img src="${p.imagen}" alt="${p.Nombre}" class="prod-img">
                ${p.Nombre}
            </td>
            <td>$${p.Precio}</td>
            <td>${p.Stock}</td>
        </tr>
    `;
            });
        });
});

const btnAgregar = document.getElementById("btnAgregar");
const modalAgregar = document.getElementById("modalAgregar");
const spanClose = document.querySelector("#modalAgregar .close");

btnAgregar.onclick = () => {
    modalAgregar.style.display = "flex";           // mostramos overlay
    setTimeout(() => modalAgregar.classList.add("show"), 10); // animamos contenido
};

spanClose.onclick = () => {
    modalAgregar.classList.remove("show");        // animación de cierre
    setTimeout(() => modalAgregar.style.display = "none", 300); // ocultar overlay
};

window.onclick = (e) => {
    if (e.target === modalAgregar) {
        modalAgregar.classList.remove("show");
        setTimeout(() => modalAgregar.style.display = "none", 300);
    }
};

const formAgregar = document.getElementById("formAgregar");

formAgregar.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(formAgregar);

    fetch("../../backend/php/productos/agregar.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.text())
        .then(res => {
            // Cierra el modal
            modalAgregar.style.display = "none";
            formAgregar.reset();
            // Recarga la tabla automáticamente
            buscador.dispatchEvent(new Event('keyup'));
        })
        .catch(err => console.error(err));
});
