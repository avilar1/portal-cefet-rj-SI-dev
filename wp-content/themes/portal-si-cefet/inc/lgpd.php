<?php
/**
 * LGPD — cookies, privacidade e formulário de contato (RNF07, RN10).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_PRIVACIDADE_SLUG', 'politica-de-privacidade' );
define( 'PORTAL_SI_PRIVACIDADE_SEEDED_OPTION', 'portal_si_privacidade_seeded_v2' );
define( 'PORTAL_SI_CONTATO_FORM_ACTION', 'portal_si_contato_form' );

/**
 * Conteúdo inicial da Política de Privacidade (linguagem simples).
 *
 * @return string
 */
function portal_si_privacidade_default_content() {
	ob_start();
	?>
	<h2><?php esc_html_e( 'Quem somos', 'portal-si-cefet' ); ?></h2>
	<p><?php esc_html_e( 'Este portal é mantido pela coordenação do curso de Bacharelado em Sistemas de Informação do CEFET/RJ — Campus Maria da Graça.', 'portal-si-cefet' ); ?></p>

	<h2><?php esc_html_e( 'Quais dados podemos receber', 'portal-si-cefet' ); ?></h2>
	<p><?php esc_html_e( 'Se você usar o formulário de contato, recebemos apenas o que você digitar: nome, e-mail, assunto e mensagem.', 'portal-si-cefet' ); ?></p>

	<h2><?php esc_html_e( 'Para que usamos seus dados', 'portal-si-cefet' ); ?></h2>
	<p><?php esc_html_e( 'Usamos essas informações somente para responder sua mensagem. Não vendemos nem compartilhamos seus dados com fins comerciais.', 'portal-si-cefet' ); ?></p>

	<h2><?php esc_html_e( 'Cookies', 'portal-si-cefet' ); ?></h2>
	<p><?php esc_html_e( 'Cookies são pequenos arquivos guardados no seu navegador. Este portal usa:', 'portal-si-cefet' ); ?></p>
	<ul>
		<li><?php esc_html_e( 'Cookies necessários — para o site funcionar (por exemplo, lembrar se você aceitou ou recusou cookies).', 'portal-si-cefet' ); ?></li>
		<li><?php esc_html_e( 'Preferência de alto contraste — guardada no seu aparelho, se você ativar essa opção.', 'portal-si-cefet' ); ?></li>
	</ul>
	<p><?php esc_html_e( 'Nesta versão de demonstração não usamos cookies de publicidade ou rastreamento. Se recusar cookies opcionais, a navegação continua normalmente.', 'portal-si-cefet' ); ?></p>

	<h2><?php esc_html_e( 'Seus direitos', 'portal-si-cefet' ); ?></h2>
	<p><?php esc_html_e( 'Você pode pedir informações, correção ou exclusão dos seus dados entrando em contato com a coordenação do curso pela página Contato deste portal.', 'portal-si-cefet' ); ?></p>

	<h2><?php esc_html_e( 'Contato do responsável', 'portal-si-cefet' ); ?></h2>
	<p>
		<?php
		echo wp_kses_post(
			sprintf(
				/* translators: %s: link to contact page */
				__( 'Dúvidas sobre privacidade: use a %s ou os canais oficiais da coordenação.', 'portal-si-cefet' ),
				'<a href="' . esc_url( portal_si_page_url( 'contato' ) ) . '">' . esc_html__( 'página de Contato', 'portal-si-cefet' ) . '</a>'
			)
		);
		?>
	</p>
	<?php
	return ob_get_clean();
}

/**
 * Verifica se a página já tem o texto padrão do tema.
 *
 * @param WP_Post|null $post Post.
 * @return bool
 */
function portal_si_privacidade_page_has_theme_content( $post ) {
	if ( ! $post instanceof WP_Post ) {
		return false;
	}

	return false !== strpos( (string) $post->post_content, 'Quem somos' );
}

/**
 * Páginas candidatas (slug canônico ou sufixos -2, -3…).
 *
 * @return int[]
 */
function portal_si_privacidade_collect_page_ids() {
	$all = get_posts(
		array(
			'post_type'              => 'page',
			'post_status'            => array( 'publish', 'draft', 'private' ),
			'posts_per_page'         => 50,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'orderby'                => 'ID',
			'order'                  => 'ASC',
		)
	);

	$prefix = PORTAL_SI_PRIVACIDADE_SLUG;
	$ids    = array();

	foreach ( $all as $post ) {
		if ( ! $post instanceof WP_Post ) {
			continue;
		}
		if ( $post->post_name === $prefix || 0 === strpos( $post->post_name, $prefix . '-' ) ) {
			$ids[] = (int) $post->ID;
		}
	}

	return $ids;
}

/**
 * Resolve a página publicada de Política de Privacidade do portal.
 *
 * @return int|null
 */
