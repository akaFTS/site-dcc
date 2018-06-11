<?php
/**
 * @package WPZOOM
 */

/**
 * Class WPZOOM_Setup_Customizer
 *
 * Methods for managing and enqueueing script and style assets.
 *
 * @since 1.7.0.
 */
class WPZOOM_Setup_Customizer {
	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private static $hooked = false;

	public function __construct() {
	    $this->hook();
	}

	/**
	 * Hook into WordPress.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		// Register style and script libs
		add_action( 'wp_enqueue_scripts', array( $this, 'register_libs' ), 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_libs' ), 1 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'register_libs' ), 1 );
		add_action( 'customize_preview_init', array( $this, 'register_libs' ), 1 );

		// Hooking has occurred.
		self::$hooked = true;
	}

	/**
	 * Check if the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function is_hooked() {
		return self::$hooked;
	}

	/**
	 * Wrapper for getting the path to the customizer assets directory.
	 *
	 * @since 1.7.0.
	 *
	 * @return string
	 */
	public function get_assets_uri( $endpoint = '' )
	{
	    return WPZOOM::$wpzoomPath . '/components/customizer/assets/' . $endpoint;
	}

	/**
	 * Wrapper for getting the URL for the customizer assets CSS directory.
	 *
	 * @since 1.7.0.
	 *
	 * @return string
	 */
	public function get_css_uri( $endpoint = '' )
	{
	    return $this->get_assets_uri('css/' . $endpoint);
	}

	/**
	 * Wrapper for getting the URL for the customizer assets JS directory.
	 *
	 * @since 1.7.0.
	 *
	 * @return string
	 */
	public function get_js_uri( $endpoint = '' )
	{
	    return $this->get_assets_uri('js/' . $endpoint);
	}

	/**
	 * Wrapper function to register style and script libraries for usage throughout the site.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action wp_enqueue_scripts
	 * @hooked action admin_enqueue_scripts
	 * @hooked action customize_controls_enqueue_scripts
	 * @hooked action customize_preview_init
	 *
	 * @return void
	 */
	public function register_libs() {
		$this->register_style_libs();
		$this->register_script_libs();
	}

	/**
	 * Register style libraries.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	private function register_style_libs() {
		// Chosen
		wp_register_style(
			'chosen',
			$this->get_css_uri('libs/chosen/chosen.min.css'),
			array(),
			'1.5.1'
		);

		// jQuery UI
		wp_register_style(
			'zoom-jquery-ui-custom',
			$this->get_css_uri('libs/jquery-ui/jquery-ui-1.10.4.custom.css'),
			array(),
			'1.10.4'
		);
	}

	/**
	 * Register JavaScript libraries.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	private function register_script_libs() {
		// Chosen
		wp_register_script(
			'chosen',
			$this->get_js_uri('libs/chosen/chosen.jquery.min.js'),
			array( 'jquery' ),
			'1.5.1',
			true
		);
	}
}