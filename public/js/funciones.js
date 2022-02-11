
//Objects
const datos = {'cicloYSiembra': 0, 'iterador': 0};

const formPersona = document.querySelector(".formPersona");
const formVariedad = document.querySelector(".formVariedad");
const formVariedadUpdate = document.querySelector(".formVariedadUpdate");
const formImagen = document.querySelector(".formImagen");
const formImagenSelect = document.querySelector(".formImagenSelect");

document.addEventListener('DOMContentLoaded', function() {
    if(formPersona){
        validarFormularioPersona();
    }

    if(formVariedad || formVariedadUpdate){
        // consultaFamilia();
        //getEspecies();
        consultarUsos();
        crearCampoDescripcionUsos();
        validarFormularioVariedad();

        if(formVariedadUpdate){
            selectUsos();
            consultarCiclosySiembras();
        }

        if(formVariedad) {
            const btn_anadir = document.querySelector('button[data-btn-plus="cicloSiembra"]');
            agregarMasCicloSiembra(btn_anadir);
        }
    }

    if(formImagen){
        validarFormularioImagen();
    }

    if(formImagenSelect){
        validarFormularioImagenSelect();
    }
});

function consultarCiclosySiembras(){
    const patron = /(\d+)/g;
    const idVariedad = window.location.pathname.match(patron);
    const columnaDerecha = document.querySelector('#columna-right');

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            var respuesta = JSON.parse(this.response);

            if(respuesta['ArrayCicloYSiembra'] != null){
                const ids = Object.keys(respuesta['ArrayCicloYSiembra']);
                Object.values(respuesta['ArrayCicloYSiembra']).forEach(cicloYSiembra => {
                    datos['cicloYSiembra'] = parseInt(ids[datos['iterador']]);

                    let ciclos = '';
                    if(cicloYSiembra['ciclo'] != null) {
                        ciclos = cicloYSiembra['ciclo'].split(';');
                    } else {
                        ciclos = new Array('vacio');
                    }

                    let meses = '';
                    if(cicloYSiembra['meses'] != null) {
                        meses = cicloYSiembra['meses'];
                    } else {
                        meses = new Array('vacio');
                    }

                    const altitud = cicloYSiembra['altitud'];
                    const zona = cicloYSiembra['zona'];
    
                    const div = document.createElement('DIV');
                    div.classList = "card card-pink cicloSiembra";
                    div.innerHTML = `
                    <div class="card-header">
                        <h3 class="card-title">Ciclo y Siembra</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body"></div>
                    `;
    
                    const car_body = div.lastElementChild;
    
                        // Tipo de Planta
                        form_group = crearDivFormGroup();
    
                        labelTipoPlanta = crearLabel('Tipo de Planta');
                        form_group.appendChild(labelTipoPlanta);
    
                        divRow = crearDivRow();
    
                            //Anual
                            if( ciclos.includes('anual') ) {
                                checkAnual = crearCheckbox('Anual', 'ciclo', 'anual', true);
                            } else {
                                checkAnual = crearCheckbox('Anual', 'ciclo', 'anual');
                            }
                            divRow.appendChild(checkAnual);    
    
                            //Bianual
                            if( ciclos.includes('bianual') ) {
                                checkBianual = crearCheckbox('Bianual', 'ciclo', 'bianual', true);
                            } else {
                                checkBianual = crearCheckbox('Bianual', 'ciclo', 'bianual');
                            }
                            divRow.appendChild(checkBianual);
    
                            //Perenne
                            if( ciclos.includes('perenne') ) {
                                checkPerenne = crearCheckbox('Perenne', 'ciclo', 'perenne', true);
                            } else {
                                checkPerenne = crearCheckbox('Perenne', 'ciclo', 'perenne');
                            }
                            divRow.appendChild(checkPerenne);
                        
                        form_group.appendChild(divRow);
                    
                    car_body.appendChild(form_group);
                    
                    //Epoca de Siembra
                    form_group = crearDivFormGroup();
    
                        label = crearLabel('Epoca de Siembra');
                        form_group.appendChild(label);
    
                        divRow = crearDivRow();
    
                            //Ene
                            if( meses.includes('ene') ) {
                                checkAnual = crearCheckbox('Enero', 'meses', 'ene', true);
                            } else {
                                checkAnual = crearCheckbox('Enero', 'meses', 'ene');
                            }
                            divRow.appendChild(checkAnual);
    
                            //Feb
                            if( meses.includes('feb') ) {
                                checkBianual = crearCheckbox('Febrero', 'meses', 'feb', true);
                            } else {
                                checkBianual = crearCheckbox('Febrero', 'meses', 'feb');
                            }
                            divRow.appendChild(checkBianual);
    
                            //Mar
                            if( meses.includes('mar') ) {
                                checkPerenne = crearCheckbox('Marzo', 'meses', 'mar', true);
                            } else {
                                checkPerenne = crearCheckbox('Marzo', 'meses', 'mar');
                            }
                            divRow.appendChild(checkPerenne);
    
                            //Abr
                            if( meses.includes('abr') ) {
                                checkPerenne = crearCheckbox('Abril', 'meses', 'abr', true);
                            } else {
                                checkPerenne = crearCheckbox('Abril', 'meses', 'abr');
                            }
                            divRow.appendChild(checkPerenne);
                    
                        form_group.appendChild(divRow);
    
                        divRow = crearDivRow();
    
                            //May
                            if( meses.includes('may') ) {
                                checkAnual = crearCheckbox('Mayo', 'meses', 'may', true);
                            } else {
                                checkAnual = crearCheckbox('Mayo', 'meses', 'may');
                            }
                            divRow.appendChild(checkAnual);
    
                            //Jun
                            if( meses.includes('jun') ) {
                                checkBianual = crearCheckbox('Junio', 'meses', 'jun', true);
                            } else {
                                checkBianual = crearCheckbox('Junio', 'meses', 'jun');
                            }
                            divRow.appendChild(checkBianual);
    
                            //Jul
                            if( meses.includes('jul') ) {
                                checkPerenne = crearCheckbox('Julio', 'meses', 'jul', true);
                            } else {
                                checkPerenne = crearCheckbox('Julio', 'meses', 'jul');
                            }
                            divRow.appendChild(checkPerenne);
    
                            //Ago
                            if( meses.includes('ago') ) {
                                checkPerenne = crearCheckbox('Agosto', 'meses', 'ago', true);
                            } else {
                                checkPerenne = crearCheckbox('Agosto', 'meses', 'ago');
                            }
                            divRow.appendChild(checkPerenne);
                    
                        form_group.appendChild(divRow);
    
                        divRow = crearDivRow();
    
                            //Sep
                            if( meses.includes('sep') ) {
                                checkAnual = crearCheckbox('Septiembre', 'meses', 'sep', true);
                            } else {
                                checkAnual = crearCheckbox('Septiembre', 'meses', 'sep');
                            }
                            divRow.appendChild(checkAnual);
    
                            //Oct
                            if( meses.includes('oct') ) {
                                checkBianual = crearCheckbox('Octubre', 'meses',  'oct', true);
                            } else {
                                checkBianual = crearCheckbox('Octubre', 'meses',  'oct');
                            }
                            divRow.appendChild(checkBianual);
    
                            //Nov
                            if( meses.includes('nov') ) {
                                checkPerenne = crearCheckbox('Noviembre', 'meses', 'nov', true);
                            } else {
                                checkPerenne = crearCheckbox('Noviembre', 'meses', 'nov');
                            }
                            divRow.appendChild(checkPerenne);
    
                            //Dic
                            if( meses.includes('dic') ) {
                                checkPerenne = crearCheckbox('Diciembre', 'meses', 'dic', true);
                            } else {
                                checkPerenne = crearCheckbox('Diciembre', 'meses', 'dic');
                            }
                            divRow.appendChild(checkPerenne);
                    
                        form_group.appendChild(divRow);
    
                    car_body.appendChild(form_group); 
    
                    //Altitud
                    form_group = crearDivFormGroup();
    
                        label = crearLabel('Altitud', 'altitud');
                        form_group.appendChild(label);
    
                        select = crearSelect('Seleccione altitud', ['+300m', '-300m'], 'altitud');
    
                        switch(altitud) {
                            case '+300m':
                                select.options[1].selected = 1;
                                break;
                            case '-300m':
                                select.options[2].selected = 1;
                                break;
                            default:
                                break;
                        };
                        
                        form_group.appendChild(select);
    
                    car_body.appendChild(form_group); 
    
                    //Zona
                    form_group = crearDivFormGroup();
    
                        label = crearLabel('Zona', 'zona');
                        form_group.appendChild(label);
    
                        select = crearSelect('Seleccione zona', ['Norte', 'Sur'], 'zona');
    
                        switch(zona) {
                            case 'norte':
                                select.options[1].selected = 1;
                                break;
                            case 'sur':
                                select.options[2].selected = 1;
                                break;
                            default:
                                break;
                        };
    
                        form_group.appendChild(select);
    
                    car_body.appendChild(form_group); 
                    
                    columnaDerecha.appendChild(div);
                    datos['iterador'] += 1;
                });
            }

            if(respuesta['ultimoId'] != null){
                datos['cicloYSiembra'] = respuesta['ultimoId'];
            }

            //Boton añadir
            const btn = document.createElement('BUTTON');
            btn.classList = 'btn btn-info btn-sm';
            btn.type = 'button';
            btn.setAttribute('data-btn-plus', 'cicloSiembra');
            btn.innerHTML = `<i class="fa fa-plus"></i> Añadir Ciclo y Siembra`;
            btn.style = 'margin-bottom: 1rem;';
            columnaDerecha.appendChild(btn);

            agregarMasCicloSiembra(btn);
        }
    }

    var params = 'idVariedad=' + idVariedad;

    xhttp.open("POST", "/admin/variedades/getCicloYSiembra", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
    return false;
}

