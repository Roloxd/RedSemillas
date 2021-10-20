document.addEventListener("DOMContentLoaded", function(event) {

    // Tabs getTab, getActive
    // Calling Function from rgcs.js
    tabs('.rgcs__nav-link.link-section', '.rgcs__tab.tab-section.active');
    tabs('.rgcs__nav-link.link-otrosIdent', '.rgcs__tab.tab-otrosIdent.active');
    tabs('.rgcs__nav-link.link-tipoRecolector', '.rgcs__tab.tab-tipoRecolector.active');
    tabs('.rgcs__nav-link.link-tipoMejorador', '.rgcs__tab.tab-tipoMejorador.active');


    setChoices('.js-choice');
    //getChoices('.cod-donante', 'searchDonante');


    // Seleccion para lista de Intitutos FAO
    getChoices('.cod-instituto', 'searchInstituto');
    getChoices('.cod-donante', 'searchDonante');

    //otro test
    // Numero de días en germinar
    diasGerminacion();
    coordinateFormat('latDDtoDMS', 'lngDDtoDMS', 'latDMStoDD', 'lngDMStoDD');


    // // Reload script APP.JS when add collection in new image
    triggerAddBtn();

    inputChoices('.rgcs__tags-box');



    // Fitosanitarios
    inputChoices('.formaDeteccion_list-tags');
    inputChoices('.metodoDeteccion_list-tags');
    inputChoices('.fitopatologias_list-tags');
    inputChoices('.patogenos_list-tags');
    inputChoices('.metodoEmpleadoGerminacion_list-tags');

    inputChoices('.condicionBiologica_otros-tags');

    inputChoices('.rgcs_especies_select');

    var variedadDesc = ['usoHumano_otros',
        'usoAnimal_otros',
        'usoMedicinal_otros',
        'usoVeterinario_otros',
        'usoVeterinario_otros',
        'usoCombustible_otros',
        'usoConstruccion_otros',
        'usoIndustrial_otros',
        'usoMedioambiental_otros',
        'usoOrnamental_otros',
        'usosSociales_otros',
        'manejoCultivo_otros'
    ];
    for(var i = 0; i<variedadDesc.length; i++){
        //console.log(variedadDesc[i]);
        inputChoices('.'+variedadDesc[i]+'-tags');
    }


    getChoicesAjax('.list-especie', 'searchEspecieList','especies_ajax', getEspecieList);


})

// Stores Especie/Familia/Genero
var getEspecieList = [];

function getChoices(clase, searchClass){

    var insti = document.querySelector(clase);
    console.log('Codigo Instituto: '+insti);

    if(insti !== null){

        var choice = new Choices(insti, {
            silent:true,
            position: 'bottom',
            searchEnabled:true,
            searchResultLimit: 1000,
            removeItemButton: true,
            placeholder: true,
            placeholderValue: 'Selecciona el código del insituto',
            searchPlaceholderValue: 'Selecciona el código del instituto',
            classNames: {
                //input: newClass,
                inputCloned: searchClass,
                list: searchClass+'-list',
            },
        });

        var institute = document.querySelector('.'+searchClass);
        //console.log(choice);
        institute.addEventListener('input', function(){

            $.ajax({
                url:'institutes',
                type:"POST",
                datatype: "json",
                async:true,
                data: {code: institute.value},
                success:function(data) {

                    console.log(data['instcode']);

                    var arr = [];
                    for(var i = 0; i < data['instcode'].length; i++){
                        arr.push(data['instcode'][i]);
                    }

                    choice.clearChoices();
                    choice.setChoices(
                        arr,
                        'value',
                        'label',
                        false,
                    );

                },
                error: function(jqxhr, status, exception) {
                    console.log('Exception:', exception + jqxhr +status);
                }
            });

        })
    }
}

/*function ocultar(getThis){

    var getDi = document.querySelector();

}*/

