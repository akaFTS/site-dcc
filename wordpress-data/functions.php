<?php

require_once "vendor/autoload.php";

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
						<a href="http://'.home_url().'/event/'.$event->post_name.'/" rel="bookmark">'.$event->post_title.'</a>
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

	return generate_event_widget($events, '<a href="'.home_url().'/events/categoria/defesas">Ver Todas as Defesas</a>');

}
add_shortcode('next-thesis', 'get_next_thesis');

// Other events widget
function get_next_events() {
	$events = tribe_get_events(array(
		'start_date' => new DateTime()
	));
	$events = array_filter($events, "is_not_defense");

	return generate_event_widget($events, '<a href="'.home_url().'/events/">Ver Todos os Eventos</a>');	
}
add_shortcode('next-events', 'get_next_events');


/* ******** OAUTH LOGIN ******** */


function oauth_login( $data ) {  

	// Create an instance of Risan\OAuth1\OAuth1 class.
	$oauth1 = Risan\OAuth1\OAuth1Factory::create([
    	'client_credentials_identifier' => 'ime_dcc',
    	'client_credentials_secret' => 'sIntaJpOodQK1TWuKnt0ij5y0GHznIu65YEvQOZE',
    	'temporary_credentials_uri' => 'https://uspdigital.usp.br/wsusuario/oauth/request_token',
    	'authorization_uri' => 'https://uspdigital.usp.br/wsusuario/oauth/authorize',
    	'token_credentials_uri' => 'https://uspdigital.usp.br/wsusuario/oauth/access_token',
    	'callback_uri' => '',
	]);

	// STEP 3
	if (isset($_SESSION['token_credentials'])) {
		// Get back the previosuly obtain token credentials.
		$tokenCredentials = unserialize($_SESSION['token_credentials']);
		$oauth1->setTokenCredentials($tokenCredentials);
	
		// Get back some user info
		$response = $oauth1->request('POST', 'https://uspdigital.usp.br/wsusuario/oauth/usuariousp');
		$user = json_decode($response->getBody()->getContents(), true);
	
		// Perform Wordpress login for user
		logUserIn($user);
	} 
	
	//STEP 2
	elseif (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) {

		// Get back the previosuly generated temporary credentials from step 1.
		$temporaryCredentials = unserialize($_SESSION['temporary_credentials']);
		unset($_SESSION['temporary_credentials']);
	
		// Obtain the token credentials (also known as access token).
		$tokenCredentials = $oauth1->requestTokenCredentials($temporaryCredentials, $_GET['oauth_token'], $_GET['oauth_verifier']);
	
		// Store the token credentials in session for later use.
		$_SESSION['token_credentials'] = serialize($tokenCredentials);
	
		// this basically just redirecting to the current page so that the query string is removed.
		// echo '<META HTTP-EQUIV="refresh" content="0;URL='.(string) $oauth1->getConfig()->getCallbackUri().'">';
		header("Location: /wp-json/oauth/login");
		exit();
	} 
	
	// STEP 1
	else {
		// Obtain a temporary credentials (also known as the request token)
		$temporaryCredentials = $oauth1->requestTemporaryCredentials();
	
		// Store the temporary credentials in session so we can use it on step 3.
		$_SESSION['temporary_credentials'] = serialize($temporaryCredentials);
	
		// Generate and redirect user to authorization URI.
		$authorizationUri = $oauth1->buildAuthorizationUri($temporaryCredentials);
		header("Location: {$authorizationUri}");
		exit();
	}
}

function logUserIn($user) {
	// Check if user already exists
	if($userid = email_exists($user['emailPrincipalUsuario'])) {
		// Log him in
		wp_set_auth_cookie($userid, true);
		header("Location: ".home_url());
		exit();

	} else {
		// Define user role
		$role = '';
		switch($user['vinculo'][0]['tipoVinculo']) {
			case 'ALUNOGR':
				$role = 'alunobcc';
				break;
			case 'ALUNOPOS':
				$role = 'alunopos';
				break;
			case 'DOCENTE':
				$role = 'professor';
				break;
			default:
				$role = 'alunobcc';
				break;
		}

		$names = explode(' ', $user['nomeUsuario']);

		// Create a new account
		$userdata = array(
			'user_login'  =>  $user['loginUsuario'],
			'first_name'    =>  $names[0],
			'last_name' => $names[count($names)-1],
			'display_name' => $names[0] . ' ' . $names[count($names)-1],
			'user_pass' => wp_generate_password(),
			'user_email' => $user['emailPrincipalUsuario'],
			'role'   =>  $role
		);

		$user_id = wp_insert_user($userdata);

		wp_set_auth_cookie($user_id, true);
		header("Location: ".home_url());
		exit();
	}
}

// Register oauth route
add_action( 'rest_api_init', function () {
	register_rest_route( 'oauth', '/login', array(
	  'methods' => 'GET',
	  'callback' => 'oauth_login',
	));
});