function agregarMasCicloSiembra(btn_anadir){
    const columnaDerecha = document.querySelector('#columna-right');

    //console.log(btn_anadir.parentNode);
    btn_anadir.addEventListener('click', () =>{
        console.log(datos['cicloYSiembra']);
        datos['cicloYSiembra'] += 1;

        const div = document.createElement('DIV');
        div.classList = "card card-pink cicloSiembra";
        div.innerHTML = `
        <div class="card-header">
            <h3 class="card-title">Ciclo y Siembra</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body"></div>
        `;

        const car_body = div.lastElementChild;

        // Tipo de Planta
        form_group = crearDivFormGroup();

            labelTipoPlanta = crearLabel('Tipo de Planta');
            form_group.appendChild(labelTipoPlanta);

            divRow = crearDivRow();

                //Anual
                checkAnual = crearCheckbox('Anual', 'ciclo', 'anual');
                divRow.appendChild(checkAnual);

                //Bianual
                checkBianual = crearCheckbox('Bianual', 'ciclo', 'bianual');
                divRow.appendChild(checkBianual);

                //Perenne
                checkPerenne = crearCheckbox('Perenne', 'ciclo', 'perenne');
                divRow.appendChild(checkPerenne);
            
            form_group.appendChild(divRow);
        
        car_body.appendChild(form_group);
        
        //Epoca de Siembra
        form_group = crearDivFormGroup();

            label = crearLabel('Epoca de Siembra');
            form_group.appendChild(label);

            divRow = crearDivRow();

                //Ene
                checkAnual = crearCheckbox('Enero', 'meses', 'ene');
                divRow.appendChild(checkAnual);

                //Feb
                checkBianual = crearCheckbox('Febrero', 'meses', 'feb');
                divRow.appendChild(checkBianual);

                //Mar
                checkPerenne = crearCheckbox('Marzo', 'meses', 'mar');
                divRow.appendChild(checkPerenne);

                //Abr
                checkPerenne = crearCheckbox('Abril', 'meses', 'abr');
                divRow.appendChild(checkPerenne);
        
            form_group.appendChild(divRow);

            divRow = crearDivRow();

                //May
                checkAnual = crearCheckbox('Mayo', 'meses', 'may');
                divRow.appendChild(checkAnual);

                //Jun
                checkBianual = crearCheckbox('Junio', 'meses', 'jun');
                divRow.appendChild(checkBianual);

                //Jul
                checkPerenne = crearCheckbox('Julio', 'meses', 'jul');
                divRow.appendChild(checkPerenne);

                //Ago
                checkPerenne = crearCheckbox('Agosto', 'meses', 'ago');
                divRow.appendChild(checkPerenne);
        
            form_group.appendChild(divRow);

            divRow = crearDivRow();

                //Sep
                checkAnual = crearCheckbox('Septiembre', 'meses', 'sep');
                divRow.appendChild(checkAnual);

                //Oct
                checkBianual = crearCheckbox('Octubre', 'meses',  'oct');
                divRow.appendChild(checkBianual);

                //Nov
                checkPerenne = crearCheckbox('Noviembre', 'meses', 'nov');
                divRow.appendChild(checkPerenne);

                //Dic
                checkPerenne = crearCheckbox('Diciembre', 'meses', 'dic');
                divRow.appendChild(checkPerenne);
        
            form_group.appendChild(divRow);

        car_body.appendChild(form_group); 

        //Altitud
        form_group = crearDivFormGroup();

            label = crearLabel('Altitud', 'altitud');
            form_group.appendChild(label);

            select = crearSelect('Seleccione altitud', ['+300m', '-300m'], 'altitud');
            form_group.appendChild(select);

        car_body.appendChild(form_group); 

        //Zona
        form_group = crearDivFormGroup();

            label = crearLabel('Zona', 'zona');
            form_group.appendChild(label);

            select = crearSelect('Seleccione zona', ['Norte', 'Sur'], 'zona');
            form_group.appendChild(select);

        car_body.appendChild(form_group); 

        columnaDerecha.appendChild(div);
    });
}

