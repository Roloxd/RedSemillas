const formGerminacion = document.querySelector('form[name="germinacion"]');

document.addEventListener('DOMContentLoaded', function() {
    if(formGerminacion) {
        iniciarForm(); // Inicia las funciones del formulario
    }
});

function iniciarForm() {
    eventListener(); // Eventos
}

function eventListener() {
    const selectEnvase = document.querySelector('#germinacion_envase');
    selectEnvase.addEventListener('change', obtenerEnvase);
}

// Obtener datos de Envase
function obtenerEnvase(e) {
    const idEnvase = e.target.value;

    $.ajax({
        url:`/admin/envase/findEnvase`,
        data: {'idEnvase': idEnvase, 'funcion': 'obtenerVariedades'},
        type:"POST",
        error:function(err){
            console.error(err);
        },
        success:function(data) {
            crearOption(data);
        },
        complete:function(){
            //console.log("Solicitud finalizada.");
        }
    });
}

function crearOption(data) {
    const selectVariedades = document.querySelector('#germinacion_variedades');
    const length = selectVariedades.options.length;

    // Elimina option anteriores
    if(length > 1) {
        for(let i = length; i >= 1 ; i--) {
            selectVariedades.remove(i);
        }
    }
    
    // Crea los options
    if( !Array.isArray(data) ) {
        for( const [key, value] of Object.entries(data) ) {
            const option = document.createElement('OPTION');
            option.value = key;
            option.textContent = value;

            selectVariedades.appendChild(option);
        }
    }
    
    comprobarOptions();
    mostrarVariedades(selectVariedades);
}

// Comprobar cuantos options existen, si solo hay 1, seleccionaarlo
function comprobarOptions() {
    const selectVariedades = document.querySelector('#germinacion_variedades');
    if(selectVariedades.options.length === 2){
        selectVariedades.options[1].setAttribute('selected', 'selected');
    }
}

function mostrarVariedades(selectVariedades) {
    const contenedorVariedades = document.querySelector('#contenedor-variedades');

    if(selectVariedades.options.length > 1 && contenedorVariedades) {
        contenedorVariedades.classList.remove('d-none');
        contenedorVariedades.classList.add('d-block');
    } else {
        contenedorVariedades.classList.add('d-none');
        contenedorVariedades.classList.remove('d-block');
    } 
}