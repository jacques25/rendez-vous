var $ = require('jquery');

     
    const starsTotal = 5;
    var starFormation = document.getElementById('star-formation');
var ratings = document.querySelectorAll('.comment-formation');

  
document.addEventListener('DOMContentLoaded',getRatings);
  
const ratingControl = document.getElementById('rating-control');
let rating;




function getRatings () {
    if (starFormation) {
        let dataFormation = starFormation.dataset.starformation;
        
        const starPercentage = (dataFormation / starsTotal) * 100;
     
        const starPercentageRounded = `${Math.round(starPercentage / 10) * 10}%`;
        console.log(starPercentageRounded)
        var ratingFormation = document.querySelector("#star-formation");
              
        ratingFormation.style.width = starPercentageRounded;
    }   
    }
  
