<?php

    if ( option::get( 'featured_type' ) == 'Featured Posts' ) {
        $FeaturedSource = 'post';
    } else {
        $FeaturedSource = 'page';
    }


    $featured = new WP_Query( array(
        'showposts'    => option::get( 'slideshow_posts' ),
        'post__not_in' => get_option( 'sticky_posts' ),
        'meta_key'     => 'wpzoom_is_featured',
        'meta_value'   => 1,
        'post_type' => $FeaturedSource
    ) );

?>

<section id="slider" class="wpzoom_slider">

	<?php if ( $featured->have_posts() ) : ?>

		<ul class="slides clearfix">

			<?php while ( $featured->have_posts() ) : $featured->the_post(); ?>

                <?php

                $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'homepage-slider-small');

                $slide_url = trim( get_post_meta( get_the_ID(), 'wpzoom_slide_url', true ) );
                $btn_title = trim( get_post_meta( get_the_ID(), 'wpzoom_slide_button_title', true ) );
                $btn_url = trim( get_post_meta( get_the_ID(), 'wpzoom_slide_button_url', true ) );

                $style = ' style="background-image:url(\'' . $large_image_url[0] . '\')"';

                ?>

                <li class="slide">

                    <div class="slide-overlay">

                        <div class="slide-header">

                            <?php if ($FeaturedSource == 'page') { ?>

                                <?php if ( empty( $slide_url ) ) : ?>

                                    <?php the_title( '<h3>', '</h3>' ); ?>

                                <?php else: ?>

                                    <?php the_title( sprintf( '<h3><a href="%s">', esc_url( $slide_url ) ), '</a></h3>' ); ?>

                                <?php endif; ?>

                            <?php } ?>


                            <?php if ($FeaturedSource == 'post') { ?>

                                <?php the_title( sprintf( '<h3><a href="%s">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

                                <div class="entry-meta">
                                    <?php if ( option::is_on( 'slider_date' ) )     printf( '<span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span>', esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ) ); ?>
                                </div>
                            <?php } ?>


                            <?php if ( option::is_on( 'slider_excerpt' ) ) { ?>

                                <?php the_excerpt(); ?>

                            <?php } ?>


                            <?php if ( option::is_on( 'slider_button' ) ) { ?>

                                <?php if ($FeaturedSource == 'post') { ?>

                                <div class="slide_button">
                                    <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpzoom' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php _e('Read More', 'wpzoom'); ?></a>
                                </div>

                                <?php } else { ?>

                                    <?php if ( ! empty( $btn_title ) && ! empty( $btn_url ) ) : ?>

                                        <div class="slide_button"><a href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $btn_title ); ?></a></div>

                                    <?php endif; ?>

                                <?php } ?>

                            <?php } ?>

                        </div>

                    </div>

                    <div class="slide-background" <?php echo $style; ?>>
                    </div>
                </li>
            <?php endwhile; ?>

		</ul>

	<?php else: ?>

		<div class="empty-slider">
			<p><strong><?php _e( 'You are now ready to set-up your Slideshow content.', 'wpzoom' ); ?></strong></p>

			<p>
				<?php
				printf(
					__( 'For more information about adding posts to the slider, please <strong><a href="%1$s">read the documentation</a></strong>', 'wpzoom' ),
					'http://www.wpzoom.com/documentation/academica-pro-3/'
				);
				?>
			</p>
		</div>

	<?php endif; ?>

</section>