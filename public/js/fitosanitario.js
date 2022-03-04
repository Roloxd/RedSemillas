document.addEventListener('DOMContentLoaded', function() {
    iniciarForm();
});

function iniciarForm() {
    optionsDefault(); // Genera los options por defecto de cada SELECT
    obtenerValores(); // Obtiene los valores y los muestra en los SELECTS
}

// Options por defecto
function optionsDefault() { 
    optionsForDet('fitosanitario_fordet'); // Forma deteccion de la patología
    optionsMetDet('fitosanitario_metdet'); // Método de detección
    optionsFitPat('fitosanitario_fitpat'); // Fitopatología
    optionsPatDet('fitosanitario_patdet'); // Pátogeno detectado
}

// Obtiene los valores de los inputs hidden
function obtenerValores() {
    optionSelect('hidden-fordet', 'fitosanitario_fordet'); // Forma deteccion de la patología
    optionSelect('hidden-metdet', 'fitosanitario_metdet'); // Método de detección
    optionSelect('hidden-fitpat', 'fitosanitario_fitpat'); // Fitopatología
    optionSelect('hidden-patdet', 'fitosanitario_patdet'); // Pátogeno detectado
}

function optionsForDet(elemento) {
    // Obtenemos el SELECT
    const select = obtenerElemento(elemento, true);

    // Creamos y añadimos los options al SELECT
    let option = newOption('En Campo', 'En Campo');
    select.appendChild(option);

    option = newOption('Manipulación de envases', 'Manipulación de envases');
    select.appendChild(option);

    option = newOption('Prueba de germinación', 'Prueba de germinación');
    select.appendChild(option);

    option = newOption('Laboratorio', 'Laboratorio');
    select.appendChild(option);
}

function optionsMetDet(elemento) {
    // Obtenemos el SELECT
    const select = obtenerElemento(elemento, true);

    // Creamos y añadimos los options al SELECT
    let option = newOption('Visual', 'Visual');
    select.appendChild(option);

    option = newOption('Laboratorio', 'Laboratorio');
    select.appendChild(option);
}

function optionsFitPat(elemento) {
    // Obtenemos el SELECT
    const select = obtenerElemento(elemento, true);

    // Creamos y añadimos los options al SELECT
    let option = newOption('Hongos', 'Hongos');
    select.appendChild(option);

    option = newOption('Parásitos', 'Parásitos');
    select.appendChild(option);

    option = newOption('Virus', 'Virus');
    select.appendChild(option);

    option = newOption('Roedores', 'Roedores');
    select.appendChild(option);

    option = newOption('Desconocido', 'Desconocido');
    select.appendChild(option);
}

function optionsPatDet(elemento) {
    // Obtenemos el SELECT
    const select = obtenerElemento(elemento, true);

    // Creamos y añadimos los options al SELECT
    let option = newOption('Penicilium spp', 'Penicilium spp');
    select.appendChild(option);

    option = newOption('Fuarium spp', 'Fuarium spp');
    select.appendChild(option);

    option = newOption('Rhizopus spp', 'Rhizopus spp');
    select.appendChild(option);

    option = newOption('Puccinia spp', 'Puccinia spp');
    select.appendChild(option);

    option = newOption('Gorgojos', 'Gorgojos');
    select.appendChild(option);
}

function optionSelect(elementoHidden, elemento) {
    const hidden = obtenerElemento(elementoHidden, true);

    if(hidden.value !== "") {
        const values = hidden.value.split(',');

        const select = obtenerElemento(elemento, true);
        const options = select.options;

        values.forEach(value => {
            let option = buscarOptionEnObjeto(value, options);

            if(typeof option !== 'undefined') {
                option.setAttribute('selected', 'selected');
            } else {
                option = newOption(value, value);
                select.appendChild(option);
                option.setAttribute('selected', 'selected');
            }
        });
    }
}