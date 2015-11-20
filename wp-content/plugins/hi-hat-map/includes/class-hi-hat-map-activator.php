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

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $table_name = $wpdb->prefix . 'hi_hat_map_settings';

        $sql = "CREATE TABLE $table_name (
                id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                option_name VARCHAR(64) DEFAULT '' NOT NULL,
                option_value LONGTEXT DEFAULT '' NOT NULL,
                date_modified datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                PRIMARY KEY  (id)
            );";

        // $sql = "CREATE TABLE $table_name (
        //     id mediumint(9) NOT NULL AUTO_INCREMENT,
        //     name varchar(64) NOT NULL,
        //     value longtext NOT NULL,
        //     date_modified datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        //     UNIQUE KEY id (id)
        // ) $charset_collate;";

        dbDelta( $sql );

        // echo $wpdb->last_error;
        // die();






        // global $wpdb;
        // $table_name = $wpdb->prefix . 'hi-hat';
        // $charset_collate = $wpdb->get_charset_collate();

        // if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
        //     $sql = "CREATE TABLE $table_name (
        //         id mediumint(9) NOT NULL AUTO_INCREMENT,
        //         time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        //         name tinytext NOT NULL,
        //         text text NOT NULL,
        //         url varchar(55) DEFAULT '' NOT NULL,
        //         UNIQUE KEY id (id)
        //     ) $charset_collate;";
        //     require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        //     dbDelta($sql);

        // // echo 'table prefix: ' . $wpdb->prefix; die();

        // }else{
        //     echo 'table exists'; die();
        // }

















	}

}
