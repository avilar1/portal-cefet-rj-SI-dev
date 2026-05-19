/**
 * Interações do header portal (menu mobile, busca, contraste, cookies).
 */
(function () {
	'use strict';

	function setExpanded(button, expanded) {
		if (button) {
			button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
		}
	}

	var menuToggle = document.querySelector('[data-portal-menu-toggle]');
	var menuWrap = document.getElementById('portal-primary-menu');

	if (menuToggle && menuWrap) {
		menuToggle.addEventListener('click', function () {
			var open = menuWrap.classList.toggle('is-open');
			setExpanded(menuToggle, open);
			var label = menuToggle.querySelector('.screen-reader-text');
			if (label) {
				label.textContent = open ? 'Fechar menu' : 'Abrir menu';
			}
		});
	}

	var searchToggle = document.querySelector('[data-portal-search-toggle]');
	var searchPanel = document.getElementById('portal-header-search');

	if (searchToggle && searchPanel) {
		searchToggle.addEventListener('click', function () {
			var open = !searchPanel.hasAttribute('hidden');
			if (open) {
				searchPanel.setAttribute('hidden', '');
				setExpanded(searchToggle, false);
			} else {
				searchPanel.removeAttribute('hidden');
				setExpanded(searchToggle, true);
				var input = searchPanel.querySelector('input[type="search"]');
				if (input) {
					input.focus();
				}
			}
		});
	}

	document.querySelectorAll('[data-portal-contrast-toggle]').forEach(function (btn) {
		btn.addEventListener('click', function () {
			document.body.classList.toggle('portal-high-contrast');
		});
	});

	var cookiesBtn = document.querySelector('[data-portal-cookies-notice]');
	if (cookiesBtn) {
		cookiesBtn.addEventListener('click', function () {
			window.alert(
				'Este portal utiliza cookies essenciais para funcionamento e, futuramente, preferências conforme a LGPD. A gestão completa de consentimento será integrada na versão de produção.'
			);
		});
	}
})();
