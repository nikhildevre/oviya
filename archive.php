<?php
/**
 * Generic (date-based) archive fallback.
 *
 * @package Oviya
 */

get_header();
?>
<div id="page-category">
	<h1 class="ps-lg-2"><?php echo wp_kses_post( get_the_archive_title() ); ?></h1>

	<ul class="content ps-0">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php
			$post_year = get_the_date( 'Y' );
			if ( $post_year !== $current_year ) :
				$current_year = $post_year;
				?>
				<li class="archive-year h3 mt-4 mb-2 ps-lg-2 fw-bold list-unstyled">
					<?php echo esc_html( $current_year ); ?>
				</li>
			<?php endif; ?>

			<li id="post-<?php the_ID(); ?>" <?php post_class( 'd-flex justify-content-between px-md-3' ); ?>>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				<span class="dash flex-grow-1"></span>
				<?php oviya_datetime( get_the_time( 'U' ), array( 'class' => 'text-muted small text-nowrap' ) ); ?>
			</li>
		<?php endwhile; ?>
	</ul>

	<?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
</div>
<?php
get_footer();
