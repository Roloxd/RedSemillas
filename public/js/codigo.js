function cambiarAnchoNumeros(){
    var variedades = document.querySelectorAll('.variedad');

    variedades.forEach(variedad => {
        var numberDiv = variedad.querySelector('.number-div');

        if (variedad.id >= 100){
            numberDiv.className = numberDiv.className + ' ' + 'ancho-1';
        }
    });
}

cambiarAnchoNumeros();