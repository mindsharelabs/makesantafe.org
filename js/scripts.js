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

		$(document).on('click', '#mobileMenu li.page_item_has_children', function(e) {
			e.preventDefault();
			var curIcon = $(this).find('svg').attr('data-icon');
			$(this).toggleClass('expanded');
		})




		jQuery('body').addClass('fade-in');



		function addToCart(p_id) {
			$.get('/?post_type=product&add-to-cart=' + p_id, function() {

			});
		}


	});


} ( this, jQuery ));
