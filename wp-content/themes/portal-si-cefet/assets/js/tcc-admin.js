/**
 * TCC — escolher o PDF na biblioteca de mídia.
 */
(function ($) {
	'use strict';

	var $input = $('#portal_tcc_arquivo');
	if (!$input.length || typeof wp === 'undefined' || !wp.media) {
		return;
	}

	var $name = $('#portal_tcc_arquivo_nome');
	var frame = null;

	$('#portal_tcc_arquivo_pick').on('click', function (event) {
		event.preventDefault();
		if (!frame) {
			frame = wp.media({
				title: 'PDF do TCC',
				button: { text: 'Usar este PDF' },
				library: { type: 'application/pdf' },
				multiple: false
			});
			frame.on('select', function () {
				var file = frame.state().get('selection').first().toJSON();
				if (file.mime !== 'application/pdf') {
					window.alert('Escolha um arquivo PDF.');
					return;
				}
				$input.val(file.id);
				$name.text((file.title || file.filename) + (file.filesizeHumanReadable ? ' (' + file.filesizeHumanReadable + ')' : ''));
			});
		}
		frame.open();
	});

	$('#portal_tcc_arquivo_clear').on('click', function () {
		$input.val('');
		$name.text('Nenhum arquivo.');
	});
})(jQuery);
