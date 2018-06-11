<?php if (option::get('banner_sidebar_top_enable') == 'on') { ?>
<div class="widget side_ad">

	<?php if ( option::get('banner_sidebar_top_html') <> "") {
		echo stripslashes(option::get('banner_sidebar_top_html'));
	} else { ?>
		<a href="<?php echo option::get('banner_sidebar_top_url'); ?>" rel="nofollow" title="<?php echo option::get('banner_sidebar_top_alt'); ?>"><img src="<?php echo option::get('banner_sidebar_top'); ?>" alt="<?php echo option::get('banner_sidebar_top_alt'); ?>" /></a>
	<?php } ?>

</div><!-- end .widget .side_ad -->
<?php } ?>

<?php if (option::get('page_nav') == 'on' && is_page()) {

	$parent_id = $post->post_parent;

	if ($parent_id == 0) {
		$child_of = $post->ID;
		$widget_title = the_title('','',false);
	} // if no parent
	else {
		$child_of = $parent_id;
		$widget_title = get_the_title($parent_id);
	}

	$children_pages = get_pages( array( 'child_of' => $child_of, 'sort_column' => 'post_title', 'sort_order' => 'ASC' ) );

	if (count($children_pages) > 0) {
		echo '<div class="widget"><ul class="related-pages">';
		echo '<p class="title">'. $widget_title.'</p>';

		foreach ($children_pages as $page) {
			echo'<li';
			if ($page->ID == $post->ID) {echo ' class="current-page"';}
			echo'><a href="' . get_page_link( $page->ID ) . '">' . $page->post_title . '</a></li>';
		} // foreach

		echo '</ul><div class="cleaner">&nbsp;</div></div>';
	}

	wp_reset_query();
} // if is_page() and enabled

?>

<?php dynamic_sidebar('Sidebar'); ?>

<?php if (option::get('banner_sidebar_bottom_enable') == 'on') { ?>
<div class="widget side_ad">

	<?php if ( option::get('banner_sidebar_bottom_html') <> "") {
		echo stripslashes(option::get('banner_sidebar_bottom_html'));
	} else { ?>
		<a href="<?php echo option::get('banner_sidebar_bottom_url'); ?>" rel="nofollow" title="<?php echo option::get('banner_sidebar_bottom_alt'); ?>"><img src="<?php echo option::get('banner_sidebar_bottom'); ?>" alt="<?php echo option::get('banner_sidebar_bottom_alt'); ?>" /></a>
	<?php } ?>

</div><!-- end .widget .side_ad -->
<?php } ?>