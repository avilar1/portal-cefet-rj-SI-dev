<?php
/**
 * CTA — solicitar parceria (antecipa RF16).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cta = portal_si_fabrica_partner_cta();
if ( empty( $cta['title'] ) && empty( $cta['text'] ) ) {
	return;
}

$contact_url = portal_si_fabrica_partner_contact_url();
$email       = function_exists( 'portal_si_fabrica_partner_cta_email' ) ? portal_si_fabrica_partner_cta_email() : '';
?>
<section class="portal-fabrica-cta" id="solicitar-parceria" aria-labelledby="portal-fabrica-cta-title">
	<div class="portal-fabrica-cta__inner">
		<h2 id="portal-fabrica-cta-title" class="portal-fabrica-cta__title">
			<?php echo esc_html( isset( $cta['title'] ) ? (string) $cta['title'] : __( 'Quer propor um projeto?', 'portal-si-cefet' ) ); ?>
		</h2>
		<?php if ( ! empty( $cta['text'] ) ) : ?>
			<p class="portal-fabrica-cta__text"><?php echo esc_html( (string) $cta['text'] ); ?></p>
		<?php endif; ?>
		<div class="portal-fabrica-cta__actions">
			<?php if ( $contact_url ) : ?>
				<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( $contact_url ); ?>">
					<?php
					echo esc_html(
						isset( $cta['button'] ) ? (string) $cta['button'] : __( 'Solicitar parceria', 'portal-si-cefet' )
					);
					?>
				</a>
			<?php endif; ?>
			<?php if ( $email && is_email( $email ) ) : ?>
				<a class="portal-btn portal-btn--secondary" href="<?php echo esc_url( 'mailto:' . $email ); ?>">
					<?php
					echo esc_html(
						isset( $cta['email_label'] ) ? (string) $cta['email_label'] : __( 'Enviar e-mail', 'portal-si-cefet' )
					);
					?>
				</a>
			<?php endif; ?>
		</div>
		<p class="portal-fabrica-cta__note">
			<?php esc_html_e( 'Inclua na mensagem: nome da organização, resumo da demanda, prazo desejado e um contato para reunião de alinhamento.', 'portal-si-cefet' ); ?>
		</p>
	</div>
</section>
