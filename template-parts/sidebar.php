<?php
/**
 * The sidebar: avatar, site title/tagline, tab navigation, mode toggle,
 * and contact icons.
 *
 * @package Oviya
 */
?>
<aside aria-label="Sidebar" id="sidebar" class="d-flex flex-column align-items-end">
	<header class="profile-wrapper">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="avatar" class="rounded-circle">
			<?php if ( has_custom_logo() ) : ?>
				<?php
				$logo_id  = get_theme_mod( 'custom_logo' );
				$logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
				?>
				<img src="<?php echo esc_url( $logo_url ); ?>" width="112" height="112" alt="avatar" onerror="this.style.display='none'">
			<?php endif; ?>
		</a>

		<a class="site-title d-block" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		<p class="site-subtitle fst-italic mb-0"><?php bloginfo( 'description' ); ?></p>
	</header>

	<nav class="flex-column flex-grow-1 w-100 ps-0">
		<ul class="nav">
			<li class="nav-item<?php echo ( is_front_page() || is_home() ) ? ' active' : ''; ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-link">
					<i class="fa-fw fas fa-home"></i>
					<span><?php esc_html_e( 'HOME', 'oviya' ); ?></span>
				</a>
			</li>

			<?php
			$tabs = oviya_get_sidebar_tabs();
			foreach ( $tabs as $tab ) :
				$icon      = oviya_guess_tab_icon( $tab );
				$is_active = ( get_permalink( $tab->object_id ) === $tab->url ) && is_page( $tab->object_id );
				?>
				<li class="nav-item<?php echo $is_active ? ' active' : ''; ?>">
					<a href="<?php echo esc_url( $tab->url ); ?>" class="nav-link">
						<i class="fa-fw <?php echo esc_attr( $icon ); ?>"></i>
						<span><?php echo esc_html( mb_strtoupper( $tab->title ) ); ?></span>
					</a>
				</li>
				<?php
			endforeach;
			?>
		</ul>
	</nav>

	<div class="sidebar-bottom d-flex flex-wrap align-items-center w-100">
		<?php if ( 'auto' === get_theme_mod( 'oviya_theme_mode', 'auto' ) ) : ?>
			<div class="btn-group dropup">
				<button type="button" class="btn btn-link nav-link" aria-label="Switch Mode" id="mode-toggle" data-bs-toggle="dropdown">
					<i class="fa-regular fa-sun" data-theme-mode="light"></i>
					<i class="fa-regular fa-moon" data-theme-mode="dark"></i>
					<i class="fa-solid fa-display" data-theme-mode="system"></i>
				</button>
				<ul class="dropdown-menu rounded-3 mb-1 p-1">
					<li>
						<button class="dropdown-item d-flex align-items-center" type="button" data-theme-mode="light">
							<i class="fa-regular fa-sun" data-theme-mode="light"></i><?php esc_html_e( 'Light', 'oviya' ); ?>
						</button>
					</li>
					<li>
						<button class="dropdown-item d-flex align-items-center" type="button" data-theme-mode="dark">
							<i class="fa-regular fa-moon" data-theme-mode="dark"></i><?php esc_html_e( 'Dark', 'oviya' ); ?>
						</button>
					</li>
					<li>
						<button class="dropdown-item d-flex align-items-center" type="button" data-theme-mode="system">
							<i class="fa-solid fa-display" data-theme-mode="system"></i><?php esc_html_e( 'System', 'oviya' ); ?>
						</button>
					</li>
				</ul>
			</div>
			<?php if ( oviya_contact_links() ) : ?>
				<span class="icon-border"></span>
			<?php endif; ?>
		<?php endif; ?>

		<?php foreach ( oviya_contact_links() as list( $type, $icon, $url ) ) : ?>
			<a href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( $type ); ?>"
				<?php if ( 'email' !== $type ) : ?>target="_blank" rel="noopener noreferrer<?php echo 'mastodon' === $type ? ' me' : ''; ?>"<?php endif; ?>>
				<i class="<?php echo esc_attr( $icon ); ?>"></i>
			</a>
		<?php endforeach; ?>
	</div>
</aside>
