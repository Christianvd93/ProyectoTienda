/* =========================================================
   TIENDA DE ACCESORIOS FLORALES - JAVASCRIPT PRINCIPAL
   ========================================================= */

console.log("✅ El archivo script.js cargó correctamente con el motor de animación.");

let contador = 0;
let isPaused = false;

// --- 1. FUNCIONES GLOBALES DE ACCESO Y REDIRECCIÓN ---
function verificarAcceso(rutaDestino) {
    if (typeof usuarioLogueado !== 'undefined' && usuarioLogueado) {
        window.location.href = rutaDestino;
    } else {
        alert("Para explorar el catálogo completo o ver tu carrito, debes iniciar sesión.");
        window.location.href = "api_login/login.php";
    }
}

function verificarAccesoCategoria(idCategoria) {
    if (typeof usuarioLogueado !== 'undefined' && usuarioLogueado) {
        window.location.href = `Paginaweb/catalogo.php?categoria=${idCategoria}`;
    } else {
        alert("Para explorar los productos de esta categoría, debes iniciar sesión.");
        window.location.href = "api_login/login.php";
    }
}

// --- 2. FUNCIÓN DEL CARRITO DE COMPRAS ---
window.agregarAlCarrito = function(evento, idProducto) {
    if (typeof usuarioLogueado === 'undefined' || !usuarioLogueado) {
        alert("Debes iniciar sesión para agregar productos al carrito.");
        window.location.href = "api_login/login.php";
        return; 
    }
    
    contador++;
    const contadorBadge = document.getElementById('contadorCarrito');
    if(contadorBadge) {
        contadorBadge.innerText = contador;
    }
    
    let btn = evento.target;
    let textoOriginal = btn.innerText;
    btn.innerText = "¡Agregado!";
    btn.classList.replace('btn-outline-accent', 'btn-accent');
    
    setTimeout(() => {
        btn.innerText = textoOriginal;
        btn.classList.replace('btn-accent', 'btn-outline-accent');
    }, 1500);
};

// --- 3. FUNCIÓN DE LAS FLECHAS MANUALES ---
window.moverRiel = function(distancia) {
    const riel = document.getElementById('rielProductos');
    if (riel) {
        isPaused = true; 
        riel.style.scrollBehavior = 'smooth';
        riel.scrollLeft += distancia;
        
        setTimeout(() => {
            isPaused = false;
        }, 1500);
    }
};

// --- 4. MOTOR DE ANIMACIÓN AUTOMÁTICA ---
window.addEventListener("load", function() {
    const riel = document.getElementById('rielProductos');
    if (!riel) return; 

    const cardsOriginales = riel.querySelectorAll('.card-producto');
    if (cardsOriginales.length <= 1) return; 

    // Clonamos las tarjetas
    cardsOriginales.forEach(card => {
        const clon = card.cloneNode(true);
        riel.appendChild(clon);
    });

    let vel_autoplay = 1;

    function autoScroll() {
        if (!isPaused && riel) {
            riel.style.scrollBehavior = 'auto'; 
            riel.scrollLeft += vel_autoplay;

            if (riel.scrollLeft >= (riel.scrollWidth / 2)) {
                riel.scrollLeft = 0; 
            }
        }
        requestAnimationFrame(autoScroll);
    }
    /**
 * --- MÓDULO DE GESTIÓN DE CARRITO ---
 */

// 1. Función para actualizar el contador y el contenido del carrito
function actualizarCarritoUI() {
    // Asegúrate de que la ruta sea correcta desde cualquier página
    // Si estás en la raíz, puede ser 'api/gestionar_carrito.php'
    // Si estás en Paginaweb/, puede ser '../api/gestionar_carrito.php'
    fetch('/Proyectotienda/api/gestionar_carrito.php?action=obtener')
        .then(response => response.json())
        .then(data => {
            // Actualizar contador navbar
            const badge = document.getElementById('contadorCarrito');
            if (badge) badge.innerText = data.total_articulos;

            // Actualizar tabla en carrito.php (si estamos en esa página)
            const tabla = document.getElementById('tablaCarritoDetallada');
            if (tabla) {
                let html = '';
                data.productos.forEach(prod => {
                    html += `<tr>
                        <td><img src="../uploads/productos/${prod.imagen}" width="50"> ${prod.nombre}</td>
                        <td>$${parseInt(prod.precio).toLocaleString()}</td>
                        <td>
                            <button class="btn btn-sm" onclick="gestionarCarrito('disminuir', ${prod.id})">-</button>
                            ${prod.cantidad}
                            <button class="btn btn-sm" onclick="gestionarCarrito('aumentar', ${prod.id})">+</button>
                        </td>
                        <td>$${parseInt(prod.subtotal).toLocaleString()}</td>
                        <td><button class="btn btn-danger btn-sm" onclick="gestionarCarrito('eliminar', ${prod.id})">x</button></td>
                    </tr>`;
                });
                tabla.innerHTML = html;
            }

            // Actualizar resumen lateral o de resumen (si existen los IDs)
            if(document.getElementById('resumenSubtotal')) {
                document.getElementById('resumenCount').innerText = data.total_articulos;
                document.getElementById('resumenSubtotal').innerText = '$' + data.subtotal.toLocaleString();
                document.getElementById('resumenTotal').innerText = '$' + data.total.toLocaleString();
            }
        })
        .catch(error => console.error('Error al actualizar carrito:', error));
}

// 2. Función para disparar las acciones (agregar, eliminar, etc.)
function gestionarCarrito(accion, idProducto) {
    fetch(`/Proyectotienda/api/gestionar_carrito.php?action=${accion}&id=${idProducto}`)
        .then(() => actualizarCarritoUI()) // Refresca la UI al terminar
        .catch(error => console.error('Error en gestión:', error));
}

// 3. Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    actualizarCarritoUI();
});

// Función para enviar acciones al servidor (Agregar, Quitar, Eliminar)
function gestionarCarrito(accion, idProducto) {
    fetch(`api/gestionar_carrito.php?action=${accion}&id=${idProducto}`)
        .then(() => actualizarCarritoUI());
}

    
    riel.addEventListener('mouseenter', () => isPaused = true);
    riel.addEventListener('mouseleave', () => isPaused = false);
    riel.addEventListener('touchstart', () => isPaused = true);
    riel.addEventListener('touchend', () => isPaused = false);

    autoScroll();
});