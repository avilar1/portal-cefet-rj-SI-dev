/**
 * Sobre o Curso — navegação por âncoras (estado ativo no scroll).
 */
(function () {
	'use strict';

	if (!document.body.classList.contains('portal-is-sobre')) {
		return;
	}

	var links = document.querySelectorAll('[data-portal-sobre-anchor]');
	var sections = [];

	links.forEach(function (link) {
		var id = link.getAttribute('data-portal-sobre-anchor');
		var el = document.getElementById(id);
		if (el) {
			sections.push({ id: id, el: el, link: link });
		}
	});

	if (!sections.length) {
		return;
	}

	function setActive(id) {
		links.forEach(function (link) {
			var active = link.getAttribute('data-portal-sobre-anchor') === id;
			link.classList.toggle('is-active', active);
			if (active) {
				link.setAttribute('aria-current', 'true');
			} else {
				link.removeAttribute('aria-current');
			}
		});
	}

	function onScroll() {
		var offset = 120;
		var current = sections[0].id;
		sections.forEach(function (item) {
			var top = item.el.getBoundingClientRect().top;
			if (top - offset <= 0) {
				current = item.id;
			}
		});
		setActive(current);
	}

	window.addEventListener('scroll', onScroll, { passive: true });
	onScroll();
})();
