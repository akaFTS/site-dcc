<?php get_header(); ?>

	<div id="main">

		<div class="wrapper">

			<?php while (have_posts()) : the_post();
			$featured_image = get_post_meta($post->ID, 'wpzoom_featured_show', true);
			$template = get_post_meta($post->ID, 'wpzoom_post_template', true);

			if (!is_active_sidebar('sidebar-left') || $template == 'side-right') { $no_side_left = true; }
			if (!is_active_sidebar('sidebar-right') || $template == 'side-left') { $no_side_right = true; }

			if ($featured_image == 'Full Width') { ?>

                <?php if ( has_post_thumbnail() ) : ?>
                    <section class="post-cover post-cover-full single-cover">
                        <?php the_post_thumbnail('homepage-slider'); ?>
                    </section>
                <?php endif; ?>

            <?php } ?>

			<?php if (!isset($no_side_left) && $template != 'side-right' && $template != 'full') { ?>
			<div class="column column-narrow">

				<?php dynamic_sidebar('Sidebar: Left Column'); ?>

				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-narrow -->
			<?php } ?>

			<div class="column <?php
			if (isset($no_side_left) && !isset($no_side_right)) {
				echo 'column-wide';
			} elseif (!isset($no_side_left) && isset($no_side_right)) {
				echo 'column-wide column-last';
			} elseif (isset($no_side_left) && isset($no_side_right)) {
				echo 'column-full column-last';
            } elseif ($template == 'full') {
                echo 'column-full column-last';
			} else {
				echo 'column-medium';
			} ?>">

				<?php
				if ($featured_image == 'Narrow' && ($template == 'side-both' || !$template)) {
                    if ( has_post_thumbnail() ) : ?>
                        <section class="post-cover single-cover">
                            <?php the_post_thumbnail('page-small'); ?>
                        </section>
                    <?php endif;

				} elseif ($featured_image == 'Narrow' && ( $template == 'side-left' || $template == 'side-right' )) {

                    if ( has_post_thumbnail() ) : ?>
                        <section class="post-cover single-cover">
                            <?php the_post_thumbnail('page-top'); ?>
                        </section>
                    <?php endif;
				} ?>

				<div class="content-block">

                    <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } ?>

					<h1 class="post-title"><?php the_title(); ?></h1>
					<?php edit_post_link( __('Edit page', 'wpzoom'), '<p class="post-meta">', '</p>'); ?>

					<div class="divider">&nbsp;</div>

					<div class="post-content">
						<?php the_content(); ?>

						<div class="cleaner">&nbsp;</div>

						<?php wp_link_pages(array('before' => '<div class="navigation"><p><strong>'.__('Pages', 'wpzoom').':</strong> ', 'after' => '</p></div>', 'next_or_number' => 'number')); ?>

					</div><!-- end .post-content -->

					<?php if (option::get('page_share') == 'on') { ?>

					<div class="divider">&nbsp;</div>
					<div class="wpzoom-share">
		                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>" target="_blank" title="<?php esc_attr_e( 'Tweet this on Twitter', 'wpzoom' ); ?>" class="twitter"><?php _e('Share on Twitter','wpzoom'); ?></a>
		                <a href="https://facebook.com/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>&t=<?php echo urlencode( get_the_title() ); ?>" target="_blank" title="<?php esc_attr_e( 'Share this on Facebook', 'wpzoom' ); ?>" class="facebook"><?php _e('Share on Facebook','wpzoom'); ?></a>
		                <a href="https://plus.google.com/share?url=<?php echo urlencode( get_permalink() ); ?>" target="_blank" title="<?php esc_attr_e( 'Post this to Google+', 'wpzoom' ); ?>" class="gplus"><?php _e('Share on Google+','wpzoom'); ?></a>
					</div><!-- end .wpzoom-share -->

					<?php } ?>

					<?php if (option::get('page_comments') == 'on') { ?>
					<div class="divider">&nbsp;</div>

					<div id="comments">
						<?php comments_template(); ?>
					</div><!-- end #comments -->

					<?php } ?>

					<div class="cleaner">&nbsp;</div>
				</div><!-- end .content-block -->

				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-medium -->

			<?php if (!isset($no_side_right) && $template != 'side-left' && $template != 'full') { ?>
			<div class="column column-narrow column-last">

				<?php dynamic_sidebar('Sidebar: Right Column'); ?>
				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-narrow -->
			<?php } ?>

			<div class="cleaner">&nbsp;</div>

			<?php endwhile; ?>

		</div><!-- end .wrapper -->

	</div><!-- end #main -->

<?php get_footer(); ?>