<?php
/**
 * Corpo docente — CPT Professor (RF08). Importação por planilha (RF12) futura.
 *
 * Campos mínimos: nome (título), foto (imagem destacada), Lattes.
 * Opcionais: formação, biografia, linhas de pesquisa — só aparecem no site se preenchidos.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const PORTAL_SI_PROFESSOR_POST_TYPE = 'portal_professor';
const PORTAL_SI_CORPO_DOCENTE_SLUG  = 'corpo-docente';

const PORTAL_SI_PROFESSOR_LATTES_META   = '_portal_professor_lattes';
const PORTAL_SI_PROFESSOR_FORMATION_META = '_portal_professor_formation';
const PORTAL_SI_PROFESSOR_BIO_META      = '_portal_professor_biography';
const PORTAL_SI_PROFESSOR_LINES_META    = '_portal_professor_research_lines';

/**
 * Registra CPT Professor.
 */
function portal_si_register_professor_cpt() {
	register_post_type(
		PORTAL_SI_PROFESSOR_POST_TYPE,
		array(
			'labels'              => array(
				'name'               => __( 'Professores', 'portal-si-cefet' ),
				'singular_name'      => __( 'Professor', 'portal-si-cefet' ),
				'add_new'            => __( 'Adicionar professor', 'portal-si-cefet' ),
				'add_new_item'       => __( 'Adicionar novo professor', 'portal-si-cefet' ),
				'edit_item'          => __( 'Editar professor', 'portal-si-cefet' ),
				'new_item'           => __( 'Novo professor', 'portal-si-cefet' ),
				'view_item'          => __( 'Ver perfil público', 'portal-si-cefet' ),
				'search_items'       => __( 'Buscar professores', 'portal-si-cefet' ),
				'not_found'          => __( 'Nenhum professor encontrado.', 'portal-si-cefet' ),
				'not_found_in_trash' => __( 'Nenhum professor na lixeira.', 'portal-si-cefet' ),
				'menu_name'          => __( 'Professores', 'portal-si-cefet' ),
			),
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-groups',
			'menu_position'       => 27,
			'has_archive'         => false,
			'query_var'           => true,
			'rewrite'             => array(
				'slug'       => 'professor',
				'with_front' => false,
			),
			'supports'            => array( 'title', 'thumbnail', 'excerpt', 'page-attributes' ),
			'show_in_rest'        => true,
			'capability_type'     => 'post',
		)
	);
}
add_action( 'init', 'portal_si_register_professor_cpt' );

/**
 * Meta box — dados do perfil.
 */
