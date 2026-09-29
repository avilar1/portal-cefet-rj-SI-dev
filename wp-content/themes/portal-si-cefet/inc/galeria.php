<?php
/**
 * Galeria multimídia — RF21.
 *
 * CPT Álbum (fotos da biblioteca de mídia + vídeos por link) organizado por categoria
 * e, opcionalmente, vinculado a um evento da agenda.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const PORTAL_SI_ALBUM_POST_TYPE   = 'portal_album';
const PORTAL_SI_ALBUM_TAXONOMY    = 'portal_album_categoria';
const PORTAL_SI_ALBUM_DATE_META   = '_portal_album_data';
const PORTAL_SI_ALBUM_PHOTOS_META = '_portal_album_fotos';
const PORTAL_SI_ALBUM_VIDEOS_META = '_portal_album_videos';
const PORTAL_SI_ALBUM_EVENTO_META = '_portal_album_evento';
const PORTAL_SI_ALBUM_HOME_META   = '_portal_album_home';
const PORTAL_SI_GALERIA_PER_PAGE  = 12;
const PORTAL_SI_GALERIA_HOME_LIMIT = 3;

define( 'PORTAL_SI_GALERIA_SLUG', 'galeria' );

/**
 * Registra CPT Álbum e a taxonomia de categorias.
 */
function portal_si_register_album_cpt() {
	register_post_type(
		PORTAL_SI_ALBUM_POST_TYPE,
		array(
			'labels'             => array(
				'name'               => __( 'Galeria', 'portal-si-cefet' ),
				'singular_name'      => __( 'Álbum', 'portal-si-cefet' ),
				'add_new'            => __( 'Adicionar álbum', 'portal-si-cefet' ),
				'add_new_item'       => __( 'Adicionar novo álbum', 'portal-si-cefet' ),
				'edit_item'          => __( 'Editar álbum', 'portal-si-cefet' ),
				'new_item'           => __( 'Novo álbum', 'portal-si-cefet' ),
				'view_item'          => __( 'Ver álbum', 'portal-si-cefet' ),
				'search_items'       => __( 'Buscar álbuns', 'portal-si-cefet' ),
				'not_found'          => __( 'Nenhum álbum encontrado.', 'portal-si-cefet' ),
				'not_found_in_trash' => __( 'Nenhum álbum na lixeira.', 'portal-si-cefet' ),
				'all_items'          => __( 'Todos os álbuns', 'portal-si-cefet' ),
				'menu_name'          => __( 'Galeria', 'portal-si-cefet' ),
			),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-format-gallery',
			'menu_position'      => 27,
			'has_archive'        => false,
			'rewrite'            => array(
				'slug'       => 'album',
				'with_front' => false,
			),
			'supports'           => array( 'title', 'editor', 'thumbnail' ),
			'show_in_rest'       => false,
			'capability_type'    => 'post',
		)
	);

	register_taxonomy(
		PORTAL_SI_ALBUM_TAXONOMY,
		PORTAL_SI_ALBUM_POST_TYPE,
		array(
			'labels'            => array(
				'name'          => __( 'Categorias da galeria', 'portal-si-cefet' ),
				'singular_name' => __( 'Categoria', 'portal-si-cefet' ),
				'menu_name'     => __( 'Categorias', 'portal-si-cefet' ),
				'add_new_item'  => __( 'Adicionar categoria', 'portal-si-cefet' ),
				'edit_item'     => __( 'Editar categoria', 'portal-si-cefet' ),
				'search_items'  => __( 'Buscar categorias', 'portal-si-cefet' ),
				'not_found'     => __( 'Nenhuma categoria encontrada.', 'portal-si-cefet' ),
			),
			'hierarchical'      => true,
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => false,
			'query_var'         => false,
			'rewrite'           => false,
		)
	);
}
add_action( 'init', 'portal_si_register_album_cpt' );

/**
 * Categorias iniciais (uma vez; depois são editadas no painel).
 */
