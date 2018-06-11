<?php

/*-----------------------------------------------------------------------------------*/
/* Initializing Widgetized Areas (Sidebars)                                                                          */
/*-----------------------------------------------------------------------------------*/

/*----------------------------------*/
/* Homepage widgetized areas		*/
/*----------------------------------*/

register_sidebar(array(
    'name'=>'Homepage: Content Widgets',
    'id' => 'home',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
    'before_title' => '<h3 class="title">',
    'after_title' => '</h3>',
));


/*----------------------------------*/
/* Sidebar							*/
/*----------------------------------*/

register_sidebar(array(
    'name'=>'Sidebar: Left Column',
    'id' => 'sidebar-left',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
    'before_title' => '<h3 class="title">',
    'after_title' => '</h3>',
));

register_sidebar(array(
    'name'=>'Sidebar: Right Column',
    'id' => 'sidebar-right',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
    'before_title' => '<h3 class="title">',
    'after_title' => '</h3>',
));

/*----------------------------------*/
/* Footer widgetized areas		*/
/*----------------------------------*/

register_sidebar(array('name'=>'Footer: Column 1',
    'id' => 'footer-column-1',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
    'before_title' => '<h3 class="title">',
    'after_title' => '</h3>',
));

register_sidebar(array('name'=>'Footer: Column 2',
    'id' => 'footer-column-2',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
    'before_title' => '<h3 class="title">',
    'after_title' => '</h3>',
));

register_sidebar(array('name'=>'Footer: Column 3',
    'id' => 'footer-column-3',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
    'before_title' => '<h3 class="title">',
    'after_title' => '</h3>',
));

register_sidebar(array('name'=>'Footer: Column 4',
    'id' => 'footer-column-4',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="cleaner">&nbsp;</div></div>',
    'before_title' => '<h3 class="title">',
    'after_title' => '</h3>',
));



register_sidebar(array('name'=>'Homepage (Below the Slider) 1/3 Column',
    'id' => 'homepage-1',
    'description' => 'Widget area for: WPZOOM: Image Box widget.',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="clear"></div></div>',
    'before_title' => '<h3 class="title">',
    'after_title' => '</h3>',
));

register_sidebar(array('name'=>'Homepage (Below the Slider) 2/3 Column',
    'id' => 'homepage-2',
    'description' => 'Widget area for: WPZOOM: Image Box widget.',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="clear"></div></div>',
    'before_title' => '<h3 class="title">',
    'after_title' => '</h3>',
));

register_sidebar(array('name'=>'Homepage (Below the Slider) 3/3 Column',
    'id' => 'homepage-3',
    'description' => 'Widget area for: WPZOOM: Image Box widget.',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="clear"></div></div>',
    'before_title' => '<h3 class="title">',
    'after_title' => '</h3>',
));


/* Header - for social icons
===============================*/

register_sidebar(array(
    'name'=>'Header Social Icons',
    'id' => 'header_social',
    'description' => 'Widget area in the header. Install the "Social Icons Widget by WPZOOM" plugin and add the widget here.',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="title"><span>',
    'after_title' => '</span></h3>',
));
