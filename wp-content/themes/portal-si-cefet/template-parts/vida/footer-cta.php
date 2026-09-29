<?php
/**
 * CTAs — continuar explorando o curso.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="portal-vida-cta" aria-labelledby="portal-vida-cta-title">
	<h2 id="portal-vida-cta-title" class="portal-vida-cta__title"><?php esc_html_e( 'Ficou com dúvida?', 'portal-si-cefet' ); ?></h2>
	<p class="portal-vida-cta__text"><?php esc_html_e( 'A coordenação do curso pode orientar sobre bolsas e indicar o setor certo para cada caso.', 'portal-si-cefet' ); ?></p>
	<div class="portal-vida-actions">
		<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( portal_si_page_url( 'contato' ) ); ?>">
			<?php esc_html_e( 'Falar com a coordenação', 'portal-si-cefet' ); ?>
		</a>
		<a class="portal-btn portal-btn--secondary" href="<?php echo esc_url( portal_si_page_url( 'calendario-academico' ) ); ?>">
			<?php esc_html_e( 'Calendário Acadêmico', 'portal-si-cefet' ); ?>
		</a>
	</div>
</section>
