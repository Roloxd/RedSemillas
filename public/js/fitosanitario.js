document.addEventListener('DOMContentLoaded', function() {
    iniciarForm();
});

function iniciarForm() {
    optionsDefault(); // Genera los options por defecto de cada SELECT
}

function optionsDefault() {
    optionsForDet(); // Options por defecto del campo (Forma deteccion de la patología)
    optionsMetDet(); // Options por defecto del campo (Método de detección)
}

function optionsForDet() {
    // Obtenemos el SELECT
    const select = document.querySelector('#fitosanitario_fordet');

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

function optionsMetDet() {
    // Obtenemos el SELECT
    const select = document.querySelector('#fitosanitario_metdet');

    // Creamos y añadimos los options al SELECT
    let option = newOption('Visual', 'Visual');
    select.appendChild(option);

    option = newOption('Laboratorio', 'Laboratorio');
    select.appendChild(option);
} // Continuar con el back-end
