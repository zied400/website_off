<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url(get_bloginfo( 'pingback_url' )); ?>">
	<?php endif; ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class('nav-ideate'); ?>>
<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	}
?>
<div id="page" class="site">
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ideate' ); ?></a>

<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="custom-header" rel="home">
		<img src="<?php esc_url(header_image()); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr(get_bloginfo( 'title' )); ?>">
	</a>
<?php endif;  ?>	

<?php 
	get_template_part('sections/specia','header');
	get_template_part('sections/ideate','navigation'); 
?>

<div id="content" class="site-content" role="main">