$(document).ready(function(){

function troca_frase() {
$(‘.frase .atual’).slideUp(‘slow’,function(){

el = $(‘.frase .atual’);
it = $(‘.frase .atual + a’);
el.removeClass(‘atual’);
it.fadeIn(‘slow’).addClass(‘atual’);
if (!it.hasClass(‘atual’)) {
$(‘.frase a:first’).fadeIn(‘slow’).addClass(‘atual’);
};

});
}

$(‘.frase a:first’).fadeIn(‘slow’).addClass(‘atual’);
var frase = setInterval(function(){ troca_frase(); }, 8000);
}); 