function portal_si_album_maybe_seed_terms() {
	if ( ! add_option( 'portal_si_album_terms_seeded', 1, '', false ) ) {
		return;
	}
	$terms = array(
		'eventos'            => __( 'Eventos', 'portal-si-cefet' ),
		'campus'             => __( 'Campus', 'portal-si-cefet' ),
		'fabrica-de-software' => __( 'Fábrica de Software', 'portal-si-cefet' ),
		'visitas-tecnicas'   => __( 'Visitas técnicas', 'portal-si-cefet' ),
	);
	foreach ( $terms as $slug => $name ) {
		if ( ! term_exists( $slug, PORTAL_SI_ALBUM_TAXONOMY ) ) {
			wp_insert_term( $name, PORTAL_SI_ALBUM_TAXONOMY, array( 'slug' => $slug ) );
		}
	}
}
add_action( 'init', 'portal_si_album_maybe_seed_terms', 20 );

/**
 * Atualiza permalinks após registrar o CPT (/album/slug).
 */
function portal_si_album_maybe_flush_rewrites() {
	if ( get_option( 'portal_si_album_rewrites_v1' ) ) {
		return;
	}
	flush_rewrite_rules( false );
	update_option( 'portal_si_album_rewrites_v1', 1 );
}
add_action( 'init', 'portal_si_album_maybe_flush_rewrites', 99 );

/**
 * Garante a página /galeria.
 */
function portal_si_ensure_galeria_page() {
	portal_si_ensure_page( __( 'Galeria', 'portal-si-cefet' ), PORTAL_SI_GALERIA_SLUG );
}
add_action( 'after_setup_theme', 'portal_si_ensure_galeria_page', 27 );

/* ------------------------------------------------------------------ */
/* Painel                                                              */
/* ------------------------------------------------------------------ */

/**
 * Meta boxes do álbum.
 */
