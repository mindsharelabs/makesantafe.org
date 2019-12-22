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

		$(function () {
			$('[data-toggle="popover"]').popover()
		})

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



		//make Member Modal

		$('#memberModal').modal({
			show : false
		});
		var modalCookie = Cookies.get('member-modal');
		var modalid = $('#memberModal').data('modalid');

		if(modalCookie != modalid) {
			$('#memberModal').modal('show')
		}
		$('#memberModal').on('shown.bs.modal', function (e) {
		  Cookies.set('member-modal', modalid);
		})



		jQuery('body').addClass('fade-in');



		function addToCart(p_id) {
			$.get('/?post_type=product&add-to-cart=' + p_id, function() {

			});
		}


	});


} ( this, jQuery ));
