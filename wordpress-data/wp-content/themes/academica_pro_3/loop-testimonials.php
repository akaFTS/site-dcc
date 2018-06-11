<?php wp_reset_query();

$args = array( 
	'post_type' => 'testimonial',
	'order' => 'ASC',
	'posts_per_page' => 25,
);

$testimonials = new WP_Query( $args );

if ( $testimonials->have_posts() ) {
?>

<ul class="posts-archive archives-columns-one posts-archive-testimonials">

<?php
while ( $testimonials->have_posts() ) : $testimonials->the_post();

$testimonial_author = get_post_meta($post->ID, 'wpzoom_testimonial_author', true);
$testimonial_position = get_post_meta($post->ID, 'wpzoom_testimonial_author_position', true);
$testimonial_company = get_post_meta($post->ID, 'wpzoom_testimonial_author_company', true);
$testimonial_company_url = get_post_meta($post->ID, 'wpzoom_testimonial_author_company_url', true);
?>

	<li class="loop-post-single loop-post-border loop-post-testimonial">
		<figure>
			<div class="post-excerpt">

				<blockquote class="testimonial"><?php the_content(); ?></blockquote>
				<figcaption class="wpzoom-author"><?php 
				if ($testimonial_author) {echo "$testimonial_author, ";} 
				if ($testimonial_position) {echo "<span class=\"position\">$testimonial_position ";}
				if ($testimonial_company_url) {echo "<a href=\"$testimonial_company_url\">$testimonial_company</a>";}
				else {echo "$testimonial_company";}
				if ($testimonial_position) {echo "</span>";}
				?></figcaption>

			</div><!-- end .post-excerpt -->
		</figure>
		<div class="cleaner">&nbsp;</div>
	</li><!-- .loop-post-single -->

	<?php endwhile; ?>

</ul><!-- end .posts-list-->
<?php } ?>
				
<?php get_template_part( 'pagination'); ?>

<?php wp_reset_query(); ?>