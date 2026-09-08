<?php
/**
 * Template Name: Oviya - Archives
 *
 * @package Oviya
 */

get_header();
?>
<article class="px-1">
	<h1 class="dynamic-title"><?php the_title(); ?></h1>

	<div class="content">
		<div id="archives" class="pl-xl-3">
			<?php
			$all_posts = get_posts(
				array(
					'post_type'      => 'post',
					'posts_per_page' => -1,
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			);

			$last_year = '';
			foreach ( $all_posts as $index => $archive_post ) :
				$year = get_the_date( 'Y', $archive_post );

				if ( $year !== $last_year ) {
					if ( '' !== $last_year ) {
						echo '</ul>';
					}
					printf( '<time class="year lead d-block">%s</time><ul class="list-unstyled">', esc_html( $year ) );
					$last_year = $year;
				}
				?>
				<li>
					<span class="date day"><?php echo esc_html( get_the_date( 'd', $archive_post ) ); ?></span>
					<span class="date month small text-muted ms-1"><?php echo esc_html( get_the_date( 'M', $archive_post ) ); ?></span>
					<a href="<?php echo esc_url( get_permalink( $archive_post ) ); ?>"><?php echo esc_html( get_the_title( $archive_post ) ); ?></a>
				</li>
				<?php
				if ( $index === count( $all_posts ) - 1 ) {
					echo '</ul>';
				}
			endforeach;

			if ( empty( $all_posts ) ) {
				echo '<p class="text-muted">' . esc_html__( 'No posts yet.', 'oviya' ) . '</p>';
			}
			?>
		</div>
	</div>
</article>
<?php
get_footer();
