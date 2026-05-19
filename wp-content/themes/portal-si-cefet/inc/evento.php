<?php
/**
 * CPT Evento — agenda editável no painel WordPress.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const PORTAL_SI_EVENTO_DATE_META = '_portal_evento_data';
const PORTAL_SI_EVENTO_POST_TYPE = 'portal_evento';

/**
 * Registra o tipo de conteúdo Evento.
 */
function portal_si_register_evento_cpt() {
	register_post_type(
		PORTAL_SI_EVENTO_POST_TYPE,
		array(
			'labels'              => array(
				'name'               => __( 'Eventos', 'portal-si-cefet' ),
				'singular_name'      => __( 'Evento', 'portal-si-cefet' ),
				'add_new'            => __( 'Adicionar evento', 'portal-si-cefet' ),
				'add_new_item'       => __( 'Adicionar novo evento', 'portal-si-cefet' ),
				'edit_item'          => __( 'Editar evento', 'portal-si-cefet' ),
				'new_item'           => __( 'Novo evento', 'portal-si-cefet' ),
				'view_item'          => __( 'Ver evento', 'portal-si-cefet' ),
				'search_items'       => __( 'Buscar eventos', 'portal-si-cefet' ),
				'not_found'          => __( 'Nenhum evento encontrado.', 'portal-si-cefet' ),
				'not_found_in_trash' => __( 'Nenhum evento na lixeira.', 'portal-si-cefet' ),
				'menu_name'          => __( 'Eventos', 'portal-si-cefet' ),
			),
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-calendar-alt',
			'menu_position'       => 26,
			'has_archive'         => false,
			'query_var'           => true,
			'rewrite'             => array(
				'slug'       => 'evento',
				'with_front' => false,
			),
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest'        => true,
			'capability_type'     => 'post',
		)
	);
}
add_action( 'init', 'portal_si_register_evento_cpt' );

/**
 * Meta box — data do evento.
 */
function portal_si_evento_add_meta_boxes() {
	add_meta_box(
		'portal-evento-data',
		__( 'Data do evento', 'portal-si-cefet' ),
		'portal_si_evento_render_meta_box',
		PORTAL_SI_EVENTO_POST_TYPE,
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'portal_si_evento_add_meta_boxes' );

/**
 * @param WP_Post $post Post atual.
 */
function portal_si_evento_render_meta_box( $post ) {
	wp_nonce_field( 'portal_si_evento_save', 'portal_si_evento_nonce' );
	$value = portal_si_evento_get_date( $post->ID );
	?>
	<p>
		<label class="screen-reader-text" for="portal_evento_data"><?php esc_html_e( 'Data do evento', 'portal-si-cefet' ); ?></label>
		<input
			type="date"
			id="portal_evento_data"
			name="portal_evento_data"
			value="<?php echo esc_attr( $value ); ?>"
			required
			style="width:100%;"
		/>
	</p>
	<p class="description">
		<?php esc_html_e( 'Obrigatória para exibir o evento na agenda da home.', 'portal-si-cefet' ); ?>
	</p>
	<?php
}

/**
 * Salva a data do evento.
 *
 * @param int $post_id ID do post.
 */
function portal_si_evento_save_meta( $post_id ) {
	if ( ! isset( $_POST['portal_si_evento_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['portal_si_evento_nonce'] ) ), 'portal_si_evento_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( PORTAL_SI_EVENTO_POST_TYPE !== get_post_type( $post_id ) ) {
		return;
	}

	if ( empty( $_POST['portal_evento_data'] ) ) {
		delete_post_meta( $post_id, PORTAL_SI_EVENTO_DATE_META );
		return;
	}

	$raw  = sanitize_text_field( wp_unslash( $_POST['portal_evento_data'] ) );
	$date = DateTime::createFromFormat( 'Y-m-d', $raw );
	if ( ! $date ) {
		return;
	}

	update_post_meta( $post_id, PORTAL_SI_EVENTO_DATE_META, $date->format( 'Y-m-d' ) );
}
add_action( 'save_post', 'portal_si_evento_save_meta' );

/**
 * Coluna "Data" na listagem do admin.
 *
 * @param string[] $columns Colunas.
 * @return string[]
 */
function portal_si_evento_admin_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['portal_evento_data'] = __( 'Data', 'portal-si-cefet' );
		}
	}
	return $new;
}
add_filter( 'manage_' . PORTAL_SI_EVENTO_POST_TYPE . '_posts_columns', 'portal_si_evento_admin_columns' );

/**
 * @param string $column  Nome da coluna.
 * @param int    $post_id ID do post.
 */
function portal_si_evento_admin_column_content( $column, $post_id ) {
	if ( 'portal_evento_data' !== $column ) {
		return;
	}
	$date = portal_si_evento_get_date( $post_id );
	if ( $date ) {
		echo esc_html( portal_si_evento_format_date( $date ) );
	} else {
		echo '—';
	}
}
add_action( 'manage_' . PORTAL_SI_EVENTO_POST_TYPE . '_posts_custom_column', 'portal_si_evento_admin_column_content', 10, 2 );

/**
 * Data ISO (Y-m-d) do evento.
 *
 * @param int $post_id ID do post.
 * @return string
 */
function portal_si_evento_get_date( $post_id ) {
	$value = get_post_meta( $post_id, PORTAL_SI_EVENTO_DATE_META, true );
	return is_string( $value ) ? $value : '';
}

/**
 * Data formatada para exibição.
 *
 * @param string $iso Data Y-m-d.
 * @return string
 */
function portal_si_evento_format_date( $iso ) {
	$ts = strtotime( $iso );
	if ( ! $ts ) {
		return $iso;
	}
	return date_i18n( 'j M Y', $ts );
}

/**
 * Argumentos base para consultas de eventos.
 *
 * @param array $overrides Sobrescritas do WP_Query.
 * @return array
 */
function portal_si_eventos_query_args( array $overrides = array() ) {
	$defaults = array(
		'post_type'      => PORTAL_SI_EVENTO_POST_TYPE,
		'post_status'    => 'publish',
		'meta_key'       => PORTAL_SI_EVENTO_DATE_META,
		'orderby'        => 'meta_value',
		'meta_type'      => 'DATE',
		'no_found_rows'  => true,
	);

	return array_merge( $defaults, $overrides );
}

/**
 * Converte WP_Query em lista normalizada de eventos.
 *
 * @param WP_Query $query Consulta executada.
 * @return array<int, array<string, mixed>>
 */
function portal_si_map_eventos_from_query( WP_Query $query ) {
	$events = array();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$event = portal_si_evento_to_array( get_the_ID() );
			if ( $event ) {
				$events[] = $event;
			}
		}
		wp_reset_postdata();
	}

	return $events;
}

