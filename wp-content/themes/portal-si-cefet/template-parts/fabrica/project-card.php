<?php
/**
 * Card de projeto do portfólio.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$project = isset( $args['project'] ) && is_array( $args['project'] ) ? $args['project'] : null;
if ( empty( $project['name'] ) ) {
	return;
}

$link = ! empty( $project['presentation_url'] ) ? esc_url( (string) $project['presentation_url'] ) : '';
?>
<li class="portal-fabrica-project portal-card">
	<?php if ( ! empty( $project['photo_url'] ) ) : ?>
		<div class="portal-fabrica-project__media">
			<img
				class="portal-fabrica-project__photo"
				src="<?php echo esc_url( (string) $project['photo_url'] ); ?>"
				alt=""
				loading="lazy"
				width="400"
				height="225"
			/>
		</div>
	<?php endif; ?>
	<div class="portal-fabrica-project__body">
		<div class="portal-fabrica-project__head">
			<h3 class="portal-fabrica-project__name"><?php echo esc_html( (string) $project['name'] ); ?></h3>
			<?php if ( ! empty( $project['year'] ) ) : ?>
				<span class="portal-fabrica-project__year"><?php echo esc_html( (string) $project['year'] ); ?></span>
			<?php endif; ?>
		</div>
		<?php if ( ! empty( $project['description'] ) ) : ?>
			<p class="portal-fabrica-project__desc"><?php echo esc_html( (string) $project['description'] ); ?></p>
		<?php endif; ?>
		<dl class="portal-fabrica-project__meta">
			<?php if ( ! empty( $project['technologies'] ) ) : ?>
				<div class="portal-fabrica-project__row">
					<dt><?php esc_html_e( 'Tecnologias', 'portal-si-cefet' ); ?></dt>
					<dd><?php echo esc_html( (string) $project['technologies'] ); ?></dd>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $project['students'] ) ) : ?>
				<div class="portal-fabrica-project__row">
					<dt><?php esc_html_e( 'Equipe', 'portal-si-cefet' ); ?></dt>
					<dd><?php echo esc_html( (string) $project['students'] ); ?></dd>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $project['result'] ) ) : ?>
				<div class="portal-fabrica-project__row">
					<dt><?php esc_html_e( 'Entrega', 'portal-si-cefet' ); ?></dt>
					<dd><?php echo esc_html( (string) $project['result'] ); ?></dd>
				</div>
			<?php endif; ?>
		</dl>
		<?php if ( $link ) : ?>
			<p class="portal-fabrica-project__actions">
				<a class="portal-btn portal-btn--secondary portal-fabrica-project__link" href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Ver solução ou apresentação', 'portal-si-cefet' ); ?>
					<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
				</a>
			</p>
		<?php endif; ?>
	</div>
</li>
