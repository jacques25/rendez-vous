import SlimSelect from 'slim-select';
var $ = require('jquery')
$(document).ready(function () {
  var mutiple = document.getElementById('multiple')
  if (mutiple) {
    new SlimSelect({
      select: mutiple,
      placeholder: true

    });
  }
});

$(document).ready(function () {
  var mutiple = document.getElementById('multiple-popup')
  if (mutiple) {
    new SlimSelect({
      select: mutiple,
      placeholder: true

    });
  }
});


$(document).ready(function () {
  var bout_cat = document.getElementById('boutique_category')
  if (bout_cat) {
    new SlimSelect({
      select: bout_cat,
      placeholder: true


    });
  }
});

$(document).ready(function () {
  var optgroup = document.getElementById('optgroup')
  if (optgroup) {
    new SlimSelect({
      select: optgroup,
      placeholder: true

    });
  }
});

$(document).ready(function () {
  var article = document.getElementById('article_category')
  if (article) {
    new SlimSelect({
      select: article,
      placeholder: true

    });
  }
});


$(document).ready(function () {
  var select = document.getElementById('category')
  if (select) {
    new SlimSelect({
      select: select,
      placeholder: true

    });
  }
});

$(document).ready(function () {
  var select = document.getElementById('produits')
  if (select) {
    new SlimSelect({
      select: select,
      placeholder: true

    });
  }
});

$(document).ready(function () {
  var select = document.getElementById('boutiques')
  if (select) {
    new SlimSelect({
      select: select,
      placeholder: true

    });
  }
});
