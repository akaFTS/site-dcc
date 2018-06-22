<?php


/* ******** LOGOUT WIDGET ******** */


// Enable shortcodes inside widgets
add_filter('widget_text', 'do_shortcode');
add_filter('widget_title', 'do_shortcode');

// Get current user's name
function show_loggedin_function( $atts ) {
	global $current_user, $user_login;
	get_currentuserinfo();
		return $current_user->display_name;
}

function show_logout_link() {
    return '<a href="'.wp_logout_url(home_url()).'">Sair</a>';
}
add_shortcode('current-user', 'show_loggedin_function');
add_shortcode('logout', 'show_logout_link');



/* ******** OAUTH LOGIN ******** */


function oauth_login( $data ) {  
	return "oi";
}

// Register oauth route
add_action( 'rest_api_init', function () {
	register_rest_route( 'oauth', '/login', array(
	  'methods' => 'GET',
	  'callback' => 'oauth_login',
	));
});


/* ******** EVENT WIDGETS ******** */


// Check if event is a thesis defense
function is_defense($event) {
	return tribe_get_event_cat_slugs($event->ID)[0] == 'defesas';
}

// Inverse of last function
function is_not_defense($event) {
	return !is_defense($event);
}

// Generate widget HTML from a list of events
function generate_event_widget($events, $footer_link) {
	$count = 0;
	$return = '<div class="tribe-events-list-widget"><ol class="tribe-list-widget">';
	foreach( $events as $event ) {
		if($count == 5)
			break;

		$count++;
		$local = tribe_get_venue($event->ID);
		$day = (new DateTime($event->EventStartDate))->format('d');
		$month = (new DateTime($event->EventStartDate))->format('M');
		$hour = (new DateTime($event->EventStartDate))->format('H:i');
		
		$return .= '
			<li class="tribe-events-list-widget-events type-tribe_events tribe-clearfix tribe-events-category-defesas">
				<div class="tribe-flex-date">
					<span class="day">'.$day.'</span>
					<span class="month">'.$month.'</span>
				</div>
				<div class="tribe-flex-text">
					<h4 class="tribe-event-title">
						<a href="http://localhost:8080/event/'.$event->post_name.'/" rel="bookmark">'.$event->post_title.'</a>
					</h4>
					<div class="tribe-event-duration">
						<b>'.$local.'</b> • <span class="tribe-event-date-start">'.$hour.'</span>				
					</div>
				</div>
			</li>
		';
	} 
	$return .= '<p class="tribe-events-widget-link">'.$footer_link.'</p></ol></div>';
	return $return;
}

// Thesis defense widget
function get_next_thesis() {
	$events = tribe_get_events(array(
		'start_date' => new DateTime()
	));
	$events = array_filter($events, "is_defense");

	return generate_event_widget($events, '<a href="http://localhost:8080/events/categoria/defesas">Ver Todas as Defesas</a>');

}
add_shortcode('next-thesis', 'get_next_thesis');

// Other events widget
function get_next_events() {
	$events = tribe_get_events(array(
		'start_date' => new DateTime()
	));
	$events = array_filter($events, "is_not_defense");

	return generate_event_widget($events, '<a href="http://localhost:8080/events/">Ver Todos os Eventos</a>');	
}
add_shortcode('next-events', 'get_next_events');
