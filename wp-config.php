<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //

//default to production
$server = strtolower( $_SERVER['SERVER_NAME'] );
$environment = 'production';

//check for development
$result = preg_match('/map-plugin.dev/', $server , $matches);
if($result > 0) $environment = 'development';

//check for staging
$result = preg_match('/staging-domain.com/', $server , $matches);
if($result > 0) $environment = 'staging';

//check for production
$result = preg_match('/production-domain.com/', $server , $matches);
if($result > 0) $environment = 'production';

//declare constant
define('ENVIRONMENT', $environment);
//echo 'ENV: ' . ENVIRONMENT;

//define database connection settings
if(defined('ENVIRONMENT')){
    switch(ENVIRONMENT){
    case 'development':
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'map_plugin');
        define('DB_USER', 'root');
        define('DB_PASSWORD', 'root');
        define('WP_DEBUG', false);
        define('WP_DEBUG_LOG', true);
        define('WP_DEBUG_DISPLAY', false);
        @ini_set('display_errors', true);
        break;
    case 'staging':
        define('DB_HOST', '');
        define('DB_NAME', '');
        define('DB_USER', '');
        define('DB_PASSWORD', '');
        define('WP_DEBUG', false);
        define('WP_DEBUG', false);
        define('WP_DEBUG_LOG', true);
        define('WP_DEBUG_DISPLAY', false);
        @ini_set('display_errors', false);
        break;
    case 'production':
        define('DB_HOST', '');
        define('DB_NAME', '');
        define('DB_USER', '');
        define('DB_PASSWORD', '');
        define('WP_DEBUG', false);
        define('WP_DEBUG', false);
        define('WP_DEBUG_LOG', true);
        define('WP_DEBUG_DISPLAY', false);
        @ini_set('display_errors', false);
        break;
    }
}

define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

// Increase memory limit to 64MB
define('WP_MEMORY_LIMIT', '64M');

// Empty trash automatically after 30 days
// define('EMPTY_TRASH_DAYS', 30);

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '|pzj;ApF&Lo`@(B`RG+%3?oCwsp-N/[DnlNeM3KqaY]#FoK_VvZku#NQ:3yG1l`#');
define('SECURE_AUTH_KEY',  'wj*9@q[@$#Ng{=}JgPUAp>%iXbOlnl+Kv5f>);7W5h2U;S|/<LxiFar}c6ap^[Z?');
define('LOGGED_IN_KEY',    'S5:zX0-p7L9Y}0V-/*|D(is_#t RgYPYqI=@>6{1dYm:k7$iN5Lu@4dO_c;}1GO^');
define('NONCE_KEY',        '$yR9;Fw,}I{ac3iQvU`,k#J<^A_E7yiIWZdO;AJ)9x)~[|ohK+cUZMOC!y7FW%#f');
define('AUTH_SALT',        'C^Tte}b@m_L @ZhkKk5,WfyvE:1[8B;/fLrjAs_NbuM$*U[p4RlnXKI]C,@/w5,C');
define('SECURE_AUTH_SALT', 'cmMDEv%GPoiu8>KzLVM,;(-u$Ws?onArz@U4>w/JLf3ga FMV&HNYq7A@[z] 0ey');
define('LOGGED_IN_SALT',   'zZ}t-[2t:sA<s6G#K@n>|)v37UR6gW;Gh)Z|8oj0HJUZb[zM0NHRu2g{jYVqhNWo');
define('NONCE_SALT',       'uie{woP3Y,p0-P?I{F+j>:?dRTtY:$@m_&ag:Q`RM+duAc3pIPzCIxF+%ZK9Bj)l');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'uxaum8qyy_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
// See evironment conditional above.
// define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
