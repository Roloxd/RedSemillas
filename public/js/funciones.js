//Objects
const datos = {};

const formPersona = document.querySelector(".formPersona");
const formVariedad = document.querySelector(".formVariedad");
const formImagen = document.querySelector(".formImagen");
const formImagenSelect = document.querySelector(".formImagenSelect");

document.addEventListener('DOMContentLoaded', function() {
    if(formPersona){
        validarFormularioPersona();
    }

    if(formVariedad){
        validarFormularioVariedad();
    }

    if(formImagen){
        validarFormularioImagen();
    }

    if(formImagenSelect){
        validarFormularioImagenSelect();
    }
    
});

function validarFormularioPersona(){
    //Etiquetas
    const dni = document.querySelector('#persona1_nif');
    const nombre = document.querySelector('#persona1_nombre');
    const apellidos = document.querySelector('#persona1_apellidos');

    //Eventos
    dni.addEventListener('input', leerValor);
    nombre.addEventListener('input', leerValor);
    apellidos.addEventListener('input', leerValor);
}

function validarFormularioVariedad(){
    const nombreComun = document.querySelector('#variedad1_nombreComun');
    const nombreLocal = document.querySelector('#variedad1_nombreLocal');
    const especie = document.querySelector('#variedad1_especie');
    const descripcion = document.querySelector('#variedad1_descripcion');
    const tipoSiembra = document.querySelector('#variedad1_tipoSiembra');
    const diasSemillero = document.querySelector('#variedad1_diasSemillero');
    const marcoA = document.querySelector('#variedad1_marcoA');
    const marcoB = document.querySelector('#variedad1_marcoB');
    const densidad = document.querySelector('#variedad1_densidad');
    const cicloCultivo = document.querySelector('#variedad1_cicloCultivo');
    const polinizacion = document.querySelector('#variedad1_polinizacion');
    const caracterizacion = document.querySelector('#variedad1_caracterizacion');
    const viabilidadMin = document.querySelector('#variedad1_viabilidadMin');
    const viabilidadMax = document.querySelector('#variedad1_viabilidadMax');
    const conocimientosTradicionales = document.querySelector('#variedad1_conocimientosTradicionales');
    const cmPlanta = document.querySelector('#variedad1_cmPlanta');
    const cmFlor = document.querySelector('#variedad1_cmFlor');
    const cmFruto = document.querySelector('#variedad1_cmFruto');
    const cmSemilla = document.querySelector('#variedad1_cmSemilla');
    const cArgonomicas = document.querySelector('#variedad1_cArgonomicas');
    const cOrganolepticas = document.querySelector('#variedad1_cOrganolepticas');
    const propagacion = document.querySelector('#variedad1_propagacion');
    const otros = document.querySelector('#variedad1_otros');
    const observaciones = document.querySelector('#variedad1_observaciones');
    const cicloYSiembras = document.querySelector('#variedad1_cicloYSiembras');
    const subtaxon = document.querySelector('#variedad1_subtaxon');

    //Eventos
    nombreComun.addEventListener('input', leerValor);
    nombreLocal.addEventListener('input', leerValor);
    especie.addEventListener('input', leerValor);
    descripcion.addEventListener('input', leerValor);
    tipoSiembra.addEventListener('input', leerValor);
    diasSemillero.addEventListener('input', leerValor);
    marcoA.addEventListener('input', leerValor);
    marcoB.addEventListener('input', leerValor);
    densidad.addEventListener('input', leerValor);
    cicloCultivo.addEventListener('input', leerValor);
    polinizacion.addEventListener('input', leerValor);
    caracterizacion.addEventListener('input', leerValor);
    viabilidadMin.addEventListener('input', leerValor);
    viabilidadMax.addEventListener('input', leerValor);
    conocimientosTradicionales.addEventListener('input', leerValor);
    cmPlanta.addEventListener('input', leerValor);
    cmFlor.addEventListener('input', leerValor);
    cmFruto.addEventListener('input', leerValor);
    cmSemilla.addEventListener('input', leerValor);
    cArgonomicas.addEventListener('input', leerValor);
    cOrganolepticas.addEventListener('input', leerValor);
    propagacion.addEventListener('input', leerValor);
    otros.addEventListener('input', leerValor);
    observaciones.addEventListener('input', leerValor);
    cicloYSiembras.addEventListener('input', leerValor);
    subtaxon.addEventListener('input', leerValor);
}

