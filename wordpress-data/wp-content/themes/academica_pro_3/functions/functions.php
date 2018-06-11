<?php

/**
 * Theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 */

if ( ! function_exists( 'academica_setup' ) ) :
/**
 * Theme setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 */
function academica_setup() {
    // This theme styles the visual editor to resemble the theme style.
    add_editor_style( array( 'css/editor-style.css' ) );

    /* Image Sizes */
    add_image_size( 'homepage-slider', 1270, 500, true );
    add_image_size( 'homepage-slider-small', 947, 500, true );
    add_image_size( 'page-top', 947 );
    add_image_size( 'page-small', 624 );
    add_image_size( 'loop-main', 365, 240, true );
    add_image_size( 'thumb-gallery-widget', 84, 56, true );


    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );


    // Register nav menus
    register_nav_menus( array(
        'secondary' => __( 'Top Menu', 'wpzoom' ),
        'third' => __( 'Next to Logo', 'wpzoom' ),
        'primary' => __( 'Main Menu', 'wpzoom' ),
        'mobile' => __( 'Mobile Menu', 'wpzoom' )

    ) );

    /**
     * Theme Logo
     */
    add_theme_support( 'custom-logo', array(
        'height'      => 150,
        'width'       => 650,
        'flex-height' => true,
        'flex-width'  => true
    ) );

    academica_old_fonts();


    // values from array a labels for options in select

    add_theme_support('wpz-widget-colors', array(
        'options' => array(
            'none' => __('-- Select --', 'wpzoom'),
            'blue' => __('Blue', 'wpzoom'),
            'gold' => __('Gold', 'wpzoom'),
            'grey' => __('Grey', 'wpzoom'),
            'red' => __('Red', 'wpzoom'),
            'green' => __('Green', 'wpzoom'),
        ),
        'key' => 'widget_style'
    ));


}
endif;
add_action( 'after_setup_theme', 'academica_setup' );



/* This theme uses a Static Page as front page */
add_theme_support('zoom-front-page-type', array(
   'type' => 'static_page'
));



/*  Add Support for Shortcodes in Excerpt
========================================== */

add_filter( 'the_excerpt', 'shortcode_unautop' );
add_filter( 'the_excerpt', 'do_shortcode' );

add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'widget_text', 'do_shortcode' );



/*  Recommended Plugins
========================================== */

function zoom_register_theme_required_plugins_callback($plugins){

    $plugins =  array_merge(array(

        array(
            'name'         => 'The Events Calendar',
            'slug'         => 'the-events-calendar',
            'required'     => false,
        ),

        array(
            'name'         => 'Jetpack',
            'slug'         => 'jetpack',
            'required'     => false,
        ),

        array(
            'name'         => 'Sidebar Login',
            'slug'         => 'sidebar-login',
            'required'     => false,
        )

    ), $plugins);

    return $plugins;
}

add_filter('zoom_register_theme_required_plugins', 'zoom_register_theme_required_plugins_callback');



/* Add support for Custom Background
==================================== */

add_theme_support( 'custom-background' );


/* Custom Excerpt Length
==================================== */

function new_excerpt_length($length) {
	return (int) option::get("excerpt_length") ? (int) option::get("excerpt_length") : 50;
}
add_filter('excerpt_length', 'new_excerpt_length');



/* Enable Excerpts for Pages
==================================== */

add_action( 'init', 'wpzoom_excerpts_to_pages' );
function wpzoom_excerpts_to_pages() {
    add_post_type_support( 'page', 'excerpt' );
}



/* Disable Jetpack Related Posts on Post Type
========================================== */

function academica_no_related_posts( $options ) {
    if ( !is_singular( 'post' ) ) {
        $options['enabled'] = false;
    }
    return $options;
}
add_filter( 'jetpack_relatedposts_filter_options', 'academica_no_related_posts' );




/*  Maximum width for images in posts
=========================================== */

if ( ! isset( $content_width ) ) $content_width = 887;

function academica_content_width() {
   if ( is_page_template( 'template-fullwidth.php' ) ) {
            global $content_width;
            $content_width = 1210;
   }
}

add_action( 'template_redirect', 'academica_content_width' );


/* Make the Gallery Widget (Jetpack) wider
============================================ */

add_filter('gallery_widget_content_width', 'gallery_widget_content_width_callback');

function gallery_widget_content_width_callback($width){
    return 584;
}



/* Disable Unyson shortcodes with the same name as in ZOOM Framework
====================================================================== */

function _filter_theme_disable_default_shortcodes($to_disable) {
    $to_disable[] = 'tabs';
    $to_disable[] = 'button';

    return $to_disable;
}
add_filter('fw_ext_shortcodes_disable_shortcodes', '_filter_theme_disable_default_shortcodes');






/* Widget Styles */
if ( ! function_exists( 'wpz_get_theme_data_for_widgets' ) ) :
    function wpz_get_theme_data_for_widgets() {
        $string_id       = 'wpz-widget-colors';
        $wpz_widget_data = get_theme_support( $string_id );
        $pushed          = array_pop( $wpz_widget_data );

        return $pushed;
    }