function portal_si_professor_add_meta_boxes() {
	add_meta_box(
		'portal-professor-profile',
		__( 'Perfil do professor', 'portal-si-cefet' ),
		'portal_si_professor_render_meta_box',
		PORTAL_SI_PROFESSOR_POST_TYPE,
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'portal_si_professor_add_meta_boxes' );

/**
 * @param WP_Post $post Post atual.
 */
function portal_si_professor_render_meta_box( $post ) {
	wp_nonce_field( 'portal_si_professor_save', 'portal_si_professor_nonce' );

	$lattes   = get_post_meta( $post->ID, PORTAL_SI_PROFESSOR_LATTES_META, true );
	$formation = get_post_meta( $post->ID, PORTAL_SI_PROFESSOR_FORMATION_META, true );
	$bio      = get_post_meta( $post->ID, PORTAL_SI_PROFESSOR_BIO_META, true );
	$lines    = get_post_meta( $post->ID, PORTAL_SI_PROFESSOR_LINES_META, true );
	?>
	<p class="description portal-professor-admin-help">
		<?php esc_html_e( 'Mínimo recomendado: nome (título acima), foto (imagem destacada à direita) e link Lattes. Demais campos são opcionais e só aparecem no site se preenchidos.', 'portal-si-cefet' ); ?>
	</p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="portal_professor_lattes"><?php esc_html_e( 'Currículo Lattes', 'portal-si-cefet' ); ?></label></th>
			<td>
				<input type="url" class="large-text" id="portal_professor_lattes" name="portal_professor_lattes" value="<?php echo esc_attr( (string) $lattes ); ?>" placeholder="https://lattes.cnpq.br/..." />
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_professor_formation"><?php esc_html_e( 'Formação acadêmica', 'portal-si-cefet' ); ?></label></th>
			<td>
				<textarea class="large-text" rows="4" id="portal_professor_formation" name="portal_professor_formation"><?php echo esc_textarea( (string) $formation ); ?></textarea>
				<p class="description"><?php esc_html_e( 'Ex.: Doutorado em … — UFRJ (2018). Uma linha por item, se preferir.', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_professor_biography"><?php esc_html_e( 'Biografia / apresentação', 'portal-si-cefet' ); ?></label></th>
			<td>
				<textarea class="large-text" rows="5" id="portal_professor_biography" name="portal_professor_biography"><?php echo esc_textarea( (string) $bio ); ?></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="portal_professor_research_lines"><?php esc_html_e( 'Linhas de pesquisa', 'portal-si-cefet' ); ?></label></th>
			<td>
				<textarea class="large-text" rows="4" id="portal_professor_research_lines" name="portal_professor_research_lines"><?php echo esc_textarea( (string) $lines ); ?></textarea>
				<p class="description"><?php esc_html_e( 'Uma linha por linha de pesquisa ou área de atuação.', 'portal-si-cefet' ); ?></p>
			</td>
		</tr>
	</table>
	<p class="description">
		<?php esc_html_e( 'Resumo (excerpt): texto curto na listagem. Ordem na página: campo «Ordem» na caixa Atributos da página.', 'portal-si-cefet' ); ?>
	</p>
	<?php
}

/**
 * @param int $post_id ID do post.
 */
function portal_si_professor_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['portal_si_professor_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_professor_nonce'] ) ), 'portal_si_professor_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( PORTAL_SI_PROFESSOR_POST_TYPE !== get_post_type( $post_id ) ) {
		return;
	}

	$lattes = isset( $_POST['portal_professor_lattes'] ) ? esc_url_raw( wp_unslash( $_POST['portal_professor_lattes'] ) ) : '';
	update_post_meta( $post_id, PORTAL_SI_PROFESSOR_LATTES_META, $lattes );

	update_post_meta(
		$post_id,
		PORTAL_SI_PROFESSOR_FORMATION_META,
		isset( $_POST['portal_professor_formation'] ) ? sanitize_textarea_field( wp_unslash( $_POST['portal_professor_formation'] ) ) : ''
	);
	update_post_meta(
		$post_id,
		PORTAL_SI_PROFESSOR_BIO_META,
		isset( $_POST['portal_professor_biography'] ) ? sanitize_textarea_field( wp_unslash( $_POST['portal_professor_biography'] ) ) : ''
	);
	update_post_meta(
		$post_id,
		PORTAL_SI_PROFESSOR_LINES_META,
		isset( $_POST['portal_professor_research_lines'] ) ? sanitize_textarea_field( wp_unslash( $_POST['portal_professor_research_lines'] ) ) : ''
	);
}
add_action( 'save_post_' . PORTAL_SI_PROFESSOR_POST_TYPE, 'portal_si_professor_save_meta_box' );

/**
 * Linhas de texto → lista (ignora vazias).
 *
 * @param string $raw Texto multilinha.
 * @return string[]
 */
function portal_si_professor_lines_to_array( $raw ) {
	$parts = preg_split( '/\r\n|\r|\n/', (string) $raw );
	if ( ! is_array( $parts ) ) {
		return array();
	}
	$out = array();
	foreach ( $parts as $line ) {
		$line = trim( $line );
		if ( '' !== $line ) {
			$out[] = $line;
		}
	}
	return $out;
}

/**
 * Iniciais do nome (avatar fallback).
 *
 * @param string $name Nome completo.
 * @return string
 */
function portal_si_professor_initials( $name ) {
	$name = trim( (string) $name );
	if ( '' === $name ) {
		return '?';
	}
	$words = preg_split( '/\s+/', $name );
	if ( ! is_array( $words ) || empty( $words ) ) {
		return '?';
	}
	if ( 1 === count( $words ) ) {
		return mb_strtoupper( mb_substr( $words[0], 0, 2 ) );
	}
	$first = mb_substr( $words[0], 0, 1 );
	$last  = mb_substr( $words[ count( $words ) - 1 ], 0, 1 );
	return mb_strtoupper( $first . $last );
}

/**
 * Normaliza professor para templates.
 *
 * @param int|WP_Post|null $post Post ou ID.
 * @return array<string, mixed>|null
 */
