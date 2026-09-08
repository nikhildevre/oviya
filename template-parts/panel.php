<?php
/**
 * The right-hand panel.
 *
 * @package Oviya
 */

if ( oviya_toc_enabled() ) :
	?>
	<div class="toc-border-cover z-3"></div>
	<section id="toc-wrapper" class="invisible position-sticky ps-0 pe-4 pb-4">
		<h2 class="panel-heading ps-3 pb-2 mb-0"><?php esc_html_e( 'Contents', 'oviya' ); ?></h2>
		<nav id="toc"></nav>
	</section>
	<?php
endif;
?>

<div class="access">
	<?php
	$recent = oviya_recently_updated( 5 );
	if ( $recent ) :
		?>
		<section id="access-lastmod">
			<h2 class="panel-heading"><?php esc_html_e( 'Recently Updated', 'oviya' ); ?></h2>
			<ul class="content list-unstyled ps-0 pb-1 ms-1 mt-2">
				<?php foreach ( $recent as $recent_post ) : ?>
					<li class="text-truncate lh-lg">
						<a href="<?php echo esc_url( get_permalink( $recent_post ) ); ?>"><?php echo esc_html( get_the_title( $recent_post ) ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endif; ?>

	<?php
	$trending = oviya_trending_tags( 10 );
	if ( $trending && ! is_wp_error( $trending ) ) :
		?>
		<section>
			<h2 class="panel-heading"><?php esc_html_e( 'Trending Tags', 'oviya' ); ?></h2>
			<div class="d-flex flex-wrap mt-3 mb-1 me-3">
				<?php foreach ( $trending as $tag ) : ?>
					<a class="post-tag btn btn-outline-primary" href="<?php echo esc_url( get_term_link( $tag ) ); ?>"><?php echo esc_html( $tag->name ); ?></a>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>
</div>

<?php if ( is_active_sidebar( 'panel-widgets' ) ) : ?>
	<?php dynamic_sidebar( 'panel-widgets' ); ?>
<?php endif; ?>
