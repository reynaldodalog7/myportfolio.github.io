<?php
/**
 * Plugin Name: RyanCV Plugin
 * Plugin URI: http://ryan.beshley.com
 * Description: This plugin it's designed for RyanCV Theme
 * Version: 1.0.1
 * Author: beshleyua
 * Author URI: http://beshley.com
 * Text Domain: ryancv
 * Domain Path: /language/
 * License: http://www.gnu.org/licenses/gpl.html
 */

/* Load plugin text-domain */
function ryancv_plugin_load_textdomain() {
	load_plugin_textdomain( 'ryancv-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'ryancv_plugin_load_textdomain' );

/* Custom Post Types */
require plugin_dir_path( __FILE__ ) . 'custom-post-types.php';

// ACF RyanCV fields extention
require plugin_dir_path( __FILE__ ) . 'acf-ext/acf-ui-google-font/acf-ui-google-font.php';
require plugin_dir_path( __FILE__ ) . 'acf-ext/acf-ionicons/acf-ionicons.php';
require plugin_dir_path( __FILE__ ) . 'acf-ext/acf-cf7/acf-cf7.php';
?>