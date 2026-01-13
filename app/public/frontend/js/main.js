 

(function ($) {
	"use strict";

	//Preloader activation
	var win =  $(window);
	win.on('load', function () {
		$('#preloader').delay(350).fadeOut('slow');
		$('body').delay(350).css({
			'overflow': 'visible'
		});
	})

	// Theme color change Js
	var windowOn = $(window);

	if (jQuery("#theme-color").length > 0){
		const colorInput = document.querySelector('#theme-color');
		const colorVariable = '--clr-theme-1';
	
		colorInput.addEventListener('change', function(e){
			var clr = e.target.value;
			document.documentElement.style.setProperty(colorVariable, clr);
		});
	}

	if (jQuery("#theme-color-2").length > 0){
		const colorInput2 = document.querySelector('#theme-color-2');
		const colorVariable2 = '--clr-theme-2';
	
		colorInput2.addEventListener('change', function(e){
			var clr2 = e.target.value;
			document.documentElement.style.setProperty(colorVariable2, clr2);
		});
	}

	// Mobile Menu Js
	$('#mobile-menu').meanmenu({
		meanMenuContainer: '.mobile-menu',
		meanScreenWidth: "991",
		meanExpand: ['<i class="fal fa-plus"></i>'],
	});

	// Sidebar Js
	$(".side-info-close,.offcanvas-overlay").on("click", function () {
		$(".side-info").removeClass("info-open");
		$(".offcanvas-overlay").removeClass("overlay-open");
	});
	$(".side-toggle").on("click", function () {
		$(".side-info").addClass("info-open");
		$(".offcanvas-overlay").addClass("overlay-open");
	});


	// Body overlay Js
	$(".body-overlay").on("click", function () {
		$(".offcanvas__area").removeClass("opened");
		$(".body-overlay").removeClass("opened");
	});

	// Search form Js
	$(".bd-h-search").on("click", function () {
		$(".bd-search__toggle").toggleClass("header_search-open");
		$(".bd-h-search").toggleClass("opened");
	});
	$("body > *:not(header)").on("click", function () {
		$(".bd-search__toggle").removeClass("header_search-open");
		$(".bd-h-search").removeClass("opened");
	});

	////////////////////////////////////////////////////
	// Sticky Header Js
	windowOn.on('scroll', function () {
		var scroll = $(window).scrollTop();
		if (scroll < 100) {
			$("#header-sticky").removeClass("header-sticky");
		} else {
			$("#header-sticky").addClass("header-sticky");
		}
	});


	////////////////////////////////////////////////////
	// Data CSS Js
	$("[data-background").each(function () {
		$(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
	});
	
	$("[data-width]").each(function () {
		$(this).css("width", $(this).attr("data-width"));
	});

	$("[data-bg-color]").each(function () {
        $(this).css("background-color", $(this).attr("data-bg-color"));
    });

	////////////////////////////////////////////////////
	// Nice Select Js
	$('select').niceSelect();


	////////////////////////////////////////////////////
	//  Slider active  Js
	if (jQuery(".bd-banner__active").length > 0) {
		let sliderActive1 = ".bd-banner__active";
		let sliderInit1 = new Swiper(sliderActive1, {
			// Optional parameters
			slidesPerView: 1,
			slidesPerColumn: 1,
			paginationClickable: true,
			loop: true,
			effect: 'fade',

			autoplay: {
				delay: 5000,
			},

			// If we need pagination
			pagination: {
				el: ".banner-pagination-1",
				// dynamicBullets: true,
				clickable: true,
			},

			// Navigation arrows
			navigation: {
				nextEl: ".swiper-button-next",
				prevEl: ".swiper-button-prev",
			},

			a11y: false,
		});

		function animated_swiper(selector, init) {
			let animated = function animated() {
				$(selector + " [data-animation]").each(function () {
					let anim = $(this).data("animation");
					let delay = $(this).data("delay");
					let duration = $(this).data("duration");

					$(this)
						.removeClass("anim" + anim)
						.addClass(anim + " animated")
						.css({
							webkitAnimationDelay: delay,
							animationDelay: delay,
							webkitAnimationDuration: duration,
							animationDuration: duration,
						})
						.one(
							"webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",
							function () {
								$(this).removeClass(anim + " animated");
							}
						);
				});
			};
			animated();
			// Make animated when slide change
			init.on("slideChange", function () {
				$(sliderActive1 + " [data-animation]").removeClass("animated");
			});
			init.on("slideChange", animated);
		}

		animated_swiper(sliderActive1, sliderInit1);
	}

	// Slider active Slider Js-2
	if (jQuery(".bd-banner-active-2").length > 0) {
		let sliderActive1 = ".bd-banner-active-2";
		let sliderInit1 = new Swiper(sliderActive1, {
			// Optional parameters
			slidesPerView: 1,
			slidesPerColumn: 1,
			paginationClickable: true,
			loop: true,
			effect: 'fade',

			autoplay: {
				delay: 5000,
			},

			// If we need pagination
			pagination: {
				el: ".banner-pagination-2",
				// dynamicBullets: true,
				clickable: true,
			},

			// Navigation arrows
			navigation: {
				nextEl: ".swiper-button-next",
				prevEl: ".swiper-button-prev",
			},

			a11y: false,
		});

		function animated_swiper(selector, init) {
			let animated = function animated() {
				$(selector + " [data-animation]").each(function () {
					let anim = $(this).data("animation");
					let delay = $(this).data("delay");
					let duration = $(this).data("duration");

					$(this)
						.removeClass("anim" + anim)
						.addClass(anim + " animated")
						.css({
							webkitAnimationDelay: delay,
							animationDelay: delay,
							webkitAnimationDuration: duration,
							animationDuration: duration,
						})
						.one(
							"webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",
							function () {
								$(this).removeClass(anim + " animated");
							}
						);
				});
			};
			animated();
			// Make animated when slide change
			init.on("slideChange", function () {
				$(sliderActive1 + " [data-animation]").removeClass("animated");
			});
			init.on("slideChange", animated);
		}

		animated_swiper(sliderActive1, sliderInit1);
	}


	// Masonary Js
	$(".package__slider").owlCarousel({
		//add owl carousel in activation class
		loop: true,
		margin: 30,
		items: 4,
		navText: ['<button class="nav-left"><i class="far fa-angle-left"></i></button>', '<button class="nav-right"><i class="far fa-angle-right"></i></button>'],
		nav: false,
		dots: true,
		responsive: {
			0: {
				items: 1
			},
			767: {
				items: 2
			},
			992: {
				items: 3
			},
			1200: {
				items: 4
			}
		}
	});


	////////////////////////////////////////////////////
	// Masonary Js
	$('.grid').imagesLoaded(function () {
		// init Isotope
		var $grid = $('.grid').isotope({
			itemSelector: '.grid-item',
			percentPosition: true,
			masonry: {
				// use outer width of grid-sizer for columnWidth
				columnWidth: '.grid-item',
			}
		});


		// filter items on button click
		$('.masonary-menu').on('click', 'button', function () {
			var filterValue = $(this).attr('data-filter');
			$grid.isotope({ filter: filterValue });
		});

		//for menu active class
		$('.masonary-menu button').on('click', function (event) {
			$(this).siblings('.active').removeClass('active');
			$(this).addClass('active');
			event.preventDefault();
		});

	});

	/* magnificPopup img view */
	$('.popup-image').magnificPopup({
		type: 'image',
		gallery: {
			enabled: true
		}
	});

	/* magnificPopup video view */
	$(".popup-video").magnificPopup({
		type: "iframe",
	});


	//  Wow Js
	new WOW().init();




	//  Show Login Toggle Js
	$('#showlogin').on('click', function () {
		$('#checkout-login').slideToggle(900);
	});

	//  Show Coupon Toggle Js
	$('#showcoupon').on('click', function () {
		$('#checkout_coupon').slideToggle(900);
	});


	//  Create An Account Toggle Js
	$('#cbox').on('click', function () {
		$('#cbox_info').slideToggle(900);
	});

	//  Shipping Box Toggle Js
	$('#ship-box').on('click', function () {
		$('#ship-box-info').slideToggle(1000);
	});


	//  Counter Js
	$('.counter').counterUp({
		delay: 10,
		time: 1000
	});

	//  Parallax Js
	if ($('.scene').length > 0) {
		$('.scene').parallax({
			scalarX: 10.0,
			scalarY: 15.0,
		});
	};


	//  InHover Active Js
	$('.hover__active').on('mouseenter', function () {
		$(this).addClass('active').parent().siblings().find('.hover__active').removeClass('active');
	});


	// Product Slider Js
	var product = new Swiper('.bd-product__active', {
		slidesPerView: 4,
		spaceBetween: 30,
		loop: true,
		observer:true,
		observeParents:true,
		autoplay: {
				delay: 5000,
			},
		pagination: {
			el: ".product-pagination",
			clickable: true,
			renderBullet: function (index, className) {
			  return '<span class="' + className + '">' + '<button>'+(index + 1)+'</button>' + "</span>";
			},
		},
		navigation: {
          nextEl: ".product-button-next",
          prevEl: ".product-button-prev",
        },
		breakpoints: {
			'1400': {
				slidesPerView: 4,
			},
			'1200': {
				slidesPerView: 4,
			},
			'992': {
				slidesPerView: 4,
			},
			'768': {
				slidesPerView: 3,
			},
			'480': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	// Flash-sell Slider Js
	var flash = new Swiper('.bd-flash-active', {
		slidesPerView: 4,
		spaceBetween: 30,
		loop: true,
		observer:true,
		observeParents:true,
		autoplay: {
				delay: 3000,
			},
		navigation: {
          nextEl: ".flash-button-prev",
          prevEl: ".flash-button-next",
        },
		breakpoints: {
			'1400': {
				slidesPerView: 1,
			},
			'1200': {
				slidesPerView: 1,
			},
			'992': {
				slidesPerView: 1,
			},
			'768': {
				slidesPerView: 1,
			},
			'576': {
				slidesPerView: 1,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	// Testimonial Slider Js
	var quite = new Swiper('.bd-quite-active', {
		slidesPerView: 1,
		loop: true,
		autoplay: {
				delay: 3000,
			},
		navigation: {
          nextEl: ".flash-button-prev",
          prevEl: ".flash-button-prev",
        },
		breakpoints: {
			'1400': {
				slidesPerView: 1,
			},
			'1200': {
				slidesPerView: 1,
			},
			'992': {
				slidesPerView: 1,
			},
			'768': {
				slidesPerView: 1,
			},
			'576': {
				slidesPerView: 1,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	// Trending Slider Js
	var trending = new Swiper('.bd-trending-active', {
		slidesPerView: 4,
		spaceBetween: 30,
		loop: true,
		observer:true,
		observeParents:true,
		autoplay: {
				delay: 5000,
			},
		pagination: {
			el: ".trending-pagination",
			clickable: true,
			renderBullet: function (index, className) {
			  return '<span class="' + className + '">' + '<button>'+(index + 1)+'</button>' + "</span>";
			},
		},
		navigation: {
          nextEl: ".trending-button-next",
          prevEl: ".trending-button-prev",
        },
		breakpoints: {
			'1400': {
				slidesPerView: 4,
			},
			'1200': {
				slidesPerView: 4,
			},
			'992': {
				slidesPerView: 3,
			},
			'768': {
				slidesPerView: 2,
			},
			'480': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});
	var trending2 = new Swiper('.bd-trending-active-2', {
		slidesPerView: 4,
		spaceBetween: 30,
		loop: true,
		observer:true,
		observeParents:true,
		autoplay: {
				delay: 5000,
			},
		pagination: {
			el: ".trending-pagination",
			clickable: true,
			renderBullet: function (index, className) {
			  return '<span class="' + className + '">' + '<button>'+(index + 1)+'</button>' + "</span>";
			},
		},
		navigation: {
          nextEl: ".trending-button-next",
          prevEl: ".trending-button-prev",
        },
		breakpoints: {
			'1400': {
				slidesPerView: 5,
			},
			'1200': {
				slidesPerView: 4,
			},
			'992': {
				slidesPerView: 3,
			},
			'768': {
				slidesPerView: 3,
			},
			'480': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});
	var trending3 = new Swiper('.bd-trending-active-3', {
		slidesPerView: 4,
		spaceBetween: 30,
		loop: true,
		observer:true,
		observeParents:true,
		autoplay: {
				delay: 5000,
			},
		pagination: {
			el: ".trending-pagination",
			clickable: true,
			renderBullet: function (index, className) {
			  return '<span class="' + className + '">' + '<button>'+(index + 1)+'</button>' + "</span>";
			},
		},
		navigation: {
          nextEl: ".trending-button-next",
          prevEl: ".trending-button-prev",
        },
		breakpoints: {
			'1400': {
				slidesPerView: 4,
			},
			'1200': {
				slidesPerView: 3,
			},
			'992': {
				slidesPerView: 3,
			},
			'768': {
				slidesPerView: 2,
			},
			'480': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	// Brand Slider Js
	var brand = new Swiper('.bd-brand-active', {
		slidesPerView: 4,
		spaceBetween: 30,
		loop: true,
		autoplay: {
				delay: 3000,
			},
		navigation: {
          nextEl: ".trending-button-next",
          prevEl: ".trending-button-prev",
        },
		breakpoints: {
			'1400': {
				slidesPerView: 6,
			},
			'1200': {
				slidesPerView: 5,
			},
			'992': {
				slidesPerView: 4,
			},
			'768': {
				slidesPerView: 3,
			},
			'480': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	// Category Slider Js
	var category = new Swiper('.bd-category-active', {
		slidesPerView: 8,
		spaceBetween: 20,
		loop: true,
		autoplay: {
				delay: 3000,
			},
		navigation: {
          nextEl: ".category-button-next",
          prevEl: ".category-button-prev",
        },
		breakpoints: {
			'1400': {
				slidesPerView: 8,
			},
			'1200': {
				slidesPerView: 6,
			},
			'992': {
				slidesPerView: 5,
			},
			'768': {
				slidesPerView: 4,
			},
			'576': {
				slidesPerView: 3,
			},
			'400': {
				slidesPerView: 2,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	});

	// Testimonial Slider Js
	var testimonial = new Swiper('.bd-testimonial-active', {
		slidesPerView: 1,
		spaceBetween: 20,
		loop: true,
		autoplay: {
				delay: 3000,
			},
		navigation: {
          nextEl: ".testimonial-button-next",
          prevEl: ".testimonial-button-prev",
        },
		breakpoints: {
			'1400': {
				slidesPerView: 1,
			},
			'1200': {
				slidesPerView: 1,
			},
			'992': {
				slidesPerView: 1,
			},
			'768': {
				slidesPerView: 1,
			},
			'576': {
				slidesPerView: 1,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	})

	// Blog Slider Js
	var blog = new Swiper('.blog-img-slide', {
		slidesPerView: 1,
		spaceBetween: 50,
		loop: true,
		autoplay: {
				delay: 3000,
			},
		navigation: {
          nextEl: ".blog-button-next",
          prevEl: ".blog-button-prev",
        },
		breakpoints: {
			'1400': {
				slidesPerView: 1,
			},
			'1200': {
				slidesPerView: 1,
			},
			'992': {
				slidesPerView: 1,
			},
			'768': {
				slidesPerView: 1,
			},
			'576': {
				slidesPerView: 1,
			},
			'0': {
				slidesPerView: 1,
			},
		},
	})


	// Cart Quantity Js
	/*$(".cart-minus").click(function () {
		var $input = $(this).parent().find("input");
		var count = parseInt($input.val()) - 1;
		count = count < 1 ? 1 : count;
		$input.val(count);
		$input.change();
		return false;
	});
	$(".cart-plus").click(function () {
		var $input = $(this).parent().find("input");
		$input.val(parseInt($input.val()) + 1);
		$input.change();
		return false;
	});*/

	// Category-click
	$(".bd-category__click").click(function () {
		$(this).siblings(".category__items").slideToggle();
		$(this).toggleClass("items-open");
	});

	
    // Drop-btn
    $(".drop-btn").on("click", function () {
        $(this).siblings("").toggleClass("content-hidden");
        $(this).parent("").toggleClass("child-content-hidden");
    });
	

	// Cart count js
	var cartCountValue = 0;
	var cartCount = $('.cart-count');
	$(cartCount).text(cartCountValue);


	$('.cart-btn').on('click', function() {
		var cartBtn = this;
		var cartCountPosition = $(cartCount).offset();
		var btnPosition = $(this).offset();
		var leftPos =
		cartCountPosition.left < btnPosition.left
			? btnPosition.left - (btnPosition.left - cartCountPosition.left)
			: cartCountPosition.left;
		var topPos =
		cartCountPosition.top < btnPosition.top
			? cartCountPosition.top
			: cartCountPosition.top;
		$(cartBtn)
		.append("<span class='count'>0</span>");
		
		$(cartBtn).find(".count").each(function(i,count){
		$(count).offset({
			left: leftPos,
			top: topPos
		})
		.animate(
			{
			opacity: 0
			},
			800,
			function() {
			$(this).remove();
			cartCountValue++;
			$(cartCount).text(cartCountValue);
			}
		);
		}); 
	});

	function getRndInteger(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}
	$('.cart-btn').on('click', function () {
		$(".added-to-cart").slideToggle("slow").delay(1500).slideToggle("slow");
	});


	// Wishlist count js
	var wishlistCountValue = 0;
	var wishlistCount = $('.wishlist-count');
	$(wishlistCount).text(wishlistCountValue);


	$('.wishlist-btn').on('click', function() {
		var wishlistBtn = this;
		var wishlistCountPosition = $(wishlistCount).offset();
		var btnPosition = $(this).offset();
		var leftPos =
		wishlistCountPosition.left < btnPosition.left
			? btnPosition.left - (btnPosition.left - wishlistCountPosition.left)
			: wishlistCountPosition.left;
		var topPos =
		wishlistCountPosition.top < btnPosition.top
			? wishlistCountPosition.top
			: wishlistCountPosition.top;
		$(wishlistBtn)
		.append("<span class='count'>0</span>");
		
		$(wishlistBtn).find(".count").each(function(i,count){
		$(count).offset({
			left: leftPos,
			top: topPos
		})
		.animate(
			{
			opacity: 0
			},
			800,
			function() {
			$(this).remove();
			wishlistCountValue++;
			$(wishlistCount).text(wishlistCountValue);
			}
		);
		}); 
	});

	function getRndInteger(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}
	$('.wishlist-btn').on('click', function () {
		$(".added-to-wishlist").slideToggle("slow").delay(1500).slideToggle("slow");
	});

	// Product Slider Js
	var swiper = new Swiper(".product-details-nav", {
		loop: true,
		spaceBetween: 10,
		slidesPerView: 5,
		freeMode: true,
		watchSlidesProgress: true,
		allowTouchMove: true,
		allowSlideNext: true,
		allowSlidePrev: true,
		observer:true,
		observeParents:true,
		freeMode: true,
		watchSlidesVisibility: true,
		watchSlidesProgress: true,
		});
		var swiper2 = new Swiper(".product-details-active", {
		loop: true,
		spaceBetween: 10,
		allowTouchMove: true,
		allowSlideNext: true,
		allowSlidePrev: true,
		observer:true,
		observeParents:true,
		freeMode: true,
		watchSlidesVisibility: true,
		watchSlidesProgress: true,
		navigation: {
			nextEl: ".product-details__button-next",
			prevEl: ".product-details__button-prev",
		},
		thumbs: {
			swiper: swiper,
		},
	});
	

	//Range slider js
	$(".slider-range-bar").slider({
		range: true,

		min: 0,

		max: 500,

		values: [0, 300],

		slide: function (event, ui) {
			$(".amount").val("£+" + ui.values[0] + " - £" + ui.values[1]);
		},
	})

	// Countdown js
	$("[data-countdown]").each(function () {
		var $this = $(this),
			finalDate = $(this).data("countdown");
		$this.countdown(finalDate, function (event) {
			$this.html(
				event.strftime(
					'<div class="count_down">%D<span>days</span></div>:<div class="count_down"> %H<span>hours</span></div>:<div class="count_down"> %M<span>minutes</span></div>:<div class="count_down"> %S<span>seconds</span></div>'
				)
			);
		});
	});



})(jQuery);