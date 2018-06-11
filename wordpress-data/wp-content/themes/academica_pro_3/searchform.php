<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
	<input type="search" class="sb-search-input" placeholder="<?php _e('Search&hellip;', 'wpzoom') ?>" value="<?php echo get_search_query(); ?>" name="s" id="s" />
    <input type="submit" id="searchsubmit" class="sb-search-submit" value="<?php _e('Search', 'wpzoom') ?>" />
    <span class="sb-icon-search"></span>
</form>