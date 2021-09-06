<?php
/*
Plugin Name: Ninja Facebook Messenger
Plugin URI: https://ninjateam.org/facebook-messenger-for-wordpress/
Description: Help your customers easy to contact with your business
Author: Ninja Team
Version: 2.4
Author URI: http://ninjateam.org/
Authoras URI: http://ninjateam.org/
*/
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define('FACEBOOK_MESSENGER_PLUGIN_URL', plugin_dir_url(__FILE__));
define('FACEBOOK_MESSENGER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FACEBOOK_MESSENGER_PLUGIN_NAME', 'Ninja Facebook Messenger');
define('FACEBOOK_MESSENGER_PLUGIN_VER', '2.3');
define('FACEBOOK_MESSENGER_PLUGIN_SLUG', 'facebook-messenger/facebook-messenger.php');

add_action('plugins_loaded', 'ninja_facebook_messenger_text_domain');
function ninja_facebook_messenger_text_domain()
{
    load_plugin_textdomain('fb_messenger', false, plugin_basename(FACEBOOK_MESSENGER_PLUGIN_DIR) . '/languages/');
}
/*
* Add default options active plugin
*/
function ninja_facebook_messenger_chat_on_plugin_activation() {
    add_option("facebook_messenger_user","https://www.facebook.com/ninjateam.org");
    add_option("facebook_messenger_backgroud","#0075FF");
    add_option("facebook_messenger_lang","en_US");
    add_option("facebook_messenger_lang_depends_on_wpml", "0");
    add_option("facebook_messenger_woo_position","3");
    add_option("facebook_messenger_display","1");
    add_option("facebook_messenger_text_botton","Support");
    add_option("facebook_messenger_app","1");
    add_option("facebook_messenger_app_text","Send message via your Messenger App");
    add_option("facebook_messenger_text_img",FACEBOOK_MESSENGER_PLUGIN_URL."frontend/images/facebook-messenger.svg");
}
register_activation_hook( __FILE__, 'ninja_facebook_messenger_chat_on_plugin_activation' );
/*
* Include Back-end
*/
include FACEBOOK_MESSENGER_PLUGIN_DIR."backend/index.php";
include FACEBOOK_MESSENGER_PLUGIN_DIR."backend/wiget.php";
/*
* Include Font-end
*/
include FACEBOOK_MESSENGER_PLUGIN_DIR."frontend/index.php";
/*
* Woocommerce
*/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
   include FACEBOOK_MESSENGER_PLUGIN_DIR."backend/woo_commerce.php";
   include FACEBOOK_MESSENGER_PLUGIN_DIR."frontend/woo_commerce.php";
}
add_filter( 'plugin_row_meta', "plugin_messenger_row_meta", 10, 2 );

function plugin_messenger_row_meta( $links, $file ) {
		if ( $file == "facebook-messenger/facebook-messenger.php" ) {
			$row_meta = array(
				'docs'    => '<a href="https://ninjateam.org/facebook-messenger-for-wordpress/" title="Documentation">' . __( 'Docs', 'fb_messenger' ) . '</a>',
                'support'    => '<a href="https://ninjateam.org/support/" title="Premium Support">' . __( 'Premium Support', 'fb_messenger' ) . '</a>',
                'view'    => '<a href="http://codecanyon.net/item/facebook-messenger-for-wordpress/16392065" title="Rate this plugin 5 stars rate on Codecanyon">' . __( ' Don\'t forget give me 5 stars rate ★★★★★ :)', 'fb_messenger' ) . '</a>',
			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
}

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'messenger_add_plugin_page_settings_link');
function messenger_add_plugin_page_settings_link( $links ) {
    $links[] = '<a href="' .
        admin_url( 'options-general.php?page=facebook_messenger_options_page' ) .
        '">' . __('Settings') . '</a>';
    return $links;
}