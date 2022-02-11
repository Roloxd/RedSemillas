const datos = {};
const formEnvase = document.querySelector(".formEnvase");
const formEditEnvase = document.querySelector(".formEditEnvase");

document.addEventListener('DOMContentLoaded', function() {
    if(formEnvase){
        fechaActual();
        guardarDatosContenido();
        calcularDatosContenido();
    }

    if(formEditEnvase){
        guardarDatosContenido();
        calcularDatosContenido();
    }
});

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
    
    document.querySelector("#envase_fecha_envasado").value = year + "-" + stringMes + "-" + stringDia;
}

function leerValor(evento) {
    datos[evento.target.id] = evento.target.value;
}

function guardarDatosContenido(){
    const inputUnidadesPorGramo = document.querySelector('#envase_unidades_gramo');
    const inputCantidadMaterialGramos = document.querySelector('#envase_cantidad_gramos');
    const inputCantidadMaterialUnidades = document.querySelector('#envase_cantidad_unidades');

    inputUnidadesPorGramo.addEventListener('input', leerValor);
    inputCantidadMaterialGramos.addEventListener('input', leerValor);
    inputCantidadMaterialUnidades.addEventListener('input', leerValor);
}

function calcularDatosContenido() { 
    const inputUnidadesGramo = document.querySelector('#envase_unidades_gramo');
    const inputCantidadMaterialUnidades = document.querySelector('#envase_cantidad_unidades');
    const inputCantidadMaterialGramos = document.querySelector('#envase_cantidad_gramos');

    var datoUnidadesGramo = 0;

    //Cuando se pierde el focus
    inputUnidadesGramo.addEventListener('blur', evento =>{
        if(inputUnidadesGramo.value != ""){
            datoUnidadesGramo = inputUnidadesGramo.value;
        } else {
            datoUnidadesGramo = 0;
        }
    });

    inputCantidadMaterialGramos.addEventListener('blur', evento => {
        if(datoUnidadesGramo != 0){
            if(evento.target.value != ""){
                const calculo =  evento.target.value * inputUnidadesGramo.value;
                inputCantidadMaterialUnidades.value = calculo;
            } else {
                inputCantidadMaterialUnidades.value = "";
            }
        }
    });

    inputCantidadMaterialUnidades.addEventListener('blur', evento => {
        if(datoUnidadesGramo != 0){
            if(evento.target.value != ""){
                const calculo =  evento.target.value / inputUnidadesGramo.value;
                inputCantidadMaterialGramos.value = calculo;
            } else {
                inputCantidadMaterialGramos.value = "";
            }
        }
    });
}