function crearSelect(textoDefault, textos, key){
    select = document.createElement('SELECT');
    select.classList = 'form-control';
    attrID = 'ciclo_y_siembra_' + key + datos['cicloYSiembra'];
    select.setAttribute('id', attrID);
    attrName = 'ciclo_y_siembra[' + datos['cicloYSiembra'] + '][' + key + ']';
    select.setAttribute('name', attrName);

    //Option Default
    option = document.createElement('OPTION');
    option.selected = 1;
    option.disabled = 1;
    option.innerText = '-- ' + textoDefault + ' --';

    select.appendChild(option);

    //Options
    textos.forEach(texto => {
        option = document.createElement('OPTION');
        option.value = texto.toLowerCase();
        option.innerText = texto;

        select.appendChild(option);
    });

    return select;
}

function crearLabel(texto, textFor = null){
    label = document.createElement('LABEL');
    label.innerText = texto;

    if(textFor != null){
        attrFor = 'ciclo_y_siembra_' + textFor + datos['cicloYSiembra'];
        label.setAttribute('for', attrFor);
    }

    return label;
}

function crearCheckbox(texto, categoria, key, marcar = null){
    checkAnual = document.createElement('DIV');
    checkAnual.classList = 'form-check col-3';

        input = document.createElement('input');
        input.type = 'checkbox';
        input.classList = 'form-check-input';

        if(marcar != null){
            input.checked = marcar;
        }

        attrName = 'ciclo_y_siembra[' + datos['cicloYSiembra'] + '][' + categoria + '][' + key + ']';
        input.setAttribute('name', attrName);
        attrID = 'ciclo_y_siembra_' + key + datos['cicloYSiembra'];
        input.setAttribute('id', attrID);
        checkAnual.appendChild(input);

        label = document.createElement('LABEL');
        label.classList = 'form-check-label';
        label.innerText = texto;
        label.setAttribute('for', attrID);
        checkAnual.appendChild(label);
    
    return checkAnual;
}

