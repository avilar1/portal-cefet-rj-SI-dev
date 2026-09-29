<?php
/**
 * Fluxo de disciplinas — mapa interativo de pré-requisitos por período (RF26).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$periods   = portal_si_grade_periods();
$optativas = portal_si_grade_optativas();
$grade_url = portal_si_page_url( PORTAL_SI_GRADE_SLUG );

/**
 * Cartão selecionável de disciplina.
 *
 * @param array<string, mixed> $disc   Disciplina normalizada.
 * @param int                  $period Período (0 = optativa).
 */
$render_card = static function ( $disc, $period ) {
	if ( ! empty( $disc['slot'] ) ) {
		?>
		<li>
			<div class="portal-fluxo-card portal-fluxo-card--slot">
				<span class="portal-fluxo-card__name"><?php esc_html_e( 'Optativa', 'portal-si-cefet' ); ?></span>
				<span class="portal-fluxo-card__meta">
					<?php
					/* translators: %d: credits */
					printf( esc_html__( '%d créditos', 'portal-si-cefet' ), (int) $disc['cr'] );
					?>
				</span>
			</div>
		</li>
		<?php
		return;
	}
	?>
	<li>
		<button
			type="button"
			class="portal-fluxo-card<?php echo $disc['nucleo'] ? ' portal-fluxo-card--' . esc_attr( $disc['nucleo'] ) : ''; ?>"
			data-fluxo-code="<?php echo esc_attr( $disc['code'] ); ?>"
			data-fluxo-name="<?php echo esc_attr( $disc['name'] ); ?>"
			data-fluxo-period="<?php echo (int) $period; ?>"
			data-fluxo-pre="<?php echo esc_attr( portal_si_fluxo_pre_attr( $disc ) ); ?>"
			aria-pressed="false"
		>
			<span class="portal-fluxo-card__code"><?php echo esc_html( $disc['code'] ); ?></span>
			<span class="portal-fluxo-card__name"><?php echo esc_html( $disc['name'] ); ?></span>
			<span class="portal-fluxo-card__meta">
				<?php
				/* translators: %d: credits */
				printf( esc_html__( '%d créditos', 'portal-si-cefet' ), (int) $disc['cr'] );
				?>
			</span>
		</button>
	</li>
	<?php
};

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--fluxo" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header portal-fluxo-header">
			<p class="portal-fluxo-header__badge"><?php esc_html_e( 'Interativo', 'portal-si-cefet' ); ?></p>
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<p class="portal-page-header__intro"><?php echo esc_html( portal_si_fluxo_intro() ); ?></p>
		</header>

		<div class="portal-fluxo-body" data-fluxo data-fluxo-grade-url="<?php echo esc_url( $grade_url ); ?>">
			<div class="portal-fluxo-toolbar">
				<ul class="portal-fluxo-legend" aria-label="<?php esc_attr_e( 'Legenda', 'portal-si-cefet' ); ?>">
					<li><span class="portal-fluxo-legend__swatch portal-fluxo-legend__swatch--selected" aria-hidden="true"></span><?php esc_html_e( 'Disciplina selecionada', 'portal-si-cefet' ); ?></li>
					<li><span class="portal-fluxo-legend__swatch portal-fluxo-legend__swatch--before" aria-hidden="true"></span><?php esc_html_e( 'Precisa cursar antes', 'portal-si-cefet' ); ?></li>
					<li><span class="portal-fluxo-legend__swatch portal-fluxo-legend__swatch--after" aria-hidden="true"></span><?php esc_html_e( 'Ela libera depois', 'portal-si-cefet' ); ?></li>
				</ul>
				<div class="portal-fluxo-toolbar__actions">
					<button type="button" class="portal-btn portal-btn--secondary portal-fluxo-clear" data-fluxo-clear hidden><?php esc_html_e( 'Limpar seleção', 'portal-si-cefet' ); ?></button>
					<a class="portal-fluxo-toolbar__link" href="<?php echo esc_url( $grade_url ); ?>"><?php esc_html_e( 'Ver grade com ementas', 'portal-si-cefet' ); ?></a>
				</div>
			</div>

			<div class="portal-fluxo-panel" data-fluxo-panel aria-live="polite">
				<p class="portal-fluxo-panel__empty"><?php esc_html_e( 'Nenhuma disciplina selecionada. Clique ou toque em uma disciplina do fluxo.', 'portal-si-cefet' ); ?></p>
			</div>

			<p class="portal-fluxo-hint"><?php esc_html_e( 'Arraste o quadro para o lado para ver todos os períodos.', 'portal-si-cefet' ); ?></p>

			<div class="portal-fluxo-scroll" role="region" aria-label="<?php esc_attr_e( 'Fluxo de disciplinas por período', 'portal-si-cefet' ); ?>" tabindex="0">
				<div class="portal-fluxo-board" data-fluxo-board>
					<svg class="portal-fluxo-lines" data-fluxo-lines aria-hidden="true" focusable="false">
						<defs>
							<marker id="portal-fluxo-arrow-before" viewBox="0 0 10 10" refX="9" refY="5" markerWidth="7" markerHeight="7" orient="auto-start-reverse">
								<path d="M0 0 L10 5 L0 10 z" />
							</marker>
							<marker id="portal-fluxo-arrow-after" viewBox="0 0 10 10" refX="9" refY="5" markerWidth="7" markerHeight="7" orient="auto-start-reverse">
								<path d="M0 0 L10 5 L0 10 z" />
							</marker>
						</defs>
					</svg>
					<ol class="portal-fluxo-columns">
						<?php foreach ( $periods as $period ) : ?>
							<li class="portal-fluxo-col">
								<h2 class="portal-fluxo-col__title">
									<?php
									/* translators: %d: period number */
									printf( esc_html__( '%dº período', 'portal-si-cefet' ), (int) $period['number'] );
									?>
								</h2>
								<p class="portal-fluxo-col__meta">
									<?php
									/* translators: %d: credits */
									printf( esc_html__( '%d créditos', 'portal-si-cefet' ), (int) $period['cr'] );
									?>
								</p>
								<ul class="portal-fluxo-col__list">
									<?php
									foreach ( $period['disciplines'] as $disc ) {
										$render_card( $disc, $period['number'] );
									}
									?>
								</ul>
							</li>
						<?php endforeach; ?>
					</ol>
				</div>
			</div>

			<?php if ( $optativas ) : ?>
				<section class="portal-fluxo-optativas" aria-labelledby="fluxo-optativas-titulo">
					<h2 id="fluxo-optativas-titulo" class="portal-fluxo-section__title"><?php esc_html_e( 'Optativas', 'portal-si-cefet' ); ?></h2>
					<p class="portal-fluxo-optativas__intro"><?php esc_html_e( 'Cursadas nas vagas de optativa a partir do 6º período. Selecione uma para ver seus pré-requisitos no fluxo.', 'portal-si-cefet' ); ?></p>
					<ul class="portal-fluxo-optativas__list">
						<?php
						foreach ( $optativas as $disc ) {
							$render_card( $disc, 0 );
						}
						?>
					</ul>
				</section>
			<?php endif; ?>
		</div>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
