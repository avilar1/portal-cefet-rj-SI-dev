/**
 * Álbum da galeria — escolher fotos na biblioteca de mídia, reordenar e remover.
 */
(function ($) {
	'use strict';

	var $list = $('#portal_album_fotos_list');
	if (!$list.length || typeof wp === 'undefined' || !wp.media) {
		return;
	}

	var $input = $('#portal_album_fotos');
	var $count = $('#portal_album_fotos_count');
	var frame = null;

	function ids() {
		return $list.children('.portal-album-admin-photo').map(function () {
			return parseInt($(this).attr('data-id'), 10);
		}).get();
	}

	function sync() {
		var current = ids();
		$input.val(current.join(','));
		if (!current.length) {
			$count.text('Nenhuma foto adicionada.');
		} else {
			$count.text(current.length + (current.length === 1 ? ' foto' : ' fotos'));
		}
	}

	function item(id, src, label) {
		var $li = $('<li class="portal-album-admin-photo"></li>').attr('data-id', id);
		$('<img alt="" />').attr('src', src).appendTo($li);
		$('<button type="button" class="portal-album-admin-photo__remove">&times;</button>')
			.attr('aria-label', 'Remover foto: ' + label)
			.appendTo($li);
		return $li;
	}

	$list.sortable({
		items: '> .portal-album-admin-photo',
		tolerance: 'pointer',
		update: sync
	});

	$('#portal_album_fotos_add').on('click', function (event) {
		event.preventDefault();
		if (!frame) {
			frame = wp.media({
				title: 'Adicionar fotos ao álbum',
				button: { text: 'Adicionar ao álbum' },
				library: { type: 'image' },
				multiple: 'add'
			});
			frame.on('open', function () {
				frame.state().get('selection').reset();
			});
			frame.on('select', function () {
				var existing = ids();
				frame.state().get('selection').each(function (attachment) {
					var data = attachment.toJSON();
					if (existing.indexOf(data.id) !== -1) {
						return;
					}
					var src = data.sizes && data.sizes.thumbnail ? data.sizes.thumbnail.url : data.url;
					$list.append(item(data.id, src, data.title || ''));
					existing.push(data.id);
				});
				sync();
			});
		}
		frame.open();
	});

	$list.on('click', '.portal-album-admin-photo__remove', function () {
		$(this).closest('.portal-album-admin-photo').remove();
		sync();
	});
})(jQuery);
