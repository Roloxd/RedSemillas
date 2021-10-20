
/* Se agrega el evento al elemento */

var modal = document.getElementById("tvesModal");
var btn = document.getElementById("btnModal");
var span = document.getElementById("close");


var modal2 = document.getElementById("tvesModal-2");
var btn2 = document.getElementById("btnModal-2");
var span2 = document.getElementById("close-2");

var modal3 = document.getElementById("tvesModal-3");
var btn3 = document.getElementById("btnModal-3");
var span3 = document.getElementById("close-3");

var modal4 = document.getElementById("tvesModal-4");
var btn4 = document.getElementById("btnModal-4");
var span4 = document.getElementById("close-4");

var modal5 = document.getElementById("tvesModal-5");
var btn5 = document.getElementById("btnModal-5");
var span5 = document.getElementById("close-5");

var modal6 = document.getElementById("tvesModal-6");
var btn6 = document.getElementById("btnModal-6");
var span6 = document.getElementById("close-6");


var body = document.getElementsByTagName("body")[0];


// ----------------------------------------------

btn.onclick = function () {
    modal.style.display = "block";

    body.style.position = "static";
    body.style.height = "100%";
    body.style.overflow = "hidden";
}

span.onclick = function () {
    modal.style.display = "none";

    body.style.position = "inherit";
    body.style.height = "auto";
    body.style.overflow = "visible";
}

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";

        body.style.position = "inherit";
        body.style.height = "auto";
        body.style.overflow = "visible";
    }
}

// -------------------------------------------

btn2.onclick = function () {
    modal2.style.display = "block";

    body.style.position = "static";
    body.style.height = "100%";
    body.style.overflow = "hidden";
}

span2.onclick = function () {
    modal2.style.display = "none";

    body.style.position = "inherit";
    body.style.height = "auto";
    body.style.overflow = "visible";
}

window.onclick = function (event) {
    if (event.target == modal2) {
        modal2.style.display = "none";

        body.style.position = "inherit";
        body.style.height = "auto";
        body.style.overflow = "visible";
    }
}


// ----------------------------------------------

btn3.onclick = function () {
    modal3.style.display = "block";

    body.style.position = "static";
    body.style.height = "100%";
    body.style.overflow = "hidden";
}

span3.onclick = function () {
    modal3.style.display = "none";

    body.style.position = "inherit";
    body.style.height = "auto";
    body.style.overflow = "visible";
}

window.onclick = function (event) {
    if (event.target == modal3) {
        modal3.style.display = "none";

        body.style.position = "inherit";
        body.style.height = "auto";
        body.style.overflow = "visible";
    }
}
// -------------------------------------------

btn4.onclick = function () {
    modal4.style.display = "block";

    body.style.position = "static";
    body.style.height = "100%";
    body.style.overflow = "hidden";
}

span4.onclick = function () {
    modal4.style.display = "none";

    body.style.position = "inherit";
    body.style.height = "auto";
    body.style.overflow = "visible";
}

window.onclick = function (event) {
    if (event.target == modal4) {
        modal4.style.display = "none";

        body.style.position = "inherit";
        body.style.height = "auto";
        body.style.overflow = "visible";
    }
}


// -------------------------------------------

btn5.onclick = function () {
    modal5.style.display = "block";

    body.style.position = "static";
    body.style.height = "100%";
    body.style.overflow = "hidden";
}

span5.onclick = function () {
    modal5.style.display = "none";

    body.style.position = "inherit";
    body.style.height = "auto";
    body.style.overflow = "visible";
}

window.onclick = function (event) {
    if (event.target == modal5) {
        modal5.style.display = "none";

        body.style.position = "inherit";
        body.style.height = "auto";
        body.style.overflow = "visible";
    }
}


// -------------------------------------------

btn6.onclick = function () {
    modal6.style.display = "block";

    body.style.position = "static";
    body.style.height = "100%";
    body.style.overflow = "hidden";
}

span6.onclick = function () {
    modal6.style.display = "none";

    body.style.position = "inherit";
    body.style.height = "auto";
    body.style.overflow = "visible";
}

window.onclick = function (event) {
    if (event.target == modal6) {
        modal6.style.display = "none";

        body.style.position = "inherit";
        body.style.height = "auto";
        body.style.overflow = "visible";
    }
}


// ----------------------------------------------










