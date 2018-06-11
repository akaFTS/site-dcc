<?php


function academica_customizer_data()
{
    static $data = array();

    if(empty($data)){

        $media_viewport = 'screen and (min-width: 768px)';
        $media_viewport_nav = 'screen and (max-width: 768px)';

        $data = array(
            'title_tagline' => array(
                'title' => __('Site Identity', 'wpzoom'),
                'priority' => 20,
                'options' => array(
                    'hide-tagline' => array(
                        'setting' => array(
                            'sanitize_callback' => 'absint',
                            'default' => true
                        ),
                        'control' => array(
                            'label' => __('Show Tagline', 'wpzoom'),
                            'type' => 'checkbox',
                            'priority' => 11
                        ),
                        'style' => array(
                            'selector' => '.navbar-brand-wpz .tagline',
                            'rule' => 'display'
                        )
                    ),
                    'custom_logo_retina_ready' => array(
                        'setting' => array(
                            'sanitize_callback' => 'absint',
                            'default' => false,
                        ),
                        'control' => array(
                            'label' => __('Retina Ready?', 'wpzoom'),
                            'type' => 'checkbox',
                            'priority' => 9
                        ),
                        'partial' => array(
                            'selector' => '.navbar-brand-wpz a',
                            'container_inclusive' => false,
                            'render_callback' => 'academica_custom_logo'
                        )
                    ),
                    'blogname' => array(
                        'setting' => array(
                            'sanitize_callback' => 'sanitize_text_field',
                            'default' => get_option('blogname'),
                            'transport' => 'postMessage',
                            'type' => 'option'
                        ),
                        'control' => array(
                            'label' => __('Site Title', 'wpzoom'),
                            'type' => 'text',
                            'priority' => 9
                        ),
                        'partial' => array(
                            'selector' => '.navbar-brand-wpz a',
                            'container_inclusive' => false,
                            'render_callback' => 'zoom_customizer_partial_blogname'
                        )
                    ),
                    'blogdescription' => array(
                        'setting' => array(
                            'sanitize_callback' => 'sanitize_text_field',
                            'default' => get_option('blogdescription'),
                            'transport' => 'postMessage',
                            'type' => 'option'
                        ),
                        'control' => array(
                            'label' => __('Tagline', 'wpzoom'),
                            'type' => 'text',
                            'priority' => 10
                        ),
                        'partial' => array(
                            'selector' => '.navbar-brand-wpz .tagline',
                            'container_inclusive' => false,
                            'render_callback' => 'zoom_customizer_partial_blogdescription'
                        )
                    ),
                    'custom_logo' => array(
                        'partial' => array(
                            'selector' => '.navbar-brand-wpz a',
                            'container_inclusive' => false,
                            'render_callback' => 'academica_custom_logo'
                        )
                    )
                )
            ),
            'header' => array(
                'title' => __('Header Options', 'wpzoom'),
                'priority' => 50,
                'options' => array(

                    'top-navbar' => array(
                        'setting' => array(
                            'sanitize_callback' => 'sanitize_text_field',
                            'default' => 'block'
                        ),
                        'control' => array(
                            'label' => __('Show Top Menu Bar', 'wpzoom'),
                            'type' => 'subtitle',
                        ),
                        'style' => array(
                            'selector' => '#top-menu',
                            'rule' => 'display'
                        )
                    ),
                    'top-navbar' => array(
                        'setting' => array(
                            'sanitize_callback' => 'sanitize_text_field',
                            'default' => 'block'
                        ),
                        'control' => array(
                            'label' => __('Show Top Menu Bar', 'wpzoom'),
                            'type' => 'checkbox',
                        ),
                        'style' => array(
                            'selector' => '#top-menu',
                            'rule' => 'display'
                        )
                    ),
                    'top-navbar-mobile' => array(
                        'setting' => array(
                            'sanitize_callback' => 'sanitize_text_field',
                            'default' => 'block',
                         ),
                        'control' => array(
                            'label' => __('Show Top Menu on Mobile Devices', 'wpzoom'),
                            'type' => 'checkbox',
                            'description' => '<br/>Don\'t panic if the menu disappears from desktop computers too. Refresh this page and it will appear back in the Customizer.'
                        ),
                        'style' => array(
                            'selector' => '#navbar-top',
                            'media' => $media_viewport_nav,
                            'rule' => 'display'
                        )
                    ),
                    'navbar-hide-search' => array(
                        'setting' => array(
                            'sanitize_callback' => 'sanitize_text_field',
                            'default' => 'block'
                        ),
                        'control' => array(
                            'label' => __('Show Search Form in Main Menu', 'wpzoom'),
                            'type' => 'checkbox',
                        ),
                        'style' => array(
                            'selector' => '.sb-search',
                            'rule' => 'display'
                        )
                    ),
                )
            ),
            'color' => array(
                'title' => __('General', 'wpzoom'),
                'panel' => 'color-scheme',
                'priority' => 110,
                'capability' => 'edit_theme_options',
                'options' => array(
                    'color-background' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#F4F6F8'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Background Color', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => 'body',
                            'rule' => 'background'
                        )
                    ),
                    'color-text' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#555555'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Body Text', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => 'body, h1, h2, h3, h4, h5, h6',
                            'rule' => 'color'
                        )
                    ),
                    'color-logo' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#1B3058'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Logo Color', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.navbar-brand-wpz a',
                            'rule' => 'color'
                        ),
                    ),
                    'color-logo-hover' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#a41d31'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Logo Color on Hover', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.navbar-brand-wpz a:hover',
                            'rule' => 'color'
                        )
                    ),
                    'color-tagline' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#999'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Site Description', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.navbar-brand-wpz .tagline',
                            'rule' => 'color'
                        ),
                    ),
                    'color-background-header' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#ffffff'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Header Background', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '#header',
                            'rule' => 'background'
                        ),
                    ),
                    'color-link' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#1B3058'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Link Color', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => 'a',
                            'rule' => 'color'
                        )
                    ),
                    'color-link-hover' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#a41d31'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Link Color on Hover', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => 'a:hover',
                            'rule' => 'color'
                        ),
                    ),
                    'color-button-background' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#1B3058'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Buttons Background', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => 'button, input[type=button], input[type=reset], input[type=submit]',
                            'rule' => 'background'
                        ),
                    ),
                    'color-button-color' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#fff'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Buttons Text Color', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => 'button, input[type=button], input[type=reset], input[type=submit]',
                            'rule' => 'color'
                        ),
                    ),
                    'color-button-background-hover' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#a41d31'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Buttons Background on Hover', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => 'button:hover, input[type=button]:hover, input[type=reset]:hover, input[type=submit]:hover',
                            'rule' => 'background'
                        ),
                    ),
                    'color-button-color-hover' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#fff'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Buttons Text Color on Hover', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => 'button:hover, input[type=button]:hover, input[type=reset]:hover, input[type=submit]:hover',
                            'rule' => 'color'
                        ),
                    ),
                ),

            ),
            'color-top-menu' => array(
                'panel' => 'color-scheme',
                'title' => __('Top Menu', 'wpzoom'),
                'options' => array(
                    'color-top-menu-background' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#F4F6F8'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Top Menu Background', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '#top-menu',
                            'rule' => 'background'
                        )
                    ),
                    'color-top-menu-link' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#6d6d6d'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Menu Item', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.top-navbar .navbar-wpz > li > a',
                            'rule' => 'color'
                        )
                    ),
                    'color-top-menu-link-hover' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#a41d31'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Menu Item Hover', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.top-navbar .navbar-wpz > li > a:hover',
                            'rule' => 'color'
                        )
                    ),
                    'color-top-menu-link-current' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#a41d31'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Menu Current Item', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.top-navbar .navbar-wpz > .current-menu-item > a, .top-navbar .navbar-wpz > .current_page_item > a, .top-navbar .navbar-wpz > .current-menu-parent > a',
                            'rule' => 'color'
                        )
                    )
                )
            ),
            'color-main-menu' => array(
                'panel' => 'color-scheme',
                'title' => __('Main Menu', 'wpzoom'),
                'options' => array(
                    'color-menu-background' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#1B3058'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Menu Background', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.main-navbar',
                            'rule' => 'background'
                        )
                    ),
                    'color-menu-border' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#FFCB00'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Menu Border Color', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.main-navbar',
                            'rule' => 'border-top-color'
                        )
                    ),
                    'color-menu-link' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#fff'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Menu Item', 'wpzoom'),
                        ),
                        'style' => array(
                            'id' => 'color-menu-link',
                            'selector' => '.main-navbar .navbar-wpz > li > a',
                            'rule' => 'color'
                        )
                    ),
                    'color-dropdown' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#1B3058'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Dropdown Background', 'wpzoom'),
                        ),
                        'style' => array(
                            array(
                                'selector' => '.navbar-wpz ul',
                                'rule' => 'background'
                            ),
                            array(
                                'selector' => '.navbar-wpz ul li',
                                'rule' => 'border-color'
                            ),
                            array(
                                'selector' => '.navbar-wpz > li > ul:after ',
                                'rule' => 'border-bottom-color'
                            ),
                            array(
                                'selector' => '.navbar-wpz > li > ul:before ',
                                'rule' => 'border-bottom-color'
                            )
                        )
                    ),
                    'color-menu-link-hover' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#FFB400'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Menu Item Hover', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.main-navbar .navbar-wpz > li > a:hover',
                            'rule' => 'color'
                        )
                    ),
                    'color-menu-link-current' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#FFB400'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Menu Current Item', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.main-navbar .navbar-wpz > .current-menu-item > a, .main-navbar .navbar-wpz > .current_page_item > a, .main-navbar .navbar-wpz > .current-menu-parent > a',
                            'rule' => 'color'
                        )
                    ),
                    'color-search-icon-background' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#363940'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Search Icon Background', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.sb-search .sb-icon-search',
                            'rule' => 'background'
                        )
                    ),
                    'color-search-icon' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#fff'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Search Icon Color', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.sb-search .sb-icon-search',
                            'rule' => 'color'
                        )
                    ),
                    'color-search-icon-background-hover' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#818592'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Search Icon Background on Hover', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.sb-search .sb-icon-search:hover, .sb-search .sb-search-input',
                            'rule' => 'background'
                        )
                    ),
                    'color-search-icon-hover' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#ffffff'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Search Icon Color on Hover', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.sb-search .sb-icon-search:hover, .sb-search .sb-search-input, .sb-search.sb-search-open .sb-icon-search:before',
                            'rule' => 'color'
                        )
                    )
                )
            ),
            'color-slider' => array(
                'panel' => 'color-scheme',
                'title' => __('Homepage Slider', 'wpzoom'),
                'options' => array(
                    'color-slider-button-background' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#1B3058'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Button Background', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.slides .slide_button a',
                            'rule' => 'background',
                        )
                    ),
                    'color-slider-button-color' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#fff'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Button Text', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.slides .slide_button a',
                            'rule' => 'color',
                        )
                    ),
                    'color-slider-button-background-hover' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#fff'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Button Background Hover', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.slides .slide_button a:hover',
                            'rule' => 'background',
                        )
                    ),
                    'color-slider-button-color-hover' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#1B3058'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Button Text Hover', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.slides .slide_button a:hover',
                            'rule' => 'color',
                        )
                    ),

                )
            ),
            'color-posts' => array(
                'panel' => 'color-scheme',
                'title' => __('Blog Posts', 'wpzoom'),
                'options' => array(
                    'color-post-title' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#111'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Post Title', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.posts-archive h2 a, .posts-archive h2.entry-title a',
                            'rule' => 'color'
                        )
                    ),
                    'color-post-title-hover' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#a41d31'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Post Title Hover', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.posts-archive h2 a:hover, .posts-archive h2.entry-title a:hover',
                            'rule' => 'color'
                        )
                    ),
                    'color-post-meta' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#666'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Post Meta', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.posts-archive .post-meta',
                            'rule' => 'color'
                        )
                    ),
                    'color-post-meta-link' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#1B3058'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Post Meta Link', 'wpzoom'),
                        ),
                        'style' => array(
                            array(
                                'selector' => '.entry-meta a',
                                'rule' => 'color'
                            ),
                            array(
                                'selector' => '.posts-archive .post-meta a',
                                'rule' => 'border-color'
                            )
                        )
                    ),
                    'color-post-meta-link-hover' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#a41d31'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Post Meta Link Hover', 'wpzoom'),
                        ),
                        'style' => array(
                                'selector' => '.posts-archive .post-meta a:hover',
                                'rule' => 'color'
                        )
                    ),

                )
            ),
            'color-single' => array(
                'panel' => 'color-scheme',
                'title' => __('Individual Posts and Pages', 'wpzoom'),
                'options' => array(
                    'color-single-title' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#222222'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Post/Page Title', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => 'h1.post-title',
                            'rule' => 'color'
                        )
                    ),
                    'color-single-meta' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#666'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Post Meta', 'wpzoom'),
                        ),
                        'style' => array(
                            'id' => 'color-single-meta',
                            'selector' => '.single #main .post-meta',
                            'rule' => 'color'
                        )
                    ),
                    'color-single-meta-link' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#1B3058'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Post Meta Link', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.single #main .post-meta a',
                            'rule' => 'color'
                        )
                    ),
                    'color-single-meta-link-hover' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#a41d31'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Post Meta Link Hover', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.single #main .post-meta a:hover',
                            'rule' => 'color'
                        )
                    ),
                    'color-single-content' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#555555'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Post/Page Text Color', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.post-content',
                            'rule' => 'color'
                        )
                    ),
                    'color-single-link' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#1B3058'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Links Color in Posts', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.post-content a',
                            'rule' => 'color'
                        )
                    ),
                )
            ),
            'color-widgets' => array(
                'panel' => 'color-scheme',
                'title' => __('Widgets', 'wpzoom'),
                'options' => array(
                    'color-widget-title' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#333333'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Widget Title Color', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.widget .title',
                            'rule' => 'color'
                        )
                    ),
                    'color-footer-widget-title' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#ffffff'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Footer Widget Title Color', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.site-footer .widget .title',
                            'rule' => 'color'
                        )
                    ),

                )
            ),
            'color-footer' => array(
                'panel' => 'color-scheme',
                'title' => __('Footer', 'wpzoom'),
                'options' => array(
                    'color-footer-widget-area-background' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#1B3058'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Footer Background', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.site-footer',
                            'rule' => 'background-color'
                        )
                    ),
                    'color-footer-widget-area-border' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#FFB400'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Footer Border Color', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.site-footer',
                            'rule' => 'border-color'
                        )
                    ),
                    'color-footer-copy-background' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#1B3058'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Copyright Bar Background', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '#footer-copy',
                            'rule' => 'background-color'
                        )
                    ),
                    'color-footer-copy-text' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#d3dde6'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Copyright Bar Text Color', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '#footer-copy',
                            'rule' => 'color'
                        )
                    ),
                    'color-footer-link' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#FFB400'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Footer Link', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.site-footer a',
                            'rule' => 'color'
                        )
                    ),
                    'color-footer-link-hover' => array(
                        'setting' => array(
                            'sanitize_callback' => 'maybe_hash_hex_color',
                            'transport' => 'postMessage',
                            'default' => '#fff'
                        ),
                        'control' => array(
                            'control_type' => 'WP_Customize_Color_Control',
                            'label' => __('Footer Link Hover', 'wpzoom'),
                        ),
                        'style' => array(
                            'selector' => '.site-footer a:hover',
                            'rule' => 'color'
                        )
                    ),

                )
            ),
            /**
             *  Typography
             */
            'font-site-body' => array(
                'panel' => 'typography',
                'title' => __('Body', 'wpzoom'),
                'options' => array(
                    'body' => array(
                        'type' => 'typography',
                        'selector' => 'body',
                        'rules' => array(
                            'font-family' => 'Roboto',
                            'font-size' => 14,
                            'font-weight' => 'normal',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),
            'font-post-body' => array(
                'panel' => 'typography',
                'title' => __('Post Content', 'wpzoom'),
                'options' => array(
                    'post' => array(
                        'type' => 'typography',
                        'selector' => '.post-content',
                        'rules' => array(
                            'font-family' => 'Roboto',
                            'font-size' => 15,
                            'font-weight' => 'normal',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),
            'font-site-title' => array(
                'panel' => 'typography',
                'title' => __('Site Title', 'wpzoom'),
                'options' => array(
                    'title' => array(
                        'type' => 'typography',
                        'selector' => '.navbar-brand-wpz h1 a',
                        'rules' => array(
                            'font-family' => 'Libre Baskerville',
                            'font-size' => 33,
                            'font-weight' => 'bold',
                            'text-transform' => 'none',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),
            'description-typography' => array(
                'panel' => 'typography',
                'title' => __('Site Description', 'wpzoom'),
                'options' => array(
                    'description' => array(
                        'type' => 'typography',
                        'selector' => '.navbar-brand-wpz .tagline',
                        'rules' => array(
                            'font-family' => 'Roboto',
                            'font-size' => 16,
                            'font-weight' => 'normal',
                            'text-transform' => 'normal',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),
            'topmenu-typography' => array(
                'panel' => 'typography',
                'title' => __('Top Menu Links', 'wpzoom'),
                'options' => array(
                    'topmenu' => array(
                        'type' => 'typography',
                        'selector' => '.top-navbar .navbar-wpz > li > a',
                        'rules' => array(
                            'font-family' => 'Roboto',
                            'font-size' => 14,
                            'font-weight' => 'normal',
                            'text-transform' => 'normal',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),
            'logomenu-typography' => array(
                'panel' => 'typography',
                'title' => __('Logo Menu Links', 'wpzoom'),
                'options' => array(
                    'logopmenu' => array(
                        'type' => 'typography',
                        'selector' => '.logo-navbar .navbar-wpz > li > a',
                        'rules' => array(
                            'font-family' => 'Roboto',
                            'font-size' => 14,
                            'font-weight' => 'normal',
                            'text-transform' => 'normal',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),
            'font-nav' => array(
                'panel' => 'typography',
                'title' => __('Main Menu Links', 'wpzoom'),
                'options' => array(
                    'mainmenu' => array(
                        'type' => 'typography',
                        'selector' => '.main-navbar a',
                        'rules' => array(
                            'font-family' => 'Libre Baskerville',
                            'font-size' => 16,
                            'font-weight' => 'normal',
                            'text-transform' => 'normal',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),
            'font-slider' => array(
                'panel' => 'typography',
                'title' => __('Homepage Slider Title', 'wpzoom'),
                'options' => array(
                    'slider-title' => array(
                        'type' => 'typography',
                        'selector' => '.slides li h3, .page-template-home-full .slides li h3, .page-template-home-3cols  .slides li h3',
                        'rules' => array(
                            'font-family' => 'Libre Baskerville',
                            'font-size' => 26,
                            'font-weight' => 'bold',
                            'text-transform' => 'none',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),
            'font-slider-description' => array(
                'panel' => 'typography',
                'title' => __('Homepage Slider Text', 'wpzoom'),
                'options' => array(
                    'slider-text' => array(
                        'type' => 'typography',
                        'selector' => '.slides li .slide-header p',
                        'rules' => array(
                            'font-family' => 'Roboto',
                            'font-size' => 16,
                            'font-weight' => 'normal',
                            'text-transform' => 'none',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),
            'font-slider-button' => array(
                'panel' => 'typography',
                'title' => __('Homepage Slider Button', 'wpzoom'),
                'options' => array(
                    'slider-button' => array(
                        'type' => 'typography',
                        'selector' => '.slides .slide_button a',
                        'rules' => array(
                            'font-family' => 'Roboto',
                            'font-size' => 14,
                            'font-weight' => 'bold',
                            'text-transform' => 'uppercase',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),
            'font-widgets' => array(
                'panel' => 'typography',
                'title' => __('Widget Title', 'wpzoom'),
                'options' => array(
                    'widget-title' => array(
                        'type' => 'typography',
                        'selector' => '.widget h3.title',
                        'rules' => array(
                            'font-family' => 'Libre Baskerville',
                            'font-size' => 16,
                            'font-weight' => 'bold',
                            'text-transform' => 'normal',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),

            'font-widgets-footer' => array(
                'panel' => 'typography',
                'title' => __('Footer Widget Title', 'wpzoom'),
                'options' => array(
                    'footer-widget-title' => array(
                        'type' => 'typography',
                        'selector' => '.site-footer .widget .title',
                        'rules' => array(
                            'font-family' => 'Libre Baskerville',
                            'font-size' => 18,
                            'font-weight' => 'bold',
                            'text-transform' => 'normal',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),

            'font-post-title' => array(
                'panel' => 'typography',
                'title' => __('Blog Posts Title', 'wpzoom'),
                'options' => array(
                    'blog-title' => array(
                        'type' => 'typography',
                        'selector' => '.posts-archive h2, .posts-archive h2.entry-title',
                        'rules' => array(
                            'font-family' => 'Libre Baskerville',
                            'font-size' => 18,
                            'font-weight' => 'bold',
                            'text-transform' => 'none',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),
            'font-single-post-title' => array(
                'panel' => 'typography',
                'title' => __('Single Post Title', 'wpzoom'),
                'options' => array(
                    'post-title' => array(
                        'type' => 'typography',
                        'selector' => '.single h1.post-title',
                        'rules' => array(
                            'font-family' => 'Libre Baskerville',
                            'font-size' => 32,
                            'font-weight' => 'bold',
                            'text-transform' => 'none',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),
            'font-page-title' => array(
                'panel' => 'typography',
                'title' => __('Single Page Title', 'wpzoom'),
                'options' => array(
                    'page-title' => array(
                        'type' => 'typography',
                        'selector' => '.page h1.post-title',
                        'rules' => array(
                            'font-family' => 'Libre Baskerville',
                            'font-size' => 32,
                            'font-weight' => 'bold',
                            'text-transform' => 'none',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),
            'font-footer' => array(
                'panel' => 'typography',
                'title' => __('Footer Text', 'wpzoom'),
                'options' => array(
                    'footer' => array(
                        'type' => 'typography',
                        'selector' => '.site-footer, .site-footer .column, #footer-copy',
                        'rules' => array(
                            'font-family' => 'Roboto',
                            'font-size' => 14,
                            'font-weight' => 'normal',
                            'text-transform' => 'normal',
                            'font-style' => 'normal'
                        )
                    )
                )
            ),
            'footer-area' => array(
                'title' => __('Footer', 'wpzoom'),
                'options' => array(
                    'blogcopyright' => array(
                        'setting' => array(
                            'sanitize_callback' => 'sanitize_text_field',
                            'default' => get_option('blogcopyright', sprintf( __( 'Copyright &copy; %1$s %2$s. All Rights Reserved', 'wpzoom' ), date( 'Y' ), get_bloginfo( 'name' ) )),
                            'transport' => 'postMessage',
                            'type' => 'option'
                        ),
                        'control' => array(
                            'label' => __('Footer Text', 'wpzoom'),
                            'type' => 'text',
                            'priority' => 10
                        ),
                        'partial' => array(
                            'selector' => '#footer-copy .copyright',
                            'container_inclusive' => false,
                            'render_callback' => 'zoom_customizer_partial_blogcopyright'
                        )

                    )
                )
            )
        );

        zoom_customizer_normalize_options($data);
    }


    return $data;
}

add_filter('wpzoom_customizer_data', 'academica_customizer_data');