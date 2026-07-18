/**
 * Primex header behavior: sticky, smart scroll, mobile menu, dropdowns.
 */
(function () {
	'use strict';

	window.Primex = window.Primex || {};

	var TOGGLE_TARGETS = {
		'mobile-menu': 'primex-mobile-menu',
		'search': 'primex-search-panel'
	};

	var focusState = { saved: null, handler: null };
	var lastScrollY = 0;
	var ticking = false;

	function getConfig() {
		return window.Primex.header || {};
	}

	function getFocusables(scope) {
		return Array.prototype.slice.call(
			scope.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])')
		).filter(function (el) {
			return el.offsetParent !== null || el === document.activeElement;
		});
	}

	function trapFocus(container) {
		focusState.saved = document.activeElement;
		var focusables = getFocusables(container);
		if (focusables.length) {
			focusables[0].focus();
		}

		focusState.handler = function (event) {
			if (event.key !== 'Tab') {
				return;
			}
			var list = getFocusables(container);
			if (!list.length) {
				return;
			}
			var first = list[0];
			var last = list[list.length - 1];
			if (event.shiftKey && document.activeElement === first) {
				event.preventDefault();
				last.focus();
			} else if (!event.shiftKey && document.activeElement === last) {
				event.preventDefault();
				first.focus();
			}
		};

		container.addEventListener('keydown', focusState.handler);
	}

	function releaseFocus() {
		if (focusState.saved && typeof focusState.saved.focus === 'function') {
			focusState.saved.focus();
		}
		focusState.saved = null;
		focusState.handler = null;
	}

	function openTarget(id, toggle) {
		var target = document.getElementById(id);
		if (!target) {
			return;
		}
		target.hidden = false;
		if (toggle) {
			toggle.setAttribute('aria-expanded', 'true');
		}
		if (id === 'primex-mobile-menu') {
			document.body.classList.add('primex-no-scroll');
			trapFocus(target);
		}
	}

	function closeTarget(id, toggle) {
		var target = document.getElementById(id);
		if (!target) {
			return;
		}
		target.hidden = true;
		if (toggle) {
			toggle.setAttribute('aria-expanded', 'false');
		}
		if (id === 'primex-mobile-menu') {
			document.body.classList.remove('primex-no-scroll');
			releaseFocus();
		}
	}

	function initToggles() {
		document.querySelectorAll('[data-primex-toggle]').forEach(function (toggle) {
			toggle.addEventListener('click', function (event) {
				event.preventDefault();
				var key = toggle.getAttribute('data-primex-toggle');
				var targetId = TOGGLE_TARGETS[key];
				if (!targetId) {
					return;
				}
				var expanded = toggle.getAttribute('aria-expanded') === 'true';
				if (expanded) {
					closeTarget(targetId, toggle);
				} else {
					Object.keys(TOGGLE_TARGETS).forEach(function (otherKey) {
						if (otherKey !== key) {
							var otherToggle = document.querySelector('[data-primex-toggle="' + otherKey + '"]');
							closeTarget(TOGGLE_TARGETS[otherKey], otherToggle);
						}
					});
					openTarget(targetId, toggle);
				}
			});
		});

		document.querySelectorAll('[data-primex-close]').forEach(function (closer) {
			closer.addEventListener('click', function () {
				var key = closer.getAttribute('data-primex-close');
				var targetId = TOGGLE_TARGETS[key];
				var toggle = document.querySelector('[data-primex-toggle="' + key + '"]');
				closeTarget(targetId, toggle);
			});
		});
	}

	function initEscape() {
		document.addEventListener('keydown', function (event) {
			if (event.key !== 'Escape') {
				return;
			}
			Object.keys(TOGGLE_TARGETS).forEach(function (key) {
				var toggle = document.querySelector('[data-primex-toggle="' + key + '"][aria-expanded="true"]');
				if (toggle) {
					closeTarget(TOGGLE_TARGETS[key], toggle);
				}
			});
		});
	}

	function initDropdowns() {
		document.querySelectorAll('.primex-menu__toggle').forEach(function (btn) {
			btn.addEventListener('click', function (event) {
				event.preventDefault();
				event.stopPropagation();
				var expanded = btn.getAttribute('aria-expanded') === 'true';
				btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
				var li = btn.closest('li');
				if (li) {
					li.classList.toggle('is-expanded', !expanded);
					var link = li.querySelector(':scope > a');
					if (link) {
						link.setAttribute('aria-expanded', expanded ? 'false' : 'true');
					}
				}
			});
		});

		document.addEventListener('click', function (event) {
			if (!event.target.closest('.primex-menu')) {
				document.querySelectorAll('.primex-menu li.is-expanded').forEach(function (li) {
					li.classList.remove('is-expanded');
					var t = li.querySelector('.primex-menu__toggle');
					if (t) {
						t.setAttribute('aria-expanded', 'false');
					}
					var link = li.querySelector(':scope > a');
					if (link) {
						link.setAttribute('aria-expanded', 'false');
					}
				});
			}
		});
	}

	function updateStickyHeader() {
		var header = document.querySelector('[data-primex-header]');
		if (!header) {
			return;
		}

		var cfg = getConfig();
		var stickyEnabled = header.getAttribute('data-primex-sticky') === 'true';
		var hideDown = header.getAttribute('data-primex-hide-down') === 'true' || cfg.hideDown;
		var revealUp = header.getAttribute('data-primex-reveal-up') === 'true' || cfg.revealUp;
		var shrink = header.getAttribute('data-primex-shrink') === 'true' || cfg.shrink;
		var offset = parseInt(header.getAttribute('data-primex-sticky-offset') || cfg.offset || 20, 10);
		var isTransparent = header.classList.contains('primex-header--transparent');
		var scrollY = window.scrollY || window.pageYOffset;
		var scrollingDown = scrollY > lastScrollY;
		var stuck = scrollY > offset;

		header.classList.toggle('is-stuck', stuck && (stickyEnabled || isTransparent));
		header.classList.toggle('is-shrunk', stuck && shrink);
		header.classList.toggle('is-hidden', stuck && hideDown && scrollingDown && !revealUp);

		if (stuck && hideDown && revealUp) {
			header.classList.toggle('is-hidden', scrollingDown);
		}

		lastScrollY = scrollY <= 0 ? 0 : scrollY;
		ticking = false;
	}

	function initStickyHeader() {
		var header = document.querySelector('[data-primex-header]');
		if (!header) {
			return;
		}

		lastScrollY = window.scrollY || 0;
		updateStickyHeader();

		window.addEventListener('scroll', function () {
			if (!ticking) {
				window.requestAnimationFrame(updateStickyHeader);
				ticking = true;
			}
		}, { passive: true });

		window.addEventListener('resize', updateStickyHeader, { passive: true });
	}

	document.addEventListener('DOMContentLoaded', function () {
		initStickyHeader();
		initToggles();
		initEscape();
		initDropdowns();
	});
})();
