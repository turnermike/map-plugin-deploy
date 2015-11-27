<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    hi_hat_map
 * @subpackage hi_hat_map/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    hi_hat_map
 * @subpackage hi_hat_map/includes
 * @author     Your Name <email@example.com>
 */
class hi_hat_map_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

        global $wpdb;
        global $custom_table_example_db_version;

        $table_name = $wpdb->prefix . 'hi_hat_map_locations';

        // sql to create your table
        // NOTICE that:
        // 1. each field MUST be in separate line
        // 2. There must be two spaces between PRIMARY KEY and its name
        //    Like this: PRIMARY KEY[space][space](id)
        // otherwise dbDelta will not work
        $sql = "CREATE TABLE " . $table_name . " (
          id bigint(20) NOT NULL AUTO_INCREMENT,
          name varchar(100) NOT NULL,
          description varchar(255) NULL,
          project_installer varchar(60) NULL,
          project_installer_url varchar(255) NOT NULL,
          project_size varchar(60) NULL,
          project_mounting_system varchar(60) NULL,
          project_tilt_angle varchar(60) NULL,
          project_completion_date datetime NULL,
          image_thumbnail_paths text NULL,
          image_large_paths text NULL,
          image_original_paths text NULL,
          latitude decimal(10,8) NOT NULL,
          longitude decimal(11, 8) NOT NULL,
          contact_name varchar(60) NULL,
          contact_email varchar(100) NOT NULL,
          date_added datetime NOT NULL,
          PRIMARY KEY  (id)
        );";

        // we do not execute sql directly
        // we are calling dbDelta which cant migrate database
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);








        // global $wpdb;

        // require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // $table_name = $wpdb->prefix . 'hi_hat_map_settings';

        // $sql = "CREATE TABLE $table_name (
        //         id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        //         option_name VARCHAR(64) DEFAULT '' NOT NULL,
        //         option_value LONGTEXT DEFAULT '' NOT NULL,
        //         date_modified datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        //         PRIMARY KEY  (id)
        //     );";

        // dbDelta( $sql );



	}

}
