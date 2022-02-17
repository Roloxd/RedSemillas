
document.addEventListener('DOMContentLoaded', function() {
    iniciarForm();
});

function iniciarForm() {

    const pagina = document.querySelector('#titulo-pagina');
    if(pagina.textContent === "Editar Terreno") {
        consultarPersonas('terreno_personas', 'personas', 'class'); // Retona las Persona y las inserta como Options en el Select

    } else if (pagina.textContent === "Nuevo Terreno") {
        consultarPersonas('terreno_personas', 'personas');
    }
    
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

function crearOption(id, textContent) { // consulta.js
    const option = document.createElement('OPTION');
    option.value = id;
    option.textContent = textContent;

    // Seleccionar propietarios
    const personasSelect = document.querySelectorAll('.personasSelect');

    // Pasamos los ids a un array
    let ids = new Array;
    if(personasSelect.length > 0) {
        personasSelect.forEach( input => {
            ids.push( parseInt(input.value) );
        });

        if(ids.indexOf( id ) >= 0) {
            option.setAttribute('selected', 'selected');
        }
    }

    const select = document.querySelector('#terreno_propietarios');
    select.appendChild(option);
}