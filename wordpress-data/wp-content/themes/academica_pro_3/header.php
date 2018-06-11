<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="container">

    <header id="header">

        <nav id="top-menu">

            <div class="wrapper">

                <div id="navbar-top" class="top-navbar">

                    <?php if (has_nav_menu( 'secondary' )) {

                        wp_nav_menu( array(
                            'menu_class'     => 'navbar-wpz dropdown sf-menu',
                            'theme_location' => 'secondary'
                        ) );

                     }
                    ?>

                </div>

                <div class="header_social">
                    <?php dynamic_sidebar('header_social'); ?>
                </div>

                <?php if (option::get('tel_enable') == 'on' ) { ?>
                    <div id="header-helpful">

                        <?php if (option::get('tel_enable') == 'on' ) { ?>
                            <span class="action"><?php print(option::get('tel_caption')); ?><span class="value"><?php print(option::get('tel_text')); ?></span></span>
                        <?php } ?>
                    </div><!-- end #header-helpful -->
                <?php } // if show header text ?>

                <div class="clear"></div>

             </div>
        </nav><!-- end #top-menu -->
        <div class="cleaner"></div>


        <div class="wrapper">

            <div class="brand_wrapper">

                <div class="navbar-brand-wpz">

                    <?php academica_custom_logo() ?>

                    <p class="tagline"><?php bloginfo('description')  ?></p>

                </div><!-- .navbar-brand -->

                <div id="navbar-logo" class="logo-navbar">

                    <?php if (has_nav_menu( 'third' )) {

                        wp_nav_menu( array(
                            'menu_class'     => 'navbar-wpz dropdown sf-menu',
                            'theme_location' => 'third'
                        ) );

                     }
                    ?>

                </div>

            </div>

            <div class="cleaner">&nbsp;</div>

        </div><!-- end .wrapper -->

    </header>

    <nav id="main-navbar" class="main-navbar">

        <div class="wrapper">

            <div class="navbar-header-main">
                <?php if ( has_nav_menu( 'mobile' ) ) {
                    wp_nav_menu( array(
                       'container_id'   => 'menu-main-slide',
                       'theme_location' => 'mobile'
                   ) );
               } elseif ( has_nav_menu( 'primary' ) ) {
                 wp_nav_menu( array(
                    'container_id'   => 'menu-main-slide',
                    'theme_location' => 'primary'
                ) );
             } ?>

            </div>

            <div id="navbar-main">

                <?php if (has_nav_menu( 'primary' )) {

                    wp_nav_menu( array(
                        'menu_class'     => 'navbar-wpz dropdown sf-menu',
                        'theme_location' => 'primary'
                    ) );
                }
                else
                {
                    echo '<p class="wpzoom-notice">Please set your Main Menu on the <a href="'.get_admin_url().'nav-menus.php">Appearance > Menus</a> page. For more information please <a href="http://www.wpzoom.com/documentation/academica-pro-3/">read the documentation</a></p>';
                }
                ?>

            </div><!-- end .menu -->

            <div id="sb-search" class="sb-search">
                <?php get_search_form(); ?>
            </div>

        </div>

    </nav><!-- end #main-menu -->