// Ajax Choices
function getChoicesAjax(clase, searchClass, gerUrl, array){

    var getClase = document.querySelector(clase);
    console.log('Codigo Instituto: '+getClase);

    if(getClase !== null){

        var choice = new Choices(getClase, {
            silent:true,
            position: 'bottom',
            searchEnabled:true,
            searchResultLimit: 1000,
            removeItemButton: true,
            placeholder: true,
            placeholderValue: 'Selecciona el código del insituto',
            searchPlaceholderValue: 'Selecciona el código del instituto',
            classNames: {
                //input: newClass,
                inputCloned: searchClass,
                list: searchClass+'-list',
            },
        });

        var institute = document.querySelector('.'+searchClass);
        //console.log(choice);
        institute.addEventListener('input', function(){
            //array = [];
            $.ajax({
                url:'especies_ajax',
                type:"POST",
                datatype: "json",
                async:true,
                data: {code: institute.value},
                success:function(data) {

                    var arr = [];
                    for(var i = 0; i < data['data'].length; i++){
                            arr.push(data['data'][i]);
                    }

                    choice.clearChoices();
                    choice.setChoices(
                        arr,
                        'value',
                        'label',
                        false,
                    );
                    //array = [];
                    if(data['properties'] != null){
                       //array = [];

                        for(var i = 0; i < data['properties'].length; i++){
                            array.push(data['properties'][i])
                            //console.log(data['properties'][i]);
                        }
                    }
                    //array = [];
                    console.log(array);

                },
                error: function(jqxhr, status, exception) {
                    console.log('Exception:', exception + jqxhr +status);
                }
            });

        })
    }
}


function setEspecie(getThis){

    var id = getThis.getAttribute('id');
    var setFamilia = document.querySelector('.familia_getEspecie');
    var setGenero = document.querySelector('.genero_getEspecie');

    var getoption = document.querySelector('#'+id+' option');
    var extra = getoption.getAttribute('value');

    for(var i =0; i<getEspecieList.length;i++){

        for(especie in getEspecieList[i]){
            console.log(getEspecieList[i]);
            var set = getEspecieList[i][especie];

            if(extra == especie){
                setFamilia.value = set['familia'];
                setGenero.value = set['genero'];
            }

        }
    }

}

/*function finPruebaGerminacion() {
var


}*/

// Formulas -----------------------
function convertDD2DMS(coord, type){

    var lat = coord;
    var latn = Math.abs(lat); /* Devuelve el valor absoluto de un número, sea positivo o negativo */
    var latgr = Math.floor(latn * 1); /* Redondea un número hacia abajo a su entero más cercano */
    var latmin = Math.floor((latn - latgr) * 60); /* Vamos restando el número entero para transformarlo en minutos */
    var latseg = ((((latn - latgr) * 60) - latmin) * 60); /* Restamos el entero  anterior ahora para segundos */
    var latc = (latgr + "º " + latmin + "\' " + latseg.toFixed(3) + '\"'); /* Prolongamos a centésimas de segundo */

    if(type === 'lat'){
        if (lat > 0) {
            x = latc + ' N'; /* Si el número original era positivo, es Norte */
        } else {
            x = latc + ' S'; /* Si el número original era negativo, es Sur */
        } /* Repetimos el proceso para la longitud (Este, -W-Oeste) */

        return x;
    }else if(type === 'lng'){

        if (lat > 0) {
            x = latc + ' E';
        } else {
            x = latc + ' W';
        }
        return x;

    }

}

function convertDMSToDD(dms) {
    let parts = dms.split(/[^\d+(\,\d+)\d+(\.\d+)?\w]+/);
    let degrees = parseFloat(parts[0]);
    let minutes = parseFloat(parts[1]);
    let seconds = parseFloat(parts[2].replace(',','.'));
    let direction = parts[3];

    console.log('degrees: '+degrees)
    console.log('minutes: '+minutes)
    console.log('seconds: '+seconds)
    console.log('direction: '+direction)

    let dd = degrees + minutes / 60 + seconds / (60 * 60);

    if (direction == 'S' || direction == 'W') {
        dd = dd.toFixed(3) * -1;
    } // Don't do anything for N or E
    return dd;
}


