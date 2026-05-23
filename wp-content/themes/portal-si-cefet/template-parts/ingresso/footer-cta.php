<?php
/**
 * CTAs — explorar o curso.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = portal_si_ingresso_config();
$cta    = isset( $config['footer_cta'] ) && is_array( $config['footer_cta'] ) ? $config['footer_cta'] : array();
?>
<section class="portal-ingresso-cta" aria-labelledby="portal-ingresso-cta-title">
	<div class="portal-ingresso-cta__inner">
		<h2 id="portal-ingresso-cta-title" class="portal-ingresso-cta__title">
			<?php
			echo esc_html(
				isset( $cta['title'] ) ? (string) $cta['title'] : __( 'Explore o curso', 'portal-si-cefet' )
			);
			?>
		</h2>
		<?php if ( ! empty( $cta['text'] ) ) : ?>
			<p class="portal-ingresso-cta__text"><?php echo esc_html( (string) $cta['text'] ); ?></p>
		<?php endif; ?>
		<div class="portal-ingresso-cta__actions">
			<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( portal_si_page_url( 'sobre-o-curso' ) ); ?>">
				<?php esc_html_e( 'Sobre o Curso', 'portal-si-cefet' ); ?>
			</a>
			<a class="portal-btn portal-btn--secondary" href="<?php echo esc_url( portal_si_page_url( 'grade-curricular' ) ); ?>">
				<?php esc_html_e( 'Grade Curricular', 'portal-si-cefet' ); ?>
			</a>
			<a class="portal-btn portal-btn--secondary" href="<?php echo esc_url( portal_si_page_url( 'calendario-academico' ) ); ?>">
				<?php esc_html_e( 'Calendário Acadêmico', 'portal-si-cefet' ); ?>
			</a>
			<a class="portal-btn portal-btn--secondary" href="<?php echo esc_url( portal_si_page_url( 'contato' ) ); ?>">
				<?php esc_html_e( 'Contato', 'portal-si-cefet' ); ?>
			</a>
		</div>
	</div>
</section>
