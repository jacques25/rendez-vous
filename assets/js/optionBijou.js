var $ = require('jquery')
let Routing = require('../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router')
let Routes = require('./js-routing.json')

Routing.setRoutingData(Routes)


context.forEach(function (index) {
  var taille = index.taille;
  var reference = index.reference;
  var dimensions = index.dimensions;
  var disponible = index.disponible;
  var cout = index.prix;
  var id = index.id;

  let form = document.getElementById("form-panier")


  var select = document.getElementById('select-taille');
  var option = document.createElement("option");

  option.text = taille;
  select.add(option);

  var valeur = select[select.selectedIndex];

  if (valeur === option) {

    if (option.text === null) {
      select.display = 'none';
    } else {
      document.getElementById("option-taille").innerHTML = '<strong> Taille : </strong>' + taille;

    }
    document.getElementById("option-reference").innerHTML = '<strong>Réference: </strong>' + reference;
    document.getElementById('option-dimensions').innerHTML = '<strong>Dimensions: </strong>' + dimensions;
    document.getElementById("option-prix").innerHTML = '<h4>' + cout + '€</h4>';

    // document.getElementById("input-reference").value = reference;
    // document.getElementById("input-prix").value = cout;

    url = Routing.generate('panier_add', {
      id: id,
    })
    form.setAttribute("action", url)


    if (disponible === true) {
      document.getElementById('option-disponible').innerHTML = '<p style="color:green;"> Disponible immédiatement</p>';
    } else {
      document.getElementById('option-disponible').innerHTML = '<p style="color:red;"> Momentanément indisponible</p>';
    }
  }


  select.addEventListener('click', function (e) {


    ref = reference;
    prix = cout;
    dim = dimensions;
    dispo = disponible;
    t = taille;
    ident = id;

    e.preventDefault();

    if (this.value === taille) {
      url = Routing.generate('panier_add', {
        'id': ident
      })
      form.setAttribute("action", url)
      document.getElementById("option-taille").innerHTML = '<strong> Taille : </strong>' + this.value;
      document.getElementById("option-reference").innerHTML = '<strong>Réference: </strong>' + ref;
      document.getElementById('option-dimensions').innerHTML = '<strong>Dimensions: </strong>' + dim;
      document.getElementById("option-prix").innerHTML = '<h4>' + prix + '€</h4>';

      // document.getElementById("input-reference").value = ref;
      // document.getElementById("input-prix").value = prix;

      if (dispo === true) {
        document.getElementById('option-disponible').innerHTML = '<p style="color:green;"> Disponible immédiatement</p>';
      } else {
        document.getElementById('option-disponible').innerHTML = '<p style="color:red;"> Momentanément indisponible</p>';
      }

    }
  }, false);




});