/**
 * Dados de um evento para templates.
 *
 * @param int $post_id ID do post.
 * @return array<string, mixed>|null
 */
function portal_si_evento_to_array( $post_id ) {
	$iso = portal_si_evento_get_date( $post_id );
	if ( ! $iso ) {
		return null;
	}

	$excerpt = get_the_excerpt( $post_id );
	if ( ! $excerpt ) {
		$excerpt = wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ), 24, '…' );
	}

	return array(
		'id'         => $post_id,
		'date'       => portal_si_evento_format_date( $iso ),
		'date_iso'   => $iso,
		'title'      => get_the_title( $post_id ),
		'url'        => get_permalink( $post_id ),
		'excerpt'    => $excerpt,
		'has_thumb'  => has_post_thumbnail( $post_id ),
		'thumb_html' => get_the_post_thumbnail( $post_id, 'medium_large', array( 'class' => 'portal-event-card__img' ) ),
	);
}

/**
 * Próximos eventos publicados (para a home e agenda).
 *
 * @param int $limit Quantidade máxima (-1 = todos).
 * @return array<int, array<string, mixed>>
 */
function portal_si_get_upcoming_eventos( $limit = 4 ) {
	$today = current_time( 'Y-m-d' );

	$query = new WP_Query(
		portal_si_eventos_query_args(
			array(
				'posts_per_page' => $limit,
				'order'          => 'ASC',
				'meta_query'     => array(
					array(
						'key'     => PORTAL_SI_EVENTO_DATE_META,
						'value'   => $today,
						'compare' => '>=',
						'type'    => 'DATE',
					),
				),
			)
		)
	);

	return portal_si_map_eventos_from_query( $query );
}

/**
 * Eventos já realizados (data anterior a hoje).
 *
 * @param int $limit Quantidade máxima (-1 = todos).
 * @return array<int, array<string, mixed>>
 */
