<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package democompany
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer container-fluid">

		<div class="container row">
			<div class="col-12 col-md-7">
				<div class="footer-nav">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'footer-menu',
							'menu_id'        => 'footer-menu',
						) );
					?>
				</div>
					<p class="copyright-content">Copyright &copy; <?php echo date("Y") . ' ' . get_theme_mod('copyright_info') ?></p>
			</div>
			<div class="footer-img-holder col-12 col-md-5">
				<?php
					$footer_logo = get_theme_mod('footer_logo_url') ? get_theme_mod('footer_logo_url') : get_theme_file_uri() . '/images/logo.jpg';
				?>
				<a href="<?php site_url("/"); ?>">
					<img class="footer-logo" src="<?php echo $footer_logo; ?>" alt="democompany_logo" />
				</a>
			</div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
