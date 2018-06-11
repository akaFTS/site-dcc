<?php if (have_posts()) {
$i = 0;
$display_with_thumbs = option::get('display_with_thumbs');
$archive_columns = option::get('display_posts_columns');
?>

<ul class="posts-archive<?php if ($archive_columns == 'One') { echo ' archives-columns-one'; } ?>">
	<?php while (have_posts()) : the_post();
	$i++;
	if ($i <= $display_with_thumbs) {
	?>
	<li<?php if ($archive_columns == 'One') {
			echo ' class="loop-post-single"';
		}
	elseif ($archive_columns == 'Two') {
			echo ' class="loop-post';
			if ($i % 2 == 0) { echo ' post-last'; }
			echo '"';
		}
		?>>
		<?php if ( has_post_thumbnail() ) : ?>
            <div class="post-cover"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail('loop-main'); ?>
            </a></div>
        <?php endif; ?>

		<div class="post-excerpt">
			<p class="post-meta">
			<?php if (option::get('display_date') == 'on') { ?><time datetime="<?php the_time("Y-m-d"); ?>" pubdate><?php the_time(get_option('date_format')); ?></time><?php $prev = true; } ?>
			<?php if (option::get('display_category') == 'on') { if ($prev) { echo ' / '; } ?><span class="category"><?php the_category(', '); ?></span><?php } ?>
			</p>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<?php the_excerpt(); ?>
		</div><!-- end .post-excerpt -->
		<div class="cleaner">&nbsp;</div>
	</li>
	<?php if ($i % 2 == 0 || $archive_columns == 'One') { echo '<li class="divider">&nbsp;</li>'; }
	} else { ?>
	<li class="loop-post-simple">
		<div class="post-excerpt">
			<p class="post-meta"><time datetime="<?php the_time("Y-m-d"); ?>" pubdate><?php printf( __('%s', 'wpzoom'),  get_the_date()); ?></time></p>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		</div><!-- end .post-excerpt -->
		<div class="cleaner">&nbsp;</div>
	</li>
	<?php } ?>
	<?php endwhile; ?>
</ul><!-- end .posts-archive -->

<div class="cleaner">&nbsp;</div>

<?php get_template_part( 'pagination'); ?>
<?php } else { ?>

<div class="post-content">

	<?php if (is_404()) { ?>
	<h1 class="title title-large"><?php _e( '404 Error (page not found)', 'wpzoom' ); ?></h1>
	<p><?php _e( 'Apologies, but the requested page cannot be found. Perhaps searching will help find a related post.', 'wpzoom' ); ?></p>
	<?php } else { ?>
	<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'wpzoom' ); ?></p>
	<?php } ?>
	<?php get_search_form(); ?>
	<div class="cleaner">&nbsp;</div>
	<h2 class="title title-small"><?php _e( 'Browse Categories', 'wpzoom' ); ?></h2>
	<ul>
		<?php wp_list_categories('title_li=&hierarchical=0&show_count=1'); ?>
	</ul>

	<h2 class="title title-small"><?php _e( 'Monthly Archives', 'wpzoom' ); ?></h2>
	<ul>
		<?php wp_get_archives('type=monthly&show_post_count=1'); ?>
	</ul>

</div><!-- end .post-content -->

<?php } ?>

<?php wp_reset_query(); ?>