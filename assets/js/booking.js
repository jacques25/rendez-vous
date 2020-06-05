var $ = require('jquery')
 var $collectionHolder;

 var $addNewItem = $('<a href="#" class="btn btn-info"><i class="fas fa-plus"></i>Date</a>');

 $(document).ready(function () {
     // obtient la collection exp
     $collectionHolder = $('#booking_formation');
     // appending the addNewItem to the collectionHolder
     $collectionHolder.append($addNewItem);

     $collectionHolder.data('index', $collectionHolder.find('.card').length);
     // ajout du bouton supprimer pour les items exitants
     $collectionHolder.find('.card').each(function () {
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

         $collectionHolder.data('index', index++);
         // create the card
         var $card = $('<div class="card"><a href="#card-body" data-toggle="collapse"><div class="card-header">Formation du </div></a></div>');

         // create the card body and append the form it

         var $cardBody = $('<div class="card-body collapse" id="card-body"></div>').append(newForm);

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
         var $cardFooter = $('<div class="card-footer"></div>').append($removeButton);
         // handle click event of remove button

         $removeButton.click(function (e) {
             e.preventDefault();
             $(e.target).parents('.card').slideUp(1000, function () {
                 $(this).remove();
             });

         });

         // append the footer to card

         $card.append($cardFooter);
     }
 });