function portal_si_album_add_meta_boxes() {
	add_meta_box(
		'portal-album-fotos',
		__( 'Fotos e vídeos', 'portal-si-cefet' ),
		'portal_si_album_render_media_box',
		PORTAL_SI_ALBUM_POST_TYPE,
		'normal',
		'high'
	);
	add_meta_box(
		'portal-album-detalhes',
		__( 'Detalhes do álbum', 'portal-si-cefet' ),
		'portal_si_album_render_details_box',
		PORTAL_SI_ALBUM_POST_TYPE,
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'portal_si_album_add_meta_boxes' );

/**
 * @param WP_Post $post Álbum.
 */
function portal_si_album_render_media_box( $post ) {
	wp_nonce_field( 'portal_si_album_save', 'portal_si_album_nonce' );
	$ids    = portal_si_album_photo_ids( $post->ID );
	$videos = portal_si_album_video_urls( $post->ID );
	?>
	<p>
		<button type="button" class="button button-primary" id="portal_album_fotos_add">
			<?php esc_html_e( 'Adicionar fotos', 'portal-si-cefet' ); ?>
		</button>
		<span id="portal_album_fotos_count" class="portal-album-admin-count">
			<?php
			echo esc_html(
				$ids
					? sprintf( _n( '%d foto', '%d fotos', count( $ids ), 'portal-si-cefet' ), count( $ids ) )
					: __( 'Nenhuma foto adicionada.', 'portal-si-cefet' )
			);
			?>
		</span>
	</p>
	<input type="hidden" id="portal_album_fotos" name="portal_album_fotos" value="<?php echo esc_attr( implode( ',', $ids ) ); ?>" />
	<ul id="portal_album_fotos_list" class="portal-album-admin-photos">
		<?php foreach ( $ids as $id ) : ?>
			<li class="portal-album-admin-photo" data-id="<?php echo esc_attr( $id ); ?>">
				<?php echo wp_get_attachment_image( $id, 'thumbnail', false, array( 'alt' => '' ) ); ?>
				<button type="button" class="portal-album-admin-photo__remove" aria-label="<?php echo esc_attr( sprintf( __( 'Remover foto: %s', 'portal-si-cefet' ), get_the_title( $id ) ) ); ?>">&times;</button>
			</li>
		<?php endforeach; ?>
	</ul>
	<p class="description">
		<?php esc_html_e( 'Arraste as fotos para mudar a ordem. Sem imagem destacada, a primeira foto vira a capa do álbum. Preencha o "Texto alternativo" de cada foto na biblioteca de mídia (acessibilidade).', 'portal-si-cefet' ); ?>
	</p>

	<p style="margin-top:1.5em;">
		<label for="portal_album_videos"><strong><?php esc_html_e( 'Vídeos', 'portal-si-cefet' ); ?></strong></label>
	</p>
	<textarea id="portal_album_videos" name="portal_album_videos" rows="3" class="large-text code" placeholder="https://www.youtube.com/watch?v=..."><?php echo esc_textarea( implode( "\n", $videos ) ); ?></textarea>
	<p class="description">
		<?php esc_html_e( 'Links do YouTube ou Vimeo, um por linha. Outros endereços são ignorados.', 'portal-si-cefet' ); ?>
	</p>
	<?php
}

/**
 * @param WP_Post $post Álbum.
 */
function portal_si_album_render_details_box( $post ) {
	$date      = get_post_meta( $post->ID, PORTAL_SI_ALBUM_DATE_META, true );
	$evento_id = (int) get_post_meta( $post->ID, PORTAL_SI_ALBUM_EVENTO_META, true );
	$home      = '1' === get_post_meta( $post->ID, PORTAL_SI_ALBUM_HOME_META, true );

	$eventos = get_posts(
		array(
			'post_type'      => PORTAL_SI_EVENTO_POST_TYPE,
			'post_status'    => 'publish',
			'posts_per_page' => 100,
			'meta_key'       => PORTAL_SI_EVENTO_DATE_META,
			'orderby'        => 'meta_value',
			'order'          => 'DESC',
		)
	);
	?>
	<p>
		<label for="portal_album_data"><strong><?php esc_html_e( 'Data das fotos', 'portal-si-cefet' ); ?></strong></label><br />
		<input type="date" id="portal_album_data" name="portal_album_data" value="<?php echo esc_attr( $date ); ?>" style="width:100%;" />
		<span class="description"><?php esc_html_e( 'Em branco, usa a data de publicação.', 'portal-si-cefet' ); ?></span>
	</p>
	<p>
		<label for="portal_album_evento"><strong><?php esc_html_e( 'Evento relacionado', 'portal-si-cefet' ); ?></strong></label><br />
		<select id="portal_album_evento" name="portal_album_evento" style="width:100%;">
			<option value="0"><?php esc_html_e( 'Nenhum', 'portal-si-cefet' ); ?></option>
			<?php foreach ( $eventos as $evento ) : ?>
				<?php $iso = portal_si_evento_get_date( $evento->ID ); ?>
				<option value="<?php echo esc_attr( $evento->ID ); ?>" <?php selected( $evento_id, $evento->ID ); ?>>
					<?php echo esc_html( ( $iso ? portal_si_evento_format_date( $iso ) . ' · ' : '' ) . get_the_title( $evento ) ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<span class="description"><?php esc_html_e( 'A página do evento ganha um link para as fotos.', 'portal-si-cefet' ); ?></span>
	</p>
	<p>
		<label>
			<input type="checkbox" name="portal_album_home" value="1" <?php checked( $home ); ?> />
			<?php esc_html_e( 'Destacar na página inicial', 'portal-si-cefet' ); ?>
		</label><br />
		<span class="description">
			<?php
			printf(
				/* translators: %d: quantidade de álbuns. */
				esc_html__( 'A home mostra os %d álbuns destacados mais recentes. Sem nenhum destacado, a seção não aparece.', 'portal-si-cefet' ),
				(int) PORTAL_SI_GALERIA_HOME_LIMIT
			);
			?>
		</span>
	</p>
	<?php
}

/**
 * Hosts aceitos para vídeos.
 *
 * @param string $url URL.
 * @return bool
 */
function portal_si_album_is_video_url( $url ) {
	$host = strtolower( (string) wp_parse_url( $url, PHP_URL_HOST ) );
	$host = preg_replace( '/^(www\.|m\.)/', '', $host );
	return in_array( $host, array( 'youtube.com', 'youtu.be', 'vimeo.com', 'player.vimeo.com' ), true );
}

/**
 * Salva metadados do álbum.
 *
 * @param int $post_id ID do álbum.
 */
function portal_si_album_save_meta( $post_id ) {
	if ( ! isset( $_POST['portal_si_album_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_album_nonce'] ) ), 'portal_si_album_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$raw_ids = isset( $_POST['portal_album_fotos'] ) ? sanitize_text_field( wp_unslash( $_POST['portal_album_fotos'] ) ) : '';
	$ids     = array();
	foreach ( explode( ',', $raw_ids ) as $id ) {
		$id = absint( $id );
		if ( $id && wp_attachment_is_image( $id ) && ! in_array( $id, $ids, true ) ) {
			$ids[] = $id;
		}
	}
	update_post_meta( $post_id, PORTAL_SI_ALBUM_PHOTOS_META, $ids );

	$raw_videos = isset( $_POST['portal_album_videos'] ) ? sanitize_textarea_field( wp_unslash( $_POST['portal_album_videos'] ) ) : '';
	$videos     = array();
	foreach ( preg_split( '/\r\n|\r|\n/', $raw_videos ) as $line ) {
		$url = esc_url_raw( trim( $line ) );
		if ( $url && portal_si_album_is_video_url( $url ) && ! in_array( $url, $videos, true ) ) {
			$videos[] = $url;
		}
	}
	update_post_meta( $post_id, PORTAL_SI_ALBUM_VIDEOS_META, array_slice( $videos, 0, 20 ) );

	$raw_date = isset( $_POST['portal_album_data'] ) ? sanitize_text_field( wp_unslash( $_POST['portal_album_data'] ) ) : '';
	$date     = $raw_date ? DateTime::createFromFormat( 'Y-m-d', $raw_date ) : false;
	if ( $date ) {
		update_post_meta( $post_id, PORTAL_SI_ALBUM_DATE_META, $date->format( 'Y-m-d' ) );
	} else {
		delete_post_meta( $post_id, PORTAL_SI_ALBUM_DATE_META );
	}

	$evento_id = isset( $_POST['portal_album_evento'] ) ? absint( $_POST['portal_album_evento'] ) : 0;
	if ( $evento_id && PORTAL_SI_EVENTO_POST_TYPE === get_post_type( $evento_id ) ) {
		update_post_meta( $post_id, PORTAL_SI_ALBUM_EVENTO_META, $evento_id );
	} else {
		delete_post_meta( $post_id, PORTAL_SI_ALBUM_EVENTO_META );
	}

	if ( ! empty( $_POST['portal_album_home'] ) ) {
		update_post_meta( $post_id, PORTAL_SI_ALBUM_HOME_META, '1' );
	} else {
		delete_post_meta( $post_id, PORTAL_SI_ALBUM_HOME_META );
	}
}
add_action( 'save_post_' . PORTAL_SI_ALBUM_POST_TYPE, 'portal_si_album_save_meta' );

/**
 * Colunas da listagem no painel.
 *
 * @param string[] $columns Colunas.
 * @return string[]
 */
function portal_si_album_admin_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		if ( 'title' === $key ) {
			$new['portal_album_capa'] = __( 'Capa', 'portal-si-cefet' );
		}
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['portal_album_midia'] = __( 'Mídia', 'portal-si-cefet' );
			$new['portal_album_home']  = __( 'Na home', 'portal-si-cefet' );
		}
	}
	return $new;
}
add_filter( 'manage_' . PORTAL_SI_ALBUM_POST_TYPE . '_posts_columns', 'portal_si_album_admin_columns' );

