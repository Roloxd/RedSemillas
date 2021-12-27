const formDonante = document.querySelector(".formDonante");
const formPersona = document.querySelector(".formPersona");
const formEditPersona = document.querySelector(".formEditPersona");

document.addEventListener('DOMContentLoaded', function() {
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
});

if(formPersona != null && formDonante != null) {
    formDonante.addEventListener('submit', evento => {
        evento.preventDefault();
        newDonante();
    });
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