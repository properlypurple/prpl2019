<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Prpl2019theme
 */

?>

<footer id="colophon" class="site-footer">
	<div class="site-info">
		<nav id="footer-navigation" class="footer-navigation">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'footer-menu',
					'menu_id'        => 'footer-menu',
				) );
			?>
		</nav>
		<a href="<?php echo esc_url( __( 'https://wordpress.org/', '_s' ) ); ?>"><?php
			/* translators: %s: CMS name, i.e. WordPress. */
			printf( esc_html__( 'Proudly powered by %s', 'prpl2019theme' ), 'WordPress' );
		?></a>
	</div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
