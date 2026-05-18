<?php
/**
 * Zona 4 — Hero / chamada principal (RF01).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_bg = get_template_directory_uri() . '/assets/images/mariadagraca.jpg';
?>
<section class="portal-hero" aria-labelledby="portal-hero-title">
	<div
		class="portal-hero__media"
		role="img"
		aria-label="<?php esc_attr_e( 'Campus Maria da Graça do CEFET/RJ', 'portal-si-cefet' ); ?>"
		style="background-image: url('<?php echo esc_url( $hero_bg ); ?>');"
	></div>
	<div class="portal-hero__overlay" aria-hidden="true"></div>
	<div class="portal-hero__content">
		<h1 id="portal-hero-title" class="portal-hero__title">
			<?php esc_html_e( 'Sistemas de Informação', 'portal-si-cefet' ); ?>
		</h1>
		<p class="portal-hero__campus">
			<?php esc_html_e( 'CEFET/RJ — Campus Maria da Graça', 'portal-si-cefet' ); ?>
		</p>
		<p class="portal-hero__description">
			<?php esc_html_e( 'Forme-se em uma das instituições mais prestigiadas do Rio de Janeiro. Graduação gratuita e de qualidade com alto índice de empregabilidade.', 'portal-si-cefet' ); ?>
		</p>
		<div class="portal-hero__actions">
			<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( portal_si_page_url( 'ingresso' ) ); ?>">
				<?php esc_html_e( 'Como Ingressar', 'portal-si-cefet' ); ?>
			</a>
			<a class="portal-btn portal-btn--secondary" href="<?php echo esc_url( portal_si_page_url( 'grade-curricular' ) ); ?>">
				<?php esc_html_e( 'Grade Curricular', 'portal-si-cefet' ); ?>
			</a>
		</div>
	</div>
</section>
