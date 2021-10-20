//import 'bootstrap'
/*
import './cropper/cropper.min.js';
import './cropper/cropper.js';

*/

(function(w, $) {
    'use strict';

    $(function() {

        $('.cropper').each(function() {
            new Cropper($(this));

        });
    });

})(window, jQuery);



console.log('LAODEDE');
//import Cropper from './cropper/cropper.js';
//import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router'
//import Routes from './routes.json'
//import axios from 'axios'

// VERSION OVERSEAS
/*
let cropper;
var preview = document.getElementById('avatar');
var file_input = document.getElementById('avatar_input');

window.previewFile  = function ()
{
    let file = file_input.files[0]
    let reader = new FileReader()

    reader.addEventListener('load', function (event)
    {
        preview.src = reader.result
    }, false)

    if (file)
    {
        reader.readAsDataURL(file)
    }
}

preview.addEventListener('load', function (event)
{
    cropper = new Cropper(preview, {
        aspectRatio: 1/1
    })
})

let form = document.getElementById('profile_form')
form.addEventListener('submit', function (event)
{
    event.preventDefault()
    cropper.getCroppedCanvas({
        maxHeight: 1000,
        maxWidth: 1000
    }).toBlob(function (blob)
    {
        ajaxWithAxios(blob)
    })
})

function ajaxWithAxios(blob)
{
    let url = Routing.generate('image')
    let data = new FormData(form)
    data.append('file', blob)
    axios({
        method: 'post',
        url: url,
        data: data,
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
        .then((response) => {
            console.log(response)
        })
        .catch((error) => {
            console.error(error)
        })
}


 */