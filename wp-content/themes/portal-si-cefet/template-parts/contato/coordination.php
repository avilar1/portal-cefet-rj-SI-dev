<?php
/**
 * Coordenação do curso — destaque RF29.
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$coord  = portal_si_contato_coordination();
$people = isset( $coord['people'] ) && is_array( $coord['people'] ) ? $coord['people'] : array();

if ( empty( $people ) ) {
	return;
}

$title = ! empty( $coord['title'] ) ? (string) $coord['title'] : __( 'Coordenação do curso', 'portal-si-cefet' );
?>
<section class="portal-contato-section portal-contato-coord" id="coordenacao" aria-labelledby="portal-contato-coord-title">
	<h2 id="portal-contato-coord-title" class="portal-contato-section__title"><?php echo esc_html( $title ); ?></h2>
	<?php if ( ! empty( $coord['intro'] ) ) : ?>
		<p class="portal-contato-section__intro"><?php echo esc_html( (string) $coord['intro'] ); ?></p>
	<?php endif; ?>

	<div class="portal-contato-coord__grid">
		<?php foreach ( $people as $person ) : ?>
			<?php
			$name    = isset( $person['name'] ) ? trim( (string) $person['name'] ) : '';
			$role    = isset( $person['role'] ) ? trim( (string) $person['role'] ) : '';
			$phone   = isset( $person['phone'] ) ? trim( (string) $person['phone'] ) : '';
			$email   = isset( $person['email'] ) ? trim( (string) $person['email'] ) : '';
			$heading = '' !== $name ? $name : $role;
			if ( '' === $heading ) {
				continue;
			}
			?>
			<article class="portal-contato-person portal-card">
				<h3 class="portal-contato-person__name"><?php echo esc_html( $heading ); ?></h3>
				<?php if ( '' !== $name && '' !== $role ) : ?>
					<p class="portal-contato-person__role"><?php echo esc_html( $role ); ?></p>
				<?php elseif ( '' === $name && '' !== $role ) : ?>
					<p class="portal-contato-person__role portal-contato-person__role--muted"><?php esc_html_e( 'Nome e telefone em atualização.', 'portal-si-cefet' ); ?></p>
				<?php endif; ?>
				<ul class="portal-contato-person__contacts">
					<?php if ( ! empty( $person['phone'] ) ) : ?>
						<?php $tel = portal_si_contato_phone_href( $person['phone'] ); ?>
						<li>
							<span class="portal-contato-person__label"><?php esc_html_e( 'Telefone', 'portal-si-cefet' ); ?></span>
							<?php if ( $tel ) : ?>
								<a href="<?php echo esc_url( $tel ); ?>"><?php echo esc_html( (string) $person['phone'] ); ?></a>
							<?php else : ?>
								<?php echo esc_html( (string) $person['phone'] ); ?>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( ! empty( $person['email'] ) && is_email( $person['email'] ) ) : ?>
						<li>
							<span class="portal-contato-person__label"><?php esc_html_e( 'E-mail', 'portal-si-cefet' ); ?></span>
							<a href="<?php echo esc_url( 'mailto:' . $person['email'] ); ?>"><?php echo esc_html( (string) $person['email'] ); ?></a>
						</li>
					<?php endif; ?>
				</ul>
			</article>
		<?php endforeach; ?>

		<aside class="portal-contato-office portal-card">
			<h3 class="portal-contato-office__title"><?php esc_html_e( 'Atendimento presencial', 'portal-si-cefet' ); ?></h3>
			<?php if ( ! empty( $coord['hours'] ) ) : ?>
				<p><strong><?php esc_html_e( 'Horário:', 'portal-si-cefet' ); ?></strong> <?php echo esc_html( (string) $coord['hours'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $coord['room'] ) ) : ?>
				<p><strong><?php esc_html_e( 'Local:', 'portal-si-cefet' ); ?></strong> <?php echo esc_html( (string) $coord['room'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $coord['address'] ) ) : ?>
				<p><strong><?php esc_html_e( 'Endereço:', 'portal-si-cefet' ); ?></strong> <?php echo esc_html( (string) $coord['address'] ); ?></p>
			<?php endif; ?>
		</aside>
	</div>
</section>
