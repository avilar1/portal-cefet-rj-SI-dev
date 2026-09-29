<?php
/**
 * Navegação por âncoras entre períodos, optativas e carga horária.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$periods = portal_si_grade_periods();
if ( empty( $periods ) ) {
	return;
}

$fluxo_id = defined( 'PORTAL_SI_FLUXO_SLUG' ) ? portal_si_get_page_id_by_slug( PORTAL_SI_FLUXO_SLUG ) : 0;
?>
<?php if ( $fluxo_id ) : ?>
	<aside class="portal-grade-fluxo-cta">
		<p class="portal-grade-fluxo-cta__text">
			<strong><?php esc_html_e( 'Quer ver o caminho até uma disciplina?', 'portal-si-cefet' ); ?></strong>
			<?php esc_html_e( 'No fluxo interativo, selecione uma matéria e veja o que precisa cursar antes e o que ela libera.', 'portal-si-cefet' ); ?>
		</p>
		<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( get_permalink( $fluxo_id ) ); ?>"><?php esc_html_e( 'Abrir fluxo de disciplinas', 'portal-si-cefet' ); ?></a>
	</aside>
<?php endif; ?>
<nav class="portal-grade-nav" aria-label="<?php esc_attr_e( 'Períodos do curso', 'portal-si-cefet' ); ?>">
	<p class="portal-grade-nav__label"><?php esc_html_e( 'Ir para:', 'portal-si-cefet' ); ?></p>
	<ul class="portal-grade-nav__list">
		<?php foreach ( $periods as $period ) : ?>
			<li>
				<a class="portal-grade-nav__link" href="#periodo-<?php echo (int) $period['number']; ?>">
					<?php
					/* translators: %d: period number */
					printf( esc_html__( '%dº período', 'portal-si-cefet' ), (int) $period['number'] );
					?>
				</a>
			</li>
		<?php endforeach; ?>
		<?php if ( portal_si_grade_optativas() ) : ?>
			<li><a class="portal-grade-nav__link" href="#optativas"><?php esc_html_e( 'Optativas', 'portal-si-cefet' ); ?></a></li>
		<?php endif; ?>
		<?php if ( portal_si_grade_nucleos() ) : ?>
			<li><a class="portal-grade-nav__link" href="#carga-horaria"><?php esc_html_e( 'Carga horária', 'portal-si-cefet' ); ?></a></li>
		<?php endif; ?>
	</ul>
</nav>