function crearDivFormGroup(){
    const div = document.createElement('DIV');
    div.classList = "form-group";

    return div;
}

function crearDivRow(){
    const div = document.createElement('DIV');
    div.classList = "row";

    return div;
}

function selectUsos(){
    const listaAlimenHumana = document.querySelector('#variedad1_usoAlimenHumana');
    const listaAlimenAnimal = document.querySelector('#variedad1_usoAlimenAnimal');
    const listaMedicinales = document.querySelector('#variedad1_usoMedicinales');
    const listaVeterinarios = document.querySelector('#variedad1_usoVeterinarios');
    const listaToxicNocivo = document.querySelector('#variedad1_usoToxicNocivo');
    const listaCombustible = document.querySelector('#variedad1_usoCombustible');
    const listaConstruccion = document.querySelector('#variedad1_usoConstruccion');
    const listaArtesania = document.querySelector('#variedad1_usoArtesania');
    const listaMedioambientales = document.querySelector('#variedad1_usoMedioambientales');
    const listaOrnamentales = document.querySelector('#variedad1_usoOrnamentales');
    const listaSociales = document.querySelector('#variedad1_usoSociales');

    const patron = /(\d+)/g;
    const idVariedad = window.location.pathname.match(patron);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            
            var respuesta = JSON.parse(this.response);

            Object.values(respuesta).forEach(usos => {
                if(usos != null) {
                    for(const [key, value] of Object.entries(usos)) {

                        switch (key) {
                            case 'Alimentación humana':
                                if(value['descripcion'] === undefined) {
                                    seleccionarUsos(listaAlimenHumana.children, value['id']);
                                } else {
                                    seleccionarUsos(listaAlimenHumana.children, value['id'], value['descripcion']);
                                }
                                break;
                            case 'Alimentación animal':
                                if(value['descripcion'] === undefined) {
                                    seleccionarUsos(listaAlimenAnimal.children, value['id']);
                                } else {
                                    seleccionarUsos(listaAlimenAnimal.children, value['id'], value['descripcion']);
                                }
                                break;
                            case 'Medicinales':
                                if(value['descripcion'] === undefined) {
                                    seleccionarUsos(listaMedicinales.children, value['id']);
                                } else {
                                    seleccionarUsos(listaMedicinales.children, value['id'], value['descripcion']);
                                }
                                break;
                            case 'Veterinarios': //añadir cambios
                                if(value['descripcion'] === undefined) {
                                    seleccionarUsos(listaVeterinarios.children, value['id']);
                                } else {
                                    seleccionarUsos(listaVeterinarios.children, value['id'], value['descripcion']);
                                }
                                break;
                            case 'Tóxico y nocivo':
                                if(value['descripcion'] === undefined) {
                                    seleccionarUsos(listaToxicNocivo.children, value['id']);
                                } else {
                                    seleccionarUsos(listaToxicNocivo.children, value['id'], value['descripcion']);
                                }
                                break;
                            case 'Combustible':
                                if(value['descripcion'] === undefined) {
                                    seleccionarUsos(listaCombustible.children, value['id']);
                                } else {
                                    seleccionarUsos(listaCombustible.children, value['id'], value['descripcion']);
                                }
                                break;
                            case 'Construcción':
                                if(value['descripcion'] === undefined) {
                                    seleccionarUsos(listaConstruccion.children, value['id']);
                                } else {
                                    seleccionarUsos(listaConstruccion.children, value['id'], value['descripcion']);
                                }
                                break;
                            case 'Artesanía o industria':
                                if(value['descripcion'] === undefined) {
                                    seleccionarUsos(listaArtesania.children, value['id']);
                                } else {
                                    seleccionarUsos(listaArtesania.children, value['id'], value['descripcion']);
                                }
                                break;
                            case 'Medioambientales':
                                if(value['descripcion'] === undefined) {
                                    seleccionarUsos(listaMedioambientales.children, value['id']);
                                } else {
                                    seleccionarUsos(listaMedioambientales.children, value['id'], value['descripcion']);
                                }
                                break;
                            case 'Ornamentales':
                                if(value['descripcion'] === undefined) {
                                    seleccionarUsos(listaOrnamentales.children, value['id']);
                                } else {
                                    seleccionarUsos(listaOrnamentales.children, value['id'], value['descripcion']);
                                }
                                break;
                            case 'Sociales, simbólicos y rituales':
                                if(value['descripcion'] === undefined) {
                                    seleccionarUsos(listaSociales.children, value['id']);
                                } else {
                                    seleccionarUsos(listaSociales.children, value['id'], value['descripcion']);
                                }
                                break;
                            default:
                                break;
                        }
                    }
                }

            });
        }
    };

    var params = 'idVariedad=' + idVariedad;

    xhttp.open("POST", "/admin/variedades/getUsos", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
    return false;
}

