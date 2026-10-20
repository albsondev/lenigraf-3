$(window).load(function(){
	$('.slider')._TMS({
		preset:'diagonalExpand',
		easing:'easeOutQuad',
		duration:800,
		pagination:true,
		slideshow:6000})
	$('ul#menu').superfish({
      delay:       600,
      animation:   {height:'show'},
      speed:       600,
      autoArrows:  false,
      dropShadows: false
    });
})
