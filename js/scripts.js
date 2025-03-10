(function( root, $, undefined ) {
	"use strict";

	$(function () {

		var docWidth = document.documentElement.offsetWidth;


		const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
		const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


		// [].forEach.call(
		// 	document.querySelectorAll('*'),
		// 	function(el) {
		// 		if (el.offsetWidth > docWidth) {
		// 			console.log($(el));
		// 		}
		// 	}
		// );

		$(".cert-holder").popover({ trigger: "hover" });


		$( document.body ).on( 'updated_cart_totals', function(){
			var cart_count_container = $(".cart-contents-count");
			$.ajax({
                url : settings.ajax_url,
                type : 'post',
                data : {
                    action : 'cart_count_retriever'
                },
				beforeSend: function() {
					cart_count_container.html('<i class="text-success fa-xs fa fa-inverse fa-spin fa-spinner"></i>');
				},
                success: function(response) {
                  
					cart_count_container.html('<i class="text-success fa-xs fa fa-inverse fa-circle-' + response + '"></i>');

                },
                error: function (response) {
                    console.log('An error occurred.');
                    console.log(response);
                },
            });
			
			
		});



		var windowWidth = $(window).width();

		if(windowWidth < 576) {
			var menuWidth = windowWidth - 50;




		} else if(windowWidth < 992) {
			var menuWidth = windowWidth/2;
		} else if(windowWidth < 1200) {
			var menuWidth = 400;
		} else {
			var menuWidth = 400;
		}

		$(window).scroll(function() {
			if ($(document).scrollTop() > 10) {
				$('header.header').addClass('scrolled');
			}
			else {
				$('header.header').removeClass('scrolled');
			}
		});

		$(document).on('click', '#mobileMenuToggle', function() {
 
			setTimeout( function() {
				$('#mobileMenu').toggleClass('show');
			}, 100);
			$(this).toggleClass('active');
		});

		$(document).on('click', '#mobileMenu li.page_item_has_children a, #mobileMenu li.menu-item-has-children a', function(e) {
			
			if($(this).parent().hasClass('menu-item-has-children') || $(this).parent().hasClass('page_item_has_children')) {
				e.preventDefault();
			}
			// var curIcon = $(this).find('svg').attr('data-icon');
			// if(curIcon == 'angle-down') {
			// 	$(this).find('svg').setAttribute('data-icon', 'angle-down');
			// } else {
			// 	$(this).find('svg').setAttribute('data-icon', 'plus');
			// }
			$(this).parent().toggleClass('expanded');

		})

	
		jQuery('body').addClass('fade-in');



		function addToCart(p_id) {
			$.get('/?post_type=product&add-to-cart=' + p_id, function() {

			});
		}


	});


} ( this, jQuery ));