function coordinateFormat(latDDClass, lngDDClass, latDMSClass, lngDMSClass){

    var latDD  = document.getElementsByClassName(latDDClass)[0];
    var lngDD  = document.getElementsByClassName(lngDDClass)[0];
    var latDMS = document.getElementsByClassName(latDMSClass)[0];
    var lngDMS = document.getElementsByClassName(lngDMSClass)[0];
    console.log(latDD);
    if (latDD != null) {
        console.log('nsdsds');
        latDD.addEventListener('input', function () {
            latDMS.value = convertDD2DMS(latDD.value, 'lat');
        })
    }
    if(lngDD != null) {
        latDMS.addEventListener('input', function () {
            latDD.value = convertDMSToDD(latDMS.value);
        })
    }
    if(latDMS != null) {
        lngDD.addEventListener('input', function () {
            lngDMS.value = convertDD2DMS(lngDD.value, 'lng');
        })
    }
    if(lngDMS != null) {
        lngDMS.addEventListener('input', function () {
            lngDD.value = convertDMSToDD(lngDMS.value);
        })
    }

}

// FORMULAS
//var getAdquCantidad = document.getElementsByClassName('adquisicion_cantidad')[0];
//var getAdquCantGr = document.getElementsByClassName('adquisicion_unidades_gramo')[0];
function cantidadEnvGramos(getThis){
    console.log('cantidadEnvUnidades');

    var getAdquCantGr = document.getElementsByClassName('adquisicion_unidades_gramo')[0];
    if(getAdquCantGr != null) {
        var cantEnvUnid = document.getElementsByClassName('cantidadEnvUnidades')[0];
        cantEnvUnid.value = getThis.value / getAdquCantGr.value;
    }

}
// cantidad gramos por
function cantidadEnvUnidades(getThis){
    console.log('cantidadEnvUnidades');
    var getAdquCantGr = document.getElementsByClassName('adquisicion_unidades_gramo')[0];
    if(getAdquCantGr != null) {
        var cantEnvUnidGram = document.getElementsByClassName('cantidadEnvGramos')[0];
        cantEnvUnidGram.value = getThis.value * getAdquCantGr.value;
    }

}

function diasGerminacion() {

    var fecha  = document.getElementsByClassName('datePrueba');
    var result = document.getElementsByClassName('diasGerminacion')[0];

    if (fecha !== undefined || fecha !== null){

        for(var i=0; i<fecha.length;i++){

            fecha[i].addEventListener('change', function () {

                var inicio = document.getElementsByClassName('inicioPruebaGerminacion')[0];
                var final = document.getElementsByClassName('finalPruebaGerminacion')[0];

                //console.log(inicio.value);
                var date1 = new Date(inicio.value);
                var date2 = new Date(final.value);

                // To calculate the time difference of two dates
                var Difference_In_Time = date2.getTime() - date1.getTime();

                // To calculate the no. of days between two dates
                var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

                result.value = (Difference_In_Days !== null) ? Difference_In_Days : 0;

            })
        }
    }
}

function finPruebaGerminacion(getThis) {
    //console.log(getThis.checked);

    var getFinalDate = document.querySelector('.finalPruebaGerminacion.datePrueba');
    //console.log(getFinalDate);
    if(getThis.checked == true){
        getFinalDate.value = formatDate(1, '-');
    }else{
        getFinalDate.value = formatDate('empty', '-');
    }
}

// FORMULAS GERMINACIÓN

function porcentajeGerminacion(getThis, type){

    //%Germinacion = semillasGerminadas * 100 / semillasUsadas
    //%NoGerminadas =semillasMuertas * 100 / semillasUsadas
    //%Anomala =semillasAnomalas * 100 / semillasUsadas
    //%Enfermas =semillasEnfermas * 100 / semillasUsadas

    var getNumeroSemillas = document.querySelector('.getNumeroSemillas');
    var fixed = 4;

    if(type == 'germinadas'){

        var getGerminadas = document.querySelector('.setPorcentGerminacion');
        var formula = (getThis.value * 100) / getNumeroSemillas.value;

        getGerminadas.value = formula.toFixed(fixed);

    }else if(type == 'muertas'){

        var getMuertas = document.querySelector('.setPorcentNoGerminada');
        var formula = (getThis.value * 100) / getNumeroSemillas.value;
        getMuertas.value = formula.toFixed(fixed);


    }else if(type == 'anomalas'){

        var getAnomalas = document.querySelector('.setPorcentGermAnomala');
        var formula = (getThis.value * 100) / getNumeroSemillas.value;
        getAnomalas.value = formula.toFixed(fixed);

    }else if(type == 'enfermas'){

        var getEnfermas = document.querySelector('.setPorcentGermEnfermas');
        var formula = (getThis.value * 100) / getNumeroSemillas.value;
        getEnfermas.value = formula.toFixed(fixed);

    }

}


