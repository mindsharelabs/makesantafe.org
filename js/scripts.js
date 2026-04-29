(function( root, $, undefined ) {
	"use strict";

	const THEME_STORAGE_KEY = 'make-theme-mode';

	function normalizeTheme(theme) {
		return theme === 'dark' ? 'dark' : 'light';
	}

	function getStoredTheme() {
		try {
			return normalizeTheme(localStorage.getItem(THEME_STORAGE_KEY));
		} catch (error) {
			return 'light';
		}
	}

	function persistTheme(theme) {
		try {
			localStorage.setItem(THEME_STORAGE_KEY, normalizeTheme(theme));
		} catch (error) {}
	}

	function getThemeToggleState(theme) {
		if (theme === 'dark') {
			return {
				pressed: 'true',
				text: 'Light',
				label: 'Switch to light mode'
			};
		}

		return {
			pressed: 'false',
			text: 'Dark',
			label: 'Switch to dark mode'
		};
	}

	function syncThemeToggle(theme) {
		const state = getThemeToggleState(theme);
		const $toggle = $('[data-theme-toggle]');

		$toggle.attr('aria-pressed', state.pressed);
		$toggle.attr('aria-label', state.label);
		$toggle.attr('title', state.label);
		$toggle.toggleClass('is-dark', theme === 'dark');
		$('[data-theme-toggle-text]').text(state.text);
	}

	function applyTheme(theme) {
		const nextTheme = normalizeTheme(theme);

		document.documentElement.setAttribute('data-bs-theme', nextTheme);
		document.documentElement.style.colorScheme = nextTheme;
		syncThemeToggle(nextTheme);
	}

	$(function () {

		applyTheme(document.documentElement.getAttribute('data-bs-theme') || getStoredTheme());

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

		$(document).on('click', '[data-theme-toggle]', function() {
			var currentTheme = normalizeTheme(document.documentElement.getAttribute('data-bs-theme'));
			var nextTheme = currentTheme === 'dark' ? 'light' : 'dark';

			applyTheme(nextTheme);
			persistTheme(nextTheme);
		});

	
		jQuery('body').addClass('fade-in');



		function addToCart(p_id) {
			$.get('/?post_type=product&add-to-cart=' + p_id, function() {

			});
		}


	});


} ( this, jQuery ));
