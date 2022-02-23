const formDonante = document.querySelector(".formDonante");
const formPersona = document.querySelector(".formPersona");
const formEditPersona = document.querySelector(".formEditPersona");

document.addEventListener('DOMContentLoaded', function() {
    inicioForm();
});

function inicioForm() {
    eventList(); // Listado de eventos
    createOptionsTipoDonante('donante_tipoDonante'); // Create options de Tipo de Donante
    consultarInstitutos(); // Obtiene los institutos
}

function alertDomiciliar(etiqueta) {
    if( $(etiqueta).prop('checked') ) {
        alert('Informamos que la devolución del recibo tendrá un coste adicional de 1€');
    }
}

function eventList() {
    const checkboxInscriptoROPE = document.querySelector('#persona2_inscripcion_rope');
    checkboxInscriptoROPE.addEventListener('change', validarCheckbox, false);
    mostrarInput(checkboxInscriptoROPE.checked, checkboxInscriptoROPE.dataset.campo);

    const checkboxAmpliacionCuota = document.querySelector('#persona2_ampliacion_cuota');
    checkboxAmpliacionCuota.addEventListener('change', validarCheckbox, false);
    mostrarInput(checkboxAmpliacionCuota.checked, checkboxAmpliacionCuota.dataset.campo);

    const checkboxRecibirInformacion = document.querySelector('#persona2_recibir_informacion');
    checkboxRecibirInformacion.addEventListener('change', validarCheckbox, false);
    mostrarInput(checkboxRecibirInformacion.checked, checkboxRecibirInformacion.dataset.campo);

    const selectTipoDonante = document.querySelector('#donante_tipoDonante');
    selectTipoDonante.addEventListener('change', mostrarCodigoInstituto, false);
}

// Comprueba si el Checkbox se marco o no
function validarCheckbox(e) {
    const checked = e.target.checked;
    mostrarInput(checked ,e.target.dataset.campo); 
}

// Muestra y oculta input
function mostrarInput(checked, campo) {
    campo = document.querySelector(`#${campo}`);
    if(checked){
        campo.classList.remove('d-none');
    } else {
        campo.classList.add('d-none');
    }
}

// Create options de Tipo de Donante
function createOptionsTipoDonante(idElement) {
    const element = document.querySelector(`#${idElement}`);
    const tipoDonante = document.querySelector('#tipoDonante');

    const option1 = document.createElement('OPTION');
    option1.textContent = 'Selecciona tipo de donante';
    option1.setAttribute('selected', 'selected');
    option1.setAttribute('disabled', 'disabled');

    element.appendChild(option1);

    const option2 = document.createElement('OPTION');
    option2.value = 'Instituto de germoplasma';
    option2.textContent = 'Instituto de germoplasma';

    element.appendChild(option2);

    const option3 = document.createElement('OPTION');
    option3.value = 'Usuario';
    option3.textContent = 'Usuario';

    element.appendChild(option3);

    // Seleccionar option
    if(tipoDonante !== null) {
        if(tipoDonante.value === option2.value) {
            option2.setAttribute('selected', 'selected');
            document.querySelector('#campo-codigo-instituto').removeAttribute('style');
        } else if(tipoDonante.value === option3.value) {
            option3.setAttribute('selected', 'selected');
        }
    }
}

// Muestra el campo Código Instituto
function mostrarCodigoInstituto(e) {
    if(e.target.value === "Instituto de germoplasma") {
        $('#campo-codigo-instituto').show();
    } else {
        $('#campo-codigo-instituto').hide();
    }
}

// Obtiene los instutitos
function consultarInstitutos() {
    $.ajax({
        url:"/admin/instituciones/findAll",
        data: {'boolean': true},
        type:"post",
        error:function(err){
                console.error(err);
        },
        success:function(data){

            const selectInstituto = document.querySelector('#donante_codigoInstituto');
            const selectInstitutoRecolector = document.querySelector('#donante_institutoRecolector');
            const selectInstitutoMejoramiento = document.querySelector('#donante_institutoMejoramiento');

            for( const [key, value] of Object.entries(data) ) {
                const option = document.createElement('OPTION');
                option.value = key;
                option.textContent = `[${key}] ${value}`;
                selectInstituto.appendChild(option);

                //Selecciona option
                selectedOption('codigoInstituto', option);

                const optionRecolector = document.createElement('OPTION');
                optionRecolector.value = key;
                optionRecolector.textContent = `[${key}] ${value}`;
                selectInstitutoRecolector.appendChild(optionRecolector);

                selectedOption('institutoRecolector', optionRecolector);

                const optionMejoramiento = document.createElement('OPTION');
                optionMejoramiento.value = key;
                optionMejoramiento.textContent = `[${key}] ${value}`;
                selectInstitutoMejoramiento.appendChild(optionMejoramiento);

                selectedOption('institutoMejoramiento', optionMejoramiento);

            }
        },
        complete:function(){
            //console.log("Solicitud finalizada.");
        }
    });
}

// Seleciona el option
function selectedOption(id, option) {
    const elemento = document.querySelector(`#${id}`);
    if(elemento !== null) {
        if(elemento.value === option.value) {
            option.setAttribute('selected', 'selected');
        }
    }
}