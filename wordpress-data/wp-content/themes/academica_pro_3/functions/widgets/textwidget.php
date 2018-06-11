<?php

/*------------------------------------------*/
/* WPZOOM: Text Widget						*/
/*------------------------------------------*/

/**
 * Text widget class
 *
 * @since 2.8.0
 */
class WPZOOM_Widget_Text extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'wpzoom-text', 'description' => __('Display arbitrary text or HTML/JS code.', 'wpzoom'));
		$control_ops = array('id_base' => 'wpzoom-text-widget', 'width' => 400, 'height' => 350);
		parent::__construct('wpzoom-text-widget', __('WPZOOM: Text Widget (deprecated)', 'wpzoom'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );

		$pos = strpos($before_widget,'widget ');

		echo $before_widget;

		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
			<div class="textwidget"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '') );
		$title = strip_tags($instance['title']);
		$text = esc_textarea($instance['text']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wpzoom'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>


		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs', 'wpzoom'); ?></label></p>
<?php
	}
}

if ( version_compare( PHP_VERSION, '5.3', '>=' ) ) {
    add_action( 'widgets_init', function () {
        return register_widget( "WPZOOM_Widget_Text" );
    } );
} else {
    add_action( 'widgets_init', create_function( '', 'return register_widget("WPZOOM_Widget_Text");' ) );
}
// add_action('widgets_init', create_function('', 'return unregister_widget("WP_Widget_Text");'));

/*
add_filter('dynamic_sidebar_params', 'add_classes_to_widget');

function add_classes_to_widget($params,$widget_style){

	$pos = strpos($params[0]['widget_name'], 'WPZOOM');

	if ($pos !== false) {
		$class_to_add = 'widget-' .$widget_style.' '; // make sure you leave a space at the end
		$class_to_add = 'class=" '.$class_to_add;
		$params[0]['before_widget'] = str_replace('class="',$class_to_add,$params[0]['before_widget']);
	}

	return $params;
}
*/