<?php
/**
 * Formulário de contato — demo funcional (RF27 / testes de usabilidade).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$flash    = function_exists( 'portal_si_contato_form_flash' ) ? portal_si_contato_form_flash() : array();
$subjects = portal_si_contato_form_subjects();
$privacy  = portal_si_page_url( PORTAL_SI_PRIVACIDADE_SLUG );
?>
<section class="portal-contato-section portal-contato-form-section" id="formulario-contato" aria-labelledby="portal-contato-form-title">
	<h2 id="portal-contato-form-title" class="portal-contato-section__title">
		<?php esc_html_e( 'Envie uma mensagem', 'portal-si-cefet' ); ?>
	</h2>
	<p class="portal-contato-section__intro">
		<?php esc_html_e( 'Use o formulário abaixo para dúvidas sobre o curso ou parcerias com a Fábrica de Software. Campos marcados com * são obrigatórios.', 'portal-si-cefet' ); ?>
	</p>

	<?php if ( ! empty( $flash['status'] ) && in_array( $flash['status'], array( 'ok', 'ok-demo' ), true ) ) : ?>
		<div class="portal-contato-form__notice portal-contato-form__notice--success" role="status">
			<p><strong><?php esc_html_e( 'Mensagem registrada com sucesso.', 'portal-si-cefet' ); ?></strong></p>
			<?php if ( ! empty( $flash['ref'] ) ) : ?>
			<p>
				<?php
				echo wp_kses_post(
					sprintf(
						/* translators: %s: protocol reference */
						__( 'Anote sua referência: %s', 'portal-si-cefet' ),
						'<strong>' . esc_html( (string) $flash['ref'] ) . '</strong>'
					)
				);
				?>
			</p>
			<?php endif; ?>
			<?php if ( 'ok-demo' === $flash['status'] ) : ?>
				<p class="portal-contato-form__hint"><?php esc_html_e( 'Ambiente de demonstração: a mensagem foi registrada, mas o e-mail pode não ter sido enviado automaticamente.', 'portal-si-cefet' ); ?></p>
			<?php else : ?>
				<p class="portal-contato-form__hint"><?php esc_html_e( 'A coordenação responderá pelo e-mail informado.', 'portal-si-cefet' ); ?></p>
			<?php endif; ?>
		</div>
	<?php elseif ( ! empty( $flash['status'] ) && 'erro' === $flash['status'] ) : ?>
		<div class="portal-contato-form__notice portal-contato-form__notice--error" role="alert">
			<p><strong><?php esc_html_e( 'Não foi possível enviar. Verifique os campos destacados.', 'portal-si-cefet' ); ?></strong></p>
		</div>
	<?php elseif ( ! empty( $flash['status'] ) && 'erro-seguranca' === $flash['status'] ) : ?>
		<div class="portal-contato-form__notice portal-contato-form__notice--error" role="alert">
			<p><?php esc_html_e( 'Sessão expirada. Recarregue a página e tente novamente.', 'portal-si-cefet' ); ?></p>
		</div>
	<?php endif; ?>

	<form class="portal-contato-form portal-card" method="post" action="<?php echo esc_url( portal_si_page_url( PORTAL_SI_CONTATO_SLUG ) . '#formulario-contato' ); ?>" novalidate>
		<input type="hidden" name="portal_si_contato_form" value="1" />
		<?php wp_nonce_field( PORTAL_SI_CONTATO_FORM_ACTION, 'portal_si_contato_nonce' ); ?>

		<div class="portal-contato-form__field">
			<label for="portal_si_nome"><?php esc_html_e( 'Nome completo', 'portal-si-cefet' ); ?> <span class="portal-contato-form__req" aria-hidden="true">*</span></label>
			<input type="text" id="portal_si_nome" name="portal_si_nome" required autocomplete="name" class="portal-contato-form__input" />
		</div>

		<div class="portal-contato-form__field">
			<label for="portal_si_email"><?php esc_html_e( 'E-mail', 'portal-si-cefet' ); ?> <span class="portal-contato-form__req" aria-hidden="true">*</span></label>
			<input type="email" id="portal_si_email" name="portal_si_email" required autocomplete="email" class="portal-contato-form__input" />
		</div>

		<div class="portal-contato-form__field">
			<label for="portal_si_assunto"><?php esc_html_e( 'Assunto', 'portal-si-cefet' ); ?> <span class="portal-contato-form__req" aria-hidden="true">*</span></label>
			<select id="portal_si_assunto" name="portal_si_assunto" required class="portal-contato-form__input">
				<option value=""><?php esc_html_e( 'Selecione…', 'portal-si-cefet' ); ?></option>
				<?php foreach ( $subjects as $key => $label ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="portal-contato-form__field">
			<label for="portal_si_mensagem"><?php esc_html_e( 'Mensagem', 'portal-si-cefet' ); ?> <span class="portal-contato-form__req" aria-hidden="true">*</span></label>
			<textarea id="portal_si_mensagem" name="portal_si_mensagem" rows="5" required minlength="10" class="portal-contato-form__input"></textarea>
			<p class="portal-contato-form__hint"><?php esc_html_e( 'Mínimo de 10 caracteres.', 'portal-si-cefet' ); ?></p>
		</div>

		<div class="portal-contato-form__field portal-contato-form__field--checkbox">
			<input type="checkbox" id="portal_si_consent" name="portal_si_consent" value="1" required />
			<label for="portal_si_consent">
				<?php
				if ( $privacy ) {
					echo wp_kses_post(
						sprintf(
							/* translators: %s: privacy policy link */
							__( 'Li a %s e autorizo o uso dos meus dados apenas para responder este contato.', 'portal-si-cefet' ),
							'<a href="' . esc_url( $privacy ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Política de Privacidade', 'portal-si-cefet' ) . '</a>'
						)
					);
				} else {
					esc_html_e( 'Autorizo o uso dos meus dados apenas para responder este contato.', 'portal-si-cefet' );
				}
				?>
				<span class="portal-contato-form__req" aria-hidden="true">*</span>
			</label>
		</div>

		<div class="portal-contato-form__actions">
			<button type="submit" class="portal-btn portal-btn--primary"><?php esc_html_e( 'Enviar mensagem', 'portal-si-cefet' ); ?></button>
		</div>
	</form>
</section>
