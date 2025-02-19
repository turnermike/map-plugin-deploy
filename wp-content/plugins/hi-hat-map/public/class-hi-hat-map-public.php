<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    hi_hat_map
 * @subpackage hi_hat_map/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    hi_hat_map
 * @subpackage hi_hat_map/public
 * @author     Your Name <email@example.com>
 */
class hi_hat_map_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $hi_hat_map    The ID of this plugin.
	 */
	private $hi_hat_map;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $hi_hat_map       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $hi_hat_map, $version ) {

		$this->hi_hat_map = $hi_hat_map;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in hi_hat_map_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The hi_hat_map_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->hi_hat_map, plugin_dir_url( __FILE__ ) . 'css/hi-hat-map-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in hi_hat_map_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The hi_hat_map_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->hi_hat_map, plugin_dir_url( __FILE__ ) . 'js/hi-hat-map-public.js', array( 'jquery' ), $this->version, false );

	}

}
