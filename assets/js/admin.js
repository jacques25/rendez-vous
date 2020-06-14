var $ = require('jquery');
require('jquery-ui');
require('bootstrap');
require('popper.js');
global.moment = require('moment');

import 'cropper/dist/cropper.min';
import * as Cropper from '../../public/bundles/image/js/cropper';
import SlimSelect from 'slim-select';
// any CSS you require will output into a single css file (app.css in this case)

//require('bootstrap-hover-dropdown');
require("./bootstrap-datetimepicker.min.js")
require("./locales/bootstrap-datetimepicker.fr");
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
var modal1 = document.getElementById("modal1");
  var open = document.getElementById("open");

  if (modal1 !== null) {
    open.onclick = function () {
      modal1.style.display = "block";
    }; // Get the <span> element that closes the modal

    var span = document.getElementsByClassName("close-modal")[0]; // When the user clicks on <span> (x), close the modal

    span.onclick = function () {
      modal1.style.display = "none";
    };
  }


	$(function () {
      /*    var datetimepicker = this.getElementsByClassName('datetimepicker-input'); */
     
      /*    $('.beginAt').datetimepicker({
		  	 language: 'fr',
            autoclose: true,
         icons: {
             time: 'fa fa-clock-o',
             date: 'fa fa-calendar',
             up: 'fa fa-chevron-up',
             down: 'fa fa-chevron-down',
             previous: 'fa fa-chevron-left',
             next: 'fa fa-chevron-right',
             today: 'fa fa-check-circle-o',
             clear: 'fa fa-trash',
             close: 'fa fa-remove'
         }
          })
        
          $('.endAt').datetimepicker({
		  	locale: 'fr',
            autoclose: true,
         icons: {
             time: 'fa fa-clock-o',
             date: 'fa fa-calendar',
             up: 'fa fa-chevron-up',
             down: 'fa fa-chevron-down',
             previous: 'fa fa-chevron-left',
             next: 'fa fa-chevron-right',
             today: 'fa fa-check-circle-o',
             clear: 'fa fa-trash',
             close: 'fa fa-remove'
         }  
          })*/
        
         
        $('#dateExpedition').datetimepicker({
             	locale: 'fr',
            autoclose: true,
        })
     $('.datetimepicker').datetimepicker({
		  	locale: 'fr',
            autoclose: true,
         icons: {
             time: 'fa fa-clock-o',
             date: 'fa fa-calendar',
             up: 'fa fa-chevron-up',
             down: 'fa fa-chevron-down',
             previous: 'fa fa-chevron-left',
             next: 'fa fa-chevron-right',
             today: 'fa fa-check-circle-o',
             clear: 'fa fa-trash',
             close: 'fa fa-remove'
         }
        })

    $('.datetimepicker3').datetimepicker({
		  	locale: 'fr',
            format: 'hh:ii',
            autoclose: true,
	      icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-check-circle-o',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        }
				
		});
		 $('.datetimepicker2').datetimepicker({
			 	locale: 'fr',
             autoclose: true,
              
        icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-check-circle-o',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        }
         });
        var dateExpedition = document.getElementById('dateExpedition');
         $('#dateExpedition').datetimepicker({
			 	locale: 'fr',
             autoclose: true,
             onSelect: function () {
                 dateExpedition = this.datetimepicker.value;
            },
            
    });
});

