<?php
/**
 * CPT Projetos da Fábrica — portfólio RF14 editável no wp-admin.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const PORTAL_SI_FABRICA_PROJETO_POST_TYPE = 'portal_fs_projeto';
const PORTAL_SI_FABRICA_PROJETO_TECH_META  = '_portal_fabrica_projeto_technologies';
const PORTAL_SI_FABRICA_PROJETO_STUDENTS_META = '_portal_fabrica_projeto_students';
const PORTAL_SI_FABRICA_PROJETO_RESULT_META   = '_portal_fabrica_projeto_result';
const PORTAL_SI_FABRICA_PROJETO_YEAR_META     = '_portal_fabrica_projeto_year';
const PORTAL_SI_FABRICA_PROJETO_LINK_META     = '_portal_fabrica_projeto_presentation_url';
const PORTAL_SI_FABRICA_PROJETO_SEED_OPTION   = 'portal_si_fabrica_projetos_seeded_v1';

/**
 * Registra CPT.
 */
function portal_si_register_fabrica_projeto_cpt() {
	register_post_type(
		PORTAL_SI_FABRICA_PROJETO_POST_TYPE,
		array(
			'labels'              => array(
				'name'               => __( 'Projetos da Fábrica', 'portal-si-cefet' ),
				'singular_name'      => __( 'Projeto da Fábrica', 'portal-si-cefet' ),
				'add_new'            => __( 'Adicionar projeto', 'portal-si-cefet' ),
				'add_new_item'       => __( 'Adicionar novo projeto', 'portal-si-cefet' ),
				'edit_item'          => __( 'Editar projeto', 'portal-si-cefet' ),
				'new_item'           => __( 'Novo projeto', 'portal-si-cefet' ),
				'view_item'          => __( 'Ver no site', 'portal-si-cefet' ),
				'search_items'       => __( 'Buscar projetos', 'portal-si-cefet' ),
				'not_found'          => __( 'Nenhum projeto cadastrado.', 'portal-si-cefet' ),
				'not_found_in_trash' => __( 'Nenhum projeto na lixeira.', 'portal-si-cefet' ),
				'menu_name'          => __( 'Projetos Fábrica', 'portal-si-cefet' ),
			),
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-portfolio',
			'menu_position'       => 28,
			'has_archive'         => false,
			'query_var'           => false,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'show_in_rest'        => true,
			'capability_type'     => 'post',
		)
	);
}
add_action( 'init', 'portal_si_register_fabrica_projeto_cpt' );

/**
 * Corrige posts criados com slug inválido (> 20 caracteres) da versão anterior.
 */
function portal_si_fabrica_migrate_legacy_post_type() {
	if ( get_option( 'portal_si_fabrica_cpt_migrated_v2' ) ) {
		return;
	}

	global $wpdb;
	$legacy = 'portal_fabrica_projeto';
	$count  = (int) $wpdb->get_var(
		$wpdb->prepare(
			"SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = %s",
			$legacy
		)
	);

	if ( $count > 0 ) {
		$wpdb->update(
			$wpdb->posts,
			array( 'post_type' => PORTAL_SI_FABRICA_PROJETO_POST_TYPE ),
			array( 'post_type' => $legacy ),
			array( '%s' ),
			array( '%s' )
		);
	}

	update_option( 'portal_si_fabrica_cpt_migrated_v2', 1 );
}
add_action( 'init', 'portal_si_fabrica_migrate_legacy_post_type', 5 );

/**
 * Meta box do projeto.
 */
