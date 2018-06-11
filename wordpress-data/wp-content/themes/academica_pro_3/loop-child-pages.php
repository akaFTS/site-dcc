<?php
$child_of = $post->ID;
$loop = new WP_Query( array( 'post_parent' => $child_of, 'post_type' => 'page', 'nopaging' => 1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );

if ($loop->have_posts()) {
$i = 0;
?>

<ul class="posts-archive archives-columns-one">
	<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
	<li class="loop-post-single loop-post-border">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="post-cover"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail('loop-main'); ?>
            </a></div>
        <?php endif; ?>
		<div class="post-excerpt">
			<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<?php the_excerpt(); ?>
		</div><!-- end .post-excerpt -->
		<div class="cleaner">&nbsp;</div>
	</li><!-- .loop-post-single -->
	<?php endwhile; ?>
</ul><!-- end .posts-archive -->

<?php } ?>

<div class="cleaner">&nbsp;</div>

<?php wp_reset_query(); ?>