function portal_si_privacidade_resolve_page_id() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_PRIVACIDADE_SLUG );
	if ( $page_id ) {
		return $page_id;
	}

	$candidates = portal_si_privacidade_collect_page_ids();
	$best_id    = null;
	$best_score = -1;

	foreach ( $candidates as $candidate_id ) {
		$post = get_post( $candidate_id );
		if ( ! $post instanceof WP_Post || 'publish' !== $post->post_status ) {
			continue;
		}

		$score = 0;
		if ( portal_si_privacidade_page_has_theme_content( $post ) ) {
			$score += 100;
		} elseif ( portal_si_post_has_meaningful_content( $post ) ) {
			$score += 10;
		}
		if ( PORTAL_SI_PRIVACIDADE_SLUG === $post->post_name ) {
			$score += 50;
		}

		if ( $score > $best_score ) {
			$best_score = $score;
			$best_id    = $candidate_id;
		}
	}

	return $best_id ? $best_id : null;
}

/**
 * Remove rascunho padrão do WordPress que bloqueia o slug canônico.
 */
function portal_si_privacidade_clear_wp_draft_blocker() {
	$query = new WP_Query(
		array(
			'name'           => PORTAL_SI_PRIVACIDADE_SLUG,
			'post_type'      => 'page',
			'post_status'    => 'draft',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
		)
	);

	if ( ! $query->have_posts() ) {
		return;
	}

	$post = $query->posts[0];
	if ( ! $post instanceof WP_Post ) {
		return;
	}

	$policy_page = (int) get_option( 'wp_page_for_privacy_policy' );
	if ( $policy_page === (int) $post->ID || false !== strpos( (string) $post->post_content, 'privacy-policy-tutorial' ) ) {
		if ( $policy_page === (int) $post->ID ) {
			update_option( 'wp_page_for_privacy_policy', 0 );
		}
		wp_trash_post( (int) $post->ID );
	}
}

/**
 * Seed e consolidação da página Política de Privacidade.
 */
function portal_si_seed_privacidade_page() {
	if ( get_option( PORTAL_SI_PRIVACIDADE_SEEDED_OPTION ) ) {
		return;
	}

	portal_si_privacidade_clear_wp_draft_blocker();

	$page_id = portal_si_privacidade_resolve_page_id();
	if ( ! $page_id ) {
		$page_id = portal_si_ensure_page(
			__( 'Política de Privacidade', 'portal-si-cefet' ),
			PORTAL_SI_PRIVACIDADE_SLUG
		);
	}

	if ( ! $page_id ) {
		return;
	}

	$page = get_post( $page_id );
	if ( ! $page instanceof WP_Post ) {
		return;
	}

	if ( PORTAL_SI_PRIVACIDADE_SLUG !== $page->post_name ) {
		wp_update_post(
			array(
				'ID'        => $page_id,
				'post_name' => PORTAL_SI_PRIVACIDADE_SLUG,
			)
		);
	}

	if ( ! portal_si_privacidade_page_has_theme_content( $page ) ) {
		wp_update_post(
			array(
				'ID'           => $page_id,
				'post_content' => portal_si_privacidade_default_content(),
			)
		);
	}

	foreach ( portal_si_privacidade_collect_page_ids() as $duplicate_id ) {
		if ( (int) $duplicate_id === (int) $page_id ) {
			continue;
		}
		$duplicate = get_post( $duplicate_id );
		if ( ! $duplicate instanceof WP_Post || 'publish' !== $duplicate->post_status ) {
			continue;
		}
		if ( ! portal_si_post_has_meaningful_content( $duplicate ) ) {
			wp_trash_post( (int) $duplicate_id );
		}
	}

	update_option( 'wp_page_for_privacy_policy', (int) $page_id );
	update_option( PORTAL_SI_PRIVACIDADE_SEEDED_OPTION, 1 );
}
add_action( 'after_setup_theme', 'portal_si_seed_privacidade_page', 27 );

/**
 * E-mail destino do formulário de contato.
 *
 * @return string
 */
function portal_si_contato_form_recipient() {
	if ( function_exists( 'portal_si_contato_coordination' ) ) {
		$coord = portal_si_contato_coordination();
		$people = isset( $coord['people'] ) && is_array( $coord['people'] ) ? $coord['people'] : array();
		foreach ( $people as $person ) {
			if ( ! empty( $person['email'] ) && is_email( $person['email'] ) ) {
				return (string) $person['email'];
			}
		}
	}
	return get_option( 'admin_email' );
}

/**
 * Assuntos do formulário.
 *
 * @return array<string, string>
 */
function portal_si_contato_form_subjects() {
	return array(
		'duvida'   => __( 'Dúvida sobre o curso', 'portal-si-cefet' ),
		'parceria' => __( 'Parceria — Fábrica de Software', 'portal-si-cefet' ),
		'outro'    => __( 'Outro assunto', 'portal-si-cefet' ),
	);
}

/**
 * Processa envio do formulário (POST → redirect).
 */
