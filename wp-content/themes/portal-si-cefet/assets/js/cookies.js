/**
 * Consentimento de cookies — aceitar / recusar (LGPD, RNF07).
 */
(function () {
	'use strict';

	var cfg = window.portalSiCookies || {};
	var STORAGE_KEY = cfg.storageKey || 'portal-cookie-consent';
	var ACCEPTED = cfg.accepted || 'accepted';
	var REJECTED = cfg.rejected || 'rejected';

	var banner = document.getElementById('portal-cookie-banner');

	function getConsent() {
		try {
			return window.localStorage.getItem(STORAGE_KEY);
		} catch (e) {
			return null;
		}
	}

	function setConsent(value) {
		try {
			window.localStorage.setItem(STORAGE_KEY, value);
		} catch (e) {
			/* ignore */
		}
		document.dispatchEvent(
			new CustomEvent('portal-cookie-consent', {
				detail: { value: value },
			})
		);
	}

	function hideBanner() {
		if (banner) {
			banner.setAttribute('hidden', '');
		}
	}

	function showBanner() {
		if (banner) {
			banner.removeAttribute('hidden');
			var first = banner.querySelector('[data-portal-cookie-accept]');
			if (first) {
				first.focus();
			}
		}
	}

	function applyConsent(value) {
		document.body.classList.toggle('portal-cookie-accepted', value === ACCEPTED);
		document.body.classList.toggle('portal-cookie-rejected', value === REJECTED);
		hideBanner();
	}

	function accept() {
		setConsent(ACCEPTED);
		applyConsent(ACCEPTED);
	}

	function reject() {
		setConsent(REJECTED);
		applyConsent(REJECTED);
	}

	function init() {
		var stored = getConsent();
		if (stored === ACCEPTED || stored === REJECTED) {
			applyConsent(stored);
			return;
		}
		showBanner();
	}

	if (banner) {
		var acceptBtn = banner.querySelector('[data-portal-cookie-accept]');
		var rejectBtn = banner.querySelector('[data-portal-cookie-reject]');
		if (acceptBtn) {
			acceptBtn.addEventListener('click', accept);
		}
		if (rejectBtn) {
			rejectBtn.addEventListener('click', reject);
		}
	}

	document.querySelectorAll('[data-portal-cookie-preferences]').forEach(function (btn) {
		btn.addEventListener('click', function () {
			showBanner();
		});
	});

	init();
})();
