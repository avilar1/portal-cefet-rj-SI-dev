<?php
/**
 * Zona B — Grade de navegação por cards.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cards   = portal_si_institucional_nav_cards();
$heading = portal_si_institucional_zona_b_heading();

if ( empty( $cards ) ) {
	return;
}

$heading_id = 'portal-inst-zona-b-title';
?>
<section class="portal-inst-zona-b" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>">
	<div class="portal-inst-zona-b__inner">
		<?php if ( $heading ) : ?>
			<h2 id="<?php echo esc_attr( $heading_id ); ?>" class="portal-inst-zona-b__title">
				<?php echo esc_html( $heading ); ?>
			</h2>
		<?php endif; ?>
		<ul class="portal-inst-zona-b__grid">
			<?php foreach ( $cards as $card ) : ?>
				<li>
					<a
						class="<?php echo esc_attr( portal_si_br_card_class( array( 'hover' ) ) . ' portal-service-card portal-inst-zona-b__card' ); ?>"
						href="<?php echo esc_url( $card['url'] ); ?>"
					>
						<div class="card-content portal-service-card__inner">
							<span class="portal-service-card__icon" aria-hidden="true">
								<?php
								get_template_part(
									'template-parts/home/icon',
									null,
									array( 'icon' => $card['icon'] )
								);
								?>
							</span>
							<span class="portal-service-card__body">
								<span class="portal-service-card__title"><?php echo esc_html( $card['title'] ); ?></span>
								<?php if ( ! empty( $card['description'] ) ) : ?>
									<span class="portal-service-card__description"><?php echo esc_html( $card['description'] ); ?></span>
								<?php endif; ?>
							</span>
						</div>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
