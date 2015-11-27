<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    hi_hat_map
 * @subpackage hi_hat_map/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    hi_hat_map
 * @subpackage hi_hat_map/includes
 * @author     Your Name <email@example.com>
 */
class hi_hat_map_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

        global $wpdb;
        global $custom_table_example_db_version;

        $table_name = $wpdb->prefix . 'hi_hat_map_locations';

        // TODO
        // this will delete the options, add ability for user to set this in plugin settings
        // delete_option('hi_hat_map_settings');

        $sql = "DROP TABLE IF EXISTS " . $table_name . ";";

        // we do not execute sql directly
        // we are calling dbDelta which cant migrate database
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        // dbDelta($sql);

        $wpdb->query($sql);

	}

}
