/**
 * Galeria — ampliação de fotos em <dialog> (teclado: ← → Esc).
 * Sem JS (ou sem suporte a <dialog>), o link abre a imagem normalmente.
 */
(function () {
	'use strict';

	var list = document.querySelector('[data-galeria]');
	if (!list || typeof HTMLDialogElement !== 'function') {
		return;
	}

	var links = Array.prototype.slice.call(list.querySelectorAll('[data-galeria-item]'));
	if (!links.length) {
		return;
	}

	var dialog = document.createElement('dialog');
	dialog.className = 'portal-lightbox';
	dialog.setAttribute('aria-label', 'Visualizar foto');
	dialog.innerHTML =
		'<p class="portal-lightbox__counter" aria-live="polite"></p>' +
		'<figure class="portal-lightbox__figure">' +
		'<img class="portal-lightbox__img" alt="" />' +
		'<figcaption class="portal-lightbox__caption"></figcaption>' +
		'</figure>' +
		'<button type="button" class="portal-lightbox__btn portal-lightbox__btn--prev" aria-label="Foto anterior">&#8249;</button>' +
		'<button type="button" class="portal-lightbox__btn portal-lightbox__btn--next" aria-label="Próxima foto">&#8250;</button>' +
		'<button type="button" class="portal-lightbox__btn portal-lightbox__btn--close" aria-label="Fechar">&times;</button>';
	document.body.appendChild(dialog);

	var img = dialog.querySelector('.portal-lightbox__img');
	var caption = dialog.querySelector('.portal-lightbox__caption');
	var counter = dialog.querySelector('.portal-lightbox__counter');
	var prev = dialog.querySelector('.portal-lightbox__btn--prev');
	var next = dialog.querySelector('.portal-lightbox__btn--next');
	var close = dialog.querySelector('.portal-lightbox__btn--close');
	var current = 0;
	var opener = null;

	if (links.length < 2) {
		prev.hidden = true;
		next.hidden = true;
	}

	function show(index) {
		current = (index + links.length) % links.length;
		var link = links[current];
		var text = link.getAttribute('data-caption') || '';
		img.src = link.href;
		img.alt = link.getAttribute('data-alt') || text;
		caption.textContent = text;
		caption.hidden = !text;
		counter.textContent = 'Foto ' + (current + 1) + ' de ' + links.length;
	}

	links.forEach(function (link, index) {
		link.addEventListener('click', function (event) {
			event.preventDefault();
			opener = link;
			show(index);
			dialog.showModal();
			close.focus();
		});
	});

	prev.addEventListener('click', function () {
		show(current - 1);
	});
	next.addEventListener('click', function () {
		show(current + 1);
	});
	close.addEventListener('click', function () {
		dialog.close();
	});

	dialog.addEventListener('keydown', function (event) {
		if (event.key === 'ArrowLeft') {
			event.preventDefault();
			show(current - 1);
		} else if (event.key === 'ArrowRight') {
			event.preventDefault();
			show(current + 1);
		}
	});

	dialog.addEventListener('click', function (event) {
		if (event.target === dialog) {
			dialog.close();
		}
	});

	dialog.addEventListener('close', function () {
		img.removeAttribute('src');
		if (opener) {
			links[current].focus();
			opener = null;
		}
	});
})();
