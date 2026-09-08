<?php
/**
 * Tag archive template.
 *
 * @package Oviya
 */

get_header();
$term = get_queried_object();
?>
<div id="page-tag">
	<h1 class="ps-lg-2">
		<i class="fa fa-tag fa-fw text-muted"></i>
		<?php single_tag_title(); ?>
		<span class="lead text-muted ps-2"><?php echo esc_html( $term->count ); ?></span>
	</h1>

	<ul class="content ps-0">
		<?php while ( have_posts() ) : the_post(); ?>
			<li class="d-flex justify-content-between px-md-3">
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
