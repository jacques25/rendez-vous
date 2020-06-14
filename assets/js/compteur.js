;(function($){$.fn.clearTextLimit=function(){return this.each(function(){this.onkeydown=this.onkeyup=null;});};$.fn.textLimit=function(limit,callback){if(typeof callback!=='function')var callback=function(){};return this.each(function(){this.limit=limit;this.callback=callback;this.onkeydown=this.onkeyup=function(){this.value=this.value.substr(0,this.limit);this.reached=this.limit-this.value.length;this.reached=(this.reached==0)?true:false;return this.callback(this.value.length,this.limit,this.reached);}});};})(jQuery);

$("#compteur").text( "500 caractères maximum. Tapez votre texte").addClass('btn btn-secondary mt-3');
 
$("#comment_content").textLimit(500,function( length, limit, reached  ){
    //On stocke dans une variable le nombre de caractères courant
  var nb = limit - length;
   $("#compteur").addClass('btn btn-success')
  
    //Si on a effacé tout le texte du textarea
       
  
    if ( !reached && length > 0 )
    //Si on n'est pas au bout mais qu'il y a des caractères de tapés
    $("#compteur").text("Il reste " + nb + " caractères");
    if (reached)
    //Si on estarrivé au bout
      
        $("#compteur").text("Vous avez atteint  les "+length+" caractères autorisés.").attr('class' , 'btn btn-danger mt-3');
});
