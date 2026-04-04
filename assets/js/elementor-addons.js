/**
 * Concierge Golf Elementor Addons - Frontend JavaScript
 */

(function($) {
	'use strict';

	// ─── Helpers ──────────────────────────────────────────────────────

	function normalizeId(value) {
		if (!value) return '';
		return String(value).trim().replace(/^.*#/, '').replace(/^#+/, '').trim();
	}

	function scrollTop() {
		return window.pageYOffset || document.documentElement.scrollTop || 0;
	}

	// Absolute top of an element from document top (reliable during scroll)
	function absoluteTop(el) {
		return el.getBoundingClientRect().top + scrollTop();
	}

	// ─── Scroll Spy ───────────────────────────────────────────────────

	function buildEntries($nav) {
		var list = [];
		$nav.find('a').each(function() {
			var id = normalizeId($(this).attr('data-section')) || normalizeId($(this).attr('href'));
			if (!id) return;
			var el = document.getElementById(id);
			if (el) list.push({ id: id, el: el });
		});
		return list;
	}

	function pickActive(entries, offset) {
		// The active section is the one with the LARGEST absoluteTop
		// that is still <= scrollTop + offset (i.e has crossed the threshold)
		var st      = scrollTop();
		var thresh  = st + offset;
		var active  = '';
		var maxTop  = -Infinity;

		for (var i = 0; i < entries.length; i++) {
			var t = absoluteTop(entries[i].el);
			if (t <= thresh && t > maxTop) {
				maxTop = t;
				active = entries[i].id;
			}
		}

		// Nothing above threshold yet → activate whichever section is nearest
		if (!active && entries.length) {
			var minDist = Infinity;
			for (var j = 0; j < entries.length; j++) {
				var dist = Math.abs(absoluteTop(entries[j].el) - thresh);
				if (dist < minDist) {
					minDist = dist;
					active  = entries[j].id;
				}
			}
		}

		return active;
	}

	function setActive($nav, id) {
		$nav.find('a').each(function() {
			var linkId = normalizeId($(this).attr('data-section')) || normalizeId($(this).attr('href'));
			var on = !!id && linkId === id;
			$(this).toggleClass('is-active', on);
			if (on) $(this).attr('aria-current', 'true');
			else    $(this).removeAttr('aria-current');
		});
	}

	function bindScrollSpy($nav) {
		// ── Guard: only bind once per nav element ────────────────────
		if ($nav.data('cga-spy-bound')) return;
		$nav.data('cga-spy-bound', true);

		var offset = parseInt($nav.attr('data-scroll-offset'), 10);
		if (isNaN(offset) || offset < 0) offset = 150;

		var ticking = false;

		function refresh() {
			ticking = false;
			var entries = buildEntries($nav);
			if (!entries.length) return;
			setActive($nav, pickActive(entries, offset));
		}

		function onScroll() {
			if (ticking) return;
			ticking = true;
			requestAnimationFrame(refresh);
		}

		// Use native addEventListener — cannot accidentally be removed by jQuery .off()
		window.addEventListener('scroll', onScroll, { passive: true });
		window.addEventListener('resize', onScroll, { passive: true });

		// Click: smooth scroll to section
		$nav.find('a').on('click.cgaSpy', function(e) {
			e.preventDefault();
			var id = normalizeId($(this).attr('data-section')) || normalizeId($(this).attr('href'));
			var el = id ? document.getElementById(id) : null;
			if (!el) return;
			setActive($nav, id);
			var dest = absoluteTop(el) - offset;
			$('html, body').stop(true).animate({ scrollTop: dest }, 500, function() {
				// Re-check after animation in case layout shifted
				refresh();
			});
		});

		// Initial read — run now and again after layout settles
		refresh();
		setTimeout(refresh, 500);
	}

	function initScrollSpy() {
		$('.sidebar-nav[data-scroll-spy="true"]').each(function() {
			bindScrollSpy($(this));
		});
	}

	// ─── Tour Toggles ─────────────────────────────────────────────────

	function bindTourToggles($scope) {
		var $root    = $scope && $scope.length ? $scope : $(document);
		var $toggles = $root.find('.cga-tour-toggles');
		if (!$toggles.length) return;

		$toggles.each(function() {
			var $wrap = $(this);
			var id    = $wrap.attr('data-toggle-id');
			if (!id) {
				id = Math.random().toString(36).slice(2, 10);
				$wrap.attr('data-toggle-id', id);
			}
			var ns         = '.cgaT-' + id;
			var speed      = parseInt($wrap.attr('data-speed'), 10);
			var singleOpen = $wrap.attr('data-single-open') !== 'no';
			var openFirst  = $wrap.attr('data-open-first') === 'yes';
			if (isNaN(speed)) speed = 260;

			$wrap.find('.cga-toggle-item').each(function(index) {
				var $item    = $(this);
				var $content = $item.find('.cga-toggle-content').first();
				var $trigger = $item.find('.cga-toggle-trigger').first();

				if (openFirst && index === 0) {
					$item.addClass('is-open');
					$trigger.attr('aria-expanded', 'true');
					$content.show();
				} else if (!$item.hasClass('is-open')) {
					$trigger.attr('aria-expanded', 'false');
					$content.hide();
				}
			});

			$wrap.find('.cga-toggle-trigger').off('click' + ns).on('click' + ns, function() {
				var $trigger = $(this);
				var $item    = $trigger.closest('.cga-toggle-item');
				var $content = $item.find('.cga-toggle-content').first();
				var open     = !$item.hasClass('is-open');

				if (singleOpen) {
					$wrap.find('.cga-toggle-item').not($item)
						.removeClass('is-open')
						.find('.cga-toggle-trigger').attr('aria-expanded', 'false');
					$wrap.find('.cga-toggle-item').not($item)
						.find('.cga-toggle-content').stop(true, true).slideUp(speed);
				}

				$item.toggleClass('is-open', open);
				$trigger.attr('aria-expanded', open ? 'true' : 'false');
				$content.stop(true, true).slideToggle(speed);
			});
		});
	}

	// ─── Boot ─────────────────────────────────────────────────────────

	$(document).ready(function() {
		initScrollSpy();
		bindTourToggles($(document));

		// Hook Elementor widget-ready events (runs once per widget type, not globally)
		function hookElementor() {
			if (!window.elementorFrontend || !window.elementorFrontend.hooks) return;

			// sidebar-nav.default fires only when the sidebar nav widget is ready
			window.elementorFrontend.hooks.addAction(
				'frontend/element_ready/sidebar-nav.default',
				function() { initScrollSpy(); }
			);

			// tour-toggle.default fires only when a tour toggle widget is ready
			window.elementorFrontend.hooks.addAction(
				'frontend/element_ready/tour-toggle.default',
				function($scope) { bindTourToggles($scope); }
			);
		}

		if (window.elementorFrontend) {
			hookElementor();
		} else {
			$(window).one('elementor/frontend/init', hookElementor);
		}

		$(document).on('elementor/popup/show', function() {
			initScrollSpy();
			bindTourToggles($(document));
		});
	});

	// Re-measure section positions after all assets are loaded
	$(window).on('load', function() {
		$('.sidebar-nav[data-scroll-spy="true"]').each(function() {
			// Force a fresh read — don't rebind, just re-check active
			var $nav   = $(this);
			var offset = parseInt($nav.attr('data-scroll-offset'), 10);
			if (isNaN(offset) || offset < 0) offset = 150;
			var entries = buildEntries($nav);
			if (entries.length) setActive($nav, pickActive(entries, offset));
		});
	});

})(jQuery);
