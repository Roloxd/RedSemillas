//Object
const datos = {
    persona1_nif: '',
    persona1_nombre: '',
    persona1_apellidos: ''
}

document.addEventListener('DOMContentLoaded', function() {
    validarFormulario();
});

function validarFormulario(){
    //Etiquetas
    const dni = document.querySelector('#persona1_nif');
    const nombre = document.querySelector('#persona1_nombre');
    const apellidos = document.querySelector('#persona1_apellidos');

    //Eventos
    dni.addEventListener('input', leerValor);
    nombre.addEventListener('input', leerValor);
    apellidos.addEventListener('input', leerValor);
}

function leerValor(evento) {
    datos[evento.target.id] = evento.target.value;
}

//Evento submit
const formulario = document.querySelector(".formPersona");
const button = document.querySelector(".enviar");

if(formulario != null) {
    formulario.addEventListener('submit', evento => {
        evento.preventDefault();
        
        //Validar formulario
        const {persona1_nif, persona1_nombre, persona1_apellidos} = datos;

        const patronDNI = /^[0-9]{8}[a-z]{1}$/i;
        const patronText = /^([a-z]+[\s]?)+$/i;

        const comparacionDNI = patronDNI.test(persona1_nif);
        const comparacionNombre = patronText.test(persona1_nombre);
        const comparacionApellidos = patronText.test(persona1_apellidos);

        if(persona1_nif == '' || !comparacionDNI){
            mostrarAlerta('DNI incorrecto', true);
        } else if (persona1_nombre == '' || persona1_apellidos == '' || !comparacionNombre || !comparacionApellidos) {
            mostrarAlerta('Nombre o Apellidos son incorrectos', true);
        } else {
            newPersona();
        }
    });
}

function mostrarAlerta( mensaje, error = null){
    const alerta = document.createElement('P');
    alerta.textContent = mensaje;

    if(error) {
        alerta.classList.add('error');
    }

    etiqueta = document.querySelector('.alerta');
    etiqueta.appendChild(alerta);

    // Desaparece despues de 5seg
    setTimeout(()=>{
        alerta.remove();
    }, 5000);
}

function newPersona(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            var respuesta = JSON.parse(this.response);
            
            const select = document.querySelector('#terreno_id_persona');
            const option = document.createElement('OPTION');

            option.value = respuesta['id'];
            option.innerText = respuesta['nombre'];

            select.appendChild(option);

            $('#exampleModal').modal('hide');
        }
        
    };

    const {persona1_nif, persona1_nombre, persona1_apellidos} = datos;
    var params = 'dni=' + persona1_nif + "&nombre=" + persona1_nombre + "&apellidos=" + persona1_apellidos;

    xhttp.open("POST", "/admin/persona/add", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
    return false;
}