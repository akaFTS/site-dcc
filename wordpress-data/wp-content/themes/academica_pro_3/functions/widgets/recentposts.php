<?php

/*------------------------------------------*/
/* WPZOOM: Recent Posts           */
/*------------------------------------------*/

class Wpzoom_Feature_Posts extends WP_Widget {
    protected $defaults;

    function __construct() {
        /* Widget settings. */
        $widget_ops = array( 'classname' => 'feature-posts', 'description' => 'A list of posts, optionally filter by category.' );

        /* Widget control settings. */
        $control_ops = array( 'id_base' => 'wpzoom-feature-posts' );

        /* Create the widget. */
        parent::__construct( 'wpzoom-feature-posts', __( 'WPZOOM: Recent Posts', 'wpzoom' ), $widget_ops, $control_ops );

        $this->defaults = array(
            'title'          => esc_html__( 'Recent Posts', 'wpzoom' ),
            'category'       => 0,
            'show_count'     => 5,
            'show_date'      => false,
            'show_thumb'     => false,
            'show_excerpt'   => false,
            'hide_title'     => false,
            'thumb_width'    => 90,
            'thumb_height'   => 75,
            'excerpt_length' => 55
        );
    }

    function widget( $args, $instance ) {
        extract( $args );

        /* User-selected settings. */
        $title          = apply_filters('widget_title', $instance['title'] );
        $category       = $instance['category'];
        $show_count     = $instance['show_count'];
        $show_date      = $instance['show_date'];
        $show_thumb     = $instance['show_thumb'];
        $show_excerpt   = $instance['show_excerpt'];
        $excerpt_length = $instance['excerpt_length'];
        $show_title     = ! $instance['hide_title'];

        /* Before widget (defined by themes). */
        echo $before_widget;

        /* Title of widget (before and after defined by themes). */
        if ( $title )
            echo $before_title . $title . $after_title;

        echo '<ul class="feature-posts-list">';

        $query_opts = apply_filters('wpzoom_query', array(
            'posts_per_page' => $show_count,
            'post_type' => 'post',
            'post__not_in' => get_option( 'sticky_posts' )
        ));
        if ( $category ) $query_opts['cat'] = $category;

        $query = new WP_Query( $query_opts );

        if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
            $echo_thumb = $show_thumb && array_key_exists('url', get_the_image( array( 'format' => 'array' ) ) );
            $echo_title = $show_title && get_the_title();

            /* Skip posts without title and thumb. */
            if ( ! $echo_thumb && ! $echo_title ) {
                continue;
            }

            echo '<li>';

                if ( $show_thumb && has_post_thumbnail() ) {
                    echo '<div class="post-thumb"><a href="' . get_permalink() . '"><img src="' . ui::thumbIt( absint( get_post_thumbnail_id() ), absint( $instance['thumb_width'] ), absint( $instance['thumb_height'] ) ) . '" height="' . $instance['thumb_height'] . '" width="' . $instance['thumb_width'] . '" alt="'.get_the_title().'" /></a></div>';
                }

                if ( $show_title ) echo '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3><br />';

                if ( $show_date ) echo '<small>' . get_the_date() . '</small> <br />';


                if ( $show_excerpt ) {
                    $the_excerpt = get_the_excerpt();

                    // cut to character limit
                    $the_excerpt = substr( $the_excerpt, 0, $excerpt_length );

                    // cut to last space
                    $the_excerpt = substr( $the_excerpt, 0, strrpos( $the_excerpt, ' '));

                    echo '<span class="post-excerpt">' . $the_excerpt . '</span>';
                }
            echo '<div class="clear"></div></li>';
            endwhile; else:
            endif;

            //Reset query_posts
            wp_reset_postdata();
        echo '</ul><div class="clear"></div>';

        /* After widget (defined by themes). */
        echo $after_widget;
    }


