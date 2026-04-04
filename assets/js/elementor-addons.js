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

	function setActiveLink($nav, sectionId) {
		$nav.find('a').each(function() {
			var linkId = normalizeId($(this).attr('data-section')) || normalizeId($(this).attr('href'));
			var isActive = !!sectionId && linkId === sectionId;

			$(this).toggleClass('is-active', isActive);
			if (isActive) {
				$(this).attr('aria-current', 'true');
			} else {
				$(this).removeAttr('aria-current');
			}
		});
	}

	function getSectionEntries($nav) {
		var entries = [];

		$nav.find('a').each(function() {
			var targetId = normalizeId($(this).attr('data-section')) || normalizeId($(this).attr('href'));

			if (!targetId) {
				return;
			}

			var el = document.getElementById(targetId);

			if (el) {
				entries.push({
					id: targetId,
					el: el
				});
			}
		});

		return entries;
	}

	function getActiveSectionId(entries, markerY) {
		if (!entries.length) {
			return '';
		}

		var activeId = entries[0].id;

		for (var i = 0; i < entries.length; i++) {
			var top = $(entries[i].el).offset().top;

			if (markerY >= top) {
				activeId = entries[i].id;
			} else {
				break;
			}
		}

		return activeId;
	}

	function bindScrollSpy($nav) {
		var navId = $nav.attr('data-scrollspy-id');

		if (!navId) {
			navId = 'spy-' + Math.random().toString(36).slice(2, 10);
			$nav.attr('data-scrollspy-id', navId);
		}

		var scrollOffset = parseInt($nav.attr('data-scroll-offset'), 10) || 150;
		var ns = '.conciergeSpy-' + navId;
		var ticking = false;

		function refreshActive() {
			ticking = false;
			var entries = getSectionEntries($nav);
			var markerY = window.pageYOffset + scrollOffset + 1;
			setActiveLink($nav, getActiveSectionId(entries, markerY));
		}

		function requestRefresh() {
			if (ticking) {
				return;
			}

			ticking = true;
			window.requestAnimationFrame(refreshActive);
		}

		$(window).off('scroll' + ns).on('scroll' + ns, requestRefresh);
		$(window).off('resize' + ns).on('resize' + ns, requestRefresh);
		$(window).off('load' + ns).on('load' + ns, requestRefresh);

		$nav.find('a').off('click' + ns).on('click' + ns, function(e) {
			e.preventDefault();

			var targetId = normalizeId($(this).attr('data-section')) || normalizeId($(this).attr('href'));
			var $target = targetId ? $('#' + targetId) : $();

			if (!$target.length) {
				return;
			}

			setActiveLink($nav, targetId);

			$('html, body').stop(true).animate(
				{
					scrollTop: $target.offset().top - scrollOffset
				},
				500,
				requestRefresh
			);
		});

		requestRefresh();
	}

	/**
	 * Scroll Spy Handler
	 */
	function initScrollSpy() {
		var $navs = $('.sidebar-nav[data-scroll-spy="true"]');

		if ($navs.length === 0) {
			return;
		}

		$navs.each(function() {
			bindScrollSpy($(this));
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

	$(window).on('elementor/frontend/init', function() {
		if (window.elementorFrontend && window.elementorFrontend.hooks) {
			window.elementorFrontend.hooks.addAction('frontend/element_ready/global', function() {
				initScrollSpy();
			});
		}
	});

	$(window).on('load', initScrollSpy);

})(jQuery);
