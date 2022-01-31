const formDonante = document.querySelector(".formDonante");
const formPersona = document.querySelector(".formPersona");
const formEditPersona = document.querySelector(".formEditPersona");

document.addEventListener('DOMContentLoaded', function() {
    mostrarCodigoInstituto();
    EventosClick(); // Eventos de los Checkbox
});

if(formPersona != null && formDonante != null) {
    formDonante.addEventListener('submit', evento => {
        evento.preventDefault();
        newDonante();
    });
}

function alertDomiciliar(etiqueta) {
    if( $(etiqueta).prop('checked') ) {
        alert('Informamos que la devolución del recibo tendrá un coste adicional de 1€');
    }
}

function newDonante(){
    $.ajax({
        url:"/admin/donante/add",
        data: new FormData(formDonante),
        type:"post",
        contentType:false,
        processData:false,
        cache:false,
        error:function(err){
                console.error(err);
        },
        success:function(data){
            const inputHidden = document.querySelector('#persona_donante');
            inputHidden.value = data['idDonante'];

            $('#exampleModal').modal('hide');

            const btnDonante = document.querySelector('#btn-donante');
            btnDonante.innerText = "Ahora registre la Persona"
            btnDonante.disabled = true;
        },
        complete:function(){
            //console.log("Solicitud finalizada.");
        }
    });
}

function mostrarCodigoInstituto() {
    if(formPersona && formDonante){
        const inputInstCode = document.querySelector('#donante_tipo_donante');
        inputInstCode.addEventListener('change', function(evento){
            if(evento.target.value == 'Instituto de germoplasma'){
                $('#instcode').show();
            } else {
                $('#instcode').hide();
            }
        });
    } else if (formEditPersona) {
        const btnDonante = document.querySelector('#btn-donante');
        btnDonante.innerText = "Añadir como donante (En construcción)"
        btnDonante.disabled = true;
    }
}

function EventosClick() {
    checkboxInscriptoROPE = document.querySelector('#persona2_inscripcion_rope');
    checkboxInscriptoROPE.addEventListener('change', validarCheckbox, false);

    checkboxAmpliacionCuota = document.querySelector('#persona2_ampliacion_cuota');
    checkboxAmpliacionCuota.addEventListener('change', validarCheckbox, false);

    checkboxRecibirInformacion = document.querySelector('#persona2_recibir_informacion');
    checkboxRecibirInformacion.addEventListener('change', validarCheckbox, false);
}

// Comprueba si el Checkbox se marco o no
function validarCheckbox(e) {
    checked = e.target.checked;
    mostrarInput(checked ,e.target.dataset.campo); 
}

// Muestra y oculta input
function mostrarInput(checked, campo) {
    campo = document.querySelector(`#${campo}`);
    if(checked){
        campo.classList.remove('d-none');
        campo.classList.add('d-block');
    } else {
        campo.classList.remove('d-block');
        campo.classList.add('d-none');
    }
}