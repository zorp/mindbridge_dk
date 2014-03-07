<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package untitled
 */
?>

	</div><!-- #main .site-main -->
</div><!-- #page .hfeed .site -->

	<div id="colophon-wrap">
		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="footer-widget first"><?php dynamic_sidebar( 'footer-1' ); ?></div>
			<div class="footer-widget"><?php dynamic_sidebar( 'footer-2' ); ?></div>
			<div class="footer-widget last"><?php dynamic_sidebar( 'footer-3' ); ?></div>
			<div class="site-info">
				<?php do_action( 'untitled_credits' ); ?>
				<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'untitled' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'untitled' ), 'WordPress' ); ?></a>.
				<?php printf( __( 'Theme: %1$s by %2$s.', 'untitled' ), 'Untitled', '<a href="http://theme.wordpress.com/" rel="designer">WordPress.com</a>' ); ?>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #colophon-wrap -->

<?php wp_footer(); ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-116454-25', 'mindbridge.dk');
  ga('send', 'pageview');

</script>
</body>
</html>