endif;

if ( ! function_exists( 'wpz_get_string_id_for_widget_colors' ) ) :
    function wpz_get_string_id_for_widget_colors() {
        $string_id = 'wpz-widget-colors';
        $pushed    = wpz_get_theme_data_for_widgets();

        return ! empty( $pushed['key'] ) ? $pushed['key'] : $string_id . '-' . WPZOOM::$theme_raw_name;
    }
endif;

if ( ! function_exists( 'wpz_form_callback_for_widget_colors' ) ) :
    function wpz_form_callback_for_widget_colors( $widget, $return, $instance ) {

        $theme_data            = wpz_get_theme_data_for_widgets();
        $colors = $theme_data['options'];
        $theme_string_id   = wpz_get_string_id_for_widget_colors();
        $instance_color    = isset( $instance[ $theme_string_id ] ) ? $instance[ $theme_string_id ] : 0;
        ?>
        <p style="border: 2px dashed #e5e5e5; -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.04); box-shadow: 0 1px 1px rgba(0,0,0,.04); border-radius: 3px; margin: 25px 0; padding: 9px 15px;background: #FAFAFA;">
            <label
                for="<?php echo $widget->get_field_id( $theme_string_id ); ?>"><strong><?php _e( 'Widget Style:', 'wpzoom' ) ?></strong></label>
            <select id="<?php echo $widget->get_field_id( $theme_string_id ); ?>"
                    name="<?php echo $widget->get_field_name( $theme_string_id ); ?>">
                <?php

                foreach ( $colors as $color => $label ) {
                    echo '<option value="' . $color . '" ' . selected( $instance_color, $color, false ) . '>' . $label . '</option>';
                }
                ?>
            </select>
        </p>
        <?php

        return $return;
    }
endif;

if ( ! function_exists( 'wpz_update_callback_for_widget_colors' ) ) :
    function wpz_update_callback_for_widget_colors( $instance, $new_instance ) {

        $theme_string_id = wpz_get_string_id_for_widget_colors();

        if ( ! empty( $new_instance[ $theme_string_id ] ) ) {
            $instance[ $theme_string_id ] = $new_instance[ $theme_string_id ];
        }

        return $instance;
    }
endif;

if ( ! function_exists( 'wpz_render_callback_for_widget_colors' ) ) :
    function wpz_render_callback_for_widget_colors( $settings, $widget, $args ) {

        $theme_string_id = wpz_get_string_id_for_widget_colors();

        if ( ! empty( $settings[ $theme_string_id ] ) ) {

            $matches = array();

            preg_match( '/class="([^"]*)"/', $args['before_widget'], $matches );

            $old_classes  = $matches[1];
            $new_classes  = sprintf( $old_classes . ' %s', 'widget-'.$settings[ $theme_string_id ] );
            $final_string = sprintf( 'class="%s"', $new_classes );

            $args['before_widget'] = preg_replace( '/class="[^"]*"/', $final_string, $args['before_widget'] );

            $was_cache_addition_suspended = wp_suspend_cache_addition();

            if ( $widget->is_preview() && ! $was_cache_addition_suspended ) {
                wp_suspend_cache_addition( true );
            }

            $widget->widget( $args, $settings );

            if ( $widget->is_preview() ) {
                wp_suspend_cache_addition( $was_cache_addition_suspended );
            }

            return false;
        }

        return $settings;
    }
endif;

if ( ! function_exists( 'wpz_actions_init_for_widget_colors' ) ) :
    function wpz_actions_init_for_widget_colors() {
        if ( current_theme_supports( 'wpz-widget-colors' ) ) {
            add_filter( 'in_widget_form', 'wpz_form_callback_for_widget_colors', 10, 3 );
            add_filter( 'widget_update_callback', 'wpz_update_callback_for_widget_colors', 10, 2 );
            add_filter( 'widget_display_callback', 'wpz_render_callback_for_widget_colors', 10, 3 );
        }
    }

    add_action( 'after_setup_theme', 'wpz_actions_init_for_widget_colors' );

endif;



/**
 * Show custom logo or blog title and description (backward compatibility)
 *
 */
function academica_custom_logo()
{
    //In future must remove it is for backward compatibility.
    if(get_theme_mod('logo')){
        set_theme_mod('custom_logo',  zoom_get_attachment_id_from_url(get_theme_mod('logo')));
        remove_theme_mod('logo');
    }

    has_custom_logo() ? the_zoom_custom_logo() : printf('<h1><a href="%s" title="%s">%s</a></h1>', home_url(), get_bloginfo('description'), get_bloginfo('name'));
}


/**
 * Old Customizer backward compatibility.
 *
 */

