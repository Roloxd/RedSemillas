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

// Si boolean es true: Selecciona varias opciones, si es false, solo una
function optionSelect(elementoHidden, elemento, boolean = false) {
    const hidden = obtenerElemento(elementoHidden, true);

    if(hidden && hidden.value !== "") {
        const select = obtenerElemento(elemento, true);
        const options = select.options;

        if(boolean) {
            const values = hidden.value.split(',');

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
        } else {
            const value = hidden.value;
            let option = buscarOptionEnObjeto(value, options);
            option.setAttribute('selected', 'selected');
        }
    }
}

function dBlock(elemento) {
    if(elemento) {
        elemento.classList.remove('d-none');
        elemento.classList.add('d-block');
    }
}

function dNone(elemento) {
    if(elemento) {
        elemento.classList.remove('d-block');
        elemento.classList.add('d-none');
    }
}

// Retorna boolean, si el elemento contiene OPTIONS, podemos decirle desde donde empiece a contar 
function contieneOptions(elemento, inicio) {
    const num = inicio - 1;
    if(elemento && elemento.options.length > num) {
        return true;
    } else {
        return false;
    }
}