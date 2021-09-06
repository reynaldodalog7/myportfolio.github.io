<?php
    
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    /**
    * 
    *   WP Hide & Security Enhancer - MU plugin loader
    * 
    * 
    */

    $plugin_path    =   'wp-hide-security-enhancer-pro/wp-hide.php';
    
    //check if the plugin still exists, or this file should be removed
    if(! file_exists(WP_PLUGIN_DIR . '/' . $plugin_path ))
        return FALSE;
    
    //check if the plugin is active
    if ( is_multisite() )
        {
            $active_plugins =   (array)get_site_option('active_sitewide_plugins');
            if( !isset ( $active_plugins[ $plugin_path ]) )
                return FALSE;
        }
        else
        {
            $active_plugins =   (array)get_option('active_plugins');
            if( !in_array( $plugin_path , $active_plugins) )
                return FALSE;
        }
    
    
    define('WPH_PATH',              trailingslashit( dirname( WP_PLUGIN_DIR . '/' . $plugin_path ) )  );
    define('WPH_MULOADER',          TRUE);
    define('WPH_MULOADER_VERSION',  '1.2.1');
    
    include_once(WPH_PATH . '/include/wph.class.php');
    include_once(WPH_PATH . '/include/functions.class.php');
    
    include_once(WPH_PATH . '/include/module.class.php');
    include_once(WPH_PATH . '/include/module.component.class.php');
    
    
    global $wph;
    
    //if the class not defined within wp-config.php
    if  (! is_a($wph, 'WPH') )
        {
            $wph    =   new WPH();
            ob_start(array($wph, 'ob_start_callback'));
        }

    $wph->init();

?>