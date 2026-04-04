/**
 * Concierge Golf Elementor Addons - Frontend JavaScript
 */

(function($) {
	'use strict';

	function normalizeId(value) {
		if (!value) {
			return '';
		}

		var text = String(value).trim();
		var hashIndex = text.indexOf('#');

		if (hashIndex !== -1) {
			text = text.substring(hashIndex + 1);
		}

		return text.replace(/^#+/, '').trim();
	}

	/**
	 * Scroll Spy Handler
	 */
	function initScrollSpy() {
		var $navs = $('.sidebar-nav[data-scroll-spy="true"]');

		if ($navs.length === 0) {
			return;
		}

		// Handle each sidebar nav separately
		$navs.each(function() {
			var $nav = $(this);
			var navId = $nav.attr('data-scrollspy-id');

			if (!navId) {
				navId = 'spy-' + Math.random().toString(36).slice(2, 10);
				$nav.attr('data-scrollspy-id', navId);
			}

			var scrollOffset = parseInt($nav.attr('data-scroll-offset')) || 150;
			var scrollNamespace = '.conciergeSpy-' + navId;

			// Update active link on scroll
			$(window).off('scroll' + scrollNamespace).on('scroll' + scrollNamespace, function() {
				updateActiveLink($nav, scrollOffset);
			});

			// Initial call
			updateActiveLink($nav, scrollOffset);

			// Handle link clicks
			$nav.find('a').off('click' + scrollNamespace).on('click' + scrollNamespace, function(e) {
				e.preventDefault();

				var targetId = normalizeId($(this).attr('data-section'));

				if (!targetId) {
					targetId = normalizeId($(this).attr('href'));
				}

				var $target = $('#' + targetId);

				if ($target.length > 0) {
					// Remove active class from all links
					$nav.find('a').removeClass('is-active');

					// Add active class to clicked link
					$(this).addClass('is-active');

					// Smooth scroll to target
					$('html, body').animate(
						{
							scrollTop: $target.offset().top - scrollOffset
						},
						600
					);
				}
			});
		});
	}

	/**
	 * Update active link based on scroll position
	 */
	function updateActiveLink($nav, scrollOffset) {
		var sections = {};
		var $links = $nav.find('a');

		// Build sections object
		$links.each(function() {
			var targetId = normalizeId($(this).attr('data-section'));

			if (!targetId) {
				targetId = normalizeId($(this).attr('href'));
			}

			if (targetId) {
				sections[targetId] = $('#' + targetId);
			}
		});

		// Get current scroll position
		var scrollPos = $(window).scrollTop() + scrollOffset;

		// Find which section is currently in view
		var currentSection = null;

		$.each(sections, function(targetId, $section) {
			if ($section.length > 0) {
				var sectionTop = $section.offset().top;
				var sectionBottom = sectionTop + $section.outerHeight();

				if (scrollPos >= sectionTop && scrollPos < sectionBottom) {
					currentSection = targetId;
					return false;
				}
			}
		});

		// If no section found, check which is closest
		if (!currentSection) {
			var closestDistance = Infinity;
			var closestSection = null;

			$.each(sections, function(targetId, $section) {
				if ($section.length > 0) {
					var sectionTop = $section.offset().top;
					var distance = Math.abs(sectionTop - scrollPos);

					if (distance < closestDistance) {
						closestDistance = distance;
						closestSection = targetId;
					}
				}
			});

			if (closestDistance < 500) {
				currentSection = closestSection;
			}
		}

		// Update active class
		$links.each(function() {
			var targetId = normalizeId($(this).attr('data-section'));

			if (!targetId) {
				targetId = normalizeId($(this).attr('href'));
			}

			if (targetId === currentSection) {
				$(this).addClass('is-active');
			} else {
				$(this).removeClass('is-active');
			}
		});
	}

	/**
	 * Initialize on document ready
	 */
	$(document).ready(function() {
		initScrollSpy();

		// Reinitialize on Elementor updates (for live preview)
		$(document).on('elementor/popup/show', function() {
			initScrollSpy();
		});
	});

	// Support Elementor frontend rendering hooks
	$(window).on('elementor/frontend/init', function() {
		if (window.elementorFrontend && window.elementorFrontend.hooks) {
			window.elementorFrontend.hooks.addAction('frontend/element_ready/global', function() {
				initScrollSpy();
			});
		}
	});

	// Reinitialize on window load (images might affect layout)
	$(window).on('load', function() {
		initScrollSpy();
	});

	// Reinitialize on window resize
	var resizeTimer;
	$(window).on('resize', function() {
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(function() {
			initScrollSpy();
		}, 250);
	});

})(jQuery);