    function update( $new_instance, $old_instance ) {
        $instance['title']          = sanitize_text_field( $new_instance['title'] );
        $instance['category']       = ( 0 <= (int) $new_instance['category'] ) ? (int) $new_instance['category'] : null;
        $instance['show_count']     = ( 0 !== (int) $new_instance['show_count'] ) ? (int) $new_instance['show_count'] : null;
        $instance['show_date']      = (bool) $new_instance['show_date'];
        $instance['show_thumb']     = (bool) $new_instance['show_thumb'];
        $instance['show_excerpt']   = (bool) $new_instance['show_excerpt'];
        $instance['hide_title']     = (bool) $new_instance['hide_title'];
        $instance['thumb_width']    = ( 0 <= (int) $new_instance['thumb_width'] ) ? (int) $new_instance['thumb_width'] : null;
        $instance['thumb_height']   = ( 0 <= (int) $new_instance['thumb_height'] ) ? (int) $new_instance['thumb_height'] : null;
        $instance['excerpt_length'] = ( 0 <= (int) $new_instance['excerpt_length'] ) ? (int) $new_instance['excerpt_length'] : null;

        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, $this->defaults ); ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'wpzoom' ); ?></label><br />
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" type="text" class="widefat" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category:', 'wpzoom' ); ?></label>
            <select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">
                <option value="0" <?php if ( !$instance['category'] ) echo 'selected="selected"'; ?>>All</option>
                <?php
                $categories = get_categories(array('type' => 'post'));

                foreach( $categories as $cat ) {
                    echo '<option value="' . $cat->cat_ID . '"';

                    if ( $cat->cat_ID == $instance['category'] ) echo  ' selected="selected"';

                    echo '>' . esc_html( $cat->cat_name ) . ' (' . $cat->category_count . ')';

                    echo '</option>';
                }
                ?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php esc_html_e( 'Show:', 'wpzoom' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" value="<?php echo esc_attr( $instance['show_count'] ); ?>" type="text" size="2" /> posts
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['hide_title'] ); ?> id="<?php echo $this->get_field_id( 'hide_title' ); ?>" name="<?php echo $this->get_field_name( 'hide_title' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'hide_title' ); ?>"><?php esc_html_e( 'Hide post title', 'wpzoom' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['show_date'] ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php esc_html_e( 'Display post date', 'wpzoom' ); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['show_thumb'] ); ?> id="<?php echo $this->get_field_id( 'show_thumb' ); ?>" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_thumb' ); ?>"><?php esc_html_e( 'Display post thumbnail', 'wpzoom' ); ?></label>
        </p>

        <?php
        // only allow thumbnail dimensions if GD library supported
        if ( function_exists('imagecreatetruecolor') ) {
        ?>
        <p>
           <label for="<?php echo $this->get_field_id( 'thumb_width' ); ?>"><?php esc_html_e( 'Thumbnail size:', 'wpzoom' ); ?></label> <input type="text" id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo $instance['thumb_width']; ?>" size="3" /> x <input type="text" id="<?php echo $this->get_field_id( 'thumb_height' ); ?>" name="<?php echo $this->get_field_name( 'thumb_height' ); ?>" value="<?php echo $instance['thumb_height']; ?>" size="3" />
        </p>
        <?php
        }
        ?>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $instance['show_excerpt'] ); ?> id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php esc_html_e( 'Display post excerpt', 'wpzoom' ); ?></label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'excerpt_length' ); ?>"><?php esc_html_e( 'Excerpt character limit:', 'wpzoom' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'excerpt_length' ); ?>" name="<?php echo $this->get_field_name( 'excerpt_length' ); ?>" value="<?php echo esc_attr( $instance['excerpt_length'] ); ?>" type="text" size="4" />
        </p>

        <?php
    }
}

function wpzoom_register_fp_widget() {
    register_widget('Wpzoom_Feature_Posts');
}
add_action('widgets_init', 'wpzoom_register_fp_widget');