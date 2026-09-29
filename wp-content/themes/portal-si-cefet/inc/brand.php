<?php
/**
 * Identidade visual: logo do curso e ícone do site.
 *
 * Para trocar sem mexer em código, envie outro em
 * Aparência → Personalizar → Identidade do site (Logo / Ícone do site).
 * O SVG atual veio de vetorização automática e serrilha em tamanhos pequenos,
 * por isso o logo padrão é o PNG em alta resolução; o SVG fica só no ícone da aba.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_LOGO_FILE', 'assets/images/logo-si.png' );
define( 'PORTAL_SI_LOGO_ICON_FILE', 'assets/images/logo-si.svg' );

/**
 * Habilita o campo "Logo" do Personalizador.
 */
function portal_si_brand_setup() {
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 288,
			'width'       => 395,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
}
add_action( 'after_setup_theme', 'portal_si_brand_setup' );

/**
 * Dados do logo atual (personalizado no painel ou o SVG do tema).
 *
 * @return array{url: string, width: int, height: int}
 */
function portal_si_logo() {
	$logo = array(
		'url'    => get_template_directory_uri() . '/' . PORTAL_SI_LOGO_FILE,
		'width'  => 395,
		'height' => 288,
	);

	$custom_id = (int) get_theme_mod( 'custom_logo' );
	if ( $custom_id ) {
		$src = wp_get_attachment_image_src( $custom_id, 'full' );
		if ( $src ) {
			$logo = array(
				'url'    => $src[0],
				'width'  => (int) $src[1] ? (int) $src[1] : $logo['width'],
				'height' => (int) $src[2] ? (int) $src[2] : $logo['height'],
			);
		}
	}

	return apply_filters( 'portal_si_logo', $logo );
}

/**
 * Imprime o logo como <img>.
 *
 * @param array $args class, alt (vazio = decorativo).
 */
function portal_si_the_logo( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'class' => '',
			'alt'   => '',
		)
	);
	$logo = portal_si_logo();

	printf(
		'<img class="%1$s" src="%2$s" width="%3$d" height="%4$d" alt="%5$s" decoding="async">',
		esc_attr( trim( 'portal-logo ' . $args['class'] ) ),
		esc_url( $logo['url'] ),
		(int) $logo['width'],
		(int) $logo['height'],
		esc_attr( $args['alt'] )
	);
}

/**
 * Ícone da aba: usa o SVG do tema enquanto nenhum "Ícone do site" for definido no painel.
 */
function portal_si_brand_favicon() {
	if ( has_site_icon() ) {
		return;
	}
	$url = get_template_directory_uri() . '/' . PORTAL_SI_LOGO_ICON_FILE;
	printf( '<link rel="icon" type="image/svg+xml" href="%s">' . "\n", esc_url( $url ) );
}
add_action( 'wp_head', 'portal_si_brand_favicon', 5 );
add_action( 'admin_head', 'portal_si_brand_favicon', 5 );
add_action( 'login_head', 'portal_si_brand_favicon', 5 );

/**
 * Tela de login do painel com o logo do curso.
 */
function portal_si_brand_login_logo() {
	$logo = portal_si_logo();
	?>
	<style>
		body.login #login h1 a {
			width: 100%;
			height: 6rem;
			background-image: url("<?php echo esc_url( $logo['url'] ); ?>");
			background-size: contain;
			background-position: center;
		}
	</style>
	<?php
}
add_action( 'login_enqueue_scripts', 'portal_si_brand_login_logo' );

add_filter(
	'login_headerurl',
	static function () {
		return home_url( '/' );
	}
);

add_filter(
	'login_headertext',
	static function () {
		return get_bloginfo( 'name' );
	}
);
