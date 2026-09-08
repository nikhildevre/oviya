<?php
/**
 * The header: doctype, <head>, opening <body>, sidebar, topbar, and the
 * opening tags of the two-column main/panel row.
 *
 *
 * @package Oviya
 */

$oviya_theme_mode = get_theme_mod( 'oviya_theme_mode', 'auto' );
?>
<!doctype html>
<html <?php language_attributes(); ?> <?php if ( 'auto' !== $oviya_theme_mode ) : ?>data-bs-theme="<?php echo esc_attr( $oviya_theme_mode ); ?>"<?php endif; ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>">
	<meta name="theme-color" media="(prefers-color-scheme: light)" content="#f7f7f7">
	<meta name="theme-color" media="(prefers-color-scheme: dark)" content="#1b1b1e">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">

	<?php if ( is_singular() && get_the_excerpt() ) : ?>
		<meta name="description" content="<?php echo esc_attr( wp_strip_all_tags( get_the_excerpt() ) ); ?>">
	<?php endif; ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php get_template_part( 'template-parts/sidebar' ); ?>

<div id="main-wrapper" class="d-flex justify-content-center">
	<div class="container d-flex flex-column px-xxl-5">

		<?php get_template_part( 'template-parts/topbar' ); ?>

		<div class="row flex-grow-1">
			<main aria-label="Main Content" class="col-12 col-lg-11 col-xl-9 px-md-4">