/**
 * @param string $column  Coluna.
 * @param int    $post_id ID do álbum.
 */
function portal_si_album_admin_column_content( $column, $post_id ) {
	if ( 'portal_album_capa' === $column ) {
		$cover = portal_si_album_cover_id( $post_id );
		echo $cover ? wp_get_attachment_image( $cover, array( 60, 60 ), false, array( 'alt' => '' ) ) : '—';
	} elseif ( 'portal_album_midia' === $column ) {
		echo esc_html( portal_si_album_media_summary( $post_id ) );
	} elseif ( 'portal_album_home' === $column ) {
		echo '1' === get_post_meta( $post_id, PORTAL_SI_ALBUM_HOME_META, true ) ? esc_html__( 'Sim', 'portal-si-cefet' ) : '—';
	}
}
add_action( 'manage_' . PORTAL_SI_ALBUM_POST_TYPE . '_posts_custom_column', 'portal_si_album_admin_column_content', 10, 2 );

/**
 * Scripts do painel (seletor de mídia e ordenação).
 *
 * @param string $hook Tela atual.
 */
function portal_si_album_admin_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || PORTAL_SI_ALBUM_POST_TYPE !== $screen->post_type ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style(
		'portal-si-galeria-admin',
		get_template_directory_uri() . '/assets/css/galeria-admin.css',
		array(),
		PORTAL_SI_CEFET_VERSION
	);
	wp_enqueue_script(
		'portal-si-galeria-admin',
		get_template_directory_uri() . '/assets/js/galeria-admin.js',
		array( 'jquery', 'jquery-ui-sortable' ),
		PORTAL_SI_CEFET_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'portal_si_album_admin_assets' );