function validarFormularioImagen(){
    const titulo = document.querySelector('#imagen_titulo');
    const imagen = document.querySelector('#imagen_url');
    const credito = document.querySelector('#imagen_credito');

    titulo.addEventListener('input', leerValor);
    imagen.addEventListener('input', leerValor);
    credito.addEventListener('input', leerValor);
}

function validarFormularioImagenSelect(){
    const tipo = document.querySelector('#imagen_seleccionada_tipo');

    tipo.addEventListener('input', leerValor);
}

function leerValor(evento) {
    datos[evento.target.id] = evento.target.value;
    console.table(datos);
}

//Evento submit
const button = document.querySelector(".enviar");

if(formPersona != null) {
    formPersona.addEventListener('submit', evento => {
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

if(formVariedad != null) {
    formVariedad.addEventListener('submit', evento => {
        evento.preventDefault();
        
        divVariedad = document.querySelector('#variedad');
        divImagen = document.querySelector('#imagen');

        $(divVariedad).hide();
        $(divImagen).show();
        
        newVariedad();
    });
}

if(formImagen != null) {
    formImagen.addEventListener('submit', evento => {
        evento.preventDefault();

        divImagen = document.querySelector('#imagen');
        divImagenSelect = document.querySelector('#imagenSelect');

        $(divImagen).hide();
        $(divImagenSelect).show();
        
        newImagen();
    });
}

if(formImagenSelect != null) {
    formImagenSelect.addEventListener('submit', evento => {
        evento.preventDefault();        
        newImagenSelect();
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

function newVariedad(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            var respuesta = JSON.parse(this.response);
            
            const input = document.createElement('INPUT');
            input.setAttribute('type', 'hidden');
            input.setAttribute('value', respuesta['idVariedad']);
            input.setAttribute('id', 'idVariedad');

            imagenSelect.appendChild(input);
        }

    };

    const {variedad1_nombreComun, variedad1_tipoSiembra, variedad1_polinizacion, variedad1_observaciones} = datos;

    var params = 'nombreComun=' + variedad1_nombreComun + "&tipoSiembra=" + variedad1_tipoSiembra + "&polinizacion=" + variedad1_polinizacion + "&observaciones=" + variedad1_observaciones;

    xhttp.open("POST", "/admin/variedades/add", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
    return false;
}

function newImagen(){
    // var xhttp = new XMLHttpRequest();
    // xhttp.onreadystatechange = function () {
    //     if(this.readyState == 4 && this.status == 200){
    //         var respuesta = JSON.parse(this.response);
            
    //         const input = document.createElement('INPUT');
    //         input.setAttribute('type', 'hidden');
    //         input.setAttribute('value', respuesta['idImagen']);
    //         input.setAttribute('id', 'idImagen');

    //         imagenSelect.appendChild(input);

            $.ajax({
                url:"/admin/variedades/new",
                data: new FormData(formImagen),// la función formData está disponible en casi todos los navegadores nuevos.
                type:"post",
                contentType:false,
                processData:false,
                cache:false,
                dataType:"json", // Cambie esto de acuerdo con su respuesta del servidor.
                error:function(err){
                      console.error(err);
                },
                success:function(data){
                     console.log(data);      
                },
                complete:function(){
                 console.log("Solicitud finalizada.");
              
                }
            });
        // }
    // };

    // const {imagen_titulo, imagen_credito} = datos;
    // var params = 'titulo=' + imagen_titulo + "&credito=" + imagen_credito;

    // xhttp.open("POST", "/admin/imagen/add", true);
    // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // xhttp.send(params);
    // return false;
}

function newImagenSelect(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            //var respuesta = JSON.parse(this.response);
            
        }
    };

    const {} = datos;

    //var params = 'titulo=' + imagen_titulo + "&credito=" + imagen_credito;

    xhttp.open("POST", "/admin/imagen/add", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
    return false;
}

function cerrar(){
    window.location.href = "/admin/variedades";
}