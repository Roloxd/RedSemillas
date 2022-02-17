function consultarPersonas(etiqueta, etiquetaHidden, atributo = false){
    $.ajax({
        url:'/admin/persona/findAll',
        data: null,
        type:"POST",
        error:function(err){
            console.error(err);
        },
        success:function(data) {
            crearOptionPersona(etiqueta, data, etiquetaHidden, atributo);
        },
        complete:function(){
            //console.log("Solicitud finalizada.");
        }
    });
}

function crearOptionPersona(etiqueta, data, etiquetaHidden, atributo = false) {
    const selectVariedades = document.querySelector(`#${etiqueta}`);
    const length = selectVariedades.options.length;

    // Elimina option anteriores
    if(length > 1) {
        for(let i = length; i >= 1 ; i--) {
            selectVariedades.remove(i);
        }
    }
    
    // Crea los options
    if (typeof data === 'object') {
        // AREGLAR, Entre class y id
        if(atributo === "class") {
            const inputsHidden = document.querySelectorAll(`.${etiquetaHidden}`);

            // Pasamos los ids a un array
            ids = new Array;
            if(inputsHidden.length > 0) {
                inputsHidden.forEach( input => {
                    ids.push( parseInt(input.value) );
                });
            }
        } else {
            var inputsHidden = document.querySelector(`#${etiquetaHidden}`);
        }

        for( persona of data.personas ) {
            const option = document.createElement('OPTION');
            option.value = persona.id;
            option.textContent = `[${persona.nif}] ${persona.nombre} ${persona.apellidos}`;

            if(atributo == "class") {
                if(ids.indexOf( persona.id ) >= 0) {
                    option.setAttribute('selected', 'selected');
                    crearOption(persona.id, option.textContent);
                }
            } else if(atributo === "id") {
                if(inputsHidden != null) {
                    if(inputHidden.value == persona.id) {
                        option.setAttribute('selected', 'selected');
                    }
    
                    obtenerTerrenos(null, persona.id);
                }
            }

            selectVariedades.appendChild(option);
        }
    }
}