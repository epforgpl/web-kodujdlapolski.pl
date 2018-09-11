$(document).ready(function () {
	
	var default_filter = site_parameters.default_filter;
	
	$('[data-filter="' + default_filter + '"]').addClass('current');
	
	var filters = '.fl-' + default_filter;
	
	// quick search regex
	var qsRegex;
	var buttonFilter;
	
	var $isot = $('.pr-list').isotope({
		itemSelector: '.project-box',
		layoutMode: 'fitRows',
		filter: filters
	});

	$('.filter').on('click', function (e) {
		e.preventDefault();
		
		$(this).toggleClass('current');

		if ($(this).hasClass('filter2')) {
			$('.filter2').removeClass('current');
			$(this).addClass('current');
		}

		buttonFilter = $(this).data('filter');
		$isot.isotope({
			filter: filterWithSearch
		});
		
		if ($(window).width() < 642) {
			$.scrollTo($('.project-list'),500);
		}

		return false;
	});
	
	// use value of search field to filter
	var $quicksearch = $('.quicksearch').keyup(debounce(function() {
		
		qsRegex = new RegExp($quicksearch.val(), 'gi');
		$isot.isotope({
			filter: filterWithSearch
		});
		
	}, 500 ) );
	
	function filterWithSearch() {
		
		var inclusives = [];
		// inclusive filters from checkboxes
		$('.filter.current').each(function() {
			inclusives.push('fl-' + $(this).data('filter'));
		});
		
		var searchResult = qsRegex ? $(this).text().match(qsRegex) : true;
		var filterResult = inclusives.length == 0 ? true : false;
		
		if(inclusives.length > 0) {
			
			var filterToCheck = $(this).attr('class').split(/\s+/)
			
			$.each(inclusives, function(key, val) {
				
				tmpFilter = filterToCheck.includes(val);
				
				if(tmpFilter) {
					filterResult = true;
				} else {
					filterResult = false;
					return false;
				}
				
			});
			
		}
		return searchResult && filterResult;
	}
	
	// debounce so filtering doesn't happen every millisecond
	function debounce(fn, threshold) {
		var timeout;
		threshold = threshold || 100;
		return function debounced() {
			clearTimeout(timeout);
			var args = arguments;
			var _this = this;
			function delayed() {
				fn.apply(_this, args);
			}
			timeout = setTimeout(delayed, threshold);
		};
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


		$(this).parents('form').find('.required').each(function () {
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