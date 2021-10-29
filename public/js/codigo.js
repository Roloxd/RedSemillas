function cambiarAnchoNumeros(){
    var variedades = document.querySelectorAll('.variedad');

    variedades.forEach(variedad => {
        var numberDiv = variedad.querySelectorAll('.number-div');

        if (variedad.id >= 100){
            numberDiv.forEach(element => {
                element.className = numberDiv.className + ' ' + 'ancho-1';
            });
        }
    });
}

cambiarAnchoNumeros();