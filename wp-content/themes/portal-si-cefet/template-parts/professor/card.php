<?php
/**
 * Card de professor na listagem.
 *
 * @var array<string, mixed> $professor Dados de portal_si_professor_to_array().
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$professor = isset( $args['professor'] ) && is_array( $args['professor'] ) ? $args['professor'] : null;
if ( empty( $professor ) ) {
	return;
}
?>
<article class="professor-card portal-card">
	<a class="professor-card__link" href="<?php echo esc_url( $professor['url'] ); ?>">
		<div class="professor-card__media">
			<?php if ( ! empty( $professor['photo_url'] ) ) : ?>
				<img
					class="professor-card__photo"
					src="<?php echo esc_url( $professor['photo_url'] ); ?>"
					alt="<?php echo esc_attr( $professor['photo_alt'] ); ?>"
					loading="lazy"
					width="320"
					height="320"
				/>
			<?php else : ?>
				<div class="professor-card__avatar" aria-hidden="true">
					<span class="professor-card__initials"><?php echo esc_html( $professor['initials'] ); ?></span>
				</div>
			<?php endif; ?>
		</div>
		<div class="professor-card__body">
			<h2 class="professor-card__name"><?php echo esc_html( $professor['name'] ); ?></h2>
			<?php if ( ! empty( $professor['excerpt'] ) ) : ?>
				<p class="professor-card__excerpt"><?php echo esc_html( $professor['excerpt'] ); ?></p>
			<?php elseif ( ! empty( $professor['research_lines'] ) ) : ?>
				<p class="professor-card__excerpt"><?php echo esc_html( $professor['research_lines'][0] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $professor['lattes_url'] ) ) : ?>
				<span class="professor-card__lattes"><?php esc_html_e( 'Currículo Lattes', 'portal-si-cefet' ); ?></span>
			<?php endif; ?>
		</div>
	</a>
</article>