function seleccionarUsos(childrens, value, descripcion = null) {
    Object.values(childrens).forEach( option => {
        value.forEach( id => { 
            if(option.value == id) { 
                option.selected = 1;

                if(option.text.includes('Otro')){
                    label = document.createElement('LABEL');
                    label.setAttribute('for', option.parentNode.id + '_descripcion');
                    label.setAttribute('id', option.parentNode.id + '_label');
                    label.innerText = 'Otros tipos de usos';

                    option.parentNode.parentNode.appendChild(label);

                    textarea = document.createElement('TEXTAREA');
                    textarea.setAttribute('id', option.parentNode.id + '_descripcion');
                    textarea.setAttribute('class', 'form-control');
                    textarea.setAttribute('name', 'variedad1[' + option.parentNode.id + '_descripcion]');
                    textarea.innerText = descripcion;
                    option.parentNode.parentNode.appendChild(textarea);
                }
            }
        });
        
    });
}

function crearCampoDescripcionUsos(){
    for(let i= 0; i<document.querySelectorAll('#contenido-usos select').length; i++){
        document.querySelectorAll('#contenido-usos select')[i].addEventListener('input', leerValorMultiSelect);
    }
}

function leerValorMultiSelect(evento) {
    let existeTextArea = false;
    const arrayNameUsos = new Array();
   
    for(let i= 0; i< evento.target.parentNode.children.length; i++){
        etiqueta = evento.target.parentNode.children[i].localName;
        if(etiqueta == 'textarea'){
            existeTextArea = true;
        } else {
            existeTextArea = false;
        }
    }

    Object.values(evento.target.selectedOptions).forEach(option => {
        arrayNameUsos.push(option.text);
    });

    let selectOtro = false;
    arrayNameUsos.forEach(nameUsos => {
        if(nameUsos.includes('Otro uso')) {
            selectOtro = true;
        }
    });

    if(selectOtro) {
        if(!existeTextArea) {
            label = document.createElement('LABEL');
            label.setAttribute('for', evento.target.id + '_descripcion');
            label.setAttribute('id', evento.target.id + '_label');
            label.innerText = 'Otros tipos de usos';

            evento.target.parentNode.appendChild(label);

            textarea = document.createElement('TEXTAREA');
            textarea.setAttribute('id', evento.target.id + '_descripcion');
            textarea.setAttribute('class', 'form-control');
            textarea.setAttribute('name', 'variedad1[' + evento.target.id + '_descripcion]');

            //console.log(evento.target.parentNode.children);

            evento.target.parentNode.appendChild(textarea);
        }
    } else {
        // Si existe textarea, eliminarlo
        label = document.querySelector('#' + evento.target.id + '_label');
        textarea = document.querySelector('#'+ evento.target.id + '_descripcion')

        if(existeTextArea) {
            evento.target.parentNode.removeChild(label);
            evento.target.parentNode.removeChild(textarea);
        }
    }
}