/* ------------------------------------------------------------------ */
/* Dados                                                               */
/* ------------------------------------------------------------------ */

/**
 * IDs das fotos (somente imagens ainda existentes), na ordem definida.
 *
 * @param int $post_id ID do álbum.
 * @return int[]
 */
function portal_si_album_photo_ids( $post_id ) {
	$ids = get_post_meta( $post_id, PORTAL_SI_ALBUM_PHOTOS_META, true );
	if ( ! is_array( $ids ) ) {
		return array();
	}
	return array_values( array_filter( array_map( 'absint', $ids ), 'wp_attachment_is_image' ) );
}

/**
 * @param int $post_id ID do álbum.
 * @return string[]
 */
function portal_si_album_video_urls( $post_id ) {
	$urls = get_post_meta( $post_id, PORTAL_SI_ALBUM_VIDEOS_META, true );
	return is_array( $urls ) ? array_values( array_filter( $urls, 'is_string' ) ) : array();
}

/**
 * Data ISO do álbum (meta ou data de publicação).
 *
 * @param int $post_id ID do álbum.
 * @return string
 */
function portal_si_album_date_iso( $post_id ) {
	$date = get_post_meta( $post_id, PORTAL_SI_ALBUM_DATE_META, true );
	return $date ? $date : get_the_date( 'Y-m-d', $post_id );
}

/**
 * Capa: imagem destacada ou primeira foto.
 *
 * @param int $post_id ID do álbum.
 * @return int
 */
function portal_si_album_cover_id( $post_id ) {
	$thumb = (int) get_post_thumbnail_id( $post_id );
	if ( $thumb ) {
		return $thumb;
	}
	$ids = portal_si_album_photo_ids( $post_id );
	return $ids ? $ids[0] : 0;
}

/**
 * Ex.: "12 fotos · 2 vídeos".
 *
 * @param int $post_id ID do álbum.
 * @return string
 */
