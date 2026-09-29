/**
 * Fluxo de disciplinas — seleção, cadeia de pré-requisitos e setas (RF26).
 */
(function () {
	'use strict';

	var root = document.querySelector('[data-fluxo]');
	if (!root) {
		return;
	}

	var board = root.querySelector('[data-fluxo-board]');
	var svg = root.querySelector('[data-fluxo-lines]');
	var panel = root.querySelector('[data-fluxo-panel]');
	var clearBtn = root.querySelector('[data-fluxo-clear]');
	var gradeUrl = root.getAttribute('data-fluxo-grade-url') || '';
	var SVG_NS = 'http://www.w3.org/2000/svg';
	var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	var nodes = {};
	var order = [];
	var selected = null;

	root.querySelectorAll('[data-fluxo-code]').forEach(function (el, index) {
		var code = el.getAttribute('data-fluxo-code');
		nodes[code] = {
			code: code,
			el: el,
			index: index,
			name: el.getAttribute('data-fluxo-name') || code,
			period: parseInt(el.getAttribute('data-fluxo-period'), 10) || 0,
			pre: (el.getAttribute('data-fluxo-pre') || '').split(/\s+/).filter(Boolean),
			next: [],
			inBoard: board.contains(el)
		};
		order.push(code);
	});

	order.forEach(function (code) {
		var node = nodes[code];
		node.pre = node.pre.filter(function (pre) {
			return nodes[pre] && pre !== code;
		});
		node.pre.forEach(function (pre) {
			nodes[pre].next.push(code);
		});
	});

	function collect(code, key) {
		var seen = {};
		var stack = nodes[code][key].slice();
		while (stack.length) {
			var current = stack.pop();
			if (seen[current] || current === code) {
				continue;
			}
			seen[current] = true;
			stack = stack.concat(nodes[current][key]);
		}
		return seen;
	}

	function sortCodes(map) {
		return Object.keys(map).sort(function (a, b) {
			return nodes[a].index - nodes[b].index;
		});
	}

	function periodLabel(period) {
		return period ? period + 'º período' : 'Optativa';
	}

	/* —— Setas —— */

	function clearLines() {
		svg.querySelectorAll('path.portal-fluxo-line').forEach(function (path) {
			path.parentNode.removeChild(path);
		});
	}

	function drawLine(from, to, kind) {
		var base = board.getBoundingClientRect();
		var a = nodes[from].el.getBoundingClientRect();
		var b = nodes[to].el.getBoundingClientRect();
		var sx = a.right - base.left;
		var sy = a.top + a.height / 2 - base.top;
		var tx = b.left - base.left;
		var ty = b.top + b.height / 2 - base.top;
		var dx = Math.max(24, Math.abs(tx - sx) / 2);
		var path = document.createElementNS(SVG_NS, 'path');

		path.setAttribute('d', 'M' + sx + ' ' + sy + ' C' + (sx + dx) + ' ' + sy + ' ' + (tx - dx) + ' ' + ty + ' ' + tx + ' ' + ty);
		path.setAttribute('class', 'portal-fluxo-line portal-fluxo-line--' + kind);
		path.setAttribute('marker-end', 'url(#portal-fluxo-arrow-' + kind + ')');
		svg.appendChild(path);
	}

	function drawLines() {
		clearLines();
		if (!selected) {
			return;
		}

		svg.setAttribute('width', board.scrollWidth);
		svg.setAttribute('height', board.scrollHeight);

		var before = collect(selected, 'pre');
		var after = collect(selected, 'next');
		var beforeSet = Object.assign({}, before);
		var afterSet = Object.assign({}, after);
		beforeSet[selected] = true;
		afterSet[selected] = true;

		Object.keys(beforeSet).forEach(function (code) {
			nodes[code].pre.forEach(function (pre) {
				if (before[pre] && nodes[pre].inBoard && nodes[code].inBoard) {
					drawLine(pre, code, 'before');
				}
			});
		});

		Object.keys(after).forEach(function (code) {
			nodes[code].pre.forEach(function (pre) {
				if (afterSet[pre] && nodes[pre].inBoard && nodes[code].inBoard) {
					drawLine(pre, code, 'after');
				}
			});
		});
	}

	/* —— Painel —— */

	function el(tag, className, text) {
		var node = document.createElement(tag);
		if (className) {
			node.className = className;
		}
		if (text) {
			node.textContent = text;
		}
		return node;
	}

	function chipList(codes) {
		var list = el('ul', 'portal-fluxo-panel__chips');
		codes.forEach(function (code) {
			var item = el('li');
			var btn = el('button', 'portal-fluxo-panel__chip', nodes[code].name);
			btn.type = 'button';
			btn.setAttribute('data-fluxo-jump', code);
			btn.setAttribute('title', code + ' · ' + periodLabel(nodes[code].period));
			item.appendChild(btn);
			list.appendChild(item);
		});
		return list;
	}

	function group(title, codes, emptyText, kind) {
		var wrap = el('div', 'portal-fluxo-panel__group portal-fluxo-panel__group--' + kind);
		wrap.appendChild(el('h2', 'portal-fluxo-panel__label', title));
		if (!emptyText) {
			var details = el('details', 'portal-fluxo-panel__more');
			details.appendChild(el('summary', '', 'Mostrar ' + codes.length + (1 === codes.length ? ' disciplina' : ' disciplinas')));
			details.appendChild(chipList(codes));
			wrap.appendChild(details);
			return wrap;
		}
		if (codes.length) {
			wrap.appendChild(chipList(codes));
		} else {
			wrap.appendChild(el('p', 'portal-fluxo-panel__none', emptyText));
		}
		return wrap;
	}

	function renderPanel(code, before, after) {
		var node = nodes[code];
		var directBefore = node.pre.slice().sort(function (a, b) {
			return nodes[a].index - nodes[b].index;
		});
		var directAfter = node.next.slice().sort(function (a, b) {
			return nodes[a].index - nodes[b].index;
		});
		var allBefore = sortCodes(before);
		var allAfter = sortCodes(after);
		var indirectBefore = allBefore.filter(function (c) {
			return directBefore.indexOf(c) === -1;
		});
		var indirectAfter = allAfter.filter(function (c) {
			return directAfter.indexOf(c) === -1;
		});

		panel.innerHTML = '';

		var head = el('div', 'portal-fluxo-panel__head');
		head.appendChild(el('span', 'portal-fluxo-panel__code', node.code + ' · ' + periodLabel(node.period)));
		head.appendChild(el('p', 'portal-fluxo-panel__title', node.name));
		if (gradeUrl) {
			var link = el('a', 'portal-fluxo-panel__link', 'Ver ementa na grade');
			link.href = gradeUrl + '#disciplina-' + node.code.toLowerCase();
			head.appendChild(link);
		}
		panel.appendChild(head);

		var groups = el('div', 'portal-fluxo-panel__groups');
		groups.appendChild(group('Pré-requisitos diretos', directBefore, 'Nenhum. Pode ser cursada sem pré-requisitos.', 'before'));
		if (indirectBefore.length) {
			groups.appendChild(group('Também antes, pela cadeia', indirectBefore, '', 'before'));
		}
		groups.appendChild(group('Libera diretamente', directAfter, 'Nenhuma disciplina depende dela.', 'after'));
		if (indirectAfter.length) {
			groups.appendChild(group('Também libera, pela cadeia', indirectAfter, '', 'after'));
		}
		panel.appendChild(groups);
	}

	function renderEmptyPanel() {
		panel.innerHTML = '';
		panel.appendChild(el('p', 'portal-fluxo-panel__empty', 'Nenhuma disciplina selecionada. Clique ou toque em uma disciplina do fluxo.'));
	}

	/* —— Estado —— */

	function updateUrl(code) {
		if (!window.history || !window.history.replaceState || !window.URL) {
			return;
		}
		var url = new URL(window.location.href);
		if (code) {
			url.searchParams.set('disciplina', code);
		} else {
			url.searchParams.delete('disciplina');
		}
		window.history.replaceState(null, '', url.toString());
	}

	function clear() {
		selected = null;
		root.classList.remove('has-selection');
		order.forEach(function (code) {
			var node = nodes[code];
			node.el.classList.remove('is-selected', 'is-before', 'is-after', 'is-direct', 'is-dimmed');
			node.el.setAttribute('aria-pressed', 'false');
		});
		clearBtn.hidden = true;
		clearLines();
		renderEmptyPanel();
		updateUrl(null);
	}

	function select(code) {
		if (!nodes[code]) {
			return;
		}
		if (selected === code) {
			clear();
			return;
		}

		selected = code;
		var node = nodes[code];
		var before = collect(code, 'pre');
		var after = collect(code, 'next');

		root.classList.add('has-selection');
		order.forEach(function (c) {
			var item = nodes[c];
			var cls = item.el.classList;
			cls.remove('is-selected', 'is-before', 'is-after', 'is-direct', 'is-dimmed');
			item.el.setAttribute('aria-pressed', c === code ? 'true' : 'false');

			if (c === code) {
				cls.add('is-selected');
			} else if (before[c]) {
				cls.add('is-before');
				if (node.pre.indexOf(c) !== -1) {
					cls.add('is-direct');
				}
			} else if (after[c]) {
				cls.add('is-after');
				if (node.next.indexOf(c) !== -1) {
					cls.add('is-direct');
				}
			} else {
				cls.add('is-dimmed');
			}
		});

		clearBtn.hidden = false;
		renderPanel(code, before, after);
		drawLines();
		updateUrl(code);
	}

	function panelOffscreen() {
		var rect = panel.getBoundingClientRect();
		return rect.top < 0 || rect.top > window.innerHeight * 0.6;
	}

	root.addEventListener('click', function (event) {
		var jump = event.target.closest('[data-fluxo-jump]');
		if (jump) {
			var target = nodes[jump.getAttribute('data-fluxo-jump')];
			select(target.code);
			return;
		}

		var card = event.target.closest('[data-fluxo-code]');
		if (card) {
			select(card.getAttribute('data-fluxo-code'));
			if (!board.contains(card) && selected && panelOffscreen()) {
				panel.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
			}
			return;
		}

		if (event.target.closest('[data-fluxo-clear]')) {
			clear();
		}
	});

	document.addEventListener('keydown', function (event) {
		if ('Escape' === event.key && selected) {
			clear();
		}
	});

	if (window.ResizeObserver) {
		new ResizeObserver(drawLines).observe(board);
	} else {
		window.addEventListener('resize', drawLines);
	}

	if (window.URL) {
		var initial = new URL(window.location.href).searchParams.get('disciplina');
		if (initial && nodes[initial.toUpperCase()]) {
			select(initial.toUpperCase());
		}
	}
})();
