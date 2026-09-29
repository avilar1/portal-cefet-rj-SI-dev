<?php
/**
 * Observações do curso (TCC, estágio, extensão) e fonte dos dados.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = portal_si_grade_config();
$notes  = isset( $config['notes'] ) && is_array( $config['notes'] ) ? $config['notes'] : array();
$source = isset( $config['source'] ) && is_array( $config['source'] ) ? $config['source'] : array();

if ( empty( $notes ) && empty( $source ) ) {
	return;
}
?>
<section class="portal-grade-notes" aria-labelledby="observacoes-titulo">
	<h2 id="observacoes-titulo" class="portal-grade-section__title"><?php esc_html_e( 'Observações', 'portal-si-cefet' ); ?></h2>
	<?php if ( $notes ) : ?>
		<ul class="portal-grade-notes__list">
			<?php foreach ( $notes as $note ) : ?>
				<?php
				if ( ! is_array( $note ) || empty( $note['title'] ) ) {
					continue;
				}
				?>
				<li class="portal-grade-notes__item br-card">
					<div class="card-content">
						<h3 class="portal-grade-notes__title"><?php echo esc_html( (string) $note['title'] ); ?></h3>
						<?php if ( ! empty( $note['text'] ) ) : ?>
							<p class="portal-grade-notes__text"><?php echo esc_html( (string) $note['text'] ); ?></p>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<?php if ( ! empty( $source['label'] ) ) : ?>
		<p class="portal-grade-source">
			<?php
			printf(
				/* translators: %s: source document */
				esc_html__( 'Fonte: %s.', 'portal-si-cefet' ),
				esc_html( (string) $source['label'] )
			);
			if ( ! empty( $source['plans_note'] ) ) {
				echo ' ' . esc_html( (string) $source['plans_note'] );
			}
			if ( ! empty( $source['plans_url'] ) ) :
				?>
				<a href="<?php echo esc_url( (string) $source['plans_url'] ); ?>" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Acessar página do curso no CEFET/RJ', 'portal-si-cefet' ); ?>
					<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
				</a>
			<?php endif; ?>
		</p>
	<?php endif; ?>
</section>
