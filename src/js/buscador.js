
document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
    buscarPorFecha();
}

function buscarPorFecha() {
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', function(event) {
        const fechaSeleccionada = event.target.value;
        
        window.location = `?fecha=${fechaSeleccionada}`;

        // Llamar a la API para mostrar las citas que corresponden a esa fecha seleccionada
    });
}