function portal_si_get_past_eventos( $limit = -1 ) {
	$today = current_time( 'Y-m-d' );

	$query = new WP_Query(
		portal_si_eventos_query_args(
			array(
				'posts_per_page' => $limit,
				'order'          => 'DESC',
				'meta_query'     => array(
					array(
						'key'     => PORTAL_SI_EVENTO_DATE_META,
						'value'   => $today,
						'compare' => '<',
						'type'    => 'DATE',
					),
				),
			)
		)
	);

	return portal_si_map_eventos_from_query( $query );
}

/**
 * Cria eventos de exemplo (uma vez, com o seed editorial).
 */
function portal_si_seed_sample_eventos() {
	if ( get_option( 'portal_si_eventos_seeded_v1' ) ) {
		return;
	}

	$existing = new WP_Query(
		array(
			'post_type'      => PORTAL_SI_EVENTO_POST_TYPE,
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
		)
	);
	if ( $existing->have_posts() ) {
		update_option( 'portal_si_eventos_seeded_v1', 1 );
		return;
	}

	$samples = array(
		array(
			'title' => __( 'Semana de Integração — Calouros', 'portal-si-cefet' ),
			'date'  => '2026-06-12',
			'slug'  => 'semana-integracao-calouros',
		),
		array(
			'title' => __( 'Defesas de TCC — 2º semestre', 'portal-si-cefet' ),
			'date'  => '2026-08-20',
			'slug'  => 'defesas-tcc-2-semestre',
		),
		array(
			'title' => __( 'Feira de Projetos — Fábrica de Software', 'portal-si-cefet' ),
			'date'  => '2026-10-15',
			'slug'  => 'feira-projetos-fabrica',
		),
		array(
			'title' => __( 'Encerramento do semestre letivo', 'portal-si-cefet' ),
			'date'  => '2026-12-10',
			'slug'  => 'encerramento-semestre',
		),
	);

	foreach ( $samples as $sample ) {
		$id = wp_insert_post(
			array(
				'post_title'  => $sample['title'],
				'post_name'   => $sample['slug'],
				'post_status' => 'publish',
				'post_type'   => PORTAL_SI_EVENTO_POST_TYPE,
			),
			true
		);
		if ( ! is_wp_error( $id ) ) {
			update_post_meta( $id, PORTAL_SI_EVENTO_DATE_META, $sample['date'] );
		}
	}

	update_option( 'portal_si_eventos_seeded_v1', 1 );
}

/**
 * Cria exemplos na primeira visita ao painel se ainda não houver eventos.
 */
function portal_si_maybe_seed_eventos() {
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	portal_si_seed_sample_eventos();
}
add_action( 'admin_init', 'portal_si_maybe_seed_eventos', 7 );

/**
 * Regras de permalink ao ativar o tema.
 */
function portal_si_evento_flush_rewrites() {
	portal_si_register_evento_cpt();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'portal_si_evento_flush_rewrites' );

/**
 * Atualiza permalinks após mudanças no CPT (ex.: slug /evento/).
 */
function portal_si_evento_maybe_flush_rewrites() {
	$flag = 'portal_si_evento_rewrites_' . PORTAL_SI_CEFET_VERSION;
	if ( get_option( $flag ) ) {
		return;
	}
	flush_rewrite_rules( false );
	update_option( $flag, 1 );
}
add_action( 'init', 'portal_si_evento_maybe_flush_rewrites', 99 );

/**
 * Garante que /evento/slug aponte ao CPT quando as rewrite rules estiverem desatualizadas.
 *
 * @param WP $wp Instância global do WordPress.
 */
function portal_si_evento_parse_request( $wp ) {
	if ( is_admin() || empty( $wp->request ) ) {
		return;
	}

	$path = trim( $wp->request, '/' );
	if ( ! preg_match( '#^evento/([^/]+)/?$#', $path, $matches ) ) {
		return;
	}

	if ( ! empty( $wp->query_vars['name'] ) && PORTAL_SI_EVENTO_POST_TYPE === ( $wp->query_vars['post_type'] ?? '' ) ) {
		return;
	}

	$wp->query_vars['post_type'] = PORTAL_SI_EVENTO_POST_TYPE;
	$wp->query_vars['name']      = $matches[1];
	$wp->query_vars[ PORTAL_SI_EVENTO_POST_TYPE ] = $matches[1];

	unset( $wp->query_vars['pagename'], $wp->query_vars['page'], $wp->query_vars['error'] );
}
add_action( 'parse_request', 'portal_si_evento_parse_request', 5 );
