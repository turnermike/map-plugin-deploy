<?php
/**
 * Hi-hat Map
 *
 * @package   Hi_Hat_Map
 * @author    Mike Turner <turner.mike@gmail.com>
 * @license   GPL-2.0+
 * @link      http://hi-hatconsulting.com
 * @copyright 2014 Hi-hat Consulting
 *
 * @wordpress-plugin
 * Plugin Name:       Hi-hat Map
 * Plugin URI:        http://hi-hatconsulting.com
 * Description:       A mapping plugin.
 * Version:           1.0.0
 * Author:            Mike Turner
 * Author URI:        http://hi-hatconsulting.com
 * Text Domain:       hi-hat-map
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * WordPress-Plugin-Boilerplate: v2.6.1
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . '/class-hi-hat-map.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 */
register_activation_hook( __FILE__, array( 'Hi_Hat_Map', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Hi_Hat_Map', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'Hi_Hat_Map', 'get_instance' ) );


