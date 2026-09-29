/**
 * Grade curricular — escolher o documento do plano de transição na biblioteca de mídia.
 */
(function ($) {
	'use strict';

	var $input = $('#portal_si_grade_transicao_doc');
	if (!$input.length || typeof wp === 'undefined' || !wp.media) {
		return;
	}

	var $name = $('#portal_si_grade_transicao_doc_name');
	var frame = null;

	$('#portal_si_grade_transicao_pick').on('click', function (event) {
		event.preventDefault();
		if (!frame) {
			frame = wp.media({
				title: 'Plano de transição curricular',
				button: { text: 'Usar este arquivo' },
				multiple: false
			});
			frame.on('select', function () {
				var file = frame.state().get('selection').first().toJSON();
				$input.val(file.id);
				$name.text(file.title || file.filename || '');
			});
		}
		frame.open();
	});

	$('#portal_si_grade_transicao_clear').on('click', function () {
		$input.val('');
		$name.text('Nenhum arquivo escolhido.');
	});
})(jQuery);
