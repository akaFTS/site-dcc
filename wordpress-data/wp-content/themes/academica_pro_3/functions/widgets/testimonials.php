<?php

/*------------------------------------------*/
/* WPZOOM: Testimonials		*/
/*------------------------------------------*/

class wpzoom_widget_feat_testimonials extends WP_Widget {

	/* Widget setup. */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'wpzoom', 'description' => __('Custom WPZOOM widget. Displays testimonials according to chosen options.', 'wpzoom') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'wpzoom-widget-feat-testimonials' );

		/* Create the widget. */
		parent::__construct( 'wpzoom-widget-feat-testimonials', __('WPZOOM: Testimonials', 'wpzoom'), $widget_ops, $control_ops );
	}

	/* How to display the widget on the screen. */
	function widget( $args, $instance ) {

		extract( $args );

		/* Our variables from the widget settings. */

		$title = apply_filters('widget_title', $instance['title'] );
		$num = $instance['num'];
		$show_random = $instance['show_random'];

		$pos = strpos($before_widget,'widget ');

		echo $before_widget;

		if ( !empty($instance['title']) )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];

		if ($show_random == 'on')
		{
			$orderby = 'rand';
		}
		else
		{
			$orderby = 'date';
		}

		$args = array(
			'post_type' => 'testimonial',
			'posts_per_page' => $num,
			'orderby' => $orderby
		);

		$testimonials = new WP_Query( $args );

		if ( $testimonials->have_posts() ) :
		?>
		<ul class="posts-archive archives-columns-one posts-archive-testimonials">
		<?php

		while ( $testimonials->have_posts() ) : $testimonials->the_post();
		global $post;
		$testimonial_author = get_post_meta($post->ID, 'wpzoom_testimonial_author', true);
		$testimonial_position = get_post_meta($post->ID, 'wpzoom_testimonial_author_position', true);
		$testimonial_company = get_post_meta($post->ID, 'wpzoom_testimonial_author_company', true);
		$testimonial_company_url = get_post_meta($post->ID, 'wpzoom_testimonial_author_company_url', true);

		?>
				<li class="loop-post-single loop-post-border loop-post-testimonial">
					<figure>
						<div class="post-excerpt">

							<blockquote class="testimonial testimonial-widget"><?php the_content(); ?></blockquote>
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
			</ul><!-- -->
			<?php endif;
			wp_reset_query();?>

		<?php

		echo $after_widget;

		}

		/* Update the widget settings.*/
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['title'] = strip_tags( $new_instance['title'] );
 			$instance['num'] = $new_instance['num'];
			$instance['show_random'] = $new_instance['show_random'];

			return $instance;
		}

		/** Displays the widget settings controls on the widget panel.
		 * Make use of the get_field_id() and get_field_name() function when creating your form elements. This handles the confusing stuff. */
		function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array('title' => '','num' => '3', 'show_random' => '');
			$instance = wp_parse_args( (array) $instance, $defaults );
 	    ?>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label><br />
				<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
			</p>


			<p>
				<label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Testimonials to display:', 'wpzoom'); ?></label>
				<select id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" style="width:90%;">
				<?php
					$m = 0;
					while ($m < 11) {
						$m++;
						$option = '<option value="'.$m;
						if ($m == $instance['num']) { $option .='" selected="selected';}
						$option .= '">';
						$option .= $m;
						$option .= '</option>';
						echo $option;
					}
				?>
				</select>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['show_random'] ); ?> id="<?php echo $this->get_field_id('show_random'); ?>" name="<?php echo $this->get_field_name('show_random'); ?>" />
				<label for="<?php echo $this->get_field_id('show_random'); ?>"><?php _e('Display random testimonials', 'wpzoom'); ?></label>
			</p>

		<?php
		}
}

function wpzoom_register_feat_testimonials_widget() {
	register_widget('wpzoom_widget_feat_testimonials');
}
add_action('widgets_init', 'wpzoom_register_feat_testimonials_widget');