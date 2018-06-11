	<footer class="site-footer">

		<div class="wrapper">

            <div class="widget-areas">

                <?php if ( is_active_sidebar( 'Footer: Column 1' ) ) : ?>
        			<div class="column">

        				<?php dynamic_sidebar('Footer: Column 1'); ?>

        				<div class="cleaner">&nbsp;</div>
        			</div><!-- end .column -->

                <?php endif; ?>

                <?php if ( is_active_sidebar( 'Footer: Column 2' ) ) : ?>

        			<div class="column">

        				<?php dynamic_sidebar('Footer: Column 2'); ?>

        				<div class="cleaner">&nbsp;</div>
        			</div><!-- end .column -->

                <?php endif; ?>

                <?php if ( is_active_sidebar( 'Footer: Column 3' ) ) : ?>
        			<div class="column">

        				<?php dynamic_sidebar('Footer: Column 3'); ?>

        				<div class="cleaner">&nbsp;</div>
        			</div><!-- end .column -->

                <?php endif; ?>

                <?php if ( is_active_sidebar( 'Footer: Column 4' ) ) : ?>
        			<div class="column">

        				<?php dynamic_sidebar('Footer: Column 4'); ?>

        				<div class="cleaner">&nbsp;</div>
        			</div><!-- end .column -->

                <?php endif; ?>

            </div>

            <div class="cleaner">&nbsp;</div>

		</div><!-- end .wrapper -->

	</footer>

	<div id="footer-copy">
		<div class="wrapper wrapper-copy">
			<p class="copyright"><?php zoom_customizer_partial_blogcopyright(); ?></p>
            <p class="wpzoom"><?php _e('WordPress Theme', 'wpzoom'); ?> <?php _e('by', 'wpzoom'); ?> <a href="https://www.wpzoom.com/" target="_blank">WPZOOM</a></p>

			<div class="cleaner">&nbsp;</div>
		</div><!-- end .wrapper .wrapper-copy -->
	</div><!-- end #footer-copy -->

</div><!-- end #container -->

<?php wp_footer(); ?>

</body>
</html>