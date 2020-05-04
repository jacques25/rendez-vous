import "bootstrap";
import "cropper/dist/cropper.min";
import * as Cropper from "../../public/bundles/image/js/cropper";
import * as ImageZoom from "js-image-zoom";

// any CSS you require will output into a single css file (app.css in this case)
require("../css/app.css");
require("../css/user.css");

var $ = require("jquery");

require("bootstrap");
require("popper.js");
require("bootstrap-hover-dropdown");
require("./bootstrap-tagsinput.js");
require("./typeahead.js");
require("./select");
require("./menu_responsive");

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
  var modal = document.getElementById("myModal");
  var modalImg = document.getElementById("modal-img");
  var captionText = document.getElementById("caption");
  var img = document.getElementById("myImg");

  if (img !== null) {
    img.onclick = function () {
      modal.style.display = "block";
      modalImg.src = this.src;
    }; // Get the <span> element that closes the modal

    var span = document.getElementsByClassName("close")[0]; // When the user clicks on <span> (x), close the modal

    span.onclick = function () {
      modal.style.display = "none";
    };
  }

  $(function () {
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
};
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

$(document).ready(function () {
  var submitIcon = $('.searchbox-icon');
  var inputBox = $('.searchbox-input');
  var searchBox = $('.searchbox');
  var isOpen = false;
  submitIcon.click(function () {
    if (isOpen == false) {
      searchBox.addClass('searchbox-open');
      inputBox.focus();
      isOpen = true;
    } else {
      searchBox.removeClass('searchbox-open');
      inputBox.focusout();
      isOpen = false;
    }
  });
  submitIcon.mouseup(function () {
    return false;
  });
  searchBox.mouseup(function () {
    return false;
  });
  $(document).mouseup(function () {
    if (isOpen == true) {
      $('.searchbox-icon').css('display', 'block');
      submitIcon.click();
    }
  });
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
