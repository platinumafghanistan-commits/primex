/**
 * Primex main script (non-header behaviors).
 */
(function () {
	'use strict';

	window.Primex = window.Primex || {};

	function applyDarkMode(setting) {
		var html = document.documentElement;
		var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
		var shouldDark = setting === 'dark' || (setting !== 'light' && prefersDark);
		html.setAttribute('data-theme', shouldDark ? 'dark' : 'light');
	}

	applyDarkMode(window.Primex.darkMode || 'auto');

	if (window.matchMedia) {
		window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function () {
			if ((window.Primex.darkMode || 'auto') === 'auto') {
				applyDarkMode('auto');
			}
		});
	}
})();
