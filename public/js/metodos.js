// Obtener elemento, si boolean es true = id y false = class
function obtenerElemento(elemento, boolean = false) {
    if(boolean){
        return document.querySelector(`#${elemento}`);
    } else {
        return document.querySelector(`.${elemento}`);
    }
}

// Crear un elemento OPTION
function newOption(value, text) {
    const option = document.createElement('OPTION');
    option.value = value;
    option.textContent = text;

    return option;
}

// Buscar valor en un Objeto
function buscarOptionEnObjeto(value, object) {
    for( const [key, option] of Object.entries(object) ) {
        if(value === option.value) {
            return option;
        }
    }
}