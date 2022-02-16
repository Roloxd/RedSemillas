const datos = {};
const formEntrada = document.querySelector('form[name="entrada1"]');
const formEditEntrada = document.querySelector(".formEditEntrada");

document.addEventListener('DOMContentLoaded', function() {

    var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});

    document.onreadystatechange = function () {
        myModal.show();
    };

    if(formEntrada){
        iniciarForm();
    }

//     if(formEditEntrada){
//         selectPersona();     
//     }
});

function iniciarForm() {
    eventListener(); // Eventos
    fechaActual();
    //consultarPersonas('entrada1_persona', 'persona', 'id'); // consultas.js
}

function eventListener() {
    $('.select-personas').on('select2:select', obtenerTerrenos);
}

function leerValor(evento) {
    datos[evento.target.id] = evento.target.value;

    if(evento.target.id == 'entrada1_persona'){
        const divTerreno = document.querySelector('#terreno');
        const selectTerreno = $('#entrada1_id_terreno');

        var dni = datos[evento.target.id];
        
        const patron = /^[0-9]{8}[A-Z]{1}$/i;
        const comparacionDNI = patron.test(dni);

        if(comparacionDNI){
            selectTerreno.empty();
            consultarTerrenos(dni);
        } else {
            $(divTerreno).hide();
        }
    }
}

function fechaActual(){
    const fecha = new Date();
    const year = fecha.getFullYear();
    const mes = fecha.getMonth() + 1; 
    const dia = fecha.getDate();
    
    if(mes < 10){
        stringMes = "0"+mes;
    } else {
        stringMes = mes;
    }

    if(dia < 10){
        stringDia = "0"+dia;
    } else {
        stringDia = dia;
    }
    
    document.querySelector("#entrada1_fecha_entrada").value = year + "-" + stringMes + "-" + stringDia;
}

function obtenerTerrenos(e, personaId) {
    
    if(e != null) {
        id = e.params.data.id;
    } else if(personaId != null) {
        id = personaId;
    }

    $.ajax({
        url:'/admin/terreno/getTerrenosPersona',
        data: {'personaId': id},
        type:"POST",
        error:function(err){
            console.error(err);
        },
        success:function(data) {
            crearOptionTerreno('entrada1_id_terreno', data);
        },
        complete:function(){
            //console.log("Solicitud finalizada.");
        }
    });
}

function crearOptionTerreno(etiqueta, data) {
    const select = document.querySelector(`#${etiqueta}`);
    const length = select.options.length;

    // Elimina option anteriores
    if(length > 0) {
        for(let i = length; i >= 0 ; i--) {
            select.remove(i);
        }
    }
    
    // Crea los options
    if( typeof data === 'object' ) {
        
        // Comprueba si existen terrenos asociados a la persona
        if( Object.keys(data.terrenos).length > 0) {
            const inputsHidden = document.querySelectorAll('.terrenos');

            // Pasamos los ids a un array
            ids = new Array;
            if(inputsHidden.length > 0) {
                inputsHidden.forEach( input => {
                    ids.push(input.value);
                });
            }
            // console.log(ids);

            for( const [id, datos] of Object.entries(data.terrenos) ) {
                const option = document.createElement('OPTION');
                option.value = id;

                if( datos.nombre != null) {
                    option.textContent = `${datos.nombre}`;
                }
                if( datos.municipio != null ) {

                    if(datos.nombre != null) {
                        option.textContent += ", ";
                    }
                    option.textContent += `${datos.municipio}`;

                }
                if( datos.direccion != null ) {

                    if(datos.municipio != null) {
                        option.textContent += ", ";
                    }
                    option.textContent += `${datos.direccion}`;

                }
                
                if(inputsHidden.length > 0 && ids.indexOf( id ) >= 0) {
                    option.setAttribute('selected', 'selected');
                }
                
                select.appendChild(option);
            }
        }
    }
}

// function consultarTerrenos(dni) {
//     var xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function () {
//         if(this.readyState == 4 && this.status == 200){
//             var respuesta = JSON.parse(this.response);

//             if(formEntrada){
//                 const divTerreno = document.querySelector('#terreno');
//                 const selectTerreno = document.querySelector('#entrada1_id_terreno');
                
//                 Object.values(respuesta).forEach(element => {
//                     if(element != ""){
//                         element.forEach(terrenos => {
//                             // MOSTRAR TERRENOS FORMULARIO ENTRADA
//                             array = Object.values(terrenos);

//                             const option = document.createElement('OPTION');
//                             option.value = array[0];
//                             option.innerText = array[1];

//                             selectTerreno.appendChild(option);

//                             $(divTerreno).show();
//                         });
//                     }
//                 });
//             } else if(formEditEntrada) {
//                 const divTerreno = document.querySelector('#terreno');
//                 const selectTerreno = document.querySelector('#entrada1_id_terreno');
                
//                 arrayTerrenosDeLaPersona = Object.values(respuesta["arrayIdTerrenos"]);
            
//                 contador = 0;
//                 Object.values(respuesta["terrenos"]).forEach(element => {
//                     if(element != ""){
//                         array = Object.values(element);

//                         const option = document.createElement('OPTION');
//                         option.value = array[0];
//                         option.innerText = array[1];

                        
//                         if(array[0] == arrayTerrenosDeLaPersona[contador]){
//                             option.selected = 1;
//                             contador++;
//                         }

//                         selectTerreno.appendChild(option);

//                         $(divTerreno).show();
//                     }
//                 });
//             }
//         }
//     };

//     if(formEntrada) {
//         var params = 'dni=' + dni;
//     } else if(formEditEntrada) {
//         const patron = /(\d+)/g;
//         const idEntrada = window.location.pathname.match(patron);
//         var params = 'dni=' + dni + '&idEntrada=' + idEntrada;
//     }
    

//     xhttp.open("POST", "/admin/terreno/getTerrenosPersona", true);
//     xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     xhttp.send(params);
//     return false;
// }

function selectPersona(){

    const patron = /(\d+)/g;
    const idEntrada = window.location.pathname.match(patron);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            var respuesta = JSON.parse(this.response);
            
            Object.values(respuesta).forEach(element => {
                if(!Array.isArray(element)){
                    const inputPersona = document.querySelector('#entrada1_persona');
                    inputPersona.value = element;
                    consultarTerrenos(element);
                }
            });
        }
    };

    var params = 'idEntrada=' + idEntrada;

    xhttp.open("POST", "/admin/entrada/getPersona", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
    return false;
}