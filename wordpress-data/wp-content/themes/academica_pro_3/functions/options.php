<?php return array(

/* Theme Admin Menu */
"menu" => array(
    array("id"    => "1",
          "name"  => "General"),

    array("id"    => "2",
          "name"  => "Homepage"),
),

/* Theme Admin Options */
"id1" => array(
    array("type"  => "preheader",
          "name"  => "Theme Settings"),

    array("name"  => "Custom Feed URL",
          "desc"  => "Example: <strong>http://feeds.feedburner.com/wpzoom</strong>",
          "id"    => "misc_feedburner",
          "std"   => "",
          "type"  => "text"),

    array("type"  => "preheader",
          "name"  => "Header Settings"),

	array("type"  => "startsub",
          "name"  => "Header Text"),

    array("name"  => "Display Header Text",
          "desc"  => "Leave this checked if you want to display the special text in header (demo: telephone number).",
          "id"    => "tel_enable",
          "std"   => "on",
          "type"  => "checkbox"),

    array("name"  => "Header Text Caption",
          "desc"  => "Example: Call today: ",
          "id"    => "tel_caption",
          "std"   => "Edit this in WPZOOM Theme Options ",
          "type"  => "text"),

    array("name"  => "Header Text Value",
          "desc"  => "Example: 0800-123-456",
          "id"    => "tel_text",
          "std"   => "800-123-456",
          "type"  => "text"),

	array("type"  => "endsub"),

	array("type"  => "startsub",
          "name"  => "Header Social Icons"),

        array("name"  => "Social Icons",
              "desc"  => "Install <a href=\"https://wordpress.org/plugins/social-icons-widget-by-wpzoom/\">Social Icons Widget</a> plugin and add the widget in the <strong>Header Social Icons</strong> widget area on <strong>Widgets</strong> page.",
              "id"    => "theme_style",
              "std"   => "Default",
              "type"  => "paragraph"),


	array("type"  => "endsub"),

 	array("type"  => "preheader",
          "name"  => "Global Posts Options"),

     array("name"  => "Post Archives Columns",
          "desc"  => "Display posts on archives in one column or two.",
          "id"    => "display_posts_columns",
          "options" => array('One', 'Two'),
          "std"   => "One",
          "type"  => "select"),

    array("name"  => "Posts with Thumbnails",
          "desc"  => "How many posts to display with thumbnails on archive pages. Default: 4.",
          "id"    => "display_with_thumbs",
          "std"   => "4",
          "type"  => "text"),

    array("name"  => "Excerpt length",
          "desc"  => "Default: <strong>30</strong> (words)",
          "id"    => "excerpt_length",
          "std"   => "30",
          "type"  => "text"),

    array("name"  => "Show Date/time",
          "desc"  => "<strong>Date/Time format</strong> can be changed <a href='options-general.php' target='_blank'>here</a>.",
          "id"    => "display_date",
          "std"   => "on",
          "type"  => "checkbox"),

    array("name"  => "Show Category",
          "id"    => "display_category",
          "std"   => "on",
          "type"  => "checkbox"),

	array("type"  => "preheader",
          "name"  => "Single Post Options"),

	array("name"  => "Show Date/time",
          "desc"  => "<strong>Date/Time format</strong> can be changed <a href='options-general.php' target='_blank'>here</a>.",
          "id"    => "post_date",
          "std"   => "on",
          "type"  => "checkbox"),

    array("name"  => "Show Category",
          "id"    => "post_category",
          "std"   => "off",
          "type"  => "checkbox"),

    array("name"  => "Show Author",
          "desc"  => "You can edit your profile on this <a href='profile.php' target='_blank'>page</a>.",
          "id"    => "post_author",
          "std"   => "on",
          "type"  => "checkbox"),

    array("name"  => "Show Tags",
          "id"    => "post_tags",
          "std"   => "on",
          "type"  => "checkbox"),

	array("name"  => "Show Social Buttons",
          "id"    => "post_share",
          "std"   => "on",
          "type"  => "checkbox"),

    array("name"  => "Show Comments",
          "id"    => "post_comments",
          "std"   => "on",
          "type"  => "checkbox"),

	array("type"  => "preheader",
          "name"  => "Single Page Options"),

	array("name"  => "Show Social Buttons",
          "id"    => "page_share",
          "std"   => "on",
          "type"  => "checkbox"),

    array("name"  => "Show Comments",
          "id"    => "page_comments",
          "std"   => "on",
          "type"  => "checkbox"),

),

"id2" => array(


    array("type"  => "preheader",
          "name"  => "Homepage Slideshow"),

    array("name"  => "Display Slideshow on Homepage?",
          "desc"  => "Do you want to show a featured slider on the homepage? To feature a post or page in the slider just check the option <strong>Feature in Homepage Slider</strong> when you edit a specific post or page.",
          "id"    => "featured_posts_show",
          "std"   => "on",
          "type"  => "checkbox"),

    array("name"  => "Content Source",
          "desc"  => "Select the type of content that should be displayed in the slider. <strong>Slides are ordered by date</strong>.",
          "options" => array('Featured Posts', 'Featured Pages'),
          "id"   => "featured_type",
          "std"   => "Featured Posts",
          "type"  => "select"),


    array("name"  => "Autoplay Slideshow?",
          "desc"  => "Do you want to auto-scroll the slides?",
          "id"    => "slideshow_auto",
          "std"   => "off",
          "type"  => "checkbox",
          "js"    => true),

    array("name"  => "Slider Autoplay Interval",
          "desc"  => "Select the interval (in miliseconds) at which the Slider should change slides (<strong>if autoplay is enabled</strong>). Default: 3000 (3 seconds).",
          "id"    => "slideshow_speed",
          "std"   => "3000",
          "type"  => "text",
          "js"    => true),

    array("name"  => "Number of Posts/Pages in Slider",
          "desc"  => "How many posts or pages should appear in the Slider on the homepage? Default: 5.",
          "id"    => "slideshow_posts",
          "std"   => "5",
          "type"  => "text"),

    array(
        "name" => "Display Date/Time",
        "desc" => "<strong>Date/Time format</strong> can be changed <a href='options-general.php' target='_blank'>here</a>.",
        "id" => "slider_date",
        "std" => "on",
        "type" => "checkbox"
    ),

    array(
        "name" => "Display Excerpt",
        "id" => "slider_excerpt",
        "std" => "on",
        "type" => "checkbox"
    ),

    array(
        "name" => "Display Read More Button",
        "id" => "slider_button",
        "std" => "on",
        "type" => "checkbox"
    ),

),

/* end return */);