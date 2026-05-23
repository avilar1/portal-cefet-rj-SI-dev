<?php
/**
 * Secções do perfil do professor (single).
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
<div class="professor-profile">
	<header class="professor-profile__header">
		<div class="professor-profile__media">
			<?php if ( ! empty( $professor['photo_url'] ) ) : ?>
				<img
					class="professor-profile__photo"
					src="<?php echo esc_url( $professor['photo_url'] ); ?>"
					alt="<?php echo esc_attr( $professor['photo_alt'] ); ?>"
					width="400"
					height="400"
				/>
			<?php else : ?>
				<div class="professor-profile__avatar" aria-hidden="true">
					<span class="professor-profile__initials"><?php echo esc_html( $professor['initials'] ); ?></span>
				</div>
			<?php endif; ?>
		</div>
		<div class="professor-profile__intro">
			<h1 class="professor-profile__name"><?php echo esc_html( $professor['name'] ); ?></h1>
			<?php if ( ! empty( $professor['lattes_url'] ) ) : ?>
				<p class="professor-profile__lattes-wrap">
					<a class="professor-profile__lattes portal-btn portal-btn--secondary" href="<?php echo esc_url( $professor['lattes_url'] ); ?>" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Currículo Lattes', 'portal-si-cefet' ); ?>
						<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
					</a>
				</p>
			<?php endif; ?>
			<?php if ( ! empty( $professor['excerpt'] ) ) : ?>
				<p class="professor-profile__tagline"><?php echo esc_html( $professor['excerpt'] ); ?></p>
			<?php endif; ?>
		</div>
	</header>

	<div class="professor-profile__sections">
		<?php if ( ! empty( $professor['formation'] ) ) : ?>
			<section class="professor-profile__section" aria-labelledby="professor-formation-heading">
				<h2 id="professor-formation-heading" class="professor-profile__section-title"><?php esc_html_e( 'Formação acadêmica', 'portal-si-cefet' ); ?></h2>
				<?php if ( count( $professor['formation_items'] ) > 1 ) : ?>
					<ul class="professor-profile__list">
						<?php foreach ( $professor['formation_items'] as $item ) : ?>
							<li><?php echo esc_html( $item ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php else : ?>
					<p class="professor-profile__text"><?php echo nl2br( esc_html( $professor['formation'] ) ); ?></p>
				<?php endif; ?>
			</section>
		<?php endif; ?>

		<?php if ( ! empty( $professor['biography'] ) ) : ?>
			<section class="professor-profile__section" aria-labelledby="professor-bio-heading">
				<h2 id="professor-bio-heading" class="professor-profile__section-title"><?php esc_html_e( 'Biografia', 'portal-si-cefet' ); ?></h2>
				<div class="professor-profile__text"><?php echo nl2br( esc_html( $professor['biography'] ) ); ?></div>
			</section>
		<?php endif; ?>

		<?php if ( ! empty( $professor['research_lines'] ) ) : ?>
			<section class="professor-profile__section" aria-labelledby="professor-lines-heading">
				<h2 id="professor-lines-heading" class="professor-profile__section-title"><?php esc_html_e( 'Linhas de pesquisa', 'portal-si-cefet' ); ?></h2>
				<ul class="professor-profile__list professor-profile__list--tags">
					<?php foreach ( $professor['research_lines'] as $line ) : ?>
						<li><span class="professor-profile__tag"><?php echo esc_html( $line ); ?></span></li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endif; ?>
	</div>
</div>
