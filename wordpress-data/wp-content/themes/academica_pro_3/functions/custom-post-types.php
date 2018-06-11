<?php

/* Custom Posts Types for Testimonials  */
add_action('init', 'testimonials_register');

function testimonials_register() {
	$labels = array(
		'name' => _x('Testimonials', 'post type general name', 'wpzoom'),
		'singular_name' => _x('Testimonial', 'post type singular name', 'wpzoom'),
		'add_new' => _x('Add a New Testimonial', 'slideshow item', 'wpzoom'),
		'add_new_item' => __('Add New Testimonial', 'wpzoom'),
		'edit_item' => __('Edit Testimonial', 'wpzoom'),
		'new_item' => __('New Testimonial', 'wpzoom'),
		'view_item' => __('View Testimonial', 'wpzoom'),
		'search_items' => __('Search Testimonials', 'wpzoom'),
		'not_found' =>  __('Nothing found', 'wpzoom'),
		'not_found_in_trash' => __('Nothing found in Trash', 'wpzoom'),
		'parent_item_colon' => ''
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
 		'rewrite' => array(
 			'slug' => 'testimonial',
 			'with_front' => false
		 ),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 20,
		'supports' => array('title','editor','thumbnail','excerpt', 'custom-fields')
	  );

	register_post_type( 'testimonial' , $args );
}