<?php
/**
 * Hub Pesquisa e Extensão — RF11 (parcerias editáveis na página).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const PORTAL_SI_PESQUISA_PARCERIAS_META = '_portal_si_pesquisa_parcerias';

/**
 * Parcerias e convênios cadastrados na página do hub.
 *
 * @return array<int, array{label: string, description: string, url: string}>
 */
function portal_si_pesquisa_parcerias() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_PESQUISA_HUB_SLUG );
	$rows    = $page_id ? get_post_meta( $page_id, PORTAL_SI_PESQUISA_PARCERIAS_META, true ) : array();
	return is_array( $rows ) ? $rows : array();
}

/**
 * Meta box na página do hub.
 *
 * @param string       $post_type Tipo.
 * @param WP_Post|null $post      Post.
 */
function portal_si_pesquisa_hub_add_meta_box( $post_type, $post ) {
	if ( 'page' !== $post_type || ! $post || PORTAL_SI_PESQUISA_HUB_SLUG !== $post->post_name ) {
		return;
	}
	add_meta_box(
		'portal-si-pesquisa-parcerias',
		__( 'Parcerias e convênios', 'portal-si-cefet' ),
		'portal_si_pesquisa_hub_render_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'portal_si_pesquisa_hub_add_meta_box', 10, 2 );

/**
 * @param WP_Post $post Página.
 */
function portal_si_pesquisa_hub_render_meta_box( $post ) {
	wp_nonce_field( 'portal_si_pesquisa_hub_save', 'portal_si_pesquisa_hub_nonce' );
	?>
	<p class="description">
		<?php esc_html_e( 'Uma parceria por linha, no formato: Nome da organização | Descrição curta | https://site (descrição e site são opcionais). Sem nenhuma linha, a página mostra "Conteúdo em breve".', 'portal-si-cefet' ); ?>
	</p>
	<textarea class="large-text code" rows="6" name="portal_si_pesquisa_parcerias" placeholder="<?php esc_attr_e( 'Empresa X | Convênio de estágio e projetos conjuntos | https://empresa.com.br', 'portal-si-cefet' ); ?>"><?php echo esc_textarea( portal_si_link_rows_to_text( portal_si_pesquisa_parcerias() ) ); ?></textarea>
	<p class="description">
		<?php esc_html_e( 'Os projetos de pesquisa e de extensão da página vêm do menu "Projetos P&E".', 'portal-si-cefet' ); ?>
	</p>
	<?php
}

/**
 * @param int $post_id ID da página.
 */
function portal_si_pesquisa_hub_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['portal_si_pesquisa_hub_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_pesquisa_hub_nonce'] ) ), 'portal_si_pesquisa_hub_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	$post = get_post( $post_id );
	if ( ! $post || PORTAL_SI_PESQUISA_HUB_SLUG !== $post->post_name ) {
		return;
	}
	$raw = isset( $_POST['portal_si_pesquisa_parcerias'] ) ? sanitize_textarea_field( wp_unslash( $_POST['portal_si_pesquisa_parcerias'] ) ) : '';
	update_post_meta( $post_id, PORTAL_SI_PESQUISA_PARCERIAS_META, portal_si_text_to_link_rows( $raw ) );
}
add_action( 'save_post_page', 'portal_si_pesquisa_hub_save_meta_box' );
