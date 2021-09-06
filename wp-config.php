<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '3pQpGQ2ncyAWpyetdsbUiTezbwrZsaNOLe5LTyuNAa23G+ewDDZvQPyzMXVF2aB9K4V9PXyKRJR+mbRmE1k4YA==');
define('SECURE_AUTH_KEY',  'JxtAosBrZGequ7da2BQRYCEH11zASDSoDUoIF5eCwKuDGJlXLWjbfaPPLgP1Obfc406N/ViSyMCsKre3DS0fYQ==');
define('LOGGED_IN_KEY',    'bEbgfhioydNCNbecdYtHIARol/il58+DAgvWKHYQaYoRnkA5PJtvno85l3IqQv5VB/8wvyJJn6VlbYsTn/5YQg==');
define('NONCE_KEY',        'kR8aDy9WdmDDGFIMechxL3aV23kXP/40yOs4pkozCerjakClFAHOoyGiync3NIOOi1gOAD29tII9McC8Pdn3yQ==');
define('AUTH_SALT',        'q5ZbB0qd1J0mzFWN4sHrZ4V0TQqZH2DfmIbiiTt0U+RqwyvmxRM9QQL+87wNi+QzL1Ox4txQctHECwSVEUV8og==');
define('SECURE_AUTH_SALT', 'ecUZwHkrR6qNdRwDIWn0Jzw0bQINCX6Ef9LlsDOk6CeIyd42PeFMMRhJ01wzYNkIl1R/qxJ+wxDhQbRQ4x3bKQ==');
define('LOGGED_IN_SALT',   'DhwGxnnTwiyFwtSWuk9DsERsaE4Tec0LFcWada32+7f7/936tyyN8Z4QD1HGkC7gjoLpDOMOj35B2NHK/A8YGA==');
define('NONCE_SALT',       '9WhtQpiF9cEVRhm5cwgNfiKK+rsVaPGJPMXsdMHqayJuBzHI1lfZqmL2cS+KL+dUnEK4dtmEbeTvV8NpINKkog==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
# BEGIN WP Hide & Security Enhancer
define('WPH_WPCONFIG_LOADER',          TRUE);
include_once( ( defined('WP_PLUGIN_DIR')    ?     WP_PLUGIN_DIR   .   '/wp-hide-security-enhancer-pro/'    :      ( defined( 'WP_CONTENT_DIR') ? WP_CONTENT_DIR  :   dirname(__FILE__) . '/' . 'wp-content' )  . '/plugins/wp-hide-security-enhancer-pro' ) . '/include/wph.class.php');
global $wph;
$wph    =   new WPH();
ob_start( array($wph, 'ob_start_callback'));
# END WP Hide & Security Enhancer
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
