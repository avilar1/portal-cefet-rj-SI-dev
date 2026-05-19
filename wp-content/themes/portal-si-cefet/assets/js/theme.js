/**
 * Interações do header portal (menu mobile, busca, contraste, cookies).
 */
(function () {
	'use strict';

	var i18n = window.portalSiA11y || {};
	var CONTRAST_KEY = 'portal-high-contrast';

	function setExpanded(button, expanded) {
		if (button) {
			button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
		}
	}

	function setSrLabel(button, text) {
		if (!button) {
			return;
		}
		var label = button.querySelector('.screen-reader-text');
		if (label) {
			label.textContent = text;
		}
	}

	function isContrastOn() {
		return document.body.classList.contains('portal-high-contrast');
	}

	function setContrast(on) {
		document.body.classList.toggle('portal-high-contrast', on);
		try {
			window.localStorage.setItem(CONTRAST_KEY, on ? '1' : '0');
		} catch (e) {
			/* localStorage indisponível */
		}
		document.querySelectorAll('[data-portal-contrast-toggle]').forEach(function (btn) {
			btn.setAttribute('aria-pressed', on ? 'true' : 'false');
			btn.textContent = on ? i18n.contrastOn || 'Desativar alto contraste' : i18n.contrastOff || 'Alto contraste';
		});
	}

	function initContrast() {
		var on = isContrastOn();
		document.querySelectorAll('[data-portal-contrast-toggle]').forEach(function (btn) {
			btn.setAttribute('aria-pressed', on ? 'true' : 'false');
			if (on) {
				btn.textContent = i18n.contrastOn || 'Desativar alto contraste';
			}
		});
	}

	document.querySelectorAll('[data-portal-contrast-toggle]').forEach(function (btn) {
		btn.addEventListener('click', function () {
			setContrast(!isContrastOn());
		});
	});

	initContrast();

	var menuToggle = document.querySelector('[data-portal-menu-toggle]');
	var menuWrap = document.getElementById('portal-primary-menu');

	function closeMenu() {
		if (menuWrap && menuWrap.classList.contains('is-open')) {
			menuWrap.classList.remove('is-open');
			setExpanded(menuToggle, false);
			setSrLabel(menuToggle, i18n.menuOpen || 'Abrir menu');
		}
	}

	if (menuToggle && menuWrap) {
		menuToggle.addEventListener('click', function () {
			var open = menuWrap.classList.toggle('is-open');
			setExpanded(menuToggle, open);
			setSrLabel(menuToggle, open ? i18n.menuClose || 'Fechar menu' : i18n.menuOpen || 'Abrir menu');
		});
	}

	var searchToggle = document.querySelector('[data-portal-search-toggle]');
	var searchPanel = document.getElementById('portal-header-search');

	function closeSearch() {
		if (searchPanel && !searchPanel.hasAttribute('hidden')) {
			searchPanel.setAttribute('hidden', '');
			setExpanded(searchToggle, false);
			setSrLabel(searchToggle, i18n.searchOpen || 'Abrir busca');
		}
	}

	if (searchToggle && searchPanel) {
		searchToggle.addEventListener('click', function () {
			var open = !searchPanel.hasAttribute('hidden');
			if (open) {
				closeSearch();
			} else {
				searchPanel.removeAttribute('hidden');
				setExpanded(searchToggle, true);
				setSrLabel(searchToggle, i18n.searchClose || 'Fechar busca');
				var input = searchPanel.querySelector('input[type="search"]');
				if (input) {
					input.focus();
				}
			}
		});
	}

	document.addEventListener('keydown', function (event) {
		if (event.key !== 'Escape') {
			return;
		}
		closeMenu();
		closeSearch();
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