function portal_si_contato_handle_form_submission() {
	if ( ! is_page( PORTAL_SI_CONTATO_SLUG ) ) {
		return;
	}
	if ( 'POST' !== ( isset( $_SERVER['REQUEST_METHOD'] ) ? $_SERVER['REQUEST_METHOD'] : '' ) ) {
		return;
	}
	if ( empty( $_POST['portal_si_contato_form'] ) ) {
		return;
	}

	if ( ! isset( $_POST['portal_si_contato_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_contato_nonce'] ) ), PORTAL_SI_CONTATO_FORM_ACTION ) ) {
		wp_safe_redirect( add_query_arg( 'contato', 'erro-seguranca', portal_si_page_url( PORTAL_SI_CONTATO_SLUG ) . '#formulario-contato' ) );
		exit;
	}

	$name    = isset( $_POST['portal_si_nome'] ) ? sanitize_text_field( wp_unslash( $_POST['portal_si_nome'] ) ) : '';
	$email   = isset( $_POST['portal_si_email'] ) ? sanitize_email( wp_unslash( $_POST['portal_si_email'] ) ) : '';
	$subject = isset( $_POST['portal_si_assunto'] ) ? sanitize_key( wp_unslash( $_POST['portal_si_assunto'] ) ) : '';
	$message = isset( $_POST['portal_si_mensagem'] ) ? sanitize_textarea_field( wp_unslash( $_POST['portal_si_mensagem'] ) ) : '';
	$consent = ! empty( $_POST['portal_si_consent'] );

	$subjects = portal_si_contato_form_subjects();
	$errors   = array();

	if ( '' === $name ) {
		$errors[] = 'nome';
	}
	if ( ! is_email( $email ) ) {
		$errors[] = 'email';
	}
	if ( ! isset( $subjects[ $subject ] ) ) {
		$errors[] = 'assunto';
	}
	if ( strlen( $message ) < 10 ) {
		$errors[] = 'mensagem';
	}
	if ( ! $consent ) {
		$errors[] = 'consent';
	}

	if ( ! empty( $errors ) ) {
		wp_safe_redirect(
			add_query_arg(
				array(
					'contato' => 'erro',
					'campos'  => implode( ',', $errors ),
				),
				portal_si_page_url( PORTAL_SI_CONTATO_SLUG ) . '#formulario-contato'
			)
		);
		exit;
	}

	$ref = 'SI-' . wp_date( 'Ymd' ) . '-' . strtoupper( substr( wp_generate_password( 6, false, false ), 0, 6 ) );

	$body  = sprintf( "Referência: %s\n\n", $ref );
	$body .= sprintf( "Nome: %s\n", $name );
	$body .= sprintf( "E-mail: %s\n", $email );
	$body .= sprintf( "Assunto: %s\n\n", $subjects[ $subject ] );
	$body .= sprintf( "Mensagem:\n%s\n", $message );

	$sent = wp_mail(
		portal_si_contato_form_recipient(),
		sprintf( '[Portal SI] %s — %s', $ref, $subjects[ $subject ] ),
		$body,
		array(
			'Content-Type: text/plain; charset=UTF-8',
			'Reply-To: ' . $name . ' <' . $email . '>',
		)
	);

	wp_safe_redirect(
		add_query_arg(
			array(
				'contato' => $sent ? 'ok' : 'ok-demo',
				'ref'     => rawurlencode( $ref ),
			),
			portal_si_page_url( PORTAL_SI_CONTATO_SLUG ) . '#formulario-contato'
		)
	);
	exit;
}
add_action( 'template_redirect', 'portal_si_contato_handle_form_submission', 5 );

/**
 * Estado do formulário após redirect.
 *
 * @return array<string, mixed>
 */
function portal_si_contato_form_flash() {
	$status = isset( $_GET['contato'] ) ? sanitize_key( wp_unslash( $_GET['contato'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	if ( '' === $status ) {
		return array();
	}

	$flash = array( 'status' => $status );

	if ( isset( $_GET['ref'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$flash['ref'] = sanitize_text_field( wp_unslash( $_GET['ref'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	}
	if ( isset( $_GET['campos'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$flash['campos'] = sanitize_text_field( wp_unslash( $_GET['campos'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	}

	return $flash;
}

/**
 * Banner de cookies no rodapé da página.
 */
function portal_si_render_cookie_banner() {
	get_template_part( 'template-parts/global/cookie-banner' );
}
add_action( 'wp_footer', 'portal_si_render_cookie_banner', 5 );

/**
 * Assets LGPD + strings JS.
 */
function portal_si_lgpd_enqueue_assets() {
	wp_enqueue_style(
		'portal-si-lgpd',
		get_template_directory_uri() . '/assets/css/lgpd.css',
		array( 'portal-si-a11y' ),
		PORTAL_SI_CEFET_VERSION
	);

	wp_enqueue_script(
		'portal-si-cookies',
		get_template_directory_uri() . '/assets/js/cookies.js',
		array(),
		PORTAL_SI_CEFET_VERSION,
		true
	);

	wp_localize_script(
		'portal-si-cookies',
		'portalSiCookies',
		array(
			'storageKey'   => 'portal-cookie-consent',
			'accepted'     => 'accepted',
			'rejected'     => 'rejected',
			'ariaHidden'   => __( 'Aviso de cookies', 'portal-si-cefet' ),
			'prefsLabel'   => __( 'Preferências de cookies', 'portal-si-cefet' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'portal_si_lgpd_enqueue_assets', 22 );
