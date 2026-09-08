<?php
/**
 * Closes <main>, renders the right-hand panel, the tail content, and the site footer.
 *
 * @package Oviya
 */
?>
			</main>

			<aside aria-label="Panel" id="panel-wrapper" class="col-xl-3 ps-2 text-muted">
				<?php get_template_part( 'template-parts/panel' ); ?>
			</aside>
		</div>

		<div class="row">
			<div id="tail-wrapper" class="col-12 col-lg-11 col-xl-9 px-md-4">
				<?php do_action( 'oviya_tail_content' ); ?>

				<footer aria-label="Site Info" class="d-flex flex-column justify-content-center text-muted flex-lg-row justify-content-lg-between align-items-lg-center pb-lg-3">
					<p>
						&copy;
						<time><?php echo esc_html( gmdate( 'Y' ) ); ?></time>
						<?php
						$copyright_name = get_theme_mod( 'oviya_copyright_name' );
						$copyright_url  = get_theme_mod( 'oviya_copyright_url' );
						if ( ! $copyright_name ) {
							$copyright_name = get_bloginfo( 'name' );
						}
						if ( $copyright_url ) :
							?>
							<a href="<?php echo esc_url( $copyright_url ); ?>"><?php echo esc_html( $copyright_name ); ?></a>.
						<?php else : ?>
							<em class="fst-normal"><?php echo esc_html( $copyright_name ); ?></em>.
						<?php endif; ?>All rights reserved.
					</p>

					<p>
						<?php
						printf(
							/* translators: 1: link to apurgroup.com, 2: theme name */
							esc_html__( '%2$s theme by %1$s', 'oviya' ),
							'<a href="https://www.apurgroup.com" target="_blank" rel="noopener">Apur Group</a>',
							'Oviya'
						);
						?>
					</p>
				</footer>
			</div>
		</div>

	</div>

	<aside aria-label="Scroll to Top">
		<button id="back-to-top" type="button" class="btn btn-lg btn-box-shadow">
			<i class="fas fa-angle-up"></i>
		</button>
	</aside>
</div>

<div id="mask" class="d-none position-fixed w-100 h-100 z-1"></div>

<?php wp_footer(); ?>
</body>
</html>
