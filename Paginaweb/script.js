let contador = 0;

function agregar() {
    contador++;
    document.getElementById("contador").innerText = contador;
}

function quitar() {
    if (contador > 0) {
        contador--;
        document.getElementById("contador").innerText = contador;
    }
}

