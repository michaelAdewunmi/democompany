<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package democompany
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'democompany' ); ?></a>

	<header id="masthead" class="site-header container" style="background-image:url(<?php echo get_theme_file_uri('/images/body-map.jpg'); ?>)">
		<div class="row">
			<div class="site-branding col-8 col-md-4">
				<?php
				$democompany_description = get_bloginfo( 'description', 'display' );
				if(!has_custom_logo()){
					echo '<img width="201" height="85" class="custom-logo" src="' . get_theme_file_uri('/images/logo.jpg') . '" alt="' . $democompany_description . '" />';
				}else{
					the_custom_logo();
				}
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;

				if ( $democompany_description || is_customize_preview() ) :
					?>
					<p class="site-description"><?php echo $democompany_description; /* WPCS: xss ok. */ ?></p>
				<?php endif; ?>
			</div><!-- .site-branding -->

			<div class="col-12 col-md-8">
				<nav id="site-navigation" class="main-navigation">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
						<span class="hamburger"></span>
					</button>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					) );
					?>
				</nav><!-- #site-navigation -->
			</div><!-- .col-10 -->
		</div><!-- row -->
	</header><!-- #masthead -->

	<div id="content" class="site-content container-fluid">
