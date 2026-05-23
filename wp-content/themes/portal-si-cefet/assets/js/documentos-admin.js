/**
 * Meta box — publicações do curso (biblioteca de media).
 */
(function ($) {
	'use strict';

	var rowIndex = $('#portal_si_doc_rows .portal-documentos-admin-row').length;

	function reindexRows() {
		$('#portal_si_doc_rows .portal-documentos-admin-row').each(function (i) {
			var $row = $(this);
			$row.attr('data-row-index', i);
			$row.find('legend').contents().filter(function () {
				return this.nodeType === 3;
			}).first().replaceWith('Publicação ' + (i + 1) + ' ');

			$row.find('[name^="portal_si_documentos_upload"]').each(function () {
				var name = $(this).attr('name');
				if (!name) {
					return;
				}
				$(this).attr(
					'name',
					name.replace(/portal_si_documentos_upload\[[^\]]+\]/, 'portal_si_documentos_upload[' + i + ']')
				);
			});
		});
		rowIndex = $('#portal_si_doc_rows .portal-documentos-admin-row').length;
	}

	$('#portal_si_doc_add_row').on('click', function () {
		var tpl = $('#portal_si_doc_row_template').html();
		if (!tpl) {
			return;
		}
		var html = tpl.replace(/__INDEX__/g, String(rowIndex));
		$('#portal_si_doc_rows').append(html);
		rowIndex += 1;
		reindexRows();
	});

	$('#portal_si_doc_rows').on('click', '.portal-documentos-admin-remove', function () {
		var $rows = $('#portal_si_doc_rows .portal-documentos-admin-row');
		if ($rows.length <= 1) {
			$rows.find('input[type="text"], input[type="url"], input[type="date"], input[type="hidden"], textarea').val('');
			$rows.find('select').prop('selectedIndex', 0);
			$rows.find('.portal-doc-file-name').text('Nenhum ficheiro selecionado');
			return;
		}
		$(this).closest('.portal-documentos-admin-row').remove();
		reindexRows();
	});

	$('#portal_si_doc_rows').on('click', '.portal-doc-pick', function (e) {
		e.preventDefault();
		var $row = $(this).closest('.portal-documentos-admin-row');
		var $id = $row.find('.portal-doc-attachment-id');
		var $name = $row.find('.portal-doc-file-name');

		var frame = wp.media({
			title: 'Selecionar arquivo',
			button: { text: 'Usar este arquivo' },
			multiple: false
		});

		frame.on('select', function () {
			var attachment = frame.state().get('selection').first().toJSON();
			$id.val(attachment.id);
			$name.text(attachment.filename || attachment.title || '');
		});

		frame.open();
	});

	$('#portal_si_doc_rows').on('click', '.portal-doc-clear', function (e) {
		e.preventDefault();
		var $row = $(this).closest('.portal-documentos-admin-row');
		$row.find('.portal-doc-attachment-id').val('');
		$row.find('.portal-doc-file-name').text('Nenhum ficheiro selecionado');
	});
})(jQuery);
