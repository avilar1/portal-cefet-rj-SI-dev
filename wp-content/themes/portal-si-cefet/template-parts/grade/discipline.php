<?php
/**
 * Cartão de disciplina (obrigatória, optativa ou vaga de optativa no período).
 *
 * @package Portal_SI_CEFET
 *
 * @var array $args { discipline: array<string, mixed>, heading_level?: int }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$disc = isset( $args['discipline'] ) && is_array( $args['discipline'] ) ? $args['discipline'] : array();
if ( empty( $disc ) ) {
	return;
}

$heading = isset( $args['heading_level'] ) ? max( 2, min( 6, (int) $args['heading_level'] ) ) : 3;
$tag     = 'h' . $heading;

$hours = sprintf(
	/* translators: 1: clock hours, 2: class hours */
	__( '%1$s h (%2$s horas-aula)', 'portal-si-cefet' ),
	portal_si_grade_format_number( $disc['hr'] ),
	portal_si_grade_format_number( $disc['ha'] )
);

if ( ! empty( $disc['slot'] ) ) :
	?>
	<li class="portal-grade-disc portal-grade-disc--slot">
		<div class="portal-grade-disc__head">
			<<?php echo esc_html( $tag ); ?> class="portal-grade-disc__name"><?php esc_html_e( 'Disciplina optativa', 'portal-si-cefet' ); ?></<?php echo esc_html( $tag ); ?>>
		</div>
		<dl class="portal-grade-disc__meta">
			<div><dt><?php esc_html_e( 'Carga horária', 'portal-si-cefet' ); ?></dt><dd><?php echo esc_html( $hours ); ?></dd></div>
			<div><dt><?php esc_html_e( 'Créditos', 'portal-si-cefet' ); ?></dt><dd><?php echo (int) $disc['cr']; ?></dd></div>
		</dl>
		<p class="portal-grade-disc__slot-link">
			<a href="#optativas"><?php esc_html_e( 'Ver disciplinas optativas', 'portal-si-cefet' ); ?></a>
		</p>
	</li>
	<?php
	return;
endif;

$index   = portal_si_grade_index();
$unlocks = portal_si_grade_unlocks();
$nucleo  = $disc['nucleo'];
$label   = portal_si_grade_nucleo_label( $nucleo );
$freed   = isset( $unlocks[ $disc['code'] ] ) ? $unlocks[ $disc['code'] ] : array();

$render_links = static function ( $codes ) use ( $index ) {
	$items = array();
	foreach ( $codes as $code ) {
		if ( isset( $index[ $code ] ) ) {
			$items[] = sprintf(
				'<a href="#%1$s">%2$s</a>',
				esc_attr( portal_si_grade_anchor( $code ) ),
				esc_html( $index[ $code ]['name'] )
			);
		} else {
			$items[] = esc_html( $code );
		}
	}
	return implode( ', ', $items );
};

$credits = (int) $disc['cr'];
if ( $disc['t'] && $disc['p'] ) {
	$credits = sprintf(
		/* translators: 1: total credits, 2: theory credits, 3: practice credits */
		__( '%1$d (%2$d teóricos, %3$d práticos)', 'portal-si-cefet' ),
		(int) $disc['cr'],
		(int) $disc['t'],
		(int) $disc['p']
	);
} elseif ( $disc['t'] ) {
	/* translators: %d: credits */
	$credits = sprintf( __( '%d (teóricos)', 'portal-si-cefet' ), (int) $disc['cr'] );
} elseif ( $disc['p'] ) {
	/* translators: %d: credits */
	$credits = sprintf( __( '%d (práticos)', 'portal-si-cefet' ), (int) $disc['cr'] );
}
?>
<li id="<?php echo esc_attr( portal_si_grade_anchor( $disc['code'] ) ); ?>" class="portal-grade-disc<?php echo $nucleo ? ' portal-grade-disc--' . esc_attr( $nucleo ) : ''; ?>">
	<div class="portal-grade-disc__head">
		<span class="portal-grade-disc__code"><?php echo esc_html( $disc['code'] ); ?></span>
		<<?php echo esc_html( $tag ); ?> class="portal-grade-disc__name"><?php echo esc_html( $disc['name'] ); ?></<?php echo esc_html( $tag ); ?>>
		<?php if ( $label ) : ?>
			<span class="portal-grade-chip portal-grade-chip--<?php echo esc_attr( $nucleo ); ?>"><?php echo esc_html( $label ); ?></span>
		<?php endif; ?>
	</div>

	<dl class="portal-grade-disc__meta">
		<div><dt><?php esc_html_e( 'Carga horária', 'portal-si-cefet' ); ?></dt><dd><?php echo esc_html( $hours ); ?></dd></div>
		<div><dt><?php esc_html_e( 'Créditos', 'portal-si-cefet' ); ?></dt><dd><?php echo esc_html( (string) $credits ); ?></dd></div>
		<div>
			<dt><?php esc_html_e( 'Pré-requisitos', 'portal-si-cefet' ); ?></dt>
			<dd>
				<?php
				if ( $disc['pre'] ) {
					echo wp_kses( $render_links( $disc['pre'] ), array( 'a' => array( 'href' => array() ) ) );
				} else {
					esc_html_e( 'Nenhum', 'portal-si-cefet' );
				}
				?>
			</dd>
		</div>
		<?php if ( $freed ) : ?>
			<div>
				<dt><?php esc_html_e( 'É pré-requisito de', 'portal-si-cefet' ); ?></dt>
				<dd><?php echo wp_kses( $render_links( $freed ), array( 'a' => array( 'href' => array() ) ) ); ?></dd>
			</div>
		<?php endif; ?>
	</dl>

	<details class="portal-grade-disc__ementa">
		<summary><?php esc_html_e( 'Ementa', 'portal-si-cefet' ); ?></summary>
		<p>
			<?php
			if ( '' !== $disc['ementa'] ) {
				echo esc_html( $disc['ementa'] );
			} else {
				esc_html_e( 'Conteúdo variável, definido no plano de curso do semestre.', 'portal-si-cefet' );
			}
			?>
		</p>
	</details>
</li>