function portal_si_professor_to_array( $post ) {
	$post = get_post( $post );
	if ( ! $post || PORTAL_SI_PROFESSOR_POST_TYPE !== $post->post_type || 'publish' !== $post->post_status ) {
		return null;
	}

	$formation = (string) get_post_meta( $post->ID, PORTAL_SI_PROFESSOR_FORMATION_META, true );
	$bio       = (string) get_post_meta( $post->ID, PORTAL_SI_PROFESSOR_BIO_META, true );
	$lines_raw = (string) get_post_meta( $post->ID, PORTAL_SI_PROFESSOR_LINES_META, true );
	$lattes    = (string) get_post_meta( $post->ID, PORTAL_SI_PROFESSOR_LATTES_META, true );

	$thumb_id = get_post_thumbnail_id( $post->ID );
	$photo    = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'medium_large' ) : '';

	return array(
		'id'             => (int) $post->ID,
		'name'           => get_the_title( $post ),
		'slug'           => $post->post_name,
		'url'            => get_permalink( $post ),
		'excerpt'        => has_excerpt( $post ) ? get_the_excerpt( $post ) : '',
		'photo_url'      => $photo ? (string) $photo : '',
		'photo_alt'      => $photo ? sprintf(
			/* translators: %s: professor name */
			__( 'Foto de %s', 'portal-si-cefet' ),
			get_the_title( $post )
		) : '',
		'initials'       => portal_si_professor_initials( get_the_title( $post ) ),
		'lattes_url'     => $lattes,
		'formation'      => trim( $formation ),
		'formation_items' => portal_si_professor_lines_to_array( $formation ),
		'biography'      => trim( $bio ),
		'research_lines' => portal_si_professor_lines_to_array( $lines_raw ),
	);
}

/**
 * Lista professores publicados.
 *
 * @param array<string, mixed> $args Argumentos WP_Query extra.
 * @return array<int, array<string, mixed>>
 */
function portal_si_get_professores( $args = array() ) {
	$query_args = array_merge(
		array(
			'post_type'      => PORTAL_SI_PROFESSOR_POST_TYPE,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'no_found_rows'  => true,
		),
		$args
	);

	$query = new WP_Query( $query_args );
	$out   = array();

	foreach ( $query->posts as $post ) {
		$row = portal_si_professor_to_array( $post );
		if ( $row ) {
			$out[] = $row;
		}
	}

	wp_reset_postdata();
	return $out;
}

/**
 * Intro da página Corpo Docente.
 *
 * @return string
 */
function portal_si_corpo_docente_intro() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_CORPO_DOCENTE_SLUG );
	if ( $page_id ) {
		$page = get_post( $page_id );
		if ( $page && $page->post_excerpt ) {
			return $page->post_excerpt;
		}
	}
	return __( 'Professores do curso de Sistemas de Informação — formação, linhas de pesquisa e currículo Lattes.', 'portal-si-cefet' );
}

/**
 * Garante página listagem e vínculo ao hub institucional.
 */
function portal_si_ensure_corpo_docente_page() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_CORPO_DOCENTE_SLUG );
	if ( ! $page_id ) {
		$page_id = portal_si_ensure_page(
			__( 'Corpo Docente', 'portal-si-cefet' ),
			PORTAL_SI_CORPO_DOCENTE_SLUG
		);
	}

	if ( ! $page_id ) {
		return;
	}

	$hub_id = portal_si_get_page_id_by_slug( PORTAL_SI_INSTITUCIONAL_HUB_SLUG );
	if ( $hub_id && (int) get_post_field( 'post_parent', $page_id ) !== (int) $hub_id ) {
		wp_update_post(
			array(
				'ID'          => $page_id,
				'post_parent' => $hub_id,
			)
		);
	}

	$page = get_post( $page_id );
	if ( $page && '' === trim( $page->post_excerpt ) ) {
		wp_update_post(
			array(
				'ID'           => $page_id,
				'post_excerpt' => portal_si_corpo_docente_intro(),
			)
		);
	}
}
add_action( 'after_setup_theme', 'portal_si_ensure_corpo_docente_page', 26 );

/**
 * CSS listagem e perfil.
 */
function portal_si_professor_enqueue_assets() {
	if ( is_page( PORTAL_SI_CORPO_DOCENTE_SLUG ) || is_singular( PORTAL_SI_PROFESSOR_POST_TYPE ) ) {
		wp_enqueue_style(
			'portal-si-professor',
			get_template_directory_uri() . '/assets/css/professor.css',
			array( 'portal-si-pages' ),
			PORTAL_SI_CEFET_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'portal_si_professor_enqueue_assets', 16 );
