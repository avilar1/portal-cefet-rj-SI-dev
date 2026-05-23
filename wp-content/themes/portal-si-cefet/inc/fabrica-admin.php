<?php
/**
 * Fábrica de Software — meta boxes na página (resumo, e-mail parceria).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTAL_SI_FABRICA_PAGE_EMAIL_META', '_portal_si_fabrica_partner_email' );
define( 'PORTAL_SI_FABRICA_PAGE_PORTFOLIO_INTRO_META', '_portal_si_fabrica_portfolio_intro' );

/**
 * Meta box na página Fábrica de Software.
 *
 * @param string  $post_type Tipo.
 * @param WP_Post $post      Post.
 */
function portal_si_fabrica_page_add_meta_boxes( $post_type, $post ) {
	if ( 'page' !== $post_type || ! $post instanceof WP_Post || PORTAL_SI_FABRICA_SLUG !== $post->post_name ) {
		return;
	}

	add_meta_box(
		'portal-fabrica-page-settings',
		__( 'Portal — Fábrica de Software', 'portal-si-cefet' ),
		'portal_si_fabrica_page_render_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'portal_si_fabrica_page_add_meta_boxes', 10, 2 );

/**
 * Só mostra na página correta.
 *
 * @param WP_Post|null $post Post.
 */
function portal_si_fabrica_page_render_meta_box( $post ) {
	if ( ! $post || PORTAL_SI_FABRICA_SLUG !== $post->post_name ) {
		return;
	}

	wp_nonce_field( 'portal_si_fabrica_page_save', 'portal_si_fabrica_page_nonce' );

	$intro = $post->post_excerpt;
	$email = get_post_meta( $post->ID, PORTAL_SI_FABRICA_PAGE_EMAIL_META, true );
	$portfolio_intro = get_post_meta( $post->ID, PORTAL_SI_FABRICA_PAGE_PORTFOLIO_INTRO_META, true );

	$projects_url = admin_url( 'edit.php?post_type=' . PORTAL_SI_FABRICA_PROJETO_POST_TYPE );
	$add_url      = admin_url( 'post-new.php?post_type=' . PORTAL_SI_FABRICA_PROJETO_POST_TYPE );
	?>
	<div class="portal-fabrica-admin-panel">
		<p><strong><?php esc_html_e( 'Projetos desenvolvidos (portfólio)', 'portal-si-cefet' ); ?></strong></p>
		<p>
			<?php esc_html_e( 'Cadastre cada projeto em Projetos Fábrica — não use o editor de blocos abaixo para a listagem.', 'portal-si-cefet' ); ?>
		</p>
		<p>
			<a class="button button-primary" href="<?php echo esc_url( $add_url ); ?>"><?php esc_html_e( 'Adicionar projeto', 'portal-si-cefet' ); ?></a>
			<a class="button" href="<?php echo esc_url( $projects_url ); ?>"><?php esc_html_e( 'Ver todos os projetos', 'portal-si-cefet' ); ?></a>
		</p>
		<hr />
		<table class="form-table">
			<tr>
				<th scope="row"><label for="portal_fabrica_page_intro"><?php esc_html_e( 'Resumo da página', 'portal-si-cefet' ); ?></label></th>
				<td>
					<textarea class="large-text" rows="3" id="portal_fabrica_page_intro" name="portal_fabrica_page_intro"><?php echo esc_textarea( $intro ); ?></textarea>
					<p class="description"><?php esc_html_e( 'Parágrafo introdutório abaixo do título na página pública.', 'portal-si-cefet' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="portal_fabrica_portfolio_intro"><?php esc_html_e( 'Intro do portfólio', 'portal-si-cefet' ); ?></label></th>
				<td>
					<textarea class="large-text" rows="2" id="portal_fabrica_portfolio_intro" name="portal_fabrica_portfolio_intro"><?php echo esc_textarea( (string) $portfolio_intro ); ?></textarea>
					<p class="description"><?php esc_html_e( 'Texto acima da lista de projetos. Se vazio, usa o texto padrão do tema.', 'portal-si-cefet' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="portal_fabrica_partner_email"><?php esc_html_e( 'E-mail para parcerias', 'portal-si-cefet' ); ?></label></th>
				<td>
					<input type="email" class="regular-text" id="portal_fabrica_partner_email" name="portal_fabrica_partner_email" value="<?php echo esc_attr( (string) $email ); ?>" />
					<p class="description"><?php esc_html_e( 'Aparece como botão na faixa «Quer propor um projeto?».', 'portal-si-cefet' ); ?></p>
				</td>
			</tr>
		</table>
		<p class="description">
			<?php esc_html_e( 'Missão, metodologia, equipe e parceria continuam no ficheiro data/fabrica-software.php (deploy técnico) até nova versão com edição completa no painel.', 'portal-si-cefet' ); ?>
		</p>
	</div>
	<?php
}

/**
 * @param int $post_id ID.
 */
function portal_si_fabrica_page_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['portal_si_fabrica_page_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_fabrica_page_nonce'] ) ), 'portal_si_fabrica_page_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( 'page' !== get_post_type( $post_id ) ) {
		return;
	}
	if ( PORTAL_SI_FABRICA_SLUG !== get_post_field( 'post_name', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['portal_fabrica_page_intro'] ) ) {
		wp_update_post(
			array(
				'ID'           => $post_id,
				'post_excerpt' => sanitize_textarea_field( wp_unslash( $_POST['portal_fabrica_page_intro'] ) ),
			)
		);
	}

	update_post_meta(
		$post_id,
		PORTAL_SI_FABRICA_PAGE_EMAIL_META,
		isset( $_POST['portal_fabrica_partner_email'] ) ? sanitize_email( wp_unslash( $_POST['portal_fabrica_partner_email'] ) ) : ''
	);
	update_post_meta(
		$post_id,
		PORTAL_SI_FABRICA_PAGE_PORTFOLIO_INTRO_META,
		isset( $_POST['portal_fabrica_portfolio_intro'] ) ? sanitize_textarea_field( wp_unslash( $_POST['portal_fabrica_portfolio_intro'] ) ) : ''
	);
}
add_action( 'save_post_page', 'portal_si_fabrica_page_save_meta_box' );

/**
 * Intro do portfólio (página ou data).
 *
 * @return string
 */
function portal_si_fabrica_portfolio_intro_text() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_FABRICA_SLUG );
	if ( $page_id ) {
		$custom = get_post_meta( $page_id, PORTAL_SI_FABRICA_PAGE_PORTFOLIO_INTRO_META, true );
		if ( is_string( $custom ) && '' !== trim( $custom ) ) {
			return trim( $custom );
		}
	}

	$config = portal_si_fabrica_config();
	$block  = isset( $config['portfolio'] ) && is_array( $config['portfolio'] ) ? $config['portfolio'] : array();
	return isset( $block['intro'] ) ? (string) $block['intro'] : '';
}

/**
 * E-mail de parceria (página ou data).
 *
 * @return string
 */
function portal_si_fabrica_partner_email() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_FABRICA_SLUG );
	if ( $page_id ) {
		$email = get_post_meta( $page_id, PORTAL_SI_FABRICA_PAGE_EMAIL_META, true );
		if ( is_email( $email ) ) {
			return $email;
		}
	}

	$cta = portal_si_fabrica_partner_cta();
	return isset( $cta['email'] ) ? trim( (string) $cta['email'] ) : '';
}
