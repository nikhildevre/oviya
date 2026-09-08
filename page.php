<?php
/**
 * Static page template.
 *
 * @package Oviya
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article class="px-1">
		<h1 class="dynamic-title"><?php the_title(); ?></h1>
		<div class="content">
			<?php the_content(); ?>
		</div>

		<?php if ( comments_open() || get_comments_number() ) : ?>
			<?php comments_template(); ?>
		<?php endif; ?>
	</article>
	<?php
endwhile;

get_footer();
