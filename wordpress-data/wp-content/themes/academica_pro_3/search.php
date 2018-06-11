<?php get_header(); ?>

	<div id="main">

		<?php
		if (!is_active_sidebar('sidebar-left')) { $no_side_left = true; }
		if (!is_active_sidebar('sidebar-right')) { $no_side_right = true; }
		?>

		<div class="wrapper">

			<?php if (!isset($no_side_left)) { ?>
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
			} else {
				echo 'column-medium';
			} ?>">

				<div class="content-block">
					<h1 class="post-title"><?php _e('Search Results for', 'wpzoom');?>: <strong><em><?php the_search_query(); ?></em></strong></h1>

					<div class="divider">&nbsp;</div>

					<?php get_template_part('loop','search'); ?>

					<div class="cleaner">&nbsp;</div>
				</div><!-- end .content-block -->

				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-medium -->

			<?php if (!isset($no_side_right)) { ?>
			<div class="column column-narrow column-last">

				<?php dynamic_sidebar('Sidebar: Right Column'); ?>
				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-narrow -->
			<?php } ?>

			<div class="cleaner">&nbsp;</div>

		</div><!-- end .wrapper -->

	</div><!-- end #main -->

<?php get_footer(); ?>