// mensajes.js
document.addEventListener("DOMContentLoaded", function() {
    // Función para mostrar un mensaje
    function mostrarMensaje(mensaje) {
        alert(mensaje);
    }

    // Verificar si hay un parámetro "success" en la URL
    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');

    // Si el parámetro "success" es "true", mostrar el mensaje de éxito
    if (successParam === 'true') {
        mostrarMensaje("Registro exitoso.");
    }

    // Verificar si hay un parámetro "error" en la URL
    const errorParam = urlParams.get('error');

    // Si el parámetro "error" no está vacío, mostrar el mensaje de error
    if (errorParam) {
        mostrarMensaje("Error: " + errorParam);
    }
});
