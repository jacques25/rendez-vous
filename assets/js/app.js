import "bootstrap";
import "cropper/dist/cropper.min";
import * as Cropper from "../../public/bundles/image/js/cropper";
import * as ImageZoom from "js-image-zoom";
global.moment = require('moment');

// any CSS you require will output into a single css file (app.css in this case)

require("../css/user.css");
require("bootstrap");
require("./bootstrap-datetimepicker.min.js")
require("./locales/bootstrap-datetimepicker.fr");
require("./datepicker/bootstrap-datepicker.min.js")
require('./datepicker/locales/bootstrap-datepicker.fr.min.js')
require("../css/app.css");
require("popper.js");
require("bootstrap-hover-dropdown");
require("./bootstrap-tagsinput.js");
require("./typeahead.js");
require("./select");
require("./menu_responsive");
require("./compteur.js");
require("./rating.js")

$(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip();
  $('[data-toggle="popover"]').popover();
});

$(function () {
  $(".cropper").each(function () {
    new Cropper($(this));
  });
});



window.onload = function () {
  var modal = document.getElementById("myModalImg");
  var modalImg = document.getElementById("modal-img");
  var captionText = document.getElementById("caption");
  var img = document.getElementById("myImg");

  if (img !== null) {
    img.onclick = function () {
      modal.style.display = "block";
      modalImg.src = this.src;
    }; // Get the <span> element that closes the modal

    var span = document.getElementsByClassName("close")[0]; // When the user clicks on <span> (x), close the modal
    if (span !== null ){
        span.onclick = function () {
      modal.style.display = "none";
    };
    }
  
  }

   var modal_formation = document.getElementById('modal-comment')
  var btn = document.getElementById('btn_formation');
  var body = $("html","body");
  if (btn !== null) {
    $(btn).click(function () {
      modal_formation.style.display = "block";
      $("html, body").animate({ scrollTop: 0 }, 600);
    return false;
    });
    }
  
  var close = document.getElementsByClassName('close-formation')[0];
  if (close !== null) {
    $(close).click(function () {
      modal_formation.style.display = "none";

    })
  }
    let message = document.getElementById('modal-message');
    if (message !== null) {
      message.style.display = "block";
    }
    let closeMessage = document.getElementsByClassName('close-message')[0];
    if (closeMessage !== null) {
      $(closeMessage).click(function () {
        message.style.display = "none";
      })
    }
  

    var modal_contact = document.getElementById('modal-response')
    var btnClose = document.getElementById('close-contact');
  
    var body = $("html","body");
    if (btnClose !== null) {
      $(btnClose).click(function () {
        modal_contact.style.display = "block";
        $("html, body").animate({ scrollTop: 0 },600);
        return false;
      });
    }

    var closeContact = document.getElementsByClassName('close-contact')[0];
    if (closeContact !== null) {
      $(closeContact).click(function () {
        modal_contact.style.display = "none";
      })
 

    }
  }

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
  if (!event.target.matches(".dropbtn")) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains("show")) {
        openDropdown.classList.remove("show");
      }
    }
  }
};

$(window).on("scroll", function() {
	var scrollHeight = $(document).height();
	var scrollPosition = $(window).height() + $(window).scrollTop();
	if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
    $('#footerMenu').addClass("show");

  }
  else {
    	$('#footerMenu').removeClass("show");
  }
});


  $(".card").hover(
    function () {
      $(this).addClass("animate");
    },
    function () {
      $(this).removeClass("animate");
    }
  );


var element = $(".panel-heading a");
var btn = $(".panel-heading-two a");

element.on("click", function () {
  if (element.hasClass("active")) {
    element.removeClass("active");
  } else {
    element.addClass(" active");
    element.append(
      '<img src="/build/images/chevron-down.png" class="img-right>'
    );
  }
});

btn.on("click", function () {
  if (btn.hasClass("active")) {
    btn.removeClass("active");
  } else {
    btn.addClass(" active");
    btn.append('<img src="/build/images/chevron-down.png" class="img-right>');
  }
});

console.log("Hello Webpack Encore! Edit me in assets/js/app.js");
