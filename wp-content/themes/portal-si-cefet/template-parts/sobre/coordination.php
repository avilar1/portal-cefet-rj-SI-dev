<?php
/**
 * Coordenação — mesma fonte da página Contato (RF02 / RF29).
 *
 * @package Portal_SI_CEFET
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'portal_si_contato_coordination' ) ) {
	return;
}

$coord  = portal_si_contato_coordination();
$people = isset( $coord['people'] ) && is_array( $coord['people'] ) ? $coord['people'] : array();

if ( empty( $people ) ) {
	return;
}
?>
<section id="coordenacao" class="portal-sobre-section">
	<h2 class="portal-sobre-section__title"><?php esc_html_e( 'Coordenação e direção', 'portal-si-cefet' ); ?></h2>
	<p><?php esc_html_e( 'O curso conta com uma equipe dedicada de professores e coordenadores comprometidos com a excelência do ensino e o desenvolvimento dos alunos.', 'portal-si-cefet' ); ?></p>
	<div class="portal-sobre-person-grid">
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
			$tel = $phone && function_exists( 'portal_si_contato_phone_href' ) ? portal_si_contato_phone_href( $phone ) : '';
			?>
			<div class="portal-sobre-person-card br-card">
				<div class="card-content portal-sobre-person-card__inner">
					<span class="portal-sobre-person-card__avatar" aria-hidden="true"><?php portal_si_sobre_icon_person(); ?></span>
					<div class="portal-sobre-person-card__body">
						<h3 class="portal-sobre-person-card__name"><?php echo esc_html( $heading ); ?></h3>
						<?php if ( '' !== $name && '' !== $role ) : ?>
							<p class="portal-sobre-person-card__role"><?php echo esc_html( $role ); ?></p>
						<?php elseif ( '' === $name && '' !== $role ) : ?>
							<p class="portal-sobre-person-card__contact portal-sobre-person-card__contact--muted"><?php esc_html_e( 'Nome e telefone em atualização.', 'portal-si-cefet' ); ?></p>
						<?php endif; ?>
						<?php if ( $email && is_email( $email ) ) : ?>
							<p class="portal-sobre-person-card__contact"><span aria-hidden="true">✉</span> <a href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
						<?php endif; ?>
						<?php if ( $phone ) : ?>
							<p class="portal-sobre-person-card__contact">
								<span aria-hidden="true">☎</span>
								<?php if ( $tel ) : ?>
									<a href="<?php echo esc_url( $tel ); ?>"><?php echo esc_html( $phone ); ?></a>
								<?php else : ?>
									<?php echo esc_html( $phone ); ?>
								<?php endif; ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<aside class="portal-sobre-office">
		<h3 class="portal-sobre-office__title"><?php esc_html_e( 'Horário de atendimento', 'portal-si-cefet' ); ?></h3>
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
</section>
