const formDonante = document.querySelector(".formDonante");
const formPersona = document.querySelector(".formPersona");
const formEditPersona = document.querySelector(".formEditPersona");

document.addEventListener('DOMContentLoaded', function() {
    // mostrarCodigoInstituto();
    inicioForm();
});

function inicioForm() {
    eventList(); // Listado de eventos
    createOptionsTipoDonante('donante_tipoDonante'); // Create options de Tipo de Donante
    consultarInstitutos(); // Obtiene los institutos
}

// if(formPersona != null && formDonante != null) {
//     formDonante.addEventListener('submit', evento => {
//         evento.preventDefault();
//         newDonante();
//     });
// }

function alertDomiciliar(etiqueta) {
    if( $(etiqueta).prop('checked') ) {
        alert('Informamos que la devolución del recibo tendrá un coste adicional de 1€');
    }
}

// function newDonante(){
//     $.ajax({
//         url:"/admin/donante/add",
//         data: new FormData(formDonante),
//         type:"post",
//         contentType:false,
//         processData:false,
//         cache:false,
//         error:function(err){
//                 console.error(err);
//         },
//         success:function(data){
//             const inputHidden = document.querySelector('#persona_donante');
//             inputHidden.value = data['idDonante'];

//             $('#exampleModal').modal('hide');

//             const btnDonante = document.querySelector('#btn-donante');
//             btnDonante.innerText = "Ahora registre la Persona"
//             btnDonante.disabled = true;
//         },
//         complete:function(){
//             //console.log("Solicitud finalizada.");
//         }
//     });
// }

// function mostrarCodigoInstituto() {
//     if(formPersona && formDonante){
//         const inputInstCode = document.querySelector('#donante_tipo_donante');
//         inputInstCode.addEventListener('change', function(evento){
//             if(evento.target.value == 'Instituto de germoplasma'){
//                 $('#instcode').show();
//             } else {
//                 $('#instcode').hide();
//             }
//         });
//     } else if (formEditPersona) {
//         const btnDonante = document.querySelector('#btn-donante');
//         btnDonante.innerText = "Añadir como donante (En construcción)"
//         btnDonante.disabled = true;
//     }
// }

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

            for( const [key, value] of Object.entries(data) ) {
                const selectInstituto = document.querySelector('#donante_codigoInstituto');
                const selectInstitutoRecolector = document.querySelector('#donante_institutoRecolector');
                const selectInstitutoMejoramiento = document.querySelector('#donante_institutoMejoramiento');
                
                const option = document.createElement('OPTION');
                option.value = key;
                option.textContent = `[${key}] ${value}`;

                selectInstituto.appendChild(option);

                const optionRecolector = document.createElement('OPTION');
                optionRecolector.value = key;
                optionRecolector.textContent = `[${key}] ${value}`;

                selectInstitutoRecolector.appendChild(optionRecolector);

                const optionMejoramiento = document.createElement('OPTION');
                optionMejoramiento.value = key;
                optionMejoramiento.textContent = `[${key}] ${value}`;

                selectInstitutoMejoramiento.appendChild(optionMejoramiento);
            }
        },
        complete:function(){
            //console.log("Solicitud finalizada.");
        }
    });
}