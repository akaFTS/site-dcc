<?php
/*
Template Name: No Right Sidebar
*/
?>
<?php get_header(); ?>

	<div id="main">

		<div class="wrapper">

			<?php while (have_posts()) : the_post();
			$featured_image = get_post_meta($post->ID, 'wpzoom_featured_show', true);
			?>

			<?php
			if ($featured_image == 'Full Width') { ?>

                <?php if ( has_post_thumbnail() ) : ?>
                    <section class="post-cover post-cover-full single-cover">
                        <?php the_post_thumbnail('homepage-slider'); ?>
                    </section>
                <?php endif; ?>

			<?php } ?>

			<div class="column column-narrow">

				<?php dynamic_sidebar('Sidebar: Left Column'); ?>

				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-narrow -->

			<div class="column column-wide column-last">

				<?php
				if ($featured_image == 'Narrow') { ?>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <section class="post-cover single-cover">
                            <?php the_post_thumbnail('page-top'); ?>
                        </section>
                    <?php endif; ?>
 				<?php } ?>

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

			<div class="cleaner">&nbsp;</div>

			<?php endwhile; ?>

		</div><!-- end .wrapper -->

	</div><!-- end #main -->

<?php get_footer(); ?>