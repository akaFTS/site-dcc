<?php

/*----------------------------------*/
/* Custom Posts Options				*/
/*----------------------------------*/

add_action('admin_menu', 'wpzoom_options_box');

function wpzoom_options_box() {

    add_meta_box('wpzoom_post_template', 'Post Options', 'wpzoom_post_options', 'post', 'side', 'high');

    add_meta_box('wpzoom_page_options', 'Featured Image', 'wpzoom_page_options', 'page', 'side', 'high');

    if (option::get('featured_type') == 'Featured Pages') {
        add_meta_box('wpzoom_slideshow_options', 'Homepage Slideshow', 'wpzoom_slideshow_options', 'page', 'side', 'high');
    }

	add_meta_box('wpzoom_post_template', 'Event Options', 'wpzoom_post_options', 'event', 'side', 'high');
	add_meta_box('wpzoom_post_template', 'Testimonial Options', 'wpzoom_testimonial_options', 'testimonial', 'side', 'high');
	add_meta_box('wpzoom_post_layout', 'Post Layout', 'wpzoom_post_layout_options', 'post', 'normal', 'high');
	add_meta_box('wpzoom_post_layout', 'Page Layout', 'wpzoom_post_layout_options', 'page', 'normal', 'high');
	add_meta_box('wpzoom_post_layout', 'Event Layout', 'wpzoom_post_layout_options', 'event', 'normal', 'high');
	add_meta_box('wpzoom_post_layout', 'Testimonial Layout', 'wpzoom_post_layout_options', 'testimonial', 'normal', 'high');
}

add_action('save_post', 'custom_add_save');

function custom_add_save($postID){
	// called after a post or page is saved
	if($parent_id = wp_is_post_revision($postID))
	{
	  $postID = $parent_id;
	}

	if (isset($_POST['saveTestimonial'])) {
		if (isset($_POST['wpzoom_testimonial_author'])) { update_custom_meta($postID, $_POST['wpzoom_testimonial_author'], 'wpzoom_testimonial_author'); }
		if (isset($_POST['wpzoom_testimonial_author_position'])) { update_custom_meta($postID, $_POST['wpzoom_testimonial_author_position'], 'wpzoom_testimonial_author_position'); }
		if (isset($_POST['wpzoom_testimonial_author_company'])) { update_custom_meta($postID, $_POST['wpzoom_testimonial_author_company'], 'wpzoom_testimonial_author_company'); }
		if (isset($_POST['wpzoom_testimonial_author_company_url'])) { update_custom_meta($postID, $_POST['wpzoom_testimonial_author_company_url'], 'wpzoom_testimonial_author_company_url'); }
	}

	if (isset($_POST['save']) || isset($_POST['publish'])) {

        update_custom_meta( $postID, ( isset( $_POST['wpzoom_is_featured'] ) ? 1 : 0 ), 'wpzoom_is_featured' );


        // Slideshow

        if ( isset( $_POST['wpzoom_slide_url'] ) )
            update_custom_meta( $postID, esc_url_raw( $_POST['wpzoom_slide_url'] ), 'wpzoom_slide_url' );

        if ( isset( $_POST['wpzoom_slide_button_title'] ) )
            update_custom_meta( $postID, $_POST['wpzoom_slide_button_title'] , 'wpzoom_slide_button_title' );

        if ( isset( $_POST['wpzoom_slide_button_url'] ) )
            update_custom_meta( $postID, esc_url_raw( $_POST['wpzoom_slide_button_url'] ), 'wpzoom_slide_button_url' );


		if (isset($_POST['wpzoom_post_template'])) { update_custom_meta($postID, $_POST['wpzoom_post_template'], 'wpzoom_post_template'); }
		if (isset($_POST['wpzoom_featured_show'])) { update_custom_meta($postID, $_POST['wpzoom_featured_show'], 'wpzoom_featured_show'); }
		if (isset($_POST['wpzoom_gallery_show'])) { update_custom_meta($postID, $_POST['wpzoom_gallery_show'], 'wpzoom_gallery_show'); }
	}
}

function update_custom_meta($postID, $newvalue, $field_name) {
	// To create new meta
	if(!get_post_meta($postID, $field_name)){
		add_post_meta($postID, $field_name, $newvalue);
	}else{
		// or to update existing meta
		update_post_meta($postID, $field_name, $newvalue);
	}

}

