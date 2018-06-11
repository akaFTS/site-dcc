<?php

/*------------------------------------------*/
/* WPZOOM: Custom Menu						*/
/*------------------------------------------*/

/**
 * Navigation Menu widget class
 *
 * @since 3.0.0
 */
 class WPZOOM_Nav_Menu_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'wpzoom-custom-menu', 'description' => __('Use this widget to add one of your custom menus as a widget.', 'wpzoom') );
		$control_ops = array('id_base' => 'wpzoom-menu-widget');
		parent::__construct( 'wpzoom-menu-widget', __('WPZOOM: Custom Menu', 'wpzoom'), $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);
		// Get menu
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

		if ( !$nav_menu )
			return;

		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$pos = strpos($before_widget,'widget ');

		echo $before_widget;

		if ( !empty($instance['title']) )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];

		wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu ) );

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['nav_menu'] = (int) $new_instance['nav_menu'];
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

		// Get menus
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		// If no menus exists, direct the user to go and create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
			return;
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wpzoom') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:', 'wpzoom'); ?></label>
			<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
		<?php
			foreach ( $menus as $menu ) {
				echo '<option value="' . $menu->term_id . '"'
					. selected( $nav_menu, $menu->term_id, false )
					. '>'. $menu->name . '</option>';
			}
		?>
			</select>
		</p>

		<?php
	}
}

if ( version_compare( PHP_VERSION, '5.3', '>=' ) ) {
    add_action( 'widgets_init', function () {
        return register_widget( "WPZOOM_Nav_Menu_Widget" );
    } );
} else {
    add_action( 'widgets_init', create_function( '', 'return register_widget("WPZOOM_Nav_Menu_Widget");' ) );
}
// add_action('widgets_init', create_function('', 'return unregister_widget("WP_Nav_Menu_Widget");'));