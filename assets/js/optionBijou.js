var $ = require('jquery')
let Routing = require('../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router')
let Routes = require('./js-routing.json')

Routing.setRoutingData(Routes)

var promo = contextPromo;
 var dateStart = promo.dateStart;
    var dateEnd = promo.dateEnd;
    var isActive = promo.promoIsActive;
    var port = promo.port;
    var multiplicate = promo.multiplicate;
   
context.forEach(function (index) {
  var taille = index.taille;
  var reference = index.reference;
  var dimensions = index.dimensions;
  var disponible = index.disponible;
  var cout = index.prix;
  var id = index.id;
  
 var prixPromo = (cout * multiplicate);

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
     if (disponible == true) {
      document.getElementById('option-disponible').innerHTML = '<p style="color:green;"> Disponible immédiatement</p>';
    } else {
      document.getElementById('option-disponible').innerHTML = '<p style="color:red;"> Momentanément indisponible</p>';
    }
      
    
    if (isActive ==true  ) {
      document.getElementById("promo-prix").innerHTML = '<h4>' + prixPromo + '€</h4>';
      document.getElementById("option-prix").innerHTML = '<h4 class="line">' + cout + '€</h4>';
     
    } else { 
   
            document.getElementById("prix").innerHTML = '<h4>' + cout + '€</h4>';
    } 
       
    url = Routing.generate('panier_add', {
      id: id,
    })
    form.setAttribute("action", url)
     
  }


  select.addEventListener('click', function (e) {
    ref = reference;
    prix = cout;
    dim = dimensions;
    dispo = disponible;
    t = taille;
    ident = id;
   
    var prixPromo = (prix * multiplicate);
    console.log(prixPromo)
    e.preventDefault();
 
    if (this.value === taille && isActive ===true) {
      url = Routing.generate('panier_add', {
        'id': ident
      })
     
    
      form.setAttribute("action", url)
      document.getElementById("option-taille").innerHTML = '<strong> Taille : </strong>' + this.value;
      document.getElementById("option-reference").innerHTML = '<strong>Réference: </strong>' + ref;
      document.getElementById('option-dimensions').innerHTML = '<strong>Dimensions: </strong>' + dim;
      
      
      if (isActive ==true  ) {
      document.getElementById("promo-prix").innerHTML = '<h4>' + prixPromo + '€</h4>';
      document.getElementById("option-prix").innerHTML = '<h4 class="line">' + cout + '€</h4>';
     
    } else { 
   
            document.getElementById("prix").innerHTML = '<h4>' + cout + '€</h4>';
    } 
       
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
