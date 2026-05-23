<?php
/**
 * Parcerias Fábrica — âncora #parceria-fabrica (RF16 futuro).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block = portal_si_contato_fabrica_block();
if ( empty( $block['title'] ) ) {
	return;
}

$anchor = ! empty( $block['anchor'] ) ? sanitize_title( (string) $block['anchor'] ) : 'parceria-fabrica';
$slug   = ! empty( $block['fabrica_slug'] ) ? (string) $block['fabrica_slug'] : 'fabrica-de-software';
$fabrica_url = portal_si_page_url( $slug );

$email = function_exists( 'portal_si_fabrica_partner_email' ) ? portal_si_fabrica_partner_email() : '';
?>
<section class="portal-contato-fabrica" id="<?php echo esc_attr( $anchor ); ?>" aria-labelledby="portal-contato-fabrica-title">
	<div class="portal-contato-fabrica__inner">
		<h2 id="portal-contato-fabrica-title" class="portal-contato-fabrica__title"><?php echo esc_html( (string) $block['title'] ); ?></h2>
		<?php if ( ! empty( $block['text'] ) ) : ?>
			<p class="portal-contato-fabrica__text"><?php echo esc_html( (string) $block['text'] ); ?></p>
		<?php endif; ?>
		<div class="portal-contato-fabrica__actions">
			<?php if ( $fabrica_url ) : ?>
				<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( $fabrica_url ); ?>">
					<?php esc_html_e( 'Sobre a Fábrica de Software', 'portal-si-cefet' ); ?>
				</a>
			<?php endif; ?>
			<?php if ( $email && is_email( $email ) ) : ?>
				<a class="portal-btn portal-btn--secondary" href="<?php echo esc_url( 'mailto:' . $email ); ?>">
					<?php esc_html_e( 'E-mail para parcerias', 'portal-si-cefet' ); ?>
				</a>
			<?php endif; ?>
		</div>
		<div class="portal-contato-fabrica__note">
			<?php
			portal_si_the_coming_soon_notice(
				array(
					'variant' => 'compact',
					'badge'   => __( 'Conteúdo em breve', 'portal-si-cefet' ),
					'message' => __( 'Formulário oficial em breve. Favor utilizar como contato o e-mail oficial da coordenação.', 'portal-si-cefet' ),
				)
			);
			?>
		</div>
	</div>
</section>
