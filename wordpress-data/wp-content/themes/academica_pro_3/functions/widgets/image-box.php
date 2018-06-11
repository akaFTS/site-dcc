<?php

/*----------------------------------------------------------------------------------*/
/*  WPZOOM: Image Box
/*----------------------------------------------------------------------------------*/

/**
 * Load scripts.
 */
function wpzoom_image_upload_scripts() {

    global $pagenow, $wp_customize;

    if ( 'widgets.php' === $pagenow || isset( $wp_customize ) ) {

        wp_enqueue_media();
        wp_enqueue_script( 'mfc-media-upload', get_template_directory_uri() . '/js/mfc-media-upload.js', array( 'jquery' ), WPZOOM::$themeVersion, true );
        wp_enqueue_style( 'wpzoom-image-upload',  get_template_directory_uri() . '/css/upload.css' );

    }

}
add_action( 'admin_enqueue_scripts', 'wpzoom_image_upload_scripts' );


/**
 * Image Upload Widget
 */
class WPzoom_Image_Upload_Widget extends WP_Widget {

    // Holds widget settings defaults, populated in constructor.
    protected $defaults;

    // Constructor. Set the default widget options and create widget.
    function __construct() {

        $this->defaults = array(
            'title' => '',
            'image' => '',
            'link'  => '',
            'open_blank'  => false,
        );

        $widget_ops = array(
            'classname'   => 'wpzoom-media-widget',
            'description' => __( 'Simple widget that allows to upload an image', 'wpzoom' ),
        );

        $control_ops = array(
            'id_base' => 'wpzoom-media-widget',
            'width'   => 200,
            'height'  => 250,
        );

        parent::__construct( 'wpzoom-media-widget', __( 'WPZOOM: Image Box', 'wpzoom' ), $widget_ops, $control_ops );

    }

    // The widget content.
    function widget( $args, $instance ) {

        //* Merge with defaults
        $instance = wp_parse_args( (array) $instance, $this->defaults );
        $image_id = zoom_get_attachment_id_from_url($instance['image'] );
        $large_image_url = wp_get_attachment_image_src( $image_id, 'loop-main' );
        $style = ' style="background-image:url(\'' . $large_image_url[0] . '\')"';

        echo $args['before_widget'];


            echo '<div class="post_thumb_withbg" '.$style.'>';

                $target = !empty( $instance['open_blank']) ? 'target="_blank"' : '';
                echo ( ! empty( $instance['link'] ) ) ? '<a href="' . $instance['link'] . '" '.$target.' >' : '';

                    echo '<div class="featured_page_content">';

                        if ( ! empty( $instance['title'] ) )

                            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title'];

                    echo '</div>';

                echo ( ! empty( $instance['link'] ) ) ? '</a>' : '';

            echo '</div>';


        echo $args['after_widget'];

    }

    // Update a particular instance.
    function update( $new_instance, $old_instance ) {

        $new_instance['title']  = strip_tags( $new_instance['title'] );
        $new_instance['image']  = strip_tags( $new_instance['image'] );
        $new_instance['link']   = strip_tags( $new_instance['link'] );
        $new_instance['open_blank']   = $new_instance['open_blank'];

        return $new_instance;

    }

    // The settings update form.
    function form( $instance ) {

        // Merge with defaults
        $instance = wp_parse_args( (array) $instance, $this->defaults );

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wpzoom' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Image', 'wpzoom' ); ?>:</label>
            <div class="wpzoom-media-container">
                <div class="wpzoom-media-inner">
                    <?php $img_style = ( $instance[ 'image' ] != '' ) ? '' : 'style="display:none;"'; ?>
                    <img id="<?php echo $this->get_field_id( 'image' ); ?>-preview" src="<?php echo esc_attr( $instance['image'] ); ?>" <?php echo $img_style; ?> />
                    <?php $no_img_style = ( $instance[ 'image' ] != '' ) ? 'style="display:none;"' : ''; ?>
                    <span class="wpzoom-no-image" id="<?php echo $this->get_field_id( 'image' ); ?>-noimg" <?php echo $no_img_style; ?>><?php _e( 'No image selected', 'wpzoom' ); ?></span>
                </div>

            <input type="text" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo esc_attr( $instance['image'] ); ?>" class="wpzoom-media-url" />

            <input type="button" value="<?php echo _e( 'Remove', 'wpzoom' ); ?>" class="button wpzoom-media-remove" id="<?php echo $this->get_field_id( 'image' ); ?>-remove" <?php echo $img_style; ?> />

            <?php $button_text = ( $instance[ 'image' ] != '' ) ? __( 'Change Image', 'wpzoom' ) : __( 'Select Image', 'wpzoom' ); ?>
            <input type="button" value="<?php echo $button_text; ?>" class="button wpzoom-media-upload" id="<?php echo $this->get_field_id( 'image' ); ?>-button" />
            <br class="clear">
            </div>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'URL', 'wpzoom' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo esc_attr( $instance['link'] ); ?>" class="widefat" />
        </p>


        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['open_blank'], 'on' ); ?> id="<?php echo $this->get_field_id( 'open_blank' ); ?>" name="<?php echo $this->get_field_name( 'open_blank' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'open_blank' ); ?>"><?php _e('Open in New Tab', 'wpzoom'); ?></label>
        </p>

        <?php

    }

}


/**
 * Register Widget
 */
function register_wpzoom_image_upload_widget() {

    register_widget( 'WPzoom_Image_Upload_Widget' );

}
add_action( 'widgets_init','register_wpzoom_image_upload_widget' );