// Crear Pestañas de los institutos o usuarios nuevos

const entidadesForm = function(getThis, type, view) {

    if(view == null){

        // Coge la ID y extrae el número
        //console.log(getRow.getAttribute('data-num-items'));
        // split -1 field name
        // split -2 position number in array
        // split -3 class name
        var getId     = getThis.getAttribute('id');
        var split     = getId.split('_');
        var numID     = split[split.length - 2];
        var fieldName = split[split.length - 3];
        var id        = split.splice(split.length -2);
        var setId     = split.join('_');

        //console.log('Split: '+split+'- Num ID: '+numID+' - FieldName - '+fieldName+'- ID: '+id+' - setId: '+setId);



        // get section where it belongs to save
        var getBlock = 'block_'+fieldName;
        var asignar = document.getElementsByClassName(getBlock)[0];
        //console.log(asignar);

        // Localiza la clase más próxima
        //var clase = (type == 'instituto') ? '.otroIndentInstituto' : '.otroIndentUsuario';
        var clase = fieldName;
        var formRow = '#'+setId+' .form-group.row-' + numID;
        var closest = getThis.closest(formRow);
        var formBox = document.querySelector(formRow + ' .form-widget');
        var newID = getId + '__title';
        var getNode = document.querySelector('.'+newID);

        // Prepara el nodo a añadir
        var setTitle = '';
        var node = document.createElement("h3");
        node.className = newID;
        node.id = newID;
        node.setAttribute('data-index', numID);
        node.setAttribute('data-id', '#'+setId);


        var instituto = function(getType, list = 'text') {

            //var typoClass = (getType == 'instituto') ? 'row-donante_otroIdentInst' : 'row-donante_otroIdentUsuario';
            //var getSel    = (getType == 'instituto') ? 'select#Passport_donante_otroIdentInst_' : 'select#Passport_donante_otroIdentUsuario_';
            var typoClass = 'row-'+fieldName;
            var getSel = 'select#'+setId+'_';
            var setType   = (getType == 'instituto') ? 'instituto' : 'usuario';

            if(list == 'text'){
                // If field type text

                node.setAttribute('onclick', 'entidadesForm(this, "'+setType+'", "show")');
                setTitle = numID + ' - ' + asignar.getAttribute('data-name');
                //console.log(setTitle);
            }else{

                var getRow = document.getElementsByClassName(typoClass)[0];

                // Coger el instituto seleccionado
                var getChecked = document.querySelectorAll(getSel + numID + '_asignado_a option');
                console.log(getChecked.selected);

                node.setAttribute('onclick', 'entidadesForm(this, "'+setType+'", "show")');
                console.log(setType);
                for (i = 0; i < getChecked.length; i++) {
                    if (getChecked[i].selected) {
                        //console.log(getChecked[i].text)
                        setTitle = numID + ' - ' + getChecked[i].value;
                    }
                }
            }

            if(newID != null){
                if(getNode != null){
                    getNode.remove();
                }
                //console.log(formRow);
                var txt = document.createTextNode(setTitle);
                node.appendChild(txt);
                closest.insertBefore(node, closest.firstChild);
                $(formBox).hide();
                //formBox.style.display = 'none';
            }

        }

        instituto(type);

    }else{
        var getId = getThis.getAttribute('data-id');
        var list = getThis.getAttribute('data-index');

        // the hidden field with field asignar
        var addValue = document.getElementById('#'+getId+'_'+list+'_asignar');

        $(getId+' .form-group.row-'+list+' .form-widget').first().slideToggle(300);

        //console.log(getId);

    }
}



