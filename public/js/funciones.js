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
    const principal = document.querySelector('#imagen_principal');

    titulo.addEventListener('input', leerValor);
    imagen.addEventListener('input', leerValor);
    credito.addEventListener('input', leerValor);
    principal.addEventListener('input', leerValor);
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

        //Validar Formulario
        const {variedad1_marcoA, variedad1_marcoB, variedad1_densidad} = datos;

        const patron = /^[0-9]{1}[.]{1}[0-9]{3}$/i;

        const comparacionMarcoA = patron.test(variedad1_marcoA);
        const comparacionMarcoB = patron.test(variedad1_marcoB);
        const comparacionDensidad = patron.test(variedad1_densidad);


        if(!variedad1_marcoA == '' && !comparacionMarcoA){
            mostrarAlerta('Distacia entre planta, error de formato. | Formato: 0.000', true);
        } else if (!variedad1_marcoB == '' && !comparacionMarcoB) {
            mostrarAlerta('Distancia entre lineas, error de formato. | Formato: 0.000', true);
        } else if(!variedad1_densidad == '' && !comparacionDensidad) {
            mostrarAlerta('Densidad, error de formato. | Formato: 0.000', true);
        } else {
            divVariedad = document.querySelector('#variedad');
            divImagen = document.querySelector('#imagen');
            
            newVariedad();
        }
    });
}

if(formImagen != null) {
    formImagen.addEventListener('submit', evento => {
        evento.preventDefault();
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
    $.ajax({
        url:"/admin/variedades/add",
        data: new FormData(formVariedad),
        type:"post",
        contentType:false,
        processData:false,
        cache:false,
        error:function(err){
                console.error(err);
        },
        success:function(data){
            //console.log(data);
            url = "/admin/variedades/" + data['idVariedad'] + "/variedad/img";
            window.location.href = url;
        },
        complete:function(){
            //console.log("Solicitud finalizada.");
        }
    });
}

function newImagen(){
    $.ajax({
        url:"/admin/imagen/add",
        data: new FormData(formImagen),
        type:"post",
        contentType:false,
        processData:false,
        cache:false,
        error:function(err){
                console.error(err);
        },
        success:function(data){
            //console.log(data);
            if(data['neverRelation'] === true){
                const input = document.createElement('INPUT');
                input.setAttribute('type', 'hidden');
                input.setAttribute('value', data['idImagen']);
                input.setAttribute('id', 'idImagen');
    
                formImagen.appendChild(input);

                divImagen = document.querySelector('#imagen');
                divImagenSelect = document.querySelector('#imagenSelect');
    
                $(divImagen).hide();
                $(divImagenSelect).show();
            }

            document.querySelector('#imagen_titulo').value = "";
            document.querySelector('#imagen_credito').value = "";
            document.querySelector('#imagen_url').value = "";
        },
        complete:function(){
            //console.log("Solicitud finalizada.");
        }
    });
}

function newImagenSelect(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            url = "/admin/variedades/" + variedad.value + "/variedad/img";

            $('#idVariedad').remove();
            $('#idImagen').remove();

            window.location.href = url;
        }
    };

    const {imagen_seleccionada_tipo} = datos;
    var variedad = document.querySelector('#idVariedad');
    var imagen = document.querySelector('#idImagen');

    var params = 'tipo=' + imagen_seleccionada_tipo + '&idVariedad=' + variedad.value + '&idImagen=' + imagen.value;

    xhttp.open("POST", "/admin/img/seleccion/add", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
    return false;
}

function addRelation(idImagen){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){

        }
    };

    var variedad = document.querySelector('#idVariedad');
    // var imagen = document.querySelector('#idImagen');
    console.log(idImagen);
    var params = 'idVariedad=' + variedad.value + '&idImagen=' + idImagen;

    xhttp.open("POST", "/admin/img/seleccion/relation", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
    return false;
}

function cerrar(){
    window.location.href = "/admin/variedades";
}

