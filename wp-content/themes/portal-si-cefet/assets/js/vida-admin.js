/**
 * Vida estudantil — cards editáveis no painel (adicionar, remover, reordenar).
 */
(function ($) {
	'use strict';

	var $rows = $('#portal_si_vida_rows');
	if (!$rows.length) {
		return;
	}

	function reindex() {
		$rows.children('.portal-vida-admin-row').each(function (i) {
			$(this).find('[name^="portal_si_vida_items"]').each(function () {
				this.name = this.name.replace(/portal_si_vida_items\[[^\]]*\]/, 'portal_si_vida_items[' + i + ']');
			});
		});
	}

	$('#portal_si_vida_add_row').on('click', function () {
		var tpl = $('#portal_si_vida_row_template').html();
		if (!tpl) {
			return;
		}
		var $row = $(tpl.replace(/__INDEX__/g, String($rows.children().length)));
		$rows.append($row);
		reindex();
		$row.find('.portal-vida-admin-title-input').trigger('focus');
	});

	$rows.on('click', '.portal-vida-admin-remove', function () {
		var $row = $(this).closest('.portal-vida-admin-row');
		var title = $row.find('.portal-vida-admin-title-input').val();
		if (title && !window.confirm('Remover o card "' + title + '"?')) {
			return;
		}
		$row.remove();
		reindex();
	});

	$rows.on('click', '.portal-vida-admin-up', function () {
		var $row = $(this).closest('.portal-vida-admin-row');
		$row.prev('.portal-vida-admin-row').before($row);
		reindex();
	});

	$rows.on('click', '.portal-vida-admin-down', function () {
		var $row = $(this).closest('.portal-vida-admin-row');
		$row.next('.portal-vida-admin-row').after($row);
		reindex();
	});

	$rows.on('input', '.portal-vida-admin-title-input', function () {
		var value = $(this).val();
		$(this).closest('.portal-vida-admin-row').find('.portal-vida-admin-row__title').text(value || 'Novo card');
	});
})(jQuery);
