$(document).ready(function () {
	'use strict';
	$('#nav-icon').click(function () {
		$(this).toggleClass('open');
		$("#fullmenu").slideToggle("fade", function () {

		});
	});
	
	//	Owl Carousel
	$('.testimonial').owlCarousel({
		items: 1,
		loop: true,
		margin: 10,
		autoplay: true,
		autoplayTimeout: 3000,
		autoplayHoverPause: true
	});
	//Scroll totop
		$(window).scroll(function() {
			if($(this).scrollTop() !== 0) {
				$(".scrollToTop").fadeIn();	
			} else {
				$(".scrollToTop").fadeOut();
			}
		});
		
		$(".scrollToTop").click(function() {
			$("body,html").animate({scrollTop:0},800);
		});
});