function academica_old_fonts() {


    if(get_theme_mod('font-family-site-title')){
        set_theme_mod('title-font-family',  get_theme_mod('font-family-site-title'));
        remove_theme_mod('font-family-site-title');
    }

    if(get_theme_mod('font-family-site-tagline')){
        set_theme_mod('description-font-family',  get_theme_mod('font-family-site-tagline'));
        remove_theme_mod('font-family-site-tagline');
    }

    if(get_theme_mod('font-family-widgets')){
        set_theme_mod('widget-title-font-family',  get_theme_mod('font-family-widgets'));
        remove_theme_mod('font-family-widgets');
    }

    if(get_theme_mod('font-family-post-title')){
        set_theme_mod('blog-title-font-family',  get_theme_mod('font-family-post-title'));
        remove_theme_mod('font-family-post-title');
    }

    if(get_theme_mod('font-family-single-post-title')){
        set_theme_mod('post-title-font-family',  get_theme_mod('font-family-single-post-title'));
        remove_theme_mod('font-family-single-post-title');
    }

    if(get_theme_mod('font-family-page-title')){
        set_theme_mod('page-title-font-family',  get_theme_mod('font-family-page-title'));
        remove_theme_mod('font-family-page-title');
    }

}


if ( ! function_exists( 'academica_get_google_font_uri' ) ) :
    /**
     * Build the HTTP request URL for Google Fonts.
     *
     * @return string    The URL for including Google Fonts.
     */
    function academica_get_google_font_uri() {
        // Grab the font choices
        $font_keys = zoom_customizer_get_font_familiy_ids(academica_customizer_data());

        $fonts = array();
        foreach ( $font_keys as $key => $default ) {
            $fonts[] = get_theme_mod( $key, $default );
        }

        // De-dupe the fonts
        $fonts         = array_unique( $fonts );
        $allowed_fonts = zoom_customizer_get_google_fonts();
        $family        = array();

        // Validate each font and convert to URL format
        foreach ( $fonts as $font ) {
            $font = trim( $font );

            // Verify that the font exists
            if ( array_key_exists( $font, $allowed_fonts ) ) {
                // Build the family name and variant string (e.g., "Open+Sans:regular,italic,700")
                $family[] = urlencode( $font . ':' . join( ',', zoom_customizer_choose_google_font_variants( $font, $allowed_fonts[ $font ]['variants'] ) ) );
            }
        }

        // Convert from array to string
        if ( empty( $family ) ) {
            return '';
        } else {
            $request = '//fonts.googleapis.com/css?family=' . implode( '|', $family );
        }

        // Load the font subset
        $subset = get_theme_mod( 'font-subset', false );

        if ( 'all' === $subset ) {

            $subsets_available = zoom_customizer_get_google_font_subsets();

            // Remove the all set
            unset( $subsets_available['all'] );

            // Build the array
            $subsets = array_keys( $subsets_available );
        } else {
            $subsets = array(
                'latin',
                $subset,
            );
        }

        // Append the subset string
        if ( ! empty( $subsets ) ) {
            $request .= urlencode( '&subset=' . join( ',', $subsets ) );
        }

        /**
         * Filter the Google Fonts URL.
         *
         * @since 1.2.3.
         *
         * @param string    $url    The URL to retrieve the Google Fonts.
         */
        return apply_filters( 'academica_get_google_font_uri', esc_url( $request ) );
    }
endif;



/* Enqueue scripts and styles for the front end.
=========================================== */

function academica_pro_scripts() {

    if ( '' !== $google_request = academica_get_google_font_uri() ) {
        wp_enqueue_style( 'academica-google-fonts', $google_request, WPZOOM::$themeVersion );
    }


	// Load our main stylesheet.
    wp_enqueue_style( 'academica-pro-style', get_stylesheet_uri(), array(), WPZOOM::$themeVersion );

    wp_enqueue_style( 'media-queries', get_template_directory_uri() . '/css/media-queries.css', array(), WPZOOM::$themeVersion );

    wp_enqueue_style( 'academica-google-font-default', '//fonts.googleapis.com/css?family=Libre+Baskerville:400,400i,700|Roboto:400,400i,500,500i,700,700i&amp;subset=cyrillic,latin-ext', array() );

    wp_enqueue_style( 'dashicons' );

    wp_enqueue_script( 'slicknav', get_template_directory_uri() . '/js/jquery.slicknav.min.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/dropdown.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

    wp_enqueue_script( 'flickity', get_template_directory_uri() . '/js/flickity.pkgd.min.js', array(), WPZOOM::$themeVersion, true );

    wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), WPZOOM::$themeVersion, true );

    wp_enqueue_script( 'search_button', get_template_directory_uri() . '/js/search_button.js', array(), WPZOOM::$themeVersion, true );

    $themeJsOptions = option::getJsOptions();

    wp_enqueue_script( 'academica-pro-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), WPZOOM::$themeVersion, true );
    wp_localize_script( 'academica-pro-script', 'zoomOptions', $themeJsOptions );
}

add_action( 'wp_enqueue_scripts', 'academica_pro_scripts' );