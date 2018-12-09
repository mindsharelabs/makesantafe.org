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




				$(document.body).on('click', '.ajax_add_to_cart', function(){
					$('#signup_3').addClass('show');
					$([document.documentElement, document.body]).animate({
							scrollTop: $("#signup_3").offset().top
					}, 2000);
				})


				 $('.signup-continue').click(function(e) {
				 		e.preventDefault();

				 		var next = $(this).data('next');
						var parent = $(this).parent();
						var cartItem = $(this).data('item');

						if(cartItem){
							addToCart(cartItem);
						}
						if(next){
							revealStep(next, parent);
						}

				  });

					$('#certs').on('click', '.add-to-cart', function(){
						var cartItem = $(this).data('item');
						addToCart(cartItem);
					})


				 function revealStep(show, parent) {
					 parent.removeClass('show');
					 $('#signup_'+show).addClass('show');

					 if(show == 2){
						 getProductCats(70); //ID of the certification category
					 }
				 }


				 $('#prodCats').on("click", '.get-products', function(){
					 $(this).addClass('selected').siblings().removeClass('selected');
				   getCerts($(this).data('term'));
				 });

				 function getProductCats(cat) {
					 $('#prodCats').html('<i class="fas fa-spin fa-spinner fa-5x"></i>');
					 $.ajax({
		      		url : settings.ajax_url,
		      		type : 'post',
		          data : {
		      			action : 'get_prod_cats',
		      			parent : cat
		      		},
		          success: function(response) {

								$('#prodCats').html(response.data);
		          },
		          error: function (response) {
		              console.log('An error occurred.');
		              console.log(response);
		          },
		      	});
				 }


				 function getCerts(category) {
					 $('#certs').addClass('loading').html('<i class="fas fa-spin fa-spinner fa-5x"></i>');
					 $.ajax({
		      		url : settings.ajax_url,
		      		type : 'post',
		          data : {
		      			action : 'get_certs',
								category : category
		      		},
		          success: function(response) {
								$('#certs').removeClass('loading').html(response.data);

		          },
		          error: function (response) {
		              console.log('An error occurred.');
		              console.log(response);
		          },
		      	});
				 }







    });


} ( this, jQuery ));