// Custom Post Layouts
function wpzoom_post_layout_options() {
	global $post;
	$postLayouts = array('side-both' => 'Sidebar on both sides', 'side-right' => 'Sidebar on the right', 'side-left' => 'Sidebar on the left', 'full' => 'Full Width');
	?>

	<style type="text/css">
	    .RadioClass { display: none !important; }
	    .RadioLabelClass { margin-right: 20px;  float: left; font-weight: bold; text-align: center;}
	    img.layout-select { border: solid 2px #c0cdd6; border-radius: 3px; background: #fefefe;  }
	    .RadioSelected img.layout-select { border: solid 2px #3173b2; }
	</style>

	<script type="text/javascript">
	jQuery(document).ready(
	function($)
	{
		$(".RadioClass").change(function(){
		    if($(this).is(":checked")){
		        $(".RadioSelected:not(:checked)").removeClass("RadioSelected");
		        $(this).next("label").addClass("RadioSelected");
		    }
		});
	});
	</script>

	<fieldset>
		<div>

			<p>

			<?php
			foreach ($postLayouts as $key => $value)
			{
				?>
				<input id="<?php echo $key; ?>" type="radio" class="RadioClass" name="wpzoom_post_template" value="<?php echo $key; ?>"<?php if (get_post_meta($post->ID, 'wpzoom_post_template', true) == $key) { echo' checked="checked"'; } ?> />
				<label for="<?php echo $key; ?>" class="RadioLabelClass<?php if (get_post_meta($post->ID, 'wpzoom_post_template', true) == $key) { echo' RadioSelected"'; } ?>">
				<img src="<?php echo wpzoom::$wpzoomPath; ?>/assets/images/layout-<?php echo $key; ?>.png" alt="<?php echo $value; ?>" title="<?php echo $value; ?>" class="layout-select" /></label>
			<?php
			}
			?>

			</p>

  		</div>
	</fieldset>
	<?php }

// Regular Posts Options
function wpzoom_post_options() {
	global $post;
	?>
	<fieldset>
		<div>

                <?php if (option::get('featured_type') == 'Featured Posts') { ?>

                <p class="wpz_border">
                    <?php $isChecked = ( get_post_meta($post->ID, 'wpzoom_is_featured', true) == 1 ? 'checked="checked"' : '' ); // we store checked checkboxes as 1 ?>
                    <input type="checkbox" name="wpzoom_is_featured" id="wpzoom_is_featured" value="1" <?php echo esc_attr($isChecked); ?> /> <label for="wpzoom_is_featured"><?php _e('Feature in Homepage Slider', 'wpzoom'); ?></label>
                </p>
                <hr />
                <?php } ?>
                <p>

                <?php /* Keys should never change for backwards compatibility! */
                $locations = array(
                    'Don\'t Show'   => __( 'Hide', 'wpzoom' ),
                    'Narrow' => __( 'In the content column', 'wpzoom' ),
                    'Full Width'     => __( 'At the Top', 'wpzoom' )
                );
                $selected_location = get_post_meta($post->ID, 'wpzoom_featured_show', true);

                ?>

                <p><label for="wpzoom_featured_show" ><strong><?php _e('Featured Image Location', 'wpzoom' ); ?>:</strong></label></p>
                <select name="wpzoom_featured_show" id="wpzoom_featured_show">

                    <?php foreach ( $locations as $value => $text ) : ?>
                        <option <?php selected( $selected_location, $value ); ?> value="<?php echo esc_attr( $value ); ?>">
                            <?php echo esc_html( $text ); ?>
                        </option>
                    <?php endforeach; ?>

                </select>
                <br />
                <br />
                <p class="description"><?php _e('Select the location where you want to display the Featured Image when viewing this page individually.', 'wpzoom'); ?>

			</p>
  		</div>
	</fieldset>
	<?php
	}



// Page Options
function wpzoom_page_options() {
    global $post;
    ?>
    <fieldset>
        <div>

            <?php /* Keys should never change for backwards compatibility! */
            $locations = array(
                'Don\'t Show'   => __( 'Hide', 'wpzoom' ),
                'Narrow' => __( 'In the content column', 'wpzoom' ),
                'Full Width'     => __( 'At the Top', 'wpzoom' )
            );
            $selected_location = get_post_meta($post->ID, 'wpzoom_featured_show', true);

            ?>

            <p><label for="wpzoom_featured_show" ><strong><?php _e('Featured Image Location', 'wpzoom' ); ?>:</strong></label></p>
            <select name="wpzoom_featured_show" id="wpzoom_featured_show">

                <?php foreach ( $locations as $value => $text ) : ?>
                    <option <?php selected( $selected_location, $value ); ?> value="<?php echo esc_attr( $value ); ?>">
                        <?php echo esc_html( $text ); ?>
                    </option>
                <?php endforeach; ?>

            </select>
            <br />
            <br />
            <p class="description"><?php _e('Select the location where you want to display the Featured Image when viewing this page individually.', 'wpzoom'); ?>

        </div>
    </fieldset>
    <?php
    }


/* Featured Pages in Slideshow */
    function wpzoom_slideshow_options() {
        global $post;
        ?>
        <fieldset>
            <div>


                    <p class="wpz_border">
                        <?php $isChecked = ( get_post_meta($post->ID, 'wpzoom_is_featured', true) == 1 ? 'checked="checked"' : '' ); // we store checked checkboxes as 1 ?>
                        <input type="checkbox" name="wpzoom_is_featured" id="wpzoom_is_featured" value="1" <?php echo esc_attr($isChecked); ?> /> <label for="wpzoom_is_featured"><?php _e('Show this Page in Homepage Slider', 'wpzoom'); ?></label>
                    </p>
                    <hr />


                    <div>
                        <strong><label for="wpzoom_slide_url"><?php _e( 'Slide URL', 'wpzoom' ); ?></label></strong> (<?php _e('optional', 'wpzoom'); ?>)<br/>
                        <p><input type="text" name="wpzoom_slide_url" id="wpzoom_slide_url" class="widefat" value="<?php echo esc_url( get_post_meta( $post->ID, 'wpzoom_slide_url', true ) ); ?>"/></p>
                        <p class="description"><?php _e('When a URL is added, the title of the current slide will become clickable', 'wpzoom'); ?></p>

                    </div>
                    <br />
                    <hr />

                    <div>
                    <br />

                    <legend><strong><?php _e( 'Slide Button', 'wpzoom' ); ?></strong> <?php _e( '(optional)', 'wpzoom' ); ?></legend>

                    <p>
                        <label>
                            <strong><?php _e( 'Title', 'wpzoom' ); ?></strong>
                            <input type="text" name="wpzoom_slide_button_title" id="wpzoom_slide_button_title" class="widefat" value="<?php echo esc_attr( get_post_meta( $post->ID, 'wpzoom_slide_button_title', true ) ); ?>" />
                        </label>
                    </p>

                    <p>
                        <label>
                            <strong><?php _e( 'URL', 'wpzoom' ); ?></strong>
                            <input type="text" name="wpzoom_slide_button_url" id="wpzoom_slide_button_url" class="widefat" value="<?php echo esc_url( get_post_meta( $post->ID, 'wpzoom_slide_button_url', true ) ); ?>" />
                        </label>
                    </p>



            </div>
        </fieldset>
        <?php
        }



// Testimonials Options
function wpzoom_testimonial_options() {
	global $post;
	?>
	<fieldset>
		<input type="hidden" name="saveTestimonial" id="saveTestimonial" value="1" />
		<div>
			<p>
 				<label>Show Featured Image on Testimonial Page:</label><br />
				<select name="wpzoom_featured_show" id="wpzoom_featured_show">
					<option<?php selected( get_post_meta($post->ID, 'wpzoom_featured_show', true), 'Don\'t Show' ); ?>>Don't Show</option>
					<option<?php selected( get_post_meta($post->ID, 'wpzoom_featured_show', true), 'Narrow' ); ?>>Narrow</option>
					<option<?php selected( get_post_meta($post->ID, 'wpzoom_featured_show', true), 'Full Width' ); ?>>Full Width</option>
				</select>
			</p>
			<p>
				<label for="wpzoom_testimonial_author">Testimonial Author:</label><br />
				<input type="text" style="width:90%;" name="wpzoom_testimonial_author" id="wpzoom_testimonial_author" value="<?php echo get_post_meta($post->ID, 'wpzoom_testimonial_author', true); ?>"><br />
			</p>
			<p>
				<label for="wpzoom_testimonial_author_position">Author Position:</label><br />
				<input type="text" style="width:90%;" name="wpzoom_testimonial_author_position" id="wpzoom_testimonial_author_position" value="<?php echo get_post_meta($post->ID, 'wpzoom_testimonial_author_position', true); ?>"><br />
				<span class="description">Example: CEO &amp; Founder</span>
			</p>
			<p>
				<label for="wpzoom_testimonial_author_company">Author Company:</label><br />
				<input type="text" style="width:90%;" name="wpzoom_testimonial_author_company" id="wpzoom_testimonial_author_company" value="<?php echo get_post_meta($post->ID, 'wpzoom_testimonial_author_company', true); ?>"><br />
				<span class="description">Example: WPZOOM</span>
			</p>
			<p>
				<label for="wpzoom_testimonial_author_company_url">Author Company Link:</label><br />
				<input type="text" style="width:90%;" name="wpzoom_testimonial_author_company_url" id="wpzoom_testimonial_author_company_url" value="<?php echo get_post_meta($post->ID, 'wpzoom_testimonial_author_company_url', true); ?>"><br />
				<span class="description">Example: http://www.wpzoom.com</span>
			</p>

  		</div>
	</fieldset>
	<?php
	}