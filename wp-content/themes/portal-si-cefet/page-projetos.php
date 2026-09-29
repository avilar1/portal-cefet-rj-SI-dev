<?php
/**
 * Projetos de pesquisa e extensão — listagem com filtros (RF09).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$filters  = portal_si_projetos_current_filters();
$projetos = portal_si_get_projetos( $filters );
$page_url = get_permalink();

/**
 * Link de filtro preservando o outro filtro.
 *
 * @param string $key   tipo|situacao.
 * @param string $value Valor ('' = todos).
 */
$filter_url = function ( $key, $value ) use ( $filters, $page_url ) {
	$query         = array_filter( $filters );
	$query[ $key ] = $value;
	return add_query_arg( array_filter( $query ), $page_url );
};

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--projetos" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header portal-pesquisa-header">
			<p class="portal-pesquisa-header__badge"><?php esc_html_e( 'Pesquisa e Extensão', 'portal-si-cefet' ); ?></p>
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<p class="portal-page-header__intro">
				<?php
				echo esc_html(
					has_excerpt()
						? get_the_excerpt()
						: __( 'Projetos de pesquisa e de extensão coordenados pelos professores do curso, com a situação atual de cada um.', 'portal-si-cefet' )
				);
				?>
			</p>
		</header>

		<div class="portal-pesquisa-body">
			<nav class="portal-projeto-filters" aria-label="<?php esc_attr_e( 'Filtrar projetos', 'portal-si-cefet' ); ?>">
				<?php
				$groups = array(
					'tipo'     => array(
						'label'   => __( 'Tipo', 'portal-si-cefet' ),
						'all'     => __( 'Todos', 'portal-si-cefet' ),
						'options' => portal_si_projeto_tipos(),
					),
					'situacao' => array(
						'label'   => __( 'Situação', 'portal-si-cefet' ),
						'all'     => __( 'Todas', 'portal-si-cefet' ),
						'options' => portal_si_projeto_situacoes(),
					),
				);
				foreach ( $groups as $key => $group ) :
					?>
					<div class="portal-projeto-filters__group">
						<span class="portal-projeto-filters__label" id="filtro-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $group['label'] ); ?>:</span>
						<ul class="portal-projeto-filters__list" aria-labelledby="filtro-<?php echo esc_attr( $key ); ?>">
							<li>
								<a class="portal-projeto-filters__link" href="<?php echo esc_url( $filter_url( $key, '' ) ); ?>" <?php echo '' === $filters[ $key ] ? 'aria-current="true"' : ''; ?>><?php echo esc_html( $group['all'] ); ?></a>
							</li>
							<?php foreach ( $group['options'] as $value => $label ) : ?>
								<li>
									<a class="portal-projeto-filters__link" href="<?php echo esc_url( $filter_url( $key, $value ) ); ?>" <?php echo $value === $filters[ $key ] ? 'aria-current="true"' : ''; ?>><?php echo esc_html( $label ); ?></a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</nav>

			<p class="portal-projeto-count" aria-live="polite">
				<?php
				printf(
					/* translators: %d: quantidade de projetos. */
					esc_html( _n( '%d projeto encontrado', '%d projetos encontrados', count( $projetos ), 'portal-si-cefet' ) ),
					count( $projetos )
				);
				?>
			</p>

			<?php
			get_template_part(
				'template-parts/projeto/grid',
				null,
				array(
					'items'             => $projetos,
					'heading'           => 'h2',
					'show_exemplo_note' => true,
					'empty_message'     => ( $filters['tipo'] || $filters['situacao'] )
						? __( 'Nenhum projeto com esses filtros.', 'portal-si-cefet' )
						: __( 'Nenhum projeto publicado ainda.', 'portal-si-cefet' ),
				)
			);
			?>

			<aside class="portal-pesquisa-cta">
				<h2 class="portal-pesquisa-cta__title"><?php esc_html_e( 'Quer participar de um projeto?', 'portal-si-cefet' ); ?></h2>
				<p class="portal-pesquisa-cta__text"><?php esc_html_e( 'Veja como funciona a iniciação científica e quais projetos estão aceitando alunos.', 'portal-si-cefet' ); ?></p>
				<a class="portal-btn portal-btn--primary" href="<?php echo esc_url( portal_si_page_url( 'iniciacao-cientifica' ) ); ?>"><?php esc_html_e( 'Iniciação científica', 'portal-si-cefet' ); ?></a>
			</aside>
		</div>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
