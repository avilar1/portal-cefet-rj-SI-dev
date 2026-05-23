<?php
/**
 * Aviso — fonte oficial CEFET/RJ.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$config = portal_si_ingresso_config();
$links  = isset( $config['official_links'] ) && is_array( $config['official_links'] ) ? $config['official_links'] : array();
$url    = '';

foreach ( $links as $link ) {
	if ( ! is_array( $link ) || empty( $link['primary'] ) || empty( $link['url'] ) ) {
		continue;
	}
	$url = (string) $link['url'];
	break;
}

if ( '' === $url ) {
	return;
}

$edition = isset( $config['edition'] ) && is_array( $config['edition'] ) ? $config['edition'] : array();
?>
<aside class="portal-ingresso-alert" role="note">
	<p>
		<strong><?php esc_html_e( 'Atenção:', 'portal-si-cefet' ); ?></strong>
		<?php
		if ( ! empty( $edition['detail'] ) ) {
			echo esc_html( (string) $edition['detail'] ) . ' ';
		}
		esc_html_e( 'Chamadas, listas de convocados e prazos de matrícula são atualizados somente na página oficial do CEFET/RJ.', 'portal-si-cefet' );
		?>
		<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
			<?php esc_html_e( 'Abrir avisos e convocações no site do CEFET/RJ', 'portal-si-cefet' ); ?>
			<span aria-hidden="true"> ↗</span>
			<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
		</a>
	</p>
</aside>
