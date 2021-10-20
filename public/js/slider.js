/* Elemento DIV que cambia su texto */
var a = document.getElementById("flecha");
var b = document.getElementById("flecha_iz");

var slider_1 = document.getElementById("home-impression-01");
var slider_2 = document.getElementById("home-impression-02");
var slider_3 = document.getElementById("home-impression-03");

var num = 1;
window.num = num;


/* Se agrega el evento al elemento */
a.addEventListener("click", flecha_derecha);
b.addEventListener("click", flecha_izquierda);



/* Función que se gatilla al hacer click en el elemento DIV */
function flecha_derecha() {




  if(window.num == 3){
    window.num = 0;
  }

  window.num = window.num + 1;



  if(window.num == 1){
    slider_1.style.display = 'block';
    slider_2.style.display = 'none';
    slider_3.style.display = 'none';
    
  }

  if(window.num == 2){
    slider_1.style.display = 'none';
    slider_2.style.display = "block";
    slider_3.style.display = 'none';
  }
  if(window.num == 3 ){
    slider_2.style.display = 'none';
    slider_1.style.display = 'none';
    slider_3.style.display = "block";
  }
  

}

function flecha_izquierda() {

  
  window.num = window.num - 1;

  if(window.num == 0 ){
    slider_3.style.display = 'block';
    slider_1.style.display = 'none';
    slider_2.style.display = "none";

    window.num = 3;
    
  }

  if(window.num == 2 ){
    slider_2.style.display = 'block';
    slider_3.style.display = "none";
    slider_1.style.display = 'none';
    
  }
  
  if(window.num == 1){
    slider_1.style.display = 'block';
    slider_2.style.display = "none";
    slider_3.style.display = 'none';
  }



  
  

}