function consultarUsos() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            var respuesta = JSON.parse(this.response);
            const listaAlimenHumana = document.querySelector('#variedad1_usoAlimenHumana');
            const listaAlimenAnimal = document.querySelector('#variedad1_usoAlimenAnimal');
            const listaMedicinales = document.querySelector('#variedad1_usoMedicinales');
            const listaVeterinarios = document.querySelector('#variedad1_usoVeterinarios');
            const listaToxicNocivo = document.querySelector('#variedad1_usoToxicNocivo');
            const listaCombustible = document.querySelector('#variedad1_usoCombustible');
            const listaConstruccion = document.querySelector('#variedad1_usoConstruccion');
            const listaArtesania = document.querySelector('#variedad1_usoArtesania');
            const listaMedioambientales = document.querySelector('#variedad1_usoMedioambientales');
            const listaOrnamentales = document.querySelector('#variedad1_usoOrnamentales');
            const listaSociales = document.querySelector('#variedad1_usoSociales');

            Object.values(respuesta).forEach(usos => {
                for(const [key, value] of Object.entries(usos["Alimentación humana"])) {
                    const option = document.createElement('OPTION');
                    option.value = key;
                    option.innerText = value;

                    listaAlimenHumana.appendChild(option);
                }
                
                for(const [key, value] of Object.entries(usos["Alimentación animal"])) {
                    const option = document.createElement('OPTION');
                    option.value = key;
                    option.innerText = value;

                    listaAlimenAnimal.appendChild(option);
                }

                for(const [key, value] of Object.entries(usos["Medicinales"])) {
                    const option = document.createElement('OPTION');
                    option.value = key;
                    option.innerText = value;

                    listaMedicinales.appendChild(option);
                }

                for(const [key, value] of Object.entries(usos["Veterinarios"])) {
                    const option = document.createElement('OPTION');
                    option.value = key;
                    option.innerText = value;

                    listaVeterinarios.appendChild(option);
                }
                
                for(const [key, value] of Object.entries(usos["Tóxico y nocivo"])) {
                    const option = document.createElement('OPTION');
                    option.value = key;
                    option.innerText = value;

                    listaToxicNocivo.appendChild(option);
                }

                for(const [key, value] of Object.entries(usos["Combustible"])) {
                    const option = document.createElement('OPTION');
                    option.value = key;
                    option.innerText = value;

                    listaCombustible.appendChild(option);
                }

                for(const [key, value] of Object.entries(usos["Construcción"])) {
                    const option = document.createElement('OPTION');
                    option.value = key;
                    option.innerText = value;

                    listaConstruccion.appendChild(option);
                }

                for(const [key, value] of Object.entries(usos["Artesanía o industria"])) {
                    const option = document.createElement('OPTION');
                    option.value = key;
                    option.innerText = value;

                    listaArtesania.appendChild(option);
                }

                for(const [key, value] of Object.entries(usos["Medioambientales"])) {
                    const option = document.createElement('OPTION');
                    option.value = key;
                    option.innerText = value;

                    listaMedioambientales.appendChild(option);
                }

                for(const [key, value] of Object.entries(usos["Ornamentales"])) {
                    const option = document.createElement('OPTION');
                    option.value = key;
                    option.innerText = value;

                    listaOrnamentales.appendChild(option);
                }

                for(const [key, value] of Object.entries(usos["Sociales, simbólicos y rituales"])) {
                    const option = document.createElement('OPTION');
                    option.value = key;
                    option.innerText = value;

                    listaSociales.appendChild(option);
                }
            });
        }
    };

    xhttp.open("POST", "/admin/uso/findAll", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
    return false;
}

function getUsosValueId(name, options, input){
    if(name != ""){
        for(const option of options) {
            if(option.value == name){
                const id = option.getAttribute('data-id');
                input.value = id;
            }
        }
    } else {
        input.value = "";
    }
}

function consultaFamilia(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            var respuesta = JSON.parse(this.response);
            const lista = document.querySelector('#familia_list');

            Object.values(respuesta).forEach(element => {
                element.forEach(familia => {
                    
                    array = Object.values(familia);

                    const option = document.createElement('OPTION');
                    option.value = array[0];
                    option.innerText = array[0];

                    lista.appendChild(option);
                })
            });
            
        }
        
    };

    xhttp.open("POST", "/admin/taxon/familia", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
    return false;
}

async function getEspecies(){
    try {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if(this.readyState == 4 && this.status == 200){
                var respuesta = JSON.parse(this.response);
    
                console.log(respuesta);
                // for(const [key, value] of Object.entries(respuesta['especies'])) {
                //     const lista = document.querySelector('#especie_list');
                //     const option = document.createElement('OPTION');
    
                //     option.value = key;
                //     option.innerText = value;
                    
                //     lista.appendChild(option);
                // }
                
                // //Añade Especie en el Input
                // if(respuesta['especieDefault']){
                //     const inputEspecie = document.querySelector('#variedad1_especie');
                //     inputEspecie.value = respuesta['especieDefault'];
                // }
            }
        };
    
        const patron = /(\d+)/g;
        const idVariedad = window.location.pathname.match(patron);
    
        xhttp.open("POST", "/admin/variedades/getEspecies", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
        if(idVariedad){
            var params = 'idVariedad=' + idVariedad;
            xhttp.send(params);
        } else {
            xhttp.send();
        }
    
        return false;
    } catch (error) {
        console.log(error);
    }
   
}

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
    const codigo = document.querySelector('#variedad1_codigo');

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
    codigo.addEventListener('input', leerValor);
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

        var error = false;

        //Validar Formulario
        const {variedad1_marcoA, variedad1_marcoB, variedad1_densidad, variedad1_codigo} = datos;

        const patron = /^[0-9]{1}[.]{1}[0-9]{3}$/i;
        // const lengthCodigo = variedad1_codigo.toString().length;

        const comparacionMarcoA = patron.test(variedad1_marcoA);
        const comparacionMarcoB = patron.test(variedad1_marcoB);
        const comparacionDensidad = patron.test(variedad1_densidad);

        // if(lengthCodigo >= 6){
        //     mostrarAlerta('Código, maximo 5 carácteres', true);
        //     error = true;
        // }
        if(!variedad1_marcoA == '' && !comparacionMarcoA){
            mostrarAlerta('Distacia entre planta, error de formato. | Formato: 0.000', true);
            error = true;
        } 
        if (!variedad1_marcoB == '' && !comparacionMarcoB) {
            mostrarAlerta('Distancia entre lineas, error de formato. | Formato: 0.000', true);
            error = true;
        }
        if(!variedad1_densidad == '' && !comparacionDensidad) {
            mostrarAlerta('Densidad, error de formato. | Formato: 0.000', true);
            error = true;
        }
        
        if(error === false) {
            newVariedad();
        }
    });
} else if(formVariedadUpdate != null){
    formVariedadUpdate.addEventListener('submit', evento => {
        evento.preventDefault();

        var error = false;

        //Validar Formulario
        const {variedad1_marcoA, variedad1_marcoB, variedad1_densidad, variedad1_codigo} = datos;

        const patron = /^[0-9]{1}[.]{1}[0-9]{3}$/i;
        const patronCodigo = /^[0-9]$/;
        // const lengthCodigo = variedad1_codigo.toString().length;

        const comparacionMarcoA = patron.test(variedad1_marcoA);
        const comparacionMarcoB = patron.test(variedad1_marcoB);
        const comparacionDensidad = patron.test(variedad1_densidad);

        // if(lengthCodigo >= 6){
        //     mostrarAlerta('Código, maximo 5 carácteres', true);
        //     error = true;
        // }
        if(!variedad1_marcoA == '' && !comparacionMarcoA){
            mostrarAlerta('Distacia entre planta, error de formato. | Formato: 0.000', true);
            error = true;
        } 
        if (!variedad1_marcoB == '' && !comparacionMarcoB) {
            mostrarAlerta('Distancia entre lineas, error de formato. | Formato: 0.000', true);
            error = true;
        }
        if(!variedad1_densidad == '' && !comparacionDensidad) {
            mostrarAlerta('Densidad, error de formato. | Formato: 0.000', true);
            error = true;
        }
        if(!variedad1_codigo == '') {
            const patron = /(\d+)/g;
            const idVariedad = window.location.pathname.match(patron);

            $.ajax({
                url:"/admin/variedades/findCodigo",
                data:{codigo : variedad1_codigo, variedadID : idVariedad},
                type:"post",
                error:function(err){
                        console.error(err);
                },
                success:function(data){
                    const contenedor = document.querySelector('#alerta-codigo');

                    if(data != null) {
                        Object.values(data).forEach(element => {
                            const etiqueta = document.createElement('DIV');
                            etiqueta.classList = 'error';
                            etiqueta.innerText = element;
                            contenedor.appendChild(etiqueta);

                            setTimeout(()=>{
                                etiqueta.remove();
                            }, 5000);
                        });
                    }
                    
                },
                complete:function(){
                    //console.log("Solicitud finalizada.");
                }
            });
        }
         
        if(error === false) {
            updateVariedad();
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
    // setTimeout(()=>{
    //     alerta.remove();
    // }, 5000);
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
        url:"/admin/variedades/new",
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

function updateVariedad(){
    const patron = /(\d+)/g;
    const idVariedad = window.location.pathname.match(patron);

    $.ajax({
        url:"/admin/variedades/"+idVariedad+"/edit",
        data: new FormData(formVariedadUpdate),
        type:"post",
        contentType:false,
        processData:false,
        cache:false,
        error:function(err){
            console.error(err);
        },
        success:function(data){
            //console.log(data);
            url = "/admin/variedades/";
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
            
            const input = document.createElement('INPUT');
            input.setAttribute('type', 'hidden');
            input.setAttribute('value', data['idImagen']);
            input.setAttribute('id', 'idImagen');

            formImagen.appendChild(input);

            divImagen = document.querySelector('#imagen');
            divImagenSelect = document.querySelector('#imagenSelect');

            $(divImagen).hide();
            $(divImagenSelect).show();
            

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
    //console.log(idImagen);
    var params = 'idVariedad=' + variedad.value + '&idImagen=' + idImagen;

    xhttp.open("POST", "/admin/img/seleccion/relation", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
    return false;
}

function cerrar(){
    window.location.href = "/admin/variedades";
}

