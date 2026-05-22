/**
 * Meta box — PDF do calendário (biblioteca de media).
 */
(function ($) {
	'use strict';

	var frame;

	$('#portal_si_cal_pdf_pick').on('click', function (e) {
		e.preventDefault();

		if (frame) {
			frame.open();
			return;
		}

		frame = wp.media({
			title: 'Selecionar PDF do calendário',
			button: { text: 'Usar este PDF' },
			library: { type: 'application/pdf' },
			multiple: false
		});

		frame.on('select', function () {
			var attachment = frame.state().get('selection').first().toJSON();
			$('#portal_si_cal_pdf_id').val(attachment.id);
			$('#portal_si_cal_pdf_name').text(attachment.filename || attachment.title || '');
		});

		frame.open();
	});

	$('#portal_si_cal_pdf_clear').on('click', function (e) {
		e.preventDefault();
		$('#portal_si_cal_pdf_id').val('');
		$('#portal_si_cal_pdf_name').text('Nenhum ficheiro — usa o PDF padrão do tema se existir.');
	});
})(jQuery);
