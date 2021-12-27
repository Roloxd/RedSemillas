const datos = {};
const formEntrada = document.querySelector(".formEntrada");
const formEditEntrada = document.querySelector(".formEditEntrada");

document.addEventListener('DOMContentLoaded', function() {

    var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});

    document.onreadystatechange = function () {
        myModal.show();
    };

    if(formEntrada){
        fechaActual();
        consultarPersonas();
        getPersona();
    }

    if(formEditEntrada){
        consultarPersonas();
        selectPersona();
        getPersona();      
    }
});

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

function consultarPersonas(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            var respuesta = JSON.parse(this.response);
            
            Object.values(respuesta).forEach(element => {
                element.forEach(persona => {
                    const lista = document.querySelector('#personas_list');
                    array = Object.values(persona);

                    const option = document.createElement('OPTION');
                    option.value = array[2];

                    if(array[2] === null || array[2] === ""){
                        option.innerText = array[0];
                    } else {
                        option.innerText = array[0] + " " + array[1] + " - " + array[2];
                    }
                    
                    lista.appendChild(option);
                })
            });
        }
    };

    xhttp.open("POST", "/admin/persona/findAll", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
    return false;
}

function getPersona() {
    const inputDNI = document.querySelector('#entrada1_persona');
    inputDNI.addEventListener('input', leerValor);

    if(formEditEntrada){
        consultarTerrenos(document.querySelector('#entrada1_persona').value);
    }
}

function consultarTerrenos(dni) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            var respuesta = JSON.parse(this.response);

            if(formEntrada){
                const divTerreno = document.querySelector('#terreno');
                const selectTerreno = document.querySelector('#entrada1_id_terreno');
                
                Object.values(respuesta).forEach(element => {
                    if(element != ""){
                        element.forEach(terrenos => {
                            // MOSTRAR TERRENOS FORMULARIO ENTRADA
                            array = Object.values(terrenos);

                            const option = document.createElement('OPTION');
                            option.value = array[0];
                            option.innerText = array[1];

                            selectTerreno.appendChild(option);

                            $(divTerreno).show();
                        });
                    }
                });
            } else if(formEditEntrada) {
                const divTerreno = document.querySelector('#terreno');
                const selectTerreno = document.querySelector('#entrada1_id_terreno');
                
                arrayTerrenosDeLaPersona = Object.values(respuesta["arrayIdTerrenos"]);
            
                contador = 0;
                Object.values(respuesta["terrenos"]).forEach(element => {
                    if(element != ""){
                        array = Object.values(element);

                        const option = document.createElement('OPTION');
                        option.value = array[0];
                        option.innerText = array[1];

                        
                        if(array[0] == arrayTerrenosDeLaPersona[contador]){
                            option.selected = 1;
                            contador++;
                        }

                        selectTerreno.appendChild(option);

                        $(divTerreno).show();
                    }
                });
            }
        }
    };

    if(formEntrada) {
        var params = 'dni=' + dni;
    } else if(formEditEntrada) {
        const patron = /(\d+)/g;
        const idEntrada = window.location.pathname.match(patron);
        var params = 'dni=' + dni + '&idEntrada=' + idEntrada;
    }
    

    xhttp.open("POST", "/admin/terreno/getTerrenosPersona", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
    return false;
}

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