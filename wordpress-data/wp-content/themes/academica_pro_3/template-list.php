<?php
/*
Template Name: Parent Page
*/
?>
<?php get_header(); ?>

	<div id="main">

		<?php
		if (!is_active_sidebar('sidebar-left')) { $no_side_left = true; }
		if (!is_active_sidebar('sidebar-right')) { $no_side_right = true; }
		?>

		<div class="wrapper">

			<?php while (have_posts()) : the_post();
			$template = get_post_meta($post->ID, 'wpzoom_post_template', true);
			endwhile;
			?>

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
			} else {
				echo 'column-medium';
			} ?>">

				<div class="content-block">
					<h1 class="post-title"><?php the_title(); ?></h1>
					<?php edit_post_link( __('Edit page', 'wpzoom'), '<p class="post-meta">', '</p>'); ?>

					<div class="post-content">
						<?php the_content(); ?>

						<div class="cleaner">&nbsp;</div>

					</div><!-- end .post-content -->

					<div class="divider divider-notop">&nbsp;</div>

					<?php get_template_part('loop','child-pages'); ?>

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

		</div><!-- end .wrapper -->

	</div><!-- end #main -->

<?php get_footer(); ?>