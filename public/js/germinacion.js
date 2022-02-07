const formGerminacion = document.querySelector('form[name="germinacion"]');

const datos = {
    keyRevision: 0,
}

document.addEventListener('DOMContentLoaded', function() {
    if(formGerminacion) {
        iniciarForm(); // Inicia las funciones del formulario
    }
});

function iniciarForm() {
    eventListener(); // Eventos

    //generarModuloRevision(); // Genera un modulo Revision
}

function eventListener() {
    const selectEnvase = document.querySelector('#germinacion_envase');
    selectEnvase.addEventListener('change', obtenerEnvase);

    const btnAddRevision = document.querySelector('#btn-add-revision');
    btnAddRevision.addEventListener('click', generarModuloRevision);

    const btnShowRevision = document.querySelector('#btn-show-revision');
    btnShowRevision.addEventListener('click', function() {
        redireccion(window.location.pathname, 'http://localhost/admin/revision', '/ver');
    });
}

function redireccion(pathname, url, direccion) {
    const patron = /(\d+)/g;
    const id = pathname.match(patron);

    const enlace = url + '/' + id + direccion;
    const newWindow = window.open(enlace, '_blank');
    newWindow.focus();
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

function generarModuloRevision() {
    const colRigth = document.querySelector('#col-rigth');

    const modulo = crearModulo('Revision');
    colRigth.appendChild(modulo);

    // Gernerar contenido del modulo
    const cuerpoModulo = modulo.lastElementChild;

    const campoFecha = crearCampoFecha("Fecha inicio", "Fecha inicio de la revision.", "revision_fecha_revision", "revision[" + datos.keyRevision + "][fecha_revision]");
    cuerpoModulo.appendChild(campoFecha);

    const campoCheckboxRevisionFinalizada = crearCampoCheckbox("¿La revision ha terminado?", "Marcar si la revision ha finalizado.", "revision_prueba_finalizada", "revision[" + datos.keyRevision + "][revision_finalizada]", "Si");
    cuerpoModulo.appendChild(campoCheckboxRevisionFinalizada);

    const campoSemillasMuertas = crearCampoInput("Semillas muertas", "Revision de las semillas muertas.", "revision_semillas_muertas", "revision[" + datos.keyRevision + "][semillas_muertas]", "number");
    cuerpoModulo.appendChild(campoSemillasMuertas);

    const campoSemillasGerminadas = crearCampoInput("Semillas germinadas", "Revision de las semillas germinadas.", "revision_semillas_germinadas", "revision[" + datos.keyRevision + "][semillas_germinadas]", "number");
    cuerpoModulo.appendChild(campoSemillasGerminadas);

    const campoSemillasNoGerminadas = crearCampoInput("Semillas no germinadas", "Revision de las semillas no germinadas.", "revision_semillas_no_germinadas", "revision[" + datos.keyRevision + "][semillas_no_germinadas]", "number");
    cuerpoModulo.appendChild(campoSemillasNoGerminadas);

    const campoSemillasAnomalas = crearCampoInput("Semillas anómalas", "Revision de las semillas anómalas.", "revision_semillas_anomalas", "revision[" + datos.keyRevision + "][semillas_anomalas]", "number");
    cuerpoModulo.appendChild(campoSemillasAnomalas);

    const campoSemillasEnfermas = crearCampoInput("Semillas enfermas", "Revision de las semillas enfermas.", "revision_semillas_enfermas", "revision[" + datos.keyRevision + "][semillas_enfermas]", "number");
    cuerpoModulo.appendChild(campoSemillasEnfermas);
    
    const campoTemperaturaMax = crearCampoInput("Temperatura máxima", "Temperatura máxima.", "revision_temperatura_max", "revision[" + datos.keyRevision + "][temperatura_max]", "number", "any");
    cuerpoModulo.appendChild(campoTemperaturaMax);

    const campoTemperaturaMin = crearCampoInput("Temperatura minima", "Temperatura minima.", "revision_temperatura_min", "revision[" + datos.keyRevision + "][temperatura_min]", "number", "any");
    cuerpoModulo.appendChild(campoTemperaturaMin);

    const campoHumedadMax = crearCampoInput("Humedad máxima", "Humedad máxima.", "revision_humedad_max", "revision[" + datos.keyRevision + "][humedad_max]", "number", "any");
    cuerpoModulo.appendChild(campoHumedadMax);

    const campoHumedadMin = crearCampoInput("Humedad minima", "Humedad minima.", "revision_humedad_min", "revision[" + datos.keyRevision + "][humedad_min]", "number", "any");
    cuerpoModulo.appendChild(campoHumedadMin);

    datos.keyRevision++;
}

// Crea un modulo
function crearModulo(nombreModulo) {
    const modulo = document.createElement('DIV');
    modulo.classList = "card card-purple collapsed-card";

    modulo.innerHTML = `
    <div class="card-header">
        <h3 id="ancla-direccion" class="card-title">${nombreModulo}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="card-body"></div>
    `;

    return modulo;
}

function crearCampoFecha(textLabel, textTooltip, id, name) {
    const formGroup = document.createElement('DIV');
    formGroup.classList.add('form-group');

    formGroup.innerHTML = `
    <label for="${id}">${textLabel}</label>
    <a href="#" data-toggle="tooltip" title="${textTooltip}">?</a>
    <input type="date" id="${id}" name="${name}" required="required" class="form-control">
    `;

    return formGroup;
}

function crearCampoCheckbox(textLabel, textTooltip, id, name, textCheckbox) {
    const formGroup = document.createElement('DIV');
    formGroup.classList.add('form-group');

    formGroup.innerHTML = `
    <label>${textLabel}</label>
    <a href="#" data-toggle="tooltip" title="${textTooltip}">?</a>
    <div class="form-check">
        <input type="checkbox" id="${id}" name="${name}" class="form-check-input" value="1">
        <label class="form-check-label" for="${id}">${textCheckbox}</label>
    </div>
    `;

    return formGroup;
}

function crearCampoInput(textLabel, textTooltip, id, name, type, step = null) {
    const formGroup = document.createElement('DIV');
    formGroup.classList.add('form-group');

    formGroup.innerHTML = `
    <label for="${id}">${textLabel}</label>
    <a href="#" data-toggle="tooltip" title="${textTooltip}">?</a>
    `;

    if(step != null) {
        formGroup.innerHTML += `
        <input type="${type}" id="${id}" class="form-control" name="${name}" step="${step}">
        `;
    } else {
        formGroup.innerHTML += `
        <input type="${type}" id="${id}" class="form-control" name="${name}">
        `;
    }

    return formGroup;
}