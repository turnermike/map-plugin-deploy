<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    hi_hat_map
 * @subpackage hi_hat_map/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    hi_hat_map
 * @subpackage hi_hat_map/admin
 * @author     Your Name <email@example.com>
 */
class hi_hat_map_Admin {

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
	 * @param      string    $hi_hat_map       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $hi_hat_map, $version ) {

		$this->hi_hat_map = $hi_hat_map;
		$this->version = $version;

		add_action('admin_menu', array($this, 'add_menu_item'));

	}



	public function add_menu_item(){
		add_options_page( 'My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', array($this, 'my_plugin_options') );
	}

	public function my_plugin_options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		echo '<div class="wrap">';
		echo '<p>Here is where the form would go if I actually had options.</p>';
		echo '</div>';
	}	


	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->hi_hat_map, plugin_dir_url( __FILE__ ) . 'css/hi-hat-map-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->hi_hat_map, plugin_dir_url( __FILE__ ) . 'js/hi-hat-map-admin.js', array( 'jquery' ), $this->version, false );

	}

}