function portal_si_fabrica_projeto_add_meta_boxes( $post_type, $post = null ) {
	if ( PORTAL_SI_FABRICA_PROJETO_POST_TYPE !== $post_type ) {
		return;
	}

	add_meta_box(
		'portal-fabrica-projeto-details',
		__( 'Detalhes do projeto', 'portal-si-cefet' ),
		'portal_si_fabrica_projeto_render_meta_box',
		PORTAL_SI_FABRICA_PROJETO_POST_TYPE,
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'portal_si_fabrica_projeto_add_meta_boxes', 10, 2 );

/**
 * @param WP_Post $post Post.
 */
function portal_si_fabrica_projeto_render_meta_box( $post ) {
	wp_nonce_field( 'portal_si_fabrica_projeto_save', 'portal_si_fabrica_projeto_nonce' );

	$tech = get_post_meta( $post->ID, PORTAL_SI_FABRICA_PROJETO_TECH_META, true );
	$students = get_post_meta( $post->ID, PORTAL_SI_FABRICA_PROJETO_STUDENTS_META, true );
	$result = get_post_meta( $post->ID, PORTAL_SI_FABRICA_PROJETO_RESULT_META, true );
	$year = get_post_meta( $post->ID, PORTAL_SI_FABRICA_PROJETO_YEAR_META, true );
	$link = get_post_meta( $post->ID, PORTAL_SI_FABRICA_PROJETO_LINK_META, true );
	?>
	<p class="description">
		<?php esc_html_e( 'Título = nome do projeto. O editor abaixo = descrição. Resumo (excerpt) é opcional. Imagem destacada aparece no card, se enviada.', 'portal-si-cefet' ); ?>
	</p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="portal_fabrica_projeto_year"><?php esc_html_e( 'Ano / turma', 'portal-si-cefet' ); ?></label></th>
			<td><input type="text" class="regular-text" id="portal_fabrica_projeto_year" name="portal_fabrica_projeto_year" value="<?php echo esc_attr( (string) $year ); ?>" placeholder="2025" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_fabrica_projeto_technologies"><?php esc_html_e( 'Tecnologias', 'portal-si-cefet' ); ?></label></th>
			<td><input type="text" class="large-text" id="portal_fabrica_projeto_technologies" name="portal_fabrica_projeto_technologies" value="<?php echo esc_attr( (string) $tech ); ?>" placeholder="PHP, React, PostgreSQL" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_fabrica_projeto_students"><?php esc_html_e( 'Equipe (alunos)', 'portal-si-cefet' ); ?></label></th>
			<td><input type="text" class="large-text" id="portal_fabrica_projeto_students" name="portal_fabrica_projeto_students" value="<?php echo esc_attr( (string) $students ); ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_fabrica_projeto_result"><?php esc_html_e( 'Entrega / resultado', 'portal-si-cefet' ); ?></label></th>
			<td><textarea class="large-text" rows="3" id="portal_fabrica_projeto_result" name="portal_fabrica_projeto_result"><?php echo esc_textarea( (string) $result ); ?></textarea></td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_fabrica_projeto_presentation_url"><?php esc_html_e( 'Link da solução ou apresentação', 'portal-si-cefet' ); ?></label></th>
			<td>
				<input type="url" class="large-text" id="portal_fabrica_projeto_presentation_url" name="portal_fabrica_projeto_presentation_url" value="<?php echo esc_attr( (string) $link ); ?>" placeholder="https://…" />
				<p class="description"><?php esc_html_e( 'Demo online, slides, repositório ou vídeo da apresentação.', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
	</table>
	<p class="description"><?php esc_html_e( 'Ordem na página: campo «Ordem» em Atributos da página.', 'portal-si-cefet' ); ?></p>
	<?php
}

/**
 * @param int $post_id ID.
 */
function portal_si_fabrica_projeto_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['portal_si_fabrica_projeto_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_fabrica_projeto_nonce'] ) ), 'portal_si_fabrica_projeto_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( PORTAL_SI_FABRICA_PROJETO_POST_TYPE !== get_post_type( $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, PORTAL_SI_FABRICA_PROJETO_YEAR_META, isset( $_POST['portal_fabrica_projeto_year'] ) ? sanitize_text_field( wp_unslash( $_POST['portal_fabrica_projeto_year'] ) ) : '' );
	update_post_meta( $post_id, PORTAL_SI_FABRICA_PROJETO_TECH_META, isset( $_POST['portal_fabrica_projeto_technologies'] ) ? sanitize_text_field( wp_unslash( $_POST['portal_fabrica_projeto_technologies'] ) ) : '' );
	update_post_meta( $post_id, PORTAL_SI_FABRICA_PROJETO_STUDENTS_META, isset( $_POST['portal_fabrica_projeto_students'] ) ? sanitize_text_field( wp_unslash( $_POST['portal_fabrica_projeto_students'] ) ) : '' );
	update_post_meta( $post_id, PORTAL_SI_FABRICA_PROJETO_RESULT_META, isset( $_POST['portal_fabrica_projeto_result'] ) ? sanitize_textarea_field( wp_unslash( $_POST['portal_fabrica_projeto_result'] ) ) : '' );
	update_post_meta( $post_id, PORTAL_SI_FABRICA_PROJETO_LINK_META, isset( $_POST['portal_fabrica_projeto_presentation_url'] ) ? esc_url_raw( wp_unslash( $_POST['portal_fabrica_projeto_presentation_url'] ) ) : '' );
}
add_action( 'save_post_' . PORTAL_SI_FABRICA_PROJETO_POST_TYPE, 'portal_si_fabrica_projeto_save_meta_box' );

/**
 * @param int|WP_Post|null $post Post.
 * @return array<string, mixed>|null
 */
