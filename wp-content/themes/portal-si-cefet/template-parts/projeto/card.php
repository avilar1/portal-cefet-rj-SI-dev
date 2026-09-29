<?php
/**
 * Card de projeto de pesquisa/extensão.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$projeto = isset( $args['projeto'] ) ? $args['projeto'] : null;
if ( ! $projeto ) {
	return;
}
$heading = isset( $args['heading'] ) ? $args['heading'] : 'h3';
$heading = in_array( $heading, array( 'h2', 'h3', 'h4' ), true ) ? $heading : 'h3';
?>
<li class="portal-projeto-grid__item">
	<article class="<?php echo esc_attr( portal_si_br_card_class() . ' portal-projeto-card portal-projeto-card--' . $projeto['tipo'] ); ?>">
		<div class="card-content portal-projeto-card__body">
			<p class="portal-projeto-card__tags">
				<span class="portal-projeto-tag portal-projeto-tag--<?php echo esc_attr( $projeto['tipo'] ); ?>"><?php echo esc_html( $projeto['tipo_label'] ); ?></span>
				<span class="portal-projeto-tag portal-projeto-tag--<?php echo esc_attr( $projeto['situacao'] ); ?>"><?php echo esc_html( $projeto['situacao_label'] ); ?></span>
				<?php if ( $projeto['exemplo'] ) : ?>
					<span class="portal-projeto-tag portal-projeto-tag--exemplo"><?php esc_html_e( 'Exemplo', 'portal-si-cefet' ); ?></span>
				<?php endif; ?>
			</p>
			<<?php echo $heading; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- whitelist acima. ?> class="portal-projeto-card__title">
				<a href="<?php echo esc_url( $projeto['url'] ); ?>"><?php echo esc_html( $projeto['title'] ); ?></a>
			</<?php echo $heading; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php if ( $projeto['excerpt'] ) : ?>
				<p class="portal-projeto-card__excerpt"><?php echo esc_html( $projeto['excerpt'] ); ?></p>
			<?php endif; ?>
			<dl class="portal-projeto-card__meta">
				<?php if ( $projeto['responsavel'] ) : ?>
					<div>
						<dt><?php esc_html_e( 'Responsável', 'portal-si-cefet' ); ?></dt>
						<dd><?php echo esc_html( $projeto['responsavel'] ); ?></dd>
					</div>
				<?php endif; ?>
				<?php if ( $projeto['area'] ) : ?>
					<div>
						<dt><?php esc_html_e( 'Área', 'portal-si-cefet' ); ?></dt>
						<dd><?php echo esc_html( $projeto['area'] ); ?></dd>
					</div>
				<?php endif; ?>
				<?php if ( $projeto['periodo'] ) : ?>
					<div>
						<dt><?php esc_html_e( 'Período', 'portal-si-cefet' ); ?></dt>
						<dd><?php echo esc_html( $projeto['periodo'] ); ?></dd>
					</div>
				<?php endif; ?>
			</dl>
			<?php if ( $projeto['vagas'] && 'andamento' === $projeto['situacao'] ) : ?>
				<p class="portal-projeto-card__vagas"><?php esc_html_e( 'Aceita alunos', 'portal-si-cefet' ); ?></p>
			<?php endif; ?>
		</div>
	</article>
</li>
