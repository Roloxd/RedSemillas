document.addEventListener('DOMContentLoaded', function() {
    iniciarForm();
});

function iniciarForm() {
    optionsDefault(); // Genera los options por defecto de cada SELECT
}

function optionsDefault() {
    optionsForDet(); // Options por defecto de Forma deteccion de la patología
}

function optionsForDet() {
    // Obtenemos el SELECT
    const select = document.querySelector('#fitosanitario_fordet');

    // Creamos y añadirmos los options al SELECT
    let option = newOption('En Campo', 'En Campo');
    select.appendChild(option);

    option = newOption('Manipulación de envases', 'Manipulación de envases');
    select.appendChild(option);

    // Seguir...
    
}