function portal_si_fabrica_projeto_to_array( $post ) {
	$post = get_post( $post );
	if ( ! $post || PORTAL_SI_FABRICA_PROJETO_POST_TYPE !== $post->post_type || 'publish' !== $post->post_status ) {
		return null;
	}

	$description = $post->post_content ? wp_strip_all_tags( $post->post_content ) : '';
	if ( ! $description && has_excerpt( $post ) ) {
		$description = get_the_excerpt( $post );
	}

	$thumb_id = get_post_thumbnail_id( $post->ID );
	$photo    = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'medium' ) : '';

	return array(
		'id'               => (int) $post->ID,
		'name'             => get_the_title( $post ),
		'description'      => $description,
		'technologies'     => (string) get_post_meta( $post->ID, PORTAL_SI_FABRICA_PROJETO_TECH_META, true ),
		'students'         => (string) get_post_meta( $post->ID, PORTAL_SI_FABRICA_PROJETO_STUDENTS_META, true ),
		'result'           => (string) get_post_meta( $post->ID, PORTAL_SI_FABRICA_PROJETO_RESULT_META, true ),
		'year'             => (string) get_post_meta( $post->ID, PORTAL_SI_FABRICA_PROJETO_YEAR_META, true ),
		'presentation_url' => (string) get_post_meta( $post->ID, PORTAL_SI_FABRICA_PROJETO_LINK_META, true ),
		'photo_url'        => $photo ? (string) $photo : '',
	);
}

/**
 * Projetos publicados (ordenados).
 *
 * @return array<int, array<string, mixed>>
 */
function portal_si_get_fabrica_projetos() {
	$query = new WP_Query(
		array(
			'post_type'      => PORTAL_SI_FABRICA_PROJETO_POST_TYPE,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'no_found_rows'  => true,
		)
	);

	$out = array();
	foreach ( $query->posts as $post ) {
		$row = portal_si_fabrica_projeto_to_array( $post );
		if ( $row ) {
			$out[] = $row;
		}
	}
	wp_reset_postdata();

	return $out;
}

/**
 * Importa exemplos do data/ como rascunhos (uma vez), se não houver projetos.
 */
function portal_si_fabrica_maybe_seed_projetos() {
	if ( get_option( PORTAL_SI_FABRICA_PROJETO_SEED_OPTION ) ) {
		return;
	}

	$existing = get_posts(
		array(
			'post_type'      => PORTAL_SI_FABRICA_PROJETO_POST_TYPE,
			'post_status'    => array( 'publish', 'draft', 'pending' ),
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	if ( ! empty( $existing ) ) {
		update_option( PORTAL_SI_FABRICA_PROJETO_SEED_OPTION, 1 );
		return;
	}

	if ( ! function_exists( 'portal_si_fabrica_portfolio_items_from_data' ) ) {
		return;
	}

	$items = portal_si_fabrica_portfolio_items_from_data();
	foreach ( $items as $index => $item ) {
		$post_id = wp_insert_post(
			array(
				'post_type'    => PORTAL_SI_FABRICA_PROJETO_POST_TYPE,
				'post_status'  => 'draft',
				'post_title'   => $item['name'],
				'post_content' => $item['description'],
				'menu_order'   => $index,
			),
			true
		);
		if ( is_wp_error( $post_id ) || ! $post_id ) {
			continue;
		}
		update_post_meta( $post_id, PORTAL_SI_FABRICA_PROJETO_TECH_META, $item['technologies'] );
		update_post_meta( $post_id, PORTAL_SI_FABRICA_PROJETO_STUDENTS_META, $item['students'] );
		update_post_meta( $post_id, PORTAL_SI_FABRICA_PROJETO_RESULT_META, $item['result'] );
		update_post_meta( $post_id, PORTAL_SI_FABRICA_PROJETO_YEAR_META, $item['year'] );
	}

	update_option( PORTAL_SI_FABRICA_PROJETO_SEED_OPTION, 1 );
}
add_action( 'init', 'portal_si_fabrica_maybe_seed_projetos', 20 );

/**
 * Link «Adicionar projeto» no admin.
 */
function portal_si_fabrica_projeto_list_notice() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'edit-' . PORTAL_SI_FABRICA_PROJETO_POST_TYPE !== $screen->id ) {
		return;
	}
	$page_url = get_edit_post_link( portal_si_get_page_id_by_slug( PORTAL_SI_FABRICA_SLUG ), '' );
	if ( $page_url ) {
		echo '<div class="notice notice-info"><p>';
		printf(
			/* translators: %s: URL da página pública */
			esc_html__( 'Os projetos publicados aparecem em %s.', 'portal-si-cefet' ),
			'<a href="' . esc_url( get_permalink( portal_si_get_page_id_by_slug( PORTAL_SI_FABRICA_SLUG ) ) ) . '" target="_blank" rel="noopener">' . esc_html__( 'Fábrica de Software → Projetos desenvolvidos', 'portal-si-cefet' ) . '</a>'
		);
		echo '</p></div>';
	}
}
add_action( 'admin_notices', 'portal_si_fabrica_projeto_list_notice' );
