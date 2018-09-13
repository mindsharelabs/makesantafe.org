
jQuery(function($) {


 $(".entry-content").fitVids();

//Switch url to app for iphones
 $(".social-links a").switcher();
//lazy load video
//$('iframe').sleepyHead();



	//open-close submenu on mobile
	$('.cd-main-nav').on('click', function(event){
		if($(event.target).is('.cd-main-nav')) $(this).children('ul').toggleClass('is-visible');
	});



				   jQuery( ".edd-input.edd-item-quantity" ).change(function(event) {
				      var max = parseInt(jQuery(this).attr('max'));
				      var min = parseInt(jQuery(this).attr('min'));
				      if (jQuery(this).val() > max)
				      {
				          jQuery(this).val(max);
				          event.preventDefault();
				      }
				      else if (jQuery(this).val() < min)
				      {
				          jQuery(this).val(min);
				      }
				    });




/*Scroll to top code*/
	jQuery(window).scroll(function() {
		if(jQuery(this).scrollTop() != 0) {
			jQuery('#toTop, #backtotop').fadeIn();
		} else {
			jQuery('#toTop, #backtotop').fadeOut();
		}
	});
	jQuery('#toTop, #options a').click(function() {
		jQuery('body,html').animate({scrollTop:0},800);
	});


//Show hide content
jQuery(".expand h2").toggle(function(){
	jQuery('i', this).removeClass("fa-angle-down").addClass("fa-angle-up");
   jQuery(this).parent().children(".inner-text").slideDown('normal').parent().addClass('open');
}, function(){
	jQuery('i', this).removeClass("fa-angle-up").addClass("fa-angle-down");
    jQuery(this).parent().children(".inner-text").slideUp('normal').parent().removeClass('open');
});



jQuery('.showhide').toggle(function(){
	//console.log('bob');
	jQuery('i', this).removeClass("fa-caret-square-o-down").addClass("fa-caret-square-o-up");
   jQuery(this).next(".toshow").slideDown('normal').parent().addClass('open');
}, function(){
	//console.log('bob');
	jQuery('i', this).removeClass("fa-caret-square-o-up").addClass("fa-caret-square-o-down");
    jQuery(this).next(".toshow").slideUp('normal').parent().removeClass('open');
});


jQuery('.mobileshow').toggle(function(){
	//console.log('bob');
	//jQuery('i', this).removeClass("fa-angle-down").addClass("fa-angle-up");
   jQuery(this).next(".mobilehide").slideDown('normal').parent().addClass('open');
}, function(){
	//console.log('bob');
	//jQuery('i', this).removeClass("fa-angle-up").addClass("fa-angle-down");
    jQuery(this).next(".mobilehide").slideUp('normal').parent().removeClass('open');
});



if (location.hash !== '') {
    $('.tabs a[href="' + location.hash.replace('tab_','') + '"]').tab('show');
} else {
    $('.tabs a:first').tab('show');
}

$('.tabs a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
      window.location.hash = 'tab_'+  e.target.hash.substr(1) ;
      return false;
});



	var $container = $('.masonry');
	// initialize Masonry after all images have loaded
	$container.imagesLoaded( function() {

		var columnCount = 3;
	    var gutter = 15;

	//$('.loading').hide();

	  $container.find('.loading').hide();
	   $container.find('.item').fadeIn('slow');

		// initialize Masonry after all images have loaded
		$container.masonry({
			itemSelector: '.item',
			//gutter:15,
			//isFitWidth: true
		});

	});


//console.log(svgvars);
if (svgvars.home != "1") {
	var logo = Snap("#header-logo-load");
	Snap.load( svgvars.logo, function(f) {
	        logo.append(f);
	        	logo.attr({ opacity: '0' });

	        	logo.animate({opacity:"1"},1000);

				var t = logo.text(50,120,'MAKE').attr({ fontSize: '90px','fill':'black' ,fontWeight: 700, "text-anchor": "right" });
				var t = logo.text(110,183,'santa fe').attr({ fontSize: '56px','fill':'black' , fontWeight: 400, "text-anchor": "right" });

	});
}

 if ($( ".page-header" ).length) {
	var s = Snap(".page-header");
	var l = Snap.load("https://makesantafe.org/wp-content/themes/make-santa-fe/img/title-bg.svg", onSVGLoaded ) ;
	function onSVGLoaded( data ){
	    s.append( data );
	    s.selectAll("path").attr({stroke: svgvars.litcolor });
	}
}


/*

Snap.load('https://makesantafe.org/wp-content/themes/make-santa-fe/img/title-side-bg.svg', function (l) {
    var g = l.select("g");


    s1.append(g.clone());
    s2.append(g.clone());
    s3.append(g.clone());
});
function onSVGLoadedSide( data ){
	console.log(w);
	$('.widget-header').each(function (index) {
		var w = Snap(indexx);
	   w.append( data );
	});

}
*/

});//End on load