function portal_si_album_media_summary( $post_id ) {
	$photos = count( portal_si_album_photo_ids( $post_id ) );
	$videos = count( portal_si_album_video_urls( $post_id ) );
	$parts  = array();
	if ( $photos ) {
		$parts[] = sprintf( _n( '%d foto', '%d fotos', $photos, 'portal-si-cefet' ), $photos );
	}
	if ( $videos ) {
		$parts[] = sprintf( _n( '%d vídeo', '%d vídeos', $videos, 'portal-si-cefet' ), $videos );
	}
	return $parts ? implode( ' · ', $parts ) : __( 'Sem mídia', 'portal-si-cefet' );
}

/**
 * Primeira categoria do álbum.
 *
 * @param int $post_id ID do álbum.
 * @return WP_Term|null
 */
function portal_si_album_term( $post_id ) {
	$terms = get_the_terms( $post_id, PORTAL_SI_ALBUM_TAXONOMY );
	return ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
}

/**
 * Álbum no formato do card de notícia (template-parts/noticia/card).
 *
 * @param int|WP_Post $post Álbum.
 * @return array<string, mixed>|null
 */
function portal_si_album_to_array( $post ) {
	$post = get_post( $post );
	if ( ! $post || PORTAL_SI_ALBUM_POST_TYPE !== $post->post_type ) {
		return null;
	}

	$iso   = portal_si_album_date_iso( $post->ID );
	$term  = portal_si_album_term( $post->ID );
	$cover = portal_si_album_cover_id( $post->ID );
	$title = get_the_title( $post );

	return array(
		'id'         => $post->ID,
		'title'      => $title,
		'url'        => get_permalink( $post ),
		'date'       => date_i18n( get_option( 'date_format' ), strtotime( $iso ) ),
		'date_iso'   => $iso,
		'category'   => $term ? $term->name : __( 'Galeria', 'portal-si-cefet' ),
		'cat_slug'   => $term ? $term->slug : '',
		'excerpt'    => portal_si_album_media_summary( $post->ID ),
		'has_thumb'  => (bool) $cover,
		'thumb_html' => $cover ? wp_get_attachment_image( $cover, 'medium_large', false, array( 'class' => 'portal-noticia-card__img', 'alt' => '' ) ) : '',
		'aria_label' => sprintf( __( 'Ver álbum: %s', 'portal-si-cefet' ), $title ),
	);
}

/**
 * Consulta de álbuns, do mais recente para o mais antigo (data do álbum).
 *
 * @param array $overrides Argumentos extras do WP_Query.
 * @return WP_Query
 */
function portal_si_album_query( array $overrides = array() ) {
	$args = array(
		'post_type'      => PORTAL_SI_ALBUM_POST_TYPE,
		'post_status'    => 'publish',
		'posts_per_page' => PORTAL_SI_GALERIA_PER_PAGE,
		'meta_query'     => array(
			'relation'       => 'OR',
			'portal_has_date' => array(
				'key'     => PORTAL_SI_ALBUM_DATE_META,
				'compare' => 'EXISTS',
			),
			array(
				'key'     => PORTAL_SI_ALBUM_DATE_META,
				'compare' => 'NOT EXISTS',
			),
		),
		'orderby'        => array(
			'portal_has_date' => 'DESC',
			'date'            => 'DESC',
		),
	);

	if ( isset( $overrides['meta_query'] ) ) {
		$args['meta_query'] = array(
			'relation' => 'AND',
			$args['meta_query'],
			$overrides['meta_query'],
		);
		unset( $overrides['meta_query'] );
	}

	return new WP_Query( array_merge( $args, $overrides ) );
}

/**
 * @param WP_Query $query Consulta.
 * @return array<int, array<string, mixed>>
 */
function portal_si_map_albums_from_query( WP_Query $query ) {
	$items = array();
	foreach ( $query->posts as $post ) {
		$item = portal_si_album_to_array( $post );
		if ( $item ) {
			$items[] = $item;
		}
	}
	return $items;
}

/**
 * Álbuns destacados para a home (vazio = seção não aparece).
 *
 * @return array<int, array<string, mixed>>
 */
