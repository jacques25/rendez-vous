var $ = require('jquery');
var $collectionHolder;

// Add new item (OptionBijou forms)

var $addNewItem = $('<div class= "col" > <a href="#" class="btn btn-info mt-3 mb-3" ><i class="fa fa-plus"></i> Ajouter référence et taille ....</a></div > ');

$(document).ready(function () {
  // get collection collectionHolder
  $collectionHolder = $('#option_bijou_list');
  // appending the addNewItem to the collectionHolder
  $collectionHolder.append($addNewItem);

  $collectionHolder.data('index', $collectionHolder.find('.card').length);

  // add remove button to existing items 
  $collectionHolder.find('.card').each(function () {
    addRemoveButton($(this));

  });

  // handle click event for addNewItem
  $addNewItem.click(function (e) {
    e.preventDefault();
    // create a new form and append it to the collectionHandler
    addNewForm();
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
    var $card = $('<div class="card"><div class="card-header bg-success"><a class="nav-link" href="#card-bijou" data-toggle="collapse">Nouvelle option <i class="fas fa-chevron-down float-right"></i></div></a></div>');

    // create the card body and append the form to it

    var $cardBody = $('<div class="card-body collapse" id="card-bijou"></div>').append(newForm);

    // append the body to the card
    $card.append($cardBody);

    // append the removeButton to the new card
    addRemoveButton($card);

    // append the card to the addNewItem
    $addNewItem.before($card);

  }

  //remove then

  function addRemoveButton($card) {
    // create remove button
    var $removeButton = $('<a href="#" class="btn btn-danger">Supprimer</a>');
    // appending the removeButton to the card footer
    var $cardFooter = $('<div class="card-footer"></div>').append($removeButton);
    // handle click event of remove button

    $removeButton.click(function (e) {
      e.preventDefault();
      $(e.target).parents('.card').slideUp(900, function () {

        $(this).remove();
      });

    });

    // append the footer to card

    $card.append($cardFooter);
  }
});


