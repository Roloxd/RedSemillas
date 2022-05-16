"use strict";

// Para colocar el mapa en una posición inicial

const posiciónInicialMapa = { lat: 28.08797, lng: -15.46537 };

const map = new google.maps.Map(document.getElementById("map"), {
  zoom: 10,
  center: new google.maps.LatLng(posiciónInicialMapa),
});

// Variables
// Select del html
const selectY = document.getElementById("selectYear");
// Api de google para colocar marcadores sin lat ni lng
const geocoder = new google.maps.Geocoder();
// Fechas
const diaActual = String(new Date().getUTCDate());
const mesActual = String(new Date().getMonth());
let añoSeleccionado = String(new Date().getFullYear());
// Ventana que va a mostrar la información cuando se clicke en el marcador
let lastInfoWindow;
// Array donde se van a almacenar todos los marcadores
let markers = [];

// Sirve para colocar el select en el mapa puedes ponerlo a la izk o a la der
// TOP_LEFT , TOP_RIGHT , todo esta en la doc de google api
map.controls[google.maps.ControlPosition.TOP_CENTER].push(selectY);

// Función que atienda cambios en el select del mapa
// Cuando se elige un nuevo año, se limpian los marcadores que estuvieran
// Se almacena el año seleccionado y se llama a la función que coloca los marcadores
const selectedYear = function () {
  cleanMarkers();
  añoSeleccionado = selectY.value;
  setMarkers();
};

// Función para coger los datos de la db. Te devuelve un array de objetos
// donde se encuentran los valores.
async function getDatosEntrada() {
  const respuesta = await fetch("http://localhost/mapa/entradas");
  const datos = await respuesta.json();
  const arrayDatos = await datos.entradas;

  return arrayDatos;
}

async function setMarkers() {
  // Almaceno el array de objetos en arr
  const arr = await getDatosEntrada();
  // Hago destructuring a cada objeto.
  arr.forEach(
    ({
      municipio,
      cantidad,
      cantidadUnidades,
      fecha,
      nombreComun,
      nombreLocal,
      nombreCientifico,
      tipoDeEntrada,
    }) => {
      // La fecha viene completa, solo nos interesa el año, el formato es YYYY-MM-DD
      const añoFecha = fecha.date.slice(0, 4);
      // Filtrado por fecha. El cliente quiere que se muestren las entradas y salidas por año
      // seleccionando el año.
      if (añoSeleccionado !== añoFecha) return;
      // El geocoder es para saber la localizacion exacta solo con el nombre del municipio
      // sin tener que poner lat o lng
      geocoder.geocode(
        {
          address: municipio,
        },
        // Si el resultado es positivo se coloca el marcador
        function (results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            const marker = new google.maps.Marker({
              position: results[0].geometry.location,
              map: map,
              icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
            });
            map.setCenter(results[0].geometry.location);
            markers.push(marker);
            // Esta es la ventana que se ve cuando clickas en el marcador
            // Están solo los valores que le interesan al cliente
            const infowindow = new google.maps.InfoWindow({
              content: `<div class="mapWindow">
                  <p>Tipo de entrada: ${tipoDeEntrada}</p>
                  <p>Cantidad en gramos: ${cantidad}</p>
                  <p>Cantidad en unidades: ${cantidadUnidades}</p>
                  <p>Nombre local: ${nombreComun}</p>
                  <p>Nombre común: ${nombreLocal}</p>
                  <p>Especie: ${nombreCientifico[0]}</p> 
                  </div>`,
            });

            // Este evento es para abrir la ventana de información que hemos creado antes
            // Cierra la ultima ventana abierta antes de abrir la nueva
            google.maps.event.addListener(marker, "click", function () {
              if (lastInfoWindow) lastInfoWindow.close();
              infowindow.open({
                anchor: marker,
                map,
                shouldFocus: false,
              });
              lastInfoWindow = infowindow;
            });
          }
        }
      );
    }
  );
}

// Coloca los marcadores
function setMapOnAll(map) {
  for (let i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}
// Oculta los marcadores del mapa
function hideMarkers() {
  setMapOnAll(null);
}
// Función para eliminar todos los marcadores del mapa
const cleanMarkers = function () {
  hideMarkers();
  markers = [];
};
