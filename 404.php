<?php
/**
 * 404 error page.
 *
 * @package Oviya
 */

get_header();
?>
<article class="px-1 text-center py-5">
	<h1 class="display-1 fw-light">404</h1>
	<p class="lead"><?php esc_html_e( "The page you're looking for doesn't exist, or has moved.", 'oviya' ); ?></p>
	<p>
		<a class="btn btn-outline-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php esc_html_e( 'Take me home', 'oviya' ); ?>
		</a>
	</p>
	<div class="mt-4 mx-auto" style="max-width: 24rem;">
		<?php get_search_form(); ?>
	</div>
</article>
<?php
get_footer();
