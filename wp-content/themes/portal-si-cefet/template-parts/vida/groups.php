<?php
/**
 * Cards agrupados por categoria (auxílio, bolsas, apoio) e data de revisão.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$groups = portal_si_vida_groups();

foreach ( $groups as $key => $group ) :
	$title_id = 'vida-' . sanitize_html_class( $key ) . '-titulo';
	?>
	<section class="portal-vida-section" aria-labelledby="<?php echo esc_attr( $title_id ); ?>">
		<h2 id="<?php echo esc_attr( $title_id ); ?>" class="portal-vida-section__title"><?php echo esc_html( $group['label'] ); ?></h2>
		<ul class="portal-vida-cards">
			<?php foreach ( $group['items'] as $item ) : ?>
				<li class="portal-vida-card br-card">
					<div class="card-content portal-vida-card__content">
						<h3 class="portal-vida-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
						<?php if ( $item['description'] ) : ?>
							<p class="portal-vida-card__text"><?php echo esc_html( $item['description'] ); ?></p>
						<?php endif; ?>
						<?php if ( $item['url'] ) : ?>
							<a class="portal-vida-card__link" href="<?php echo esc_url( $item['url'] ); ?>" target="_blank" rel="noopener noreferrer">
								<?php echo esc_html( $item['link_label'] ? $item['link_label'] : __( 'Saiba mais', 'portal-si-cefet' ) ); ?>
								<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
							</a>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>
	<?php
endforeach;

$reviewed = portal_si_vida_reviewed_at();
if ( $reviewed ) :
	?>
	<p class="portal-vida-reviewed">
		<?php
		/* translators: %s: date */
		printf( esc_html__( 'Página revisada em %s. Valores, prazos e regras de cada programa estão sempre no edital oficial.', 'portal-si-cefet' ), esc_html( $reviewed ) );
		?>
	</p>
	<?php
endif;
