
document.addEventListener('DOMContentLoaded', function() {
    iniciarForm();
});

function iniciarForm() {
    consultarPersonas('terreno_personas', 'personas', 'class'); // Retona las Persona y las inserta como Options en el Select
    eventListener(); // Eventos
}

function eventListener() {
    $('.select-personas').on('change', obtenerSeleccionados);
}

function obtenerSeleccionados(e) {
    const select = document.querySelector('#terreno_propietarios');

    // Eliminar Options anteriores
    const length = select.options.length;
    if(length > 0) {
        for(let i = length; i >= 0 ; i--) {
            select.remove(i);
        }
    }

    //Crear option
    const options = e.target.selectedOptions;

    for( const [key, elemento] of Object.entries(options) ) {
        const option = document.createElement('OPTION');
        option.value = elemento.value;
        option.textContent = elemento.textContent;

        select.appendChild(option);
    }
}

