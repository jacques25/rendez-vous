var $ = require('jquery')
require('bootstrap');
require('popper.js');
import 'cropper/dist/cropper.min';
import * as Cropper from '../../public/bundles/image/js/cropper';
import SlimSelect from 'slim-select';
// any CSS you require will output into a single css file (app.css in this case)

//require('bootstrap-hover-dropdown');
require('./propertiesBijou');
require('./medias');
require('./select');
require('../css/admin.css');



$(function () {
    $('.cropper').each(function () {
        new Cropper($(this));
    });
});


// Suppression des éléments

document.querySelectorAll('[data-delete]').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault()
        fetch(a.getAttribute('href'), {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XLMHttpRequest',
                    'Content-Type': 'json'
                },
                body: JSON.stringify({
                    '_token': a.dataset.token
                })
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    a.parentNode.parentNode.removeChild(a.parentNode)
                } else {
                    alert(data.error)
                }
            })
            .catch(e => alert(e))
    })
});

$(function () {
    // Sidebar toggle behavior
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar, #content').toggleClass('active');
    });
});

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
