(function( root, $, undefined ) {
	"use strict";

	$(function () {

		var docWidth = document.documentElement.offsetWidth;

		[].forEach.call(
		  document.querySelectorAll('*'),
		  function(el) {
		    if (el.offsetWidth > docWidth) {
		      console.log($(el));
		    }
		  }
		);



        var windowWidth = $(window).width();
				var menuWidth = windowWidth;
        var slideout = new Slideout({
            'panel': document.getElementById('main-panel'),
            'menu': document.getElementById('main-nav'),
            'padding': menuWidth,
            'tolerance': 0,
            'side': 'right'
        });

        document.querySelector('.slideout-menu').style.width = menuWidth + 'px';

        //Toggle button
        document.querySelector('.menu-toggle').addEventListener('click', function () {
            slideout.toggle();
        });


        slideout.on('beforeclose', function () {
            $('.slideout-menu').fadeOut();
        });
        slideout.on('beforeopen', function () {
            $('.slideout-menu').fadeIn();
        });
        slideout.on('open', function () {
            $('.menu-toggle svg').addClass("fa-window-close").removeClass("fa-bars");

        });
        slideout.on('close', function () {
            $('.menu-toggle svg').addClass("fa-bars ").removeClass("fa-window-close");

        });

        jQuery('body').addClass('fade-in');



				function addToCart(p_id) {
		 			$.get('/?post_type=product&add-to-cart=' + p_id, function() {

		 			});
		 	 	}


				$('.footerDrawer .open').on('click', function() {
			    $('.footerDrawer .content').slideToggle();

			  });



    });


} ( this, jQuery ));
