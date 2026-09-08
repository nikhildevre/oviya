<?php
/**
 * The top bar: breadcrumb, hamburger trigger, page title, and search box.
 *
 * @package Oviya
 */
?>
<header id="topbar-wrapper" class="flex-shrink-0" aria-label="Top Bar">
	<div id="topbar" class="d-flex align-items-center justify-content-between px-lg-3 h-100">
		<?php oviya_breadcrumb(); ?>

		<button type="button" id="sidebar-trigger" class="btn btn-link" aria-label="Sidebar">
			<i class="fas fa-bars fa-fw"></i>
		</button>

		<div id="topbar-title"><?php echo esc_html( oviya_topbar_title() ); ?></div>

		<button type="button" id="search-trigger" class="btn btn-link" aria-label="Search">
			<i class="fas fa-search fa-fw"></i>
		</button>

		<search id="search" class="align-items-center ms-3 ms-lg-0">
			<i class="fas fa-search fa-fw"></i>
			<?php get_search_form(); ?>
		</search>
		<button type="button" class="btn btn-link text-decoration-none" id="search-cancel">
			<?php esc_html_e( 'Cancel', 'oviya' ); ?>
		</button>
	</div>
</header>
