var filters = '';
var $isot = $('.pr-list');
$(function () {
	
	$isot.isotope({
		itemSelector: '.project-box',
		layoutMode: 'fitRows'
	});

	$('.filter').on('click', function (e) {
		e.preventDefault();
		filters = '';
		$(this).toggleClass('current');

		if ($(this).hasClass('filter2')) {
			$('.filter2').removeClass('current');
			$(this).addClass('current');
		}

		$('.filter.current').each(function () {
			filters = filters + '.fl-' + $(this).data('filter');
		});
		$isot.isotope({filter: filters});
		
		if ($(window).width() < 642) {
			$.scrollTo($('.project-list'),500);
		}

		return false;
	});
	
	if ($('.page-template-page-projects').length > 0) {
		$('.filter.current').each(function () {
			filters = filters + '.fl-' + $(this).data('filter');
		});
		$isot.isotope({filter: filters});
	}

	if ($(window).scrollTop() > 10) {
		$('header').addClass('scrolled');
	}
	else {
		$('header').removeClass('scrolled');
	}

	$('.open-contact').on('click', function () {
		$('#stanowisko').val($(this).data('job'));
	});


	$('.send-form').on('click', function (e) {

		var wrong = 0;

		$('.required').each(function () {
			if ($(this).val() === '') {
				$(this).addClass('er');
				wrong = 1;
			}
		});

		if (wrong !== 1) {
			$(this).hide();
		}
		else {
			e.preventDefault();
			return false;
		}

	});



	$('.hamburger').on('click', function() {
		if ( $(this).hasClass('open') ) {
			$(this).removeClass('open');
			$('.mobile-overlay').removeClass('open');
		}
		else {
			$(this).addClass('open');
			$('.mobile-overlay').addClass('open');
		}
	});
	
	$('.show-filters').on('click', function() {
		if ($('.filters').hasClass('opened')) {
			$('.filters').removeClass('opened');
			curtxt = $('.show-filters').html();
			$('.show-filters').html($(this).data('sectxt'));
			$(this).data('sectxt',curtxt);
		}
		else {
			$('.filters').addClass('opened');
			curtxt = $('.show-filters').html();
			$('.show-filters').html($(this).data('sectxt'));
			$(this).data('sectxt',curtxt);
		}
	});

});

$(window).on('load', function () {

});

$(window).on('scroll', function () {

	if ($(window).scrollTop() > 10) {
		$('header').addClass('scrolled');
	}
	else {
		$('header').removeClass('scrolled');
	}

});