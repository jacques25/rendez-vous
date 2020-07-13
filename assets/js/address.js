var $ = require('jquery')
var $collectionHolder;

var $addNewItem = $('<a href="#" class="btn btn-info mt-3 ml-3"><i class="fas fa-plus"></i> Ajouter une adresse</a>');

$(document).ready(function () {
  // obtient la collection exp
  $collectionHolder = $('#address');
  // appending the addNewItem to the collectionHolder
  $collectionHolder.append($addNewItem);

  $collectionHolder.data('index', $collectionHolder.find('.card-address').length);
  // ajout du bouton supprimer pour les items exitants
  $collectionHolder.find('.card-address').each(function () {
    addRemoveButton($(this));
  });

  // handle click event for addNewItem
  $addNewItem.click(function (e) {
    e.preventDefault();
    // create a new form and append it to the collectionHandler
    addNewForm();

    // add a removeButton
  });

  function addNewForm() {
    // getting the prototype
    var prototype = $collectionHolder.data('prototype');
    // get the index
    var index = $collectionHolder.data('index');
    // create the form
    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);

    $collectionHolder.data('index', index + 1);
    // create the card
    var $card = $('<div class="card-address float-left"><div class="card-header-address mb-2 p-3"><h6>Nouvelle Adresse</h5></div></div>');

    // create the card body and append the form it

    var $cardBody = $('<div class="card-body-address"></div>').append(newForm);

    // append the body to the card
    $card.append($cardBody);

    // append the removeButton to the new card
    addRemoveButton($card);

    // appdend the card to the addNewItem
    $addNewItem.before($card);

  }
  //remove then

  function addRemoveButton($card) {
    // create remove button
    var $removeButton = $('<a href="#" class="btn btn-danger">Supprimer</a>');
    // appending the removeButton to the card footer
    var $cardFooter = $('<div class="card-footer-address"></div>').append($removeButton);
    // handle click event of remove button

    $removeButton.click(function (e) {
      e.preventDefault();
      $(e.target).parents('.card-header').slideUp(1000, function () {
        $(this).remove();
      });

    });

    // append the footer to card

    $card.append($cardFooter);
  }
});
