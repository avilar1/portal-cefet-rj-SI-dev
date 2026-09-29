<?php
/**
 * Pesquisa e Extensão — hub (RF11): atalhos, projetos em andamento e parcerias.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$projetos_url  = portal_si_page_url( PORTAL_SI_PROJETOS_SLUG );
$pesquisa      = portal_si_get_projetos(
	array(
		'tipo'     => 'pesquisa',
		'situacao' => 'andamento',
		'limit'    => 3,
	)
);
$extensao      = portal_si_get_projetos(
	array(
		'tipo'     => 'extensao',
		'situacao' => 'andamento',
		'limit'    => 3,
	)
);
$parcerias     = portal_si_pesquisa_parcerias();
$shortcuts     = array(
	array(
		'url'   => $projetos_url,
		'title' => __( 'Projetos', 'portal-si-cefet' ),
		'desc'  => __( 'Pesquisa e extensão, com responsável e situação.', 'portal-si-cefet' ),
	),
	array(
		'url'   => portal_si_page_url( PORTAL_SI_IC_SLUG ),
		'title' => __( 'Iniciação científica', 'portal-si-cefet' ),
		'desc'  => __( 'Como participar e projetos que aceitam alunos.', 'portal-si-cefet' ),
	),
	array(
		'url'   => portal_si_page_url( 'corpo-docente' ),
		'title' => __( 'Corpo docente', 'portal-si-cefet' ),
		'desc'  => __( 'Professores, formação e linhas de atuação.', 'portal-si-cefet' ),
	),
	array(
		'url'   => portal_si_page_url( 'fabrica-de-software' ),
		'title' => __( 'Fábrica de Software', 'portal-si-cefet' ),
		'desc'  => __( 'Projetos de extensão com parceiros externos.', 'portal-si-cefet' ),
	),
);

get_header();
?>
<main id="main-content" class="site-main site-main--page site-main--pesquisa" tabindex="-1">
	<?php portal_si_the_breadcrumbs(); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="portal-page-header">
			<h1 class="portal-page-header__title"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="portal-page-header__intro"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php else : ?>
				<p class="portal-page-header__intro">
					<?php esc_html_e( 'Projetos de pesquisa, extensão e parcerias do curso de Sistemas de Informação.', 'portal-si-cefet' ); ?>
				</p>
			<?php endif; ?>
			<?php if ( get_the_content() ) : ?>
				<div class="portal-page-header__intro entry-content">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
		</header>
		<?php
	endwhile;
	wp_reset_postdata();
	?>

	<div class="portal-pesquisa-hub__grid">
		<nav aria-label="<?php esc_attr_e( 'Seções de Pesquisa e Extensão', 'portal-si-cefet' ); ?>">
			<ul class="portal-pesquisa-hub__links">
				<?php foreach ( $shortcuts as $shortcut ) : ?>
					<li>
						<a class="<?php echo esc_attr( portal_si_br_card_class( array( 'hover' ) ) . ' portal-pesquisa-hub__link-card' ); ?>" href="<?php echo esc_url( $shortcut['url'] ); ?>">
							<span class="card-content">
								<span class="portal-pesquisa-hub__link-title"><?php echo esc_html( $shortcut['title'] ); ?></span>
								<span class="portal-pesquisa-hub__link-desc"><?php echo esc_html( $shortcut['desc'] ); ?></span>
							</span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>

		<section aria-labelledby="pesquisa-projetos-title">
			<header class="portal-section-header">
				<h2 id="pesquisa-projetos-title" class="portal-pesquisa-hub__section-title"><?php esc_html_e( 'Projetos de pesquisa em andamento', 'portal-si-cefet' ); ?></h2>
				<a class="portal-section-header__more" href="<?php echo esc_url( add_query_arg( 'tipo', 'pesquisa', $projetos_url ) ); ?>"><?php esc_html_e( 'Ver todos', 'portal-si-cefet' ); ?></a>
			</header>
			<?php
			get_template_part(
				'template-parts/projeto/grid',
				null,
				array(
					'items'             => $pesquisa,
					'show_exemplo_note' => true,
					'empty_message'     => __( 'Nenhum projeto de pesquisa em andamento divulgado no momento.', 'portal-si-cefet' ),
				)
			);
			?>
		</section>

		<section aria-labelledby="pesquisa-extensao-title">
			<header class="portal-section-header">
				<h2 id="pesquisa-extensao-title" class="portal-pesquisa-hub__section-title"><?php esc_html_e( 'Projetos de extensão em andamento', 'portal-si-cefet' ); ?></h2>
				<a class="portal-section-header__more" href="<?php echo esc_url( add_query_arg( 'tipo', 'extensao', $projetos_url ) ); ?>"><?php esc_html_e( 'Ver todos', 'portal-si-cefet' ); ?></a>
			</header>
			<?php
			get_template_part(
				'template-parts/projeto/grid',
				null,
				array(
					'items'         => $extensao,
					'empty_message' => __( 'Nenhum projeto de extensão em andamento divulgado no momento. Conheça também a Fábrica de Software.', 'portal-si-cefet' ),
				)
			);
			?>
		</section>

		<section aria-labelledby="pesquisa-parcerias-title">
			<h2 id="pesquisa-parcerias-title" class="portal-pesquisa-hub__section-title">
				<?php esc_html_e( 'Parcerias e convênios', 'portal-si-cefet' ); ?>
			</h2>
			<?php if ( $parcerias ) : ?>
				<ul class="portal-parcerias">
					<?php foreach ( $parcerias as $parceria ) : ?>
						<li class="<?php echo esc_attr( portal_si_br_card_class() . ' portal-parcerias__item' ); ?>">
							<div class="card-content">
								<h3 class="portal-parcerias__name">
									<?php if ( $parceria['url'] ) : ?>
										<a href="<?php echo esc_url( $parceria['url'] ); ?>" target="_blank" rel="noopener noreferrer">
											<?php echo esc_html( $parceria['label'] ); ?>
											<span class="screen-reader-text"><?php esc_html_e( '(abre em nova aba)', 'portal-si-cefet' ); ?></span>
										</a>
									<?php else : ?>
										<?php echo esc_html( $parceria['label'] ); ?>
									<?php endif; ?>
								</h3>
								<?php if ( $parceria['description'] ) : ?>
									<p class="portal-parcerias__desc"><?php echo esc_html( $parceria['description'] ); ?></p>
								<?php endif; ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php else : ?>
				<?php
				portal_si_the_coming_soon_notice(
					array(
						'variant' => 'section',
						'badge'   => __( 'Conteúdo em breve', 'portal-si-cefet' ),
						'message' => __( 'Convênios institucionais e parcerias vigentes serão apresentados nesta seção.', 'portal-si-cefet' ),
					)
				);
				?>
			<?php endif; ?>
		</section>
	</div>
</main>
<?php
get_footer();
