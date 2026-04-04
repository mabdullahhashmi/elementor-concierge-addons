/**
 * Concierge Golf Elementor Addons - Frontend JavaScript
 */

(function($) {
	'use strict';
	var observerRegistry = {};

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

	function setActiveLink($nav, sectionId) {
		var $links = $nav.find('a');

		$links.each(function() {
			var linkId = normalizeId($(this).attr('data-section')) || normalizeId($(this).attr('href'));
			$(this).toggleClass('is-active', !!sectionId && linkId === sectionId);
		});
	}

	function getSections($nav) {
		var sections = [];

		$nav.find('a').each(function() {
			var targetId = normalizeId($(this).attr('data-section')) || normalizeId($(this).attr('href'));

			if (!targetId) {
				return;
			}

			var sectionEl = document.getElementById(targetId);

			if (sectionEl) {
				sections.push({
					id: targetId,
					el: sectionEl
				});
			}
		});

		return sections;
	}

	function updateActiveByScrollFallback($nav, scrollOffset) {
		var sections = getSections($nav);

		if (!sections.length) {
			setActiveLink($nav, '');
			return;
		}

		var viewportLine = window.pageYOffset + scrollOffset;
		var activeId = sections[0].id;

		for (var i = 0; i < sections.length; i++) {
			var top = $(sections[i].el).offset().top;

			if (viewportLine >= top) {
				activeId = sections[i].id;
			} else {
				break;
			}
		}

		setActiveLink($nav, activeId);
	}

	function setupIntersectionObserver($nav, navId, scrollOffset) {
		if (!('IntersectionObserver' in window)) {
			return false;
		}

		var sections = getSections($nav);

		if (!sections.length) {
			return false;
		}

		if (observerRegistry[navId]) {
			observerRegistry[navId].disconnect();
			delete observerRegistry[navId];
		}

		var currentActive = '';
		var observer = new IntersectionObserver(function(entries) {
			entries.forEach(function(entry) {
				if (entry.isIntersecting) {
					currentActive = entry.target.id;
					setActiveLink($nav, currentActive);
				}
			});
		}, {
			root: null,
			rootMargin: '-' + scrollOffset + 'px 0px -55% 0px',
			threshold: [0, 0.1, 0.25, 0.5, 1]
		});

		sections.forEach(function(section) {
			observer.observe(section.el);
		});

		observerRegistry[navId] = observer;
		return true;
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

			$(window).off('scroll' + scrollNamespace);

			var hasObserver = setupIntersectionObserver($nav, navId, scrollOffset);

			if (!hasObserver) {
				$(window).on('scroll' + scrollNamespace, function() {
					updateActiveByScrollFallback($nav, scrollOffset);
				});
			}

			updateActiveByScrollFallback($nav, scrollOffset);

			// Handle link clicks
			$nav.find('a').off('click' + scrollNamespace).on('click' + scrollNamespace, function(e) {
				e.preventDefault();

				var targetId = normalizeId($(this).attr('data-section'));

				if (!targetId) {
					targetId = normalizeId($(this).attr('href'));
				}

				var $target = $('#' + targetId);

				if ($target.length > 0) {
					setActiveLink($nav, targetId);

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
