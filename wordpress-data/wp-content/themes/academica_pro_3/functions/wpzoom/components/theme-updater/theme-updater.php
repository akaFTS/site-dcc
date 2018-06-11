<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'http://woo.wpzoom.com/', // Site where EDD is hosted
		'item_name' => WPZOOM::$themeName, // Name of theme
		'theme_slug' => WPZOOM::$theme_raw_name, // Theme slug
		'version' => WPZOOM::$themeVersion, // The current version of this theme
		'author' => 'WPZOOM', // The author of this theme
		'download_id' => '', // Optional, used for generating a license renewal link
		'renew_url' => 'http://woo.wpzoom.com/downloads/'.WPZOOM::$theme_raw_name.'/' // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license' => __( 'Theme License', 'wpzoom' ),
		'enter-key' => __( 'Enter your theme license key.', 'wpzoom' ),
		'license-key' => __( 'License Key', 'wpzoom' ),
		'license-action' => __( 'License Action', 'wpzoom' ),
		'deactivate-license' => __( 'Deactivate License', 'wpzoom' ),
		'activate-license' => __( 'Activate License', 'wpzoom' ),
		'status-unknown' => __( 'License status is unknown.', 'wpzoom' ),
		'renew' => __( 'Renew?', 'wpzoom' ),
		'unlimited' => __( 'unlimited', 'wpzoom' ),
		'license-key-is-active' => __( 'License key is active.', 'wpzoom' ),
		'expires%s' => __( 'Expires %s.', 'wpzoom' ),
		'%1$s/%2$-sites' => __( 'You have %1$s / %2$s sites activated.', 'wpzoom' ),
		'license-key-expired-%s' => __( 'License key expired %s.', 'wpzoom' ),
		'license-key-expired' => __( 'License key has expired.', 'wpzoom' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'wpzoom' ),
		'license-is-inactive' => __( 'License is inactive.', 'wpzoom' ),
		'license-key-is-disabled' => __( 'License key is disabled.', 'wpzoom' ),
		'site-is-inactive' => __( 'Site is inactive.', 'wpzoom' ),
		'license-status-unknown' => __( 'License status is unknown.', 'wpzoom' ),
		'update-notice' => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'wpzoom' ),
		'update-available' => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'wpzoom' )
	)

);