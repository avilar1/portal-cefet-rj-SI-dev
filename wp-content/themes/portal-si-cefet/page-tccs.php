<?php
/**
 * Repositório de TCCs — busca por título, autor, orientador e ano (RF25).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$filters  = portal_si_tccs_current_filters();
$options  = portal_si_tccs_filter_options();
$results  = portal_si_filter_tccs( $filters );
$total    = count( $results );
$total_pages = max( 1, (int) ceil( $total / PORTAL_SI_TCC_PER_PAGE ) );
$current  = isset( $_GET['pagina'] ) ? max( 1, min( $total_pages, absint( $_GET['pagina'] ) ) ) : 1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$items    = array_slice( $results, ( $current - 1 ) * PORTAL_SI_TCC_PER_PAGE, PORTAL_SI_TCC_PER_PAGE );
$filtered = '' !== $filters['busca'] || $filters['ano'] || '' !== $filters['orientador'];
$has_ex   = (bool) array_filter( wp_list_pluck( $items, 'exemplo' ) );
$page_url = get_permalink();

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--tccs" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header portal-tcc-header">
			<p class="portal-tcc-header__badge"><?php esc_html_e( 'Produção acadêmica', 'portal-si-cefet' ); ?></p>
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<p class="portal-page-header__intro">
				<?php
				echo esc_html(
					has_excerpt()
						? get_the_excerpt()
						: __( 'Trabalhos de Conclusão de Curso defendidos no curso de Sistemas de Informação. Busque por título, autor, orientador ou palavra-chave.', 'portal-si-cefet' )
				);
				?>
			</p>
		</header>

		<div class="portal-tcc-body">
			<form class="portal-tcc-search" role="search" method="get" action="<?php echo esc_url( $page_url ); ?>">
				<div class="portal-tcc-search__field portal-tcc-search__field--text">
					<label for="tcc-busca"><?php esc_html_e( 'Buscar', 'portal-si-cefet' ); ?></label>
					<input type="search" id="tcc-busca" name="busca" value="<?php echo esc_attr( $filters['busca'] ); ?>" placeholder="<?php esc_attr_e( 'Título, autor, orientador ou palavra-chave', 'portal-si-cefet' ); ?>" />
				</div>
				<div class="portal-tcc-search__field">
					<label for="tcc-ano"><?php esc_html_e( 'Ano', 'portal-si-cefet' ); ?></label>
					<select id="tcc-ano" name="ano">
						<option value=""><?php esc_html_e( 'Todos', 'portal-si-cefet' ); ?></option>
						<?php foreach ( $options['anos'] as $ano ) : ?>
							<option value="<?php echo esc_attr( $ano ); ?>" <?php selected( $filters['ano'], $ano ); ?>><?php echo esc_html( $ano ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="portal-tcc-search__field">
					<label for="tcc-orientador"><?php esc_html_e( 'Orientador(a)', 'portal-si-cefet' ); ?></label>
					<select id="tcc-orientador" name="orientador">
						<option value=""><?php esc_html_e( 'Todos', 'portal-si-cefet' ); ?></option>
						<?php foreach ( $options['orientadores'] as $nome ) : ?>
							<option value="<?php echo esc_attr( $nome ); ?>" <?php selected( $filters['orientador'], $nome ); ?>><?php echo esc_html( $nome ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="portal-tcc-search__actions">
					<button type="submit" class="portal-btn portal-btn--primary"><?php esc_html_e( 'Buscar', 'portal-si-cefet' ); ?></button>
					<?php if ( $filtered ) : ?>
						<a class="portal-tcc-search__clear" href="<?php echo esc_url( $page_url ); ?>"><?php esc_html_e( 'Limpar filtros', 'portal-si-cefet' ); ?></a>
					<?php endif; ?>
				</div>
			</form>

			<p class="portal-tcc-count" aria-live="polite">
				<?php
				printf(
					/* translators: %d: quantidade de TCCs. */
					esc_html( _n( '%d trabalho encontrado', '%d trabalhos encontrados', $total, 'portal-si-cefet' ) ),
					(int) $total
				);
				?>
			</p>

			<?php if ( $has_ex ) : ?>
				<p class="portal-tcc-exemplo-note" role="note">
					<?php esc_html_e( 'Trabalhos com o selo "Exemplo" são ilustrativos e serão substituídos pelos TCCs reais do curso.', 'portal-si-cefet' ); ?>
				</p>
			<?php endif; ?>

			<?php if ( $items ) : ?>
				<ul class="portal-tcc-list">
					<?php
					foreach ( $items as $tcc ) {
						get_template_part(
							'template-parts/tcc/item',
							null,
							array(
								'tcc'     => $tcc,
								'heading' => 'h2',
							)
						);
					}
					?>
				</ul>
			<?php else : ?>
				<?php
				portal_si_the_coming_soon_notice(
					array(
						'variant' => 'compact',
						'message' => $filtered
							? __( 'Nenhum trabalho encontrado com esses filtros. Tente outros termos ou limpe os filtros.', 'portal-si-cefet' )
							: __( 'Nenhum TCC publicado ainda.', 'portal-si-cefet' ),
					)
				);
				?>
			<?php endif; ?>

			<?php
			if ( $total_pages > 1 ) :
				$links = paginate_links(
					array(
						'base'      => add_query_arg( 'pagina', '%#%', add_query_arg( array_filter( $filters ), $page_url ) ),
						'format'    => '',
						'total'     => $total_pages,
						'current'   => $current,
						'prev_text' => __( '← Anteriores', 'portal-si-cefet' ),
						'next_text' => __( 'Próximos →', 'portal-si-cefet' ),
					)
				);
				?>
				<nav class="portal-tcc-pagination" aria-label="<?php esc_attr_e( 'Páginas de resultados', 'portal-si-cefet' ); ?>">
					<?php echo wp_kses_post( $links ); ?>
				</nav>
			<?php endif; ?>
		</div>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
