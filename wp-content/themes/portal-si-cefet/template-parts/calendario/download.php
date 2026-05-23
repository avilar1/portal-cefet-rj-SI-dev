<?php
/**
 * Bloco de download do PDF oficial.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config  = portal_si_calendario_tpl_arg( isset( $args ) ? $args : null, 'config', portal_si_calendario_config() );
if ( ! is_array( $config ) ) {
	$config = portal_si_calendario_config();
}
$pdf_url = portal_si_calendario_tpl_arg( isset( $args ) ? $args : null, 'pdf_url', '' );
if ( '' === (string) $pdf_url ) {
	$pdf_url = portal_si_calendario_pdf_url();
}
$official = isset( $config['official_page_url'] ) ? (string) $config['official_page_url'] : '';
?>
<section class="portal-calendario-download br-card" aria-labelledby="portal-calendario-download-title">
	<div class="card-content portal-calendario-download__inner">
		<h2 id="portal-calendario-download-title" class="portal-calendario-section__title">
			<?php esc_html_e( 'Documento oficial', 'portal-si-cefet' ); ?>
		</h2>
		<p class="portal-calendario-download__text">
			<?php esc_html_e( 'O calendário completo (semanas letivas, feriados e atividades) está no PDF aprovado pelo CONPUS. Use-o sempre que precisar de precisão máxima.', 'portal-si-cefet' ); ?>
		</p>
		<div class="portal-calendario-download__actions">
			<?php if ( $pdf_url ) : ?>
				<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( $pdf_url ); ?>" target="_blank" rel="noopener noreferrer">
					<?php
					echo esc_html(
						isset( $config['pdf_label'] ) ? (string) $config['pdf_label'] : __( 'Baixar PDF do calendário 2026', 'portal-si-cefet' )
					);
					?>
					<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
				</a>
			<?php else : ?>
				<?php
				portal_si_the_coming_soon_notice(
					array(
						'variant' => 'inline',
						'badge'   => __( 'Conteúdo em breve', 'portal-si-cefet' ),
						'message' => __( 'O PDF oficial ainda não foi anexado nesta página. Enquanto isso, consulte o link do CEFET/RJ abaixo ou a coordenação do curso.', 'portal-si-cefet' ),
					)
				);
				?>
			<?php endif; ?>
			<?php if ( $official ) : ?>
				<a class="portal-calendario-download__secondary" href="<?php echo esc_url( $official ); ?>" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Calendários no site do CEFET/RJ', 'portal-si-cefet' ); ?>
					<span aria-hidden="true"> ↗</span>
					<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
				</a>
			<?php endif; ?>
		</div>
		<?php
		$doc_updated = portal_si_calendario_document_updated_display();
		if ( $doc_updated ) :
			?>
			<p class="portal-calendario-download__updated">
				<strong><?php esc_html_e( 'Última atualização do documento oficial:', 'portal-si-cefet' ); ?></strong>
				<?php echo esc_html( $doc_updated ); ?>
			</p>
		<?php endif; ?>
	</div>
</section>