function portal_si_galeria_home_albums() {
	if ( ! apply_filters( 'portal_si_galeria_show_on_home', true ) ) {
		return array();
	}
	$query = portal_si_album_query(
		array(
			'posts_per_page' => PORTAL_SI_GALERIA_HOME_LIMIT,
			'no_found_rows'  => true,
			'meta_query'     => array(
				array(
					'key'   => PORTAL_SI_ALBUM_HOME_META,
					'value' => '1',
				),
			),
		)
	);
	return portal_si_map_albums_from_query( $query );
}

/**
 * Categorias com ao menos um álbum publicado.
 *
 * @return WP_Term[]
 */
function portal_si_galeria_terms() {
	$terms = get_terms(
		array(
			'taxonomy'   => PORTAL_SI_ALBUM_TAXONOMY,
			'hide_empty' => true,
		)
	);
	return is_wp_error( $terms ) ? array() : $terms;
}

/**
 * Categoria selecionada no filtro (?categoria=slug).
 *
 * @return WP_Term|null
 */
function portal_si_galeria_current_term() {
	if ( empty( $_GET['categoria'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return null;
	}
	$slug = sanitize_title( wp_unslash( $_GET['categoria'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$term = get_term_by( 'slug', $slug, PORTAL_SI_ALBUM_TAXONOMY );
	return $term instanceof WP_Term ? $term : null;
}

/**
 * Álbum publicado vinculado a um evento.
 *
 * @param int $evento_id ID do evento.
 * @return WP_Post|null
 */
function portal_si_album_for_evento( $evento_id ) {
	$posts = get_posts(
		array(
			'post_type'      => PORTAL_SI_ALBUM_POST_TYPE,
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'meta_key'       => PORTAL_SI_ALBUM_EVENTO_META,
			'meta_value'     => (int) $evento_id,
		)
	);
	return $posts ? $posts[0] : null;
}

/**
 * Intro da página Galeria (resumo da página ou padrão).
 *
 * @return string
 */
function portal_si_galeria_intro() {
	$page_id = portal_si_get_page_id_by_slug( PORTAL_SI_GALERIA_SLUG );
	if ( $page_id ) {
		$excerpt = get_post_field( 'post_excerpt', $page_id );
		if ( $excerpt ) {
			return $excerpt;
		}
	}
	return __( 'Fotos e vídeos de eventos, atividades e do dia a dia do curso de Sistemas de Informação.', 'portal-si-cefet' );
}

/* ------------------------------------------------------------------ */
/* Front-end                                                           */
/* ------------------------------------------------------------------ */

/**
 * @param string[] $classes Classes do body.
 * @return string[]
 */
function portal_si_galeria_body_class( $classes ) {
	if ( is_page( PORTAL_SI_GALERIA_SLUG ) ) {
		$classes[] = 'portal-is-galeria';
	}
	if ( is_singular( PORTAL_SI_ALBUM_POST_TYPE ) ) {
		$classes[] = 'portal-is-album';
	}
	return $classes;
}
add_filter( 'body_class', 'portal_si_galeria_body_class' );

/**
 * CSS/JS da galeria (página, álbum e faixa da home quando houver destaque).
 */
function portal_si_galeria_enqueue_assets() {
	$is_album = is_singular( PORTAL_SI_ALBUM_POST_TYPE );
	if ( ! $is_album && ! is_page( PORTAL_SI_GALERIA_SLUG ) && ! is_front_page() ) {
		return;
	}

	wp_enqueue_style(
		'portal-si-galeria',
		get_template_directory_uri() . '/assets/css/galeria.css',
		array( 'portal-si-noticias' ),
		PORTAL_SI_CEFET_VERSION
	);

	if ( $is_album ) {
		wp_enqueue_script(
			'portal-si-galeria',
			get_template_directory_uri() . '/assets/js/galeria.js',
			array(),
			PORTAL_SI_CEFET_VERSION,
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'portal_si_galeria_enqueue_assets', 16 );
