<?php
/*
Template Name: Homepage
*/
?>

<?php get_header(); ?>

    <div id="main">

        <?php
            if (!is_active_sidebar('sidebar-left')) { $no_side_left = true; }
            if (!is_active_sidebar('sidebar-right')) { $no_side_right = true; }
        ?>

        <div class="wrapper">

            <?php if (!isset($no_side_left)) { ?>
                <div class="column column-narrow">

                    <?php dynamic_sidebar('Sidebar: Left Column'); ?>
                    <div class="cleaner">&nbsp;</div>

                </div><!-- end .column .column-narrow -->

                <div class="column column-wide column-wide-parent column-last">

            <?php } ?>


                <?php
                    if (option::get('featured_posts_show') == 'on') {
                        get_template_part('wpzoom-slider-small', '');
                    }
                ?>


                <?php if ( is_front_page() && $paged < 2) : ?>

                    <?php if ( is_active_sidebar( 'homepage-1' ) ||  is_active_sidebar( 'homepage-2'  )  ||  is_active_sidebar( 'homepage-3'  ) ) : ?>
                        <section class="column-widgets">

                            <?php if ( is_active_sidebar( 'homepage-1'  ) ) { ?>
                                <div class="widget-column">
                                    <?php dynamic_sidebar('homepage-1'); ?>
                                </div><!-- .column -->
                            <?php } ?>

                            <?php if ( is_active_sidebar( 'homepage-2'  ) ) { ?>
                                <div class="widget-column">
                                    <?php dynamic_sidebar('homepage-2'); ?>
                                </div><!-- .column -->
                            <?php } ?>

                            <?php if ( is_active_sidebar( 'homepage-3'  ) ) { ?>
                                <div class="widget-column">
                                    <?php dynamic_sidebar('homepage-3'); ?>
                                </div><!-- .column -->
                            <?php } ?>

                        </section>

                    <?php endif; ?>

                <?php endif; ?>

                <div class="column <?php if (isset($no_side_right)) { echo 'column-full column-last'; } else { echo 'column-wide column-wide-child'; } ?>">

                    <?php dynamic_sidebar('Homepage: Content Widgets'); ?>
                    <div class="cleaner">&nbsp;</div>

                </div><!-- end .column .column-wide -->

                <?php if (!isset($no_side_right)) { ?>
                <div class="column column-narrow column-narrow-child column-last">

                    <?php dynamic_sidebar('Sidebar: Right Column'); ?>
                    <div class="cleaner">&nbsp;</div>

                </div><!-- end .column .column-narrow -->
                <?php } ?>

                <div class="cleaner">&nbsp;</div>

            <?php if (!isset($no_side_left)) { ?>

                </div><!-- end .column .column-wide -->

            <?php } ?>

            <div class="cleaner">&nbsp;</div>

        </div><!-- end .wrapper -->

    </div><!-- end #main -->

<?php get_footer(); ?>