<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_functions
        {
            var $wph;
                                  
            function __construct()
                {
                    global $wph;
                    $this->wph          =   &$wph;
                }
    
                
            function get_module_component_default_setting()
                {
                    $defaults   = array (
                                            'type'                      =>  'component',
                                            'id'                        =>  '',
                                            'visible'                   =>  TRUE,
                                            'label'                     =>  '',
                                            'description'               =>  '',
                                            'value_description'         =>  '',
                                            'input_type'                =>  'text',
                                            'default_value'             =>  '',
                                            'sanitize_type'             =>  array('sanitize_title'),
                                            
                                            //callback function when components run. Default being set for _init_{$field_id}
                                            'callback'                  =>  '',
                                            //callback function to return the rewrite code, Default being set for _callback_saved_{$field_id}
                                            'callback_saved'            =>  '',
                                            //PassThrough any additional arguments                                            
                                            'callback_arguments'         =>  array(),
                                            
                                            
                                            //conditional to render html for module component option
                                            'display_conditions'        =>  array(),
                                            
                                            //custom html render content for this module component option
                                            'module_option_html_render' =>  '',
                                            
                                            //custom processing (interface save) for this module component option
                                            'module_option_processing' =>  '',
                                            
                                            //processing order, lower means it will be processed earlier
                                            'processing_order'          =>  10,
                                        );   
                    
                    return $defaults;
                }
            
            
            /**
            * Filter module comonent settings (set-up), by removing splits ( if $strip_splits ), and fill in default values for settings with empty data
            *     
            * @param mixed $module_settings
            * @param mixed $strip_splits
            */
            function filter_settings($module_settings, $strip_splits    =   FALSE)
                {
                    if(!is_array($module_settings)  || count($module_settings) < 1)
                        return $module_settings;
                    
                    $defaults   =   $this->get_module_component_default_setting();
                    
                    foreach($module_settings    as  $key    =>  $module_setting)
                        {
                            if(isset($module_setting['type'])   &&  $module_setting['type'] ==  'split')
                                {
                                    if($strip_splits    === TRUE)
                                        unset($module_settings[$key]);
                                        
                                    continue;
                                }
                            
                            $module_setting   =   wp_parse_args( $module_setting, $defaults );
                            
                            switch($module_setting['input_type'])
                                {
                                    case    'text' :
                                                        $defaults_type   = array (
                                                                                'placeholder'                =>  '',
                                                                            );
                                                        $module_setting   =   wp_parse_args( $module_setting, $defaults_type );
                                                        
                                                        break;   
                                    
                                    
                                }
       
                            $module_settings[$key]  =   $module_setting;
                        }
                    
                    $module_settings    =   array_values($module_settings);
                    
                    return $module_settings;
                    
                }
            
            
            /**
            * Attempt to copy the mu loader within mu-plugins folder
            * 
            */
            static function copy_mu_loader( $force_overwrite    =   FALSE   )
                {
                    
                    //check if mu-plugins folder exists
                    if(! is_dir( WPMU_PLUGIN_DIR ))
                        {
                            if (! wp_mkdir_p( WPMU_PLUGIN_DIR ) )
                                return;
                        }
                    
                    //check if file actually exists already
                    if( !   $force_overwrite    )
                        {
                            if( file_exists(WPMU_PLUGIN_DIR . '/wp-hide-loader.php' ))
                                return;
                        }
                        
                    //attempt to copy the file
                    @copy( WP_PLUGIN_DIR . '/wp-hide-security-enhancer-pro/mu-loader/wp-hide-loader.php', WPMU_PLUGIN_DIR . '/wp-hide-loader.php' );
                }
                
            
            /**
            * Attempt to remove the mu loader
            *     
            */
            static function unlink_mu_loader()
                {
                    //check if file actually exists already
                    if( !file_exists(WPMU_PLUGIN_DIR . '/wp-hide-loader.php' ))
                        return;
                        
                    //attempt to copy the file
                    @unlink ( WPMU_PLUGIN_DIR . '/wp-hide-loader.php' );
                }
                
            
            
            /**
            * Return the wp-config.php path depending on WordPress set-up type
            * Some WordPress installs might have wp-config file outside root directory. one level up
            * 
            */
            static public function get_wp_config_path()
                {
                    if ( file_exists( ABSPATH . 'wp-config.php' ) ) 
                        {
                            return ( ABSPATH . 'wp-config.php' );

                        } 
                    elseif ( @file_exists( dirname( ABSPATH ) . '/wp-config.php' ) && ! @file_exists( dirname( ABSPATH ) . '/wp-settings.php' ) ) 
                        {
                            return ( dirname( ABSPATH ) . '/wp-config.php' );
                        }   
                }
                
                
            /**
            * Check if the required lines exists within wp_config.php
            * 
            * @param mixed $update
            */
            function check_wp_config(  $update    =   TRUE )
                {
                    
                    if ( defined('WPH_WPCONFIG_LOADER') &&  WPH_WPCONFIG_LOADER === TRUE )
                        return TRUE;
                        
                    $existing_data  =   $this->extract_from_markers( $this->get_wp_config_path() , 'WP Hide & Security Enhancer');
                        
                    if (  count( $existing_data )    <   1  ||  count(array_diff($existing_data, $this->get_wp_config_data() )) > 0 )
                        {
                            if ( $update    )
                                {
                                    $this->clean_with_markers( $this->get_wp_config_path(), 'WP Hide & Security Enhancer' );
                                    $args   =   array(
                                                        'marker'            =>  'WP Hide & Security Enhancer',
                                                        'insertion'         =>  $this->get_wp_config_data(),
                                                        'before_marker'     =>  "if ( ! defined( 'ABSPATH' ) ) {",
                                                        'before_offset'     =>  0,
                                                        
                                                        'after_marker'      =>  "<?php"
                                                        );
                                    $status =   $this->insert_with_markers( $this->get_wp_config_path(),    $args );
                                    
                                    return $status;
                                }
                                else
                                return FALSE;
                        }
                        
                    return TRUE;
                    
                }
            
            
            /**
            * Return the data to put o wp-config.php file
            * 
            */
            function get_wp_config_data()
                {
                    $root_path  =   '/';
                    
                    //Check if wp-config.php os actually one leve up relative to wordpress root directory
                    if  ( realpath ( ABSPATH )  !=  realpath ( dirname( $this->get_wp_config_path() ) ) )
                        {
                            $subdirectory   =   str_replace( dirname( $this->get_wp_config_path() ), '' , realpath(ABSPATH . '/') );
                            $subdirectory   =   wp_normalize_path( $subdirectory );
                            $subdirectory   =   ltrim( $subdirectory, '/' );
                            $subdirectory   =   trailingslashit($subdirectory);
                            
                            $root_path      .=  $subdirectory;
                        }
                    
                            
                    $data   =   array(  "define('WPH_WPCONFIG_LOADER',          TRUE);",
                                        "include_once( ( defined('WP_PLUGIN_DIR')    ?     WP_PLUGIN_DIR   .   '/wp-hide-security-enhancer-pro/'    :      ( defined( 'WP_CONTENT_DIR') ? WP_CONTENT_DIR  :   dirname(__FILE__) . '" . $root_path  . "' . 'wp-content' )  . '/plugins/wp-hide-security-enhancer-pro' ) . '/include/wph.class.php');",
                                        'global $wph;',
                                        '$wph    =   new WPH();',
                                        'ob_start( array($wph, \'ob_start_callback\'));'
                                        );
                                        
                    return $data;
                    
                }
                
                
            function settings_changed_check_for_cache_plugins()
                {
                    
                    $active_plugins = (array) get_option( 'active_plugins', array() ); 
                            
                    //cache plugin nottice
                    if(array_search('w3-total-cache/w3-total-cache.php',    $active_plugins)    !== FALSE)  
                        {
                            //check if just flushed
                            if(!isset($_GET['w3tc_note']))
                                echo "<div class='error'><p>". __('W3 Total Cache Plugin is active, make sure you clear the cache for new changes to apply', 'wp-hide-security-enhancer')  ."</p></div>";
                        }
                    if(array_search('wp-super-cache/wp-cache.php',    $active_plugins)    !== FALSE)  
                        {
                            echo "<div class='error'><p>". __('WP Super Cache Plugin is active, make sure you clear the cache for new changes to apply', 'wp-hide-security-enhancer')  ."</p></div>";
                        }
                        
                       if(array_search('wp-fastest-cache/wpFastestCache.php',    $active_plugins)    !== FALSE)  
                        {
                            echo "<div class='error'><p>". __('WP Fastest Cache Plugin is active, make sure you clear the cache for new changes to apply', 'wp-hide-security-enhancer')  ."</p></div>";
                        }    
                    
                }
                
                
            /**
            * Return the module class by it's slug
            * 
            * @param mixed $module_slug
            */
            function get_module_by_slug($module_slug)
                {
                    global $wph;
                    
                    $found_module   =   FALSE;
                    
                    foreach($wph->modules     as  $module)
                        {
                            $interface_menu_data    =   $module->get_module_slug();
                            
                            if($interface_menu_data ==  $module_slug)
                                {
                                    $found_module   =   $module;
                                    break;                            
                                }
                        }
                        
                    return $found_module;
                }
            
            /**
            * Used on early access when WP_Rewrite is not available
            * 
            */
            function is_permalink_enabled()
                {
                    
                    $permalink_structure    =   get_option('permalink_structure');
                    
                    if (    empty($permalink_structure)   )
                        return FALSE;
                        
                    return TRUE;
                        
                }
            
            
            
            /**
            * Return the path to where WordPress index.php reside (WordPress loading point and .htaccess file location)
            * 
            */
            function get_home_path()
                {
                    
                    $home    = set_url_scheme( get_option( 'home' ), 'http' );
                    $siteurl = set_url_scheme( get_option( 'siteurl' ), 'http' );
                    if ( ! empty( $home ) && 0 !== strcasecmp( $home, $siteurl ) ) 
                            {
                                $home_path              =   str_replace( '\\', '/', $_SERVER['DOCUMENT_ROOT'] );
                                $home_path              =   rtrim( $home_path , '/');
                                $home_path              .=  $this->wph->default_variables['site_relative_path'];
                            } 
                        else 
                            {
                                $home_path = ABSPATH;
                            }

                    
                    $home_path      =   trim($home_path, '\\/ ');
                    
                    //not for windows
                    if ( DIRECTORY_SEPARATOR    !=  '\\')
                        $home_path      =   DIRECTORY_SEPARATOR . $home_path;
                    
                    return $home_path;
                       
                }
            
            
            /**
            * Set server type
            * 
            */
            function set_server_type()
                {
                    
                    //Allow to set server type through filter
                    if  ( !  empty ( apply_filters( 'wph/core/set_server_type' , '' ) ) )
                        return;
                    
                    $Server_SOFTWARE    =   $_SERVER['SERVER_SOFTWARE'];
                    
                    If ( empty ( $Server_SOFTWARE ) )
                        {
                            //unable to identify server type
                            return FALSE;   
                        }
                    
                    //Check for Wpengine.. Unfortunate they require all rewrite (Nginx) to be sent to support and they will do the update
                    if (  $this->server_is_wpengine() ) 
                        {
                            $this->wph->server_nginx_config  =   TRUE;
                            return;  
                        }
                        
                    //check for Flywheel hosting
                    if ( stripos( $Server_SOFTWARE, 'Flywheel') !== FALSE )
                        {
                            $this->wph->server_nginx_config  =   TRUE;
                            return;   
                        }
    
                    if ( $this->is_apache()   ===    TRUE )
                        $this->wph->server_htaccess_config  =   TRUE;
                    
                    if ( $this->is_IIS()  === TRUE )
                        $this->wph->server_web_config  =   TRUE;
                        
                    if ( $this->is_nginx()  === TRUE )
                        $this->wph->server_nginx_config  =   TRUE;
                        
                }
                
                
    
            /**
            * Return if the server is WPEngine
            * 
            */
            function server_is_wpengine()
                {
                    if (    getenv('IS_WPE')    ==  "1"   ||  getenv('IS_WPE_SNAPSHOT')    == "1" )
                        return TRUE;
                        
                    return FALSE;
                    
                }
                
            /**
            * Return if the server is Kinsta
            * 
            */
            function server_is_kinsta()
                {
                    if (    getenv('KINSTA_CDN_DOMAIN')   !==  FALSE   ||  getenv('KINSTA_CACHE_ZONE')    !==  FALSE )
                        return TRUE;
                        
                    return FALSE;
                    
                }
            
            
            /**
            * return whatever server using the .htaccess config file
            * 
            */
            function server_use_htaccess_config_file()
                {
                    
                    $home_path      = $this->get_home_path();
                    $htaccess_file  = $home_path . DIRECTORY_SEPARATOR . '.htaccess';
                        
                    if ((!file_exists($htaccess_file) && is_writable($home_path) && $this->using_mod_rewrite_permalinks()) || is_writable($htaccess_file)) 
                        {
                            if ( $this->got_mod_rewrite() )
                                return TRUE;
                        }
                    
                    return FALSE;
                    
                }
            
            
            function using_mod_rewrite_permalinks()
                {
                    
                    return $this->is_permalink_enabled() && ! $this->using_index_permalinks();    
                    
                }
            
            
            function using_index_permalinks() 
                {
                    
                    $permalink_structure    =   get_option('permalink_structure');
                    
                    if(empty($permalink_structure))
                        return;

                    $index  =   'index.php';
                        
                    // If the index is not in the permalink, we're using mod_rewrite.
                    return preg_match( '#^/*' . $index . '#', $permalink_structure );
                    
                }
            
            function got_mod_rewrite()
                {
                    
                    if ($this->apache_mod_loaded('mod_rewrite', true))
                        return TRUE;
                    
                    return FALSE;
                    
                }
            
            
            /**
            * Does the specified module exist in the Apache config?
            *
            * @since 2.5.0
            *
            * @global bool $is_apache
            *
            * @param string $mod     The module, e.g. mod_rewrite.
            * @param bool   $default Optional. The default return value if the module is not found. Default false.
            * @return bool Whether the specified module is loaded.
            */
            function apache_mod_loaded($mod, $default = false) 
                {

                    if ( !$this->is_apache() )
                        return false;
                    
                    if ( function_exists( 'apache_get_modules' ) ) 
                        {
                            $mods = apache_get_modules();
                            if ( in_array($mod, $mods) )
                                return true;
                        } 
                    elseif ( function_exists( 'phpinfo' ) && false === strpos( ini_get( 'disable_functions' ), 'phpinfo' ) ) {
                            ob_start();
                            phpinfo(8);
                            $phpinfo = ob_get_clean();
                            if ( false !== strpos($phpinfo, $mod) )
                                return true;
                    
                    }
                            
                    return $default;
                    
                }
                
            
            /**
            * return whatever the htaccess config file is writable
            *     
            */
            function is_writable_htaccess_config_file()
                {
                    $home_path      = $this->get_home_path();
                    $htaccess_file  = $home_path . DIRECTORY_SEPARATOR . '.htaccess';
                    
                    if ((!file_exists($htaccess_file)  && $this->is_permalink_enabled()) || is_writable($htaccess_file))
                        return TRUE;
                        
                    return FALSE;
                    
                }
                
            /**
            * return whatever server using the .htaccess config file
            * 
            */
            function server_use_web_config_file()
                {
                    
                    $is_iis7    = $this->is_IIS7();
                    
                    $supports_permalinks = false;
                    if ( $is_iis7 ) 
                        {

                            $supports_permalinks = class_exists( 'DOMDocument', false ) && isset($_SERVER['IIS_UrlRewriteModule']) && ( PHP_SAPI == 'cgi-fcgi' );
                        }
                    
                    
                    $supports_permalinks    =   apply_filters( 'iis7_supports_permalinks', $supports_permalinks );
                           
                    return $supports_permalinks;
                    
                }
            
            
            /**
            * return whatever the web.config config file is writable
            *     
            */
            function is_writable_web_config_file()
                {
                    $home_path = $this->get_home_path();
                    
                    $web_config_file = $home_path . 'web.config';
                    
                    if ( ( ! file_exists($web_config_file) && $this->is_permalink_enabled() ) || win_is_writable($web_config_file) )
                        return TRUE;
                        
                    return FALSE;
                    
                }          
            
            
            /**
            * Return if the server run Apache
            * 
            */
            function is_apache()
                {
                    $is_apache  =   FALSE;
                    $is_apache  = (stripos($_SERVER['SERVER_SOFTWARE'], 'Apache') !== false || stripos($_SERVER['SERVER_SOFTWARE'], 'LiteSpeed') !== false);
                    
                    return $is_apache;   
                    
                }
                
            
            /**
            * Return if the server run on nginx
            * 
            */
            function is_nginx()
                {
                    $is_nginx   =   FALSE;
                    $is_nginx   = (stripos($_SERVER['SERVER_SOFTWARE'], 'nginx') !== false);
                    
                    return $is_nginx;   
                    
                }
            
            /**
            * Return if the server run on IIS
            * 
            */
            function is_IIS()
                {
                    $is_IIS     =   FALSE;
                    $is_IIS     =   !$this->is_apache() && (stripos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false || stripos($_SERVER['SERVER_SOFTWARE'], 'ExpressionDevServer') !== false);     
   
                    return $is_IIS;
                    
                }
                
            
            /**
            * Return if the server run on IIS version 7 and up
            *     
            */
            function is_IIS7()
                {
                    $is_iis7    =   FALSE;
                    $is_iis7    =   $this->is_IIS() && intval( substr( $_SERVER['SERVER_SOFTWARE'], stripos( $_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS/' ) + 14 ) ) >= 7;   
                    
                    return $is_iis7;
                }
  
            
            /**
            * Return a write_check_string from server to ensure rewrite rules where applied
            * 
            */
            function get_write_check_string_from_server()
                {
                    $home_path      = $this->get_home_path();
                    
                    global $blog_id;
                    
                    $result =   FALSE;
                                        
                    //check for .htaccess 
                    if ( $this->wph->server_htaccess_config === TRUE ) 
                        {
                            
                            $file_path = $home_path . DIRECTORY_SEPARATOR . '.htaccess';
                            if(file_exists( $file_path ))
                                {
                                    if ( $markerdata = explode( "\n", implode( '', file( $file_path ) ) ));
                                        {
                                            foreach ( $markerdata as $markerline ) 
                                                {
                                                    preg_match("'.*\[E=WPH_REWRITE_".$blog_id.":([0-9-]+_[0-9:]+_[0-9]+).*\]'i", $markerline, $matches);
                                                    if(isset($matches[1]))
                                                        {
                                                            $result =   $matches[1]; 
                                                            break;
                                                        }
                                                }
                                        }
                                }
 
                        }
                    
                    //check for web.config
                    if ( $this->wph->server_web_config   === TRUE )
                        {
                            $file_path  =   $home_path . DIRECTORY_SEPARATOR . 'web.config';
                            if(file_exists( $file_path ))
                                {
                                    if ( $markerdata = explode( "\n", implode( '', file( $file_path ) ) ));
                                        {
                                            foreach ( $markerdata as $markerline ) 
                                                {
                                                    preg_match("'<rule name=\"wph-rewrite-check.*?<!-- WPH_REWRITE_" . $blog_id . ":([0-9-:_]+) --></rule>'si", $markerline, $matches);
                                                    if(isset($matches[1]))
                                                        {
                                                            $result =   $matches[1]; 
                                                        }
                                                        
                                                    if (!isset($matches[1])   &&  strpos($markerline, '<!-- WriteCheckString-" . $blog_id . ":') !== false)
                                                        {
                                                            $result =   trim(str_ireplace( '<!-- WriteCheckString-" . $blog_id . ":',  '', $markerline));
                                                            $result =   trim(str_replace( '-->',  '', $result));
                                                            $result =   trim($result);
                                                            
                                                            break;
                                                        }
                                                }
                                        }   
      
                                }
                                
                        }
                        
                    return $result;    
                    
                }
            
                        
            /**
            * Return a status of custom rewrite rules, if being applied correctly
            * Compare with latest write_check_string within the options and environment (saved to server rewrite file)
            * 
            */
            function rewrite_rules_applied()
                {
                    $applied_correctly = TRUE;
                    
                    if  ( $this->wph->server_nginx_config   === TRUE )
                        return $applied_correctly;    
                    
                    if ( is_multisite() )
                        {
                            $settings           =   $this->get_site_settings ( 'network' );
                                  
                            if ( $settings['allow_every_site_to_change_options']    !=  'yes' )
                                return $applied_correctly;    
                            
                        }
                    
                    $global_settings    =   $this->get_global_settings ( );
                    if  ( $global_settings['self_setup']  ==  'yes' )
                        return $applied_correctly;
                    
                    global $blog_id;
                    
                    $site_settings      =   $this->get_site_settings( $blog_id );
                    $write_check_string =   isset ( $site_settings['write_check_string'] ) ? $site_settings['write_check_string']   :   '';
                    
                    if(!empty($write_check_string))
                        {
                            $existing_write_check_string =   $this->get_write_check_string_from_server();
                            if(empty($existing_write_check_string)  ||  $existing_write_check_string    !=  $write_check_string)
                                $applied_correctly   =   FALSE;
                        }
                                   
                    return $applied_correctly;
                }
            
            
            
            /**
            * Return rewrite base
            *
            */
            function get_rewrite_base( $saved_field_data, $left_slash   =   TRUE, $right_slash  =   TRUE, $append_path =   '' )
                {
                    global $blog_id;
                    
                    $saved_field_data   =   $this->untrailingslashit_all($saved_field_data);
                    
                    $path               =   '';
                    switch($append_path)
                        {
                            case 'site_path'    :
                                                    $path               =   !empty($this->wph->default_variables['site_relative_path']) ? trailingslashit( $this->wph->default_variables['site_relative_path'] )  :   '';
                                                    break;
                            
                            case 'wp_path'    :
                                                    $path              .=   !empty($this->wph->default_variables['wordpress_directory']) ? trailingslashit( $this->wph->default_variables['wordpress_directory'] )  :   '';
                                                    break;
                            case 'full_path'    :
                                                    $path               =   !empty($this->wph->default_variables['site_relative_path']) ? trailingslashit( $this->wph->default_variables['site_relative_path'] )  :   '';
                                                    $path              .=   !empty($this->wph->default_variables['wordpress_directory']) ? trailingslashit( $this->wph->default_variables['wordpress_directory'] )  :   '';
                                                    break;                        
                        }
                        
                    if ( is_multisite() )
                        {                            
                            $ms_settings    =   $this->wph->functions->get_site_settings('network');
                            
                            $use_blog_id    =   $blog_id;
                            if ($ms_settings['allow_every_site_to_change_options']  ==  'no')
                                $use_blog_id    =   1;
                            
                            $blog_details = get_blog_details( $use_blog_id );
                            
                            $path   .=   ltrim($blog_details->path, '/') . '/';                                
                        }
                    
                    $rewrite_base   =   !empty($path) ? trailingslashit( $path ) . $saved_field_data : ( !empty($saved_field_data) ?  '/' .$saved_field_data : '' );
                    if( !empty($rewrite_base))
                        {
                            $rewrite_base   =   $this->untrailingslashit_all( $rewrite_base );
                            
                            if( $left_slash === TRUE )
                                $rewrite_base   =   '/' .   $rewrite_base;    
                                
                            if( $right_slash === TRUE )
                                $rewrite_base   =   $rewrite_base . '/';
                            
                        }
                    
                    return $rewrite_base;
                    
                }
                
            /**
            * Return rewrite to base
            *
            */
            function get_rewrite_to_base( $field_data, $left_slash   =   TRUE, $right_slash  =   TRUE, $append_path =   '')
                {

                    
                    $field_data         =   $this->untrailingslashit_all( $field_data );
                    
                    $path               =   '';
                    switch($append_path)
                        {
                            case 'site_path'    :
                                                    $path               =   !empty($this->wph->default_variables['site_relative_path']) ? trailingslashit( $this->wph->default_variables['site_relative_path'] )  :   '';
                                                    break;
                            
                            case 'wp_path'    :
                                                    $path              .=   !empty($this->wph->default_variables['wordpress_directory']) ? trailingslashit( $this->wph->default_variables['wordpress_directory'] )  :   '';
                                                    break;
                            case 'full_path'    :
                                                    $path               =   !empty($this->wph->default_variables['site_relative_path']) ? trailingslashit( $this->wph->default_variables['site_relative_path'] )  :   '';
                                                    $path              .=   !empty($this->wph->default_variables['wordpress_directory']) ? trailingslashit( $this->wph->default_variables['wordpress_directory'] )  :   '';
                                                    break;                        
                        }
                    
                    $rewrite_to_base    =   !empty($path) ? trailingslashit( $path ) . $field_data : ( !empty( $field_data ) ?  '/' . $field_data : '' );
                    if( !empty($rewrite_to_base))
                        {
                            $rewrite_to_base   =   $this->untrailingslashit_all( $rewrite_to_base );
                            
                            if( $left_slash === TRUE )
                                $rewrite_to_base   =   '/' .   $rewrite_to_base;    
                                
                            if( $right_slash === TRUE )
                                $rewrite_to_base   =   $rewrite_to_base . '/';
                            
                        }
                    
                    return $rewrite_to_base;
                    
                }
            
            
            /**
            * Insert the data using markes in a specified file
            * 
            * @param mixed $filename
            * @param mixed $marker
            * @param mixed $insertion
            * @param mixed $before_marker
            * @return mixed
            */
            function insert_with_markers ( $filename, $args )
                {
                    
                    $defaults   = array (
                                            'marker'            =>  '',
                                            
                                            'insertion'         =>  '',
                                            
                                            'before_marker'     =>  '',
                                            'before_offset'     =>  0,
                                            
                                            'after_marker'      =>  ''
                                        );
                                        
                    // Parse incoming $args into an array and merge it with $defaults
                    $args   =   wp_parse_args( $args, $defaults );
                    extract($args);
                       
                    if ( ! file_exists( $filename ) ) {
                        if ( ! is_writable( dirname( $filename ) ) ) {
                            return false;
                        }
                        if ( ! touch( $filename ) ) {
                            return false;
                        }
                    } elseif ( ! is_writeable( $filename ) ) {
                        return false;
                    }

                    if ( ! is_array( $insertion ) ) {
                        $insertion = explode( "\n", $insertion );
                    }

                    $start_marker = "# BEGIN {$marker}";
                    $end_marker   = "# END {$marker}";

                    $fp = fopen( $filename, 'r+' );
                    if ( ! $fp ) {
                        return false;
                    }

                    // Attempt to get a lock. If the filesystem supports locking, this will block until the lock is acquired.
                    flock( $fp, LOCK_EX );

                    $lines = array();
                    while ( ! feof( $fp ) ) {
                        $lines[] = rtrim( fgets( $fp ), "\r\n" );
                    }

                    // Split out the existing file into the preceding lines, and those that appear after the marker
                    $pre_lines = $post_lines = $existing_lines = array();
                    $found_marker = $found_end_marker = false;
                    foreach ( $lines as $line ) {
                        if ( ! $found_marker && false !== strpos( $line, $start_marker ) ) {
                            $found_marker = true;
                            continue;
                        } elseif ( ! $found_end_marker && false !== strpos( $line, $end_marker ) ) {
                            $found_end_marker = true;
                            continue;
                        }
                        if ( ! $found_marker ) {
                            $pre_lines[] = $line;
                        } elseif ( $found_marker && $found_end_marker ) {
                            $post_lines[] = $line;
                        } else {
                            $existing_lines[] = $line;
                        }
                    }

                    // Check to see if there was a change
                    if ( $existing_lines === $insertion ) {
                        flock( $fp, LOCK_UN );
                        fclose( $fp );

                        return true;
                    }

                    
                    // Generate the new file data
                    if($found_marker && $found_end_marker)
                        {
                            $new_file_data = implode( "\n", array_merge(
                                $pre_lines,
                                array( $start_marker ),
                                $insertion,
                                array( $end_marker ),
                                $post_lines
                            ) );
                        }
                        else
                        {
                            $insert_at  =   FALSE;                            
                            if  ( ! empty ( $before_marker ) )
                                {
                                    $insert_at  =   array_search($before_marker, array_map("trim", $pre_lines) );
                                }
                            
                            if  ( $insert_at    === FALSE  &&  ! empty ( $after_marker ) )
                                {
                                    $insert_at  =   array_search($after_marker , array_map("trim", $pre_lines) );
                                    $insert_at++;
                                }
                                
                            if  ( $insert_at  ===   FALSE )
                                $insert_at  =   0;

                            $pre_lines  =   array_merge( 
                                                            array_slice( $pre_lines, 0, $insert_at, TRUE),
                                                            array( $start_marker ),
                                                            $insertion,
                                                            array( $end_marker ),
                                                            array_slice( $pre_lines, $insert_at, count($pre_lines), TRUE)
                                                            );
                                
                            $new_file_data = implode( "\n", $pre_lines );        
                            
                        }

                    // Write to the start of the file, and truncate it to that length
                    fseek( $fp, 0 );
                    $bytes = fwrite( $fp, $new_file_data );
                    if ( $bytes ) {
                        ftruncate( $fp, ftell( $fp ) );
                    }
                    fflush( $fp );
                    flock( $fp, LOCK_UN );
                    fclose( $fp );

                    return (bool) $bytes;    
                    
                    
                }
            
            
            function extract_from_markers( $filename, $marker ) 
                {
                    $result = array ();

                    if ( ! file_exists( $filename ) ) 
                        {
                            return $result;
                        }

                    $markerdata = explode( "\n", implode( '', file( $filename ) ) );

                    $state = false;
                    foreach ( $markerdata as $markerline ) 
                        {
                            if ( false !== strpos( $markerline, '# END ' . $marker ) ) 
                                {
                                    $state = false;
                                }
                            if ( $state ) 
                                {
                                    $result[] = $markerline;
                                }
                            if ( false !== strpos( $markerline, '# BEGIN ' . $marker ) ) 
                                {
                                    $state = true;
                                }
                        }

                    return $result;
                } 
            
            static public function clean_with_markers( $filename, $marker)
                {
                    
                    if ( ! file_exists( $filename ) ) {
                        if ( ! is_writable( dirname( $filename ) ) ) {
                            return false;
                        }
                        if ( ! touch( $filename ) ) {
                            return false;
                        }
                    } elseif ( ! is_writeable( $filename ) ) {
                        return false;
                    }
              
                    $start_marker = "# BEGIN {$marker}";
                    $end_marker   = "# END {$marker}";

                    $fp = fopen( $filename, 'r+' );
                    if ( ! $fp ) {
                        return false;
                    }

                    // Attempt to get a lock. If the filesystem supports locking, this will block until the lock is acquired.
                    flock( $fp, LOCK_EX );

                    $lines = array();
                    while ( ! feof( $fp ) ) {
                        $lines[] = rtrim( fgets( $fp ), "\r\n" );
                    }

                    // Split out the existing file into the preceding lines, and those that appear after the marker
                    $pre_lines = $post_lines = $existing_lines = array();
                    $found_marker = $found_end_marker = false;
                    foreach ( $lines as $line ) {
                        if ( ! $found_marker && false !== strpos( $line, $start_marker ) ) {
                            $found_marker = true;
                            continue;
                        } elseif ( ! $found_end_marker && false !== strpos( $line, $end_marker ) ) {
                            $found_end_marker = true;
                            continue;
                        }
                        if ( ! $found_marker ) {
                            $pre_lines[] = $line;
                        } elseif ( $found_marker && $found_end_marker ) {
                            $post_lines[] = $line;
                        } else {
                            $existing_lines[] = $line;
                        }
                    }
                         
                    // Generate the new file data
                    if($found_marker && $found_end_marker)
                        {
                            $new_file_data = implode( "\n", array_merge(
                                $pre_lines,
                                $post_lines
                            ) );
                            
                            // Write to the start of the file, and truncate it to that length
                            fseek( $fp, 0 );
                            $bytes = fwrite( $fp, $new_file_data );
                            if ( $bytes ) {
                                ftruncate( $fp, ftell( $fp ) );
                            }
                            fflush( $fp );
                            flock( $fp, LOCK_UN );
                            fclose( $fp );

                            return (bool) $bytes; 
                            
                        }
                
                    return FALSE;   
                    
                    
                }
            
            
            
            /**
            * Left trim string from a list of array
            * 
            */
            function ltrim_array( $string, $strip = array())
                {
                    if ( ! is_array($strip) ||  count( $strip ) <   1   )
                        return $string;
                    
                    foreach ( $strip    as $strip_string )
                        {    
                            if( 0 === strpos($string, $strip_string))
                                {
                                    $string = substr($string, strlen($strip_string));
                                }
                        }
                       
                    return $string;
                    
                }
            
            
            
            /**
            * Check if the plugin started through MU plugin loader
            * 
            */
            function is_muloader()
                {
                    
                    if (defined('WPH_MULOADER'))
                        return TRUE;

                    return FALSE;
                       
                }
            
                
            /**
            * 
            * Check if theme is is customize mode
            *     
            */
            function is_theme_customize()
                {
                    
                    if (    strpos($_SERVER['REQUEST_URI'] ,'customize.php')   !== FALSE    )
                        return TRUE;
                        
                    if (    isset($_POST['wp_customize'])  && sanitize_text_field($_POST['wp_customize'])   ==  "on" )   
                        return TRUE;        
                    
                    return FALSE;
                    
                }
                
            
            /**
            * Return Settings for specified / curren site
            * 
            * @param mixed $blog_id_settings
            * @param mixed $force_reload
            */
            private function _get_settings( $blog_id_settings  )
                {
                    
                    global $blog_id;
                             
                    if (  is_multisite()    &&  $blog_id_settings   >   0 )
                        switch_to_blog( $blog_id_settings );
                    
                            
                    if ( $blog_id_settings ==  'network')
                        {
                            $network_settings   =   get_site_option('wph_settings');
                    
                            $defaults   = array (
                                                    'module_settings'   =>  array()
                                                );
                            
                            if (  is_multisite() &&  is_network_admin() )
                                {
                                    $defaults   = array (
                                                    'allow_every_site_to_change_options'    =>  'no'
                                                );
                                }
                            
                            $settings   =   wp_parse_args( $network_settings, $defaults ); 
                            
                            //if WPEngine force 'nginx_generate_simple_rewrite'
                            if ( $this->server_is_wpengine()    ||  $this->server_is_kinsta() )
                                {
                                    $settings['allow_every_site_to_change_options']     =   'no';
                                }
                                   
                        }
                        else
                        {
                            $settings   =   get_option('wph_settings');   
                        }
                        
                        
                        
                    //ensure the settings are filled in with defaults if not exists in array
                    $_do_update_settings =   FALSE;
                    if( !isset($settings['module_settings'] ) )
                        {
                            $settings['module_settings']  =   array();    
                            $_do_update_settings    =   TRUE;
                        }
                        
                    //make sure all options exists within modules settings
                    foreach($this->wph->modules   as  $module)
                        {
                            $module_components    =   $this->filter_settings(   $module->get_module_components_settings(), TRUE    );
                            
                            foreach($module_components as $module_component)
                                {
                                    $default_value  =   $module_component['default_value'];
                                    
                                    if(!isset( $settings['module_settings'][ $module_component['id'] ]))
                                        {
                                            $settings['module_settings'][ $module_component['id'] ]   =   $default_value;
                                            $_do_update_settings    =   TRUE;
                                        }
                                }
                        }   
                    
        
                    $settings   =   apply_filters('wp-hide/get_settings', $settings, $blog_id_settings);
                    
                    if($_do_update_settings)
                        $this->update_site_settings( $settings, $blog_id_settings );
                    
                                        
                    //hold the settings within main class for further usage
                    $this->wph->settings[ $blog_id_settings ]    =   $settings;
            
                        
                    if ( is_multisite()    &&  $blog_id_settings   >   0 )
                        restore_current_blog();
                                        
                    return $settings;
                                       
                }
            
            
            /**
            * Ensure settings include all loaded components
            * This is being called after components where loaded
            * 
            */
            function fill_settings()
                {
                    global $blog_id;
                    
                    unset ( $this->wph->settings[ $blog_id ] ) ;
                    
                    $this->_get_settings( $blog_id );
                    
                }
            
            
            /**
            * Return current $blog_id settings
            * 
            */
            function get_current_site_settings ( )
                {
                    
                    global $blog_id;
                    
                    if ( is_multisite() &&  is_network_admin()    &&  ! isset( $this->wph->settings['network'] ))
                        {
                            $settings   =   $this->_get_settings( 'network' );   
                        }
                        else if ( is_multisite() &&  is_network_admin()    &&  isset( $this->wph->settings['network'] ) )
                            {
                                $settings   =   $this->wph->settings['network'];
                            }
                        else if ( ! isset( $this->wph->settings[$blog_id] ) )
                            $settings   =   $this->_get_settings( $blog_id );
                        else
                            $settings   =   $this->wph->settings[$blog_id];    
                    
                    return $settings;
                    
                }
                
            
            /**
            * Return $blog_id settings
            * Use stored settings data set instead self::get_settings()
            * 
            */
            function get_site_settings ( $blog_id )
                {
                                        
                    if ( ! isset( $this->wph->settings[$blog_id] ) )
                        $settings   =   $this->_get_settings( $blog_id );
                        else
                        $settings   =   $this->wph->settings[$blog_id];    
                    
                    return $settings;
                    
                }
                
                
            /**
            * Return th global settings which will be used across any sites
            * 
            */
            function get_global_settings()
                {
                                        
                    $settings   =   get_site_option('wph_global_settings');
                    
                    $defaults   = array (
                                            'self_setup'                            =>  'no',
                                            'nginx_generate_simple_rewrite'         =>  'yes'
                                        );
                    
                    $settings   =   wp_parse_args( $settings, $defaults );
                    
                    //if WPEngine force 'nginx_generate_simple_rewrite'
                    if ( $this->server_is_wpengine()    ||  $this->server_is_kinsta() )
                        {
                            $settings['nginx_generate_simple_rewrite']          =   'yes';
                        }
                    
                    $settings   =   apply_filters('wp-hide/get_global_settings', $settings);
                    
                    return $settings;
                    
                }
                
                
            /**
            * Update global settings
            * 
            */
            function update_global_settings( $settings )
                {
                                        
                    update_site_option('wph_global_settings', $settings);
                    
                }
                
                
            
            /**
            * Return $blog_id settings to apply
            * NOT TO BE USED FOR INTERFACE -> this output the latest options list
            * 
            * This options list is corelated with saved rewrite rules
            */
            function get_site_modules_settings_to_apply ( $blog_id )
                {
                    
                    if ( $blog_id   ==   'network' )
                        {
                            $wph_rewrite_manual_install =   get_site_option('wph-rewrite-manual-install');
                            if ( empty ($wph_rewrite_manual_install) )
                                {
                                    $settings   =   $this->get_site_modules_settings( $blog_id );    
                                }
                                else
                                {
                                    $settings   =   get_site_option('wph-previous-options-list');
                                }   
                            
                        }
                        else
                        {
                            $wph_rewrite_manual_install =   get_option('wph-rewrite-manual-install');
                            if ( empty ($wph_rewrite_manual_install) )
                                {
                                    $settings   =   $this->get_site_modules_settings( $blog_id );    
                                }
                                else
                                {
                                    //use previous saved setings
                                    if ( is_multisite() )
                                        switch_to_blog( $blog_id );   
                                    
                                    $wph_previous_options_list  =   get_option('wph-previous-options-list');
                                    if ( ! is_array($wph_previous_options_list))
                                        $wph_previous_options_list  =   array();
                                    
                                    if ( is_multisite() )    
                                        restore_current_blog();                            
                                    
                                    $settings   =   $wph_previous_options_list;
                                }
                        }
                    
                    return $settings;
                    
                }
            
                   
            
            /**
            * Return modules setings for current site
            * 
            * @param mixed $blog_id
            */
            function get_site_modules_settings( $blog_id_settings )
                {
                    
                    if ( isset( $this->wph->settings[ $blog_id_settings ] ) )
                        $settings       =   $this->wph->settings[ $blog_id_settings ];
                        else
                        $settings       =   $this->_get_settings( $blog_id_settings );
                        
                    $modules_settings       =   $settings['module_settings'];
                    
                    return $modules_settings;
                    
                }
            
            
            /**
            * Return a Module Item value setting
            * 
            * If $context is 'display' then it returns the current saved value
            * 
            * @param mixed $item_id
            */
            function get_site_module_saved_value( $option_id, $blog_id_settings =   '', $context = '' )
                {
                    
                    if ( empty( $blog_id_settings ) )
                        {
                            global $blog_id;
                            
                            $blog_id_settings   =   $blog_id;
                        }
                    
                    if ( $context   ==   'display' )
                        $modules_settings   =   $this->get_site_modules_settings( $blog_id_settings );
                        else
                        $modules_settings   =   $this->get_site_modules_settings_to_apply( $blog_id_settings );
                        
                    
                    $value      =   isset($modules_settings[ $option_id ])  ?   $modules_settings[ $option_id] :   '';
                    
                    $value      =   apply_filters( 'wp-hide/get_site_module_saved_value', $value, $option_id );
                    
                    return $value;
                    
                }
                   
        
            
            /**
            * Update the settings for the given $blog_id
            * 
            * @param mixed $settings
            * @param mixed $blog_id_settings
            * @param mixed $update_class_settings
            */
            function update_site_settings( $settings, $blog_id_settings, $update_class_settings =   TRUE )
                {
          
                    if (  $blog_id_settings ==  'network' )
                        {
                            update_site_option('wph_settings', $settings);
                        }
                        else
                        {
                            if ( is_multisite() )
                                switch_to_blog( $blog_id_settings );
                                
                            update_option('wph_settings', $settings); 
                            
                            if ( is_multisite() )
                                restore_current_blog();   
                        }
                        
                    if  (   $update_class_settings  === TRUE )
                        $this->wph->settings[ $blog_id_settings ]   =   $settings;
                    
                }
                
                
            
            /**
            * Update the modules settings for current blog_id
            * 
            * @param mixed $modules_settings
            */
            function update_site_modules_settings( $modules_settings, $blog_id_settings, $update_class_settings =   TRUE )
                {
                        
                    $settings   =   $this->wph->settings[ $blog_id_settings ];
                    
                    $settings['module_settings']    =   $modules_settings;
                    
                    $this->update_site_settings( $settings, $blog_id_settings );
                    
                    if  (   $update_class_settings  === TRUE )
                        $this->wph->settings[ $blog_id_settings ]   =   $settings;
                    
                }
                
            
            
            /**
            * return a hash of current site settings
            * 
            */
            function get_current_site_settings_hash()
                {
                    
                    $settings   =   $this->get_current_site_settings ();
                    
                    //return md5 ( json_encode( $settings['module_settings'] ) );
                    return hash( 'crc32', json_encode( $settings['module_settings'] ), FALSE );
                    
                }
                
            
            /**
            * Return the blog id or network if superadmin dashboard
            * 
            */
            function get_blog_id()
                {
                    global $blog_id;
                    
                    $blog_id_settings   =   '';
                       
                    if ( is_multisite() &&  is_network_admin() )
                        $blog_id_settings   =   'network';
                        else
                        $blog_id_settings   =   $blog_id;      
                    
                    return $blog_id_settings;
                    
                }
                
            
            /**
            * Return the blog_id or network as blog_id, to be used to retrieve the settings.
            * This always return $blog_id when Single Site
            * 
            * If MultiSite and 'allow_every_site_to_change_options' is NO it return 'network' which held the settings to be used across all sites 
            *     
            */
            function get_blog_id_setting_to_use()
                {
                    
                    global $blog_id; 
                    
                    if(is_multisite() )
                        {
                            $ms_settings    =   $this->get_site_settings('network');
                            if ( $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                return $blog_id;
                                else
                                return 'network';
                        }
                        else
                            return $blog_id;
                        
                }
                
            
            /**
            * Get path from url relative to domain root
            *     
            * @param mixed $url
            * @param mixed $is_file_path
            * @param mixed $relative_to_wordpress_directory
            */    
            function get_url_path($url, $is_file_path   =   FALSE, $relative_to_wordpress_directory    =   FALSE)
                {
                    if(!$is_file_path)
                        $url            =   trailingslashit(    $url    );
                        
                    $url_parse      =   parse_url(  $url   );
                           
                    $path           =   $url_parse['path'];
                    if( $relative_to_wordpress_directory   === TRUE &&  $this->wph->default_variables['wordpress_directory']    !=  '/') 
                        {
                            $path   =   $this->string_left_replacement( $path , trailingslashit ( $this->wph->default_variables['wordpress_directory'] )) ;
                        }
                    
                    if(!$is_file_path)
                        $path           =   trailingslashit(    $path   );
                    
                    if($path    !=  '/' && strlen($path) > 1)
                        {
                            $path   =   ltrim($path, '/');
                            $path   =   '/' .   $path;
                        }
                    
                    if(isset($url_parse['query']))
                        $path   .=  '?' .   $url_parse['query'];
                    
                    $path   =   str_replace( '\\', '/', $path);
                    
                    return $path;
                    
                }
                
            
            /**
            * return the url relative to domain root
            * 
            * @param mixed $url
            */
            function get_url_path_relative_to_domain_root($url)
                {
                    
                    $url    =   str_replace(trailingslashit(  home_url()  ), "" , $url);
                       
                    return $url;
                    
                }
                
                
            /**
            * Replace all slashes from begining and the end of string
            * 
            * @param mixed $value
            */
            function untrailingslashit_all($value)
                {
                    $value  =   ltrim(rtrim($value, "/"),  "/");
                    
                    return $value;
                }    
            
            
            
            /**
            * Replace a prefix from the beginning of a text
            *     
            * @param mixed $string
            * @param mixed $prefix
            */
            function string_left_replacement($string, $prefix)    
                {
                    if (substr($string, 0, strlen($prefix)) == $prefix) 
                        {
                            $string = (string) substr($string, strlen($prefix));
                        }
                        
                    return $string;
                        
                }
            
            
            /**
            * saniteize including a possible extension
            * 
            * @param mixed $value
            */    
            function sanitize_file_path_name($value)
                {
                    $value  =   trim($value);
                    
                    if(empty($value))
                        return $value;
                    
                    //check for any extension
                    $pathinfo   =   pathinfo($value);
                    
                    $dirname    =   (!empty($pathinfo['dirname'])    &&  $pathinfo['dirname']    !=  '.')  ?    $pathinfo['dirname']    :   '';
                    $path       =   !empty($dirname)    ?   trailingslashit($dirname)   .   $pathinfo['filename']   :   $pathinfo['filename'];   
                    
                    $parts  =   explode("/",    $path);
                    $parts  =   array_filter($parts);
                    
                    foreach($parts  as  $key    =>  $part_item)
                        {
                            $parts[$key]    =   sanitize_title($part_item);
                        }
                        
                    $value  =   implode("/", $parts);
                    
                    $value  .=   !empty($pathinfo['extension']) ?   '.' . $pathinfo['extension'] :   '';  
                    
                    $value  =   strtolower($value);
                    
                    return $value;
                }
            
            
            
            /**
            * make sure there's a php extension included within the slug
            * 
            * @param mixed $value
            * @return mixed
            */
            function extension_required($value, $extension)
                {
                    $value  =   trim($value);
                    
                    if($value   ==  '')
                        return '';
                    
                    $file_extension  =   substr($value, -4);
                    if(strtolower( $file_extension )   !=  '.' . $extension )
                        $value  .=  '.' . $extension;    
                                        
                    return $value;
                }
                
            
            /**
            * Return current url
            *     
            */    
            function get_current_url()
                {
                    
                    $current_url    =   'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    
                    return  $current_url;
                                        
                }
                
            
            /**
            * Add replacement withint the list
            * 
            * @param mixed $old_url
            * @param mixed $new_url
            */
            function add_replacement($old_url, $new_url, $priority  =   'normal')
                {
                
                    if($this->replacement_exists($old_url))
                        return;
                        
                    $this->wph->urls_replacement[ $priority ][ $old_url ]  =   $new_url;   
                    
                }
                
            
            /**
            * Return whatever a replacement exists or not
            * The old url should be provided
            *     
            * @param mixed $old_url
            */
            function replacement_exists($old_url)
                {
                    
                    if(count($this->wph->urls_replacement)  <   1)
                        return FALSE;
                    
                    foreach($this->wph->urls_replacement    as  $priority   =>  $replacements_block)
                        {
                            if(isset($this->wph->urls_replacement[$priority][ $old_url ]))
                                return TRUE;
                        }
                        
                    return FALSE;
                                        
                }
                
                
            
            /**
            * Return a list of replacements
            * 
            */
            function get_replacement_list()
                {
                    
                    $replacements   =   array();
                    
                    if(count($this->wph->urls_replacement)  <   1)
                        return $replacements;
                    
                    foreach($this->wph->urls_replacement    as  $priority   =>  $replacements_block)
                        {
                            if(!is_array($replacements_block)   ||  count($replacements_block) < 1)
                                continue;
                            
                            foreach($replacements_block as  $old_url   =>  $new_url)
                                {
                                    $replacements[ $old_url ] =   $new_url;
                                }
                        }
                        
                    return $replacements;   
                    
                }
            
            
            /**
            * Add a preserved link
            * 
            * @param mixed $preserve_slug
            * @param mixed $new_url
            */
            function add_preserved_url($preserve_slug, $new_url)
                {
                    
                    $this->wph->url_preserve[ $preserve_slug ]  =   $new_url;   
                    
                }
                
            /**
            * Return the prserved links
            * 
            * @param mixed $preserve_slug
            * @param mixed $new_url
            */
            function get_preserved_list()
                {
                    
                    return $this->wph->url_preserve;  
                    
                }
            
            
            /**
            * Preserve Texts between     <!-- WPH Preserve - Start -->       and      <!-- WPH Preserve - Stop -->
            * 
            */
            function text_preserve( $buffer )
                {
                    
                    preg_match_all("'<!-- WPH Preserve - Start -->(.*?)<!-- WPH Preserve - Stop -->'si", $buffer, $matches);
                    
                    if ( $matches === FALSE )
                        return $buffer;
                    
                    foreach ( $matches[1]  as  $key =>  $match )
                        {
                            $hash   =   '%WPH-PLACEHOLDER-PRESERVE-' . md5($match);
                            $this->wph->text_preserve[ $hash ]    =   $match;
                            
                            $buffer =   str_ireplace($matches[0][$key], $hash, $buffer);
                        }
                        
                    return $buffer;
                    
                }
            
            
            /**
            * Restore any preserved texts
            * 
            * @param mixed $buffer
            */
            function text_preserve_restore( $buffer )
                {
                    
                    if ( count ( $this->wph->text_preserve ) < 1 )
                        return $buffer;
                    
                    foreach ( $this->wph->text_preserve as  $hash   =>  $text )
                        {
                            $buffer =   str_ireplace($hash, $text, $buffer);      
                        }
                    
                    return $buffer;
                    
                }
            
            
            /**
            * Replace the urls within given content
            * 
            * @param mixed $text
            * @param mixed $replacements
            */
            function content_urls_replacement($text, $replacements)
                {
                    //process the replacements
                    if( count($replacements)  <   1)
                        return $text;
                        
                    if  ( is_object( $text ) )
                        return $text;
                    
                    //exclude scheme to match urls without it
                    $_replacements                      =   array();
                    //no protocol
                    $_replacements_np                   =   array();
                    
                    //single quote ; double quote
                    $_relative_url_replacements_sq      =   array();
                    $_relative_url_replacements_dq      =   array();
                    
                    //single quote ; double quote / domain url / domain ssl
                    $_relative_domain_url_replacements_sq  =   array();
                    $_relative_domain_url_replacements_dq  =   array();
                    //$_relative_domain_url_replacements_ssl_sq  =   array();
                    //$_relative_domain_url_replacements_ssl_dq  =   array();
                    
                    $home_url           =   home_url();
                    $home_url_parsed    =   parse_url($home_url);
                    $domain_url         =   'http://' . $home_url_parsed['host'];
                    $domain_url_ssl     =   'https://' . $home_url_parsed['host'];
                    
                    /**
                    * 
                    * CDN
                    * 
                    */
                    $global_settings    =   $this->get_global_settings ( );
                    
                    $CDN_url    =   $this->get_site_module_saved_value('cdn_url',  $this->get_blog_id_setting_to_use());
                    if  ( ! empty ( $CDN_url ) )
                        {
                            foreach($replacements   as $old_url =>  $new_url)
                                {
                                    $replacements[ str_replace($home_url_parsed['host'], $CDN_url, $old_url) ]  =   str_replace($home_url_parsed['host'], $CDN_url, $new_url);
                                }
                        }
                    
                    /**
                    * Preserve absolute paths
                    * 
                    */
                    $text   =   str_ireplace( ABSPATH, '%WPH-PLACEHOLDER-PRESERVE-ABSPATH%', $text);
                    //jsonencoded
                    $text   =   str_ireplace( trim(json_encode(ABSPATH), '"'), '%WPH-PLACEHOLDER-PRESERVE-JSON-ABSPATH%', $text);
                    //urlencode
                    $text   =   str_ireplace( trim(urlencode(ABSPATH), '"'), '%WPH-PLACEHOLDER-PRESERVE-URLENCODE-ABSPATH%', $text);
                    
                    foreach($replacements   as $old_url =>  $new_url)
                        {
                            //add quote to make sure it's actualy a link value and is right at the start of text
                            $_relative_url_replacements_dq[ '"' . str_ireplace(   $home_url,   "", $old_url)   ] =   '"' . str_ireplace(   $home_url,   "", $new_url);
                            $_relative_url_replacements_sq[ "'" . str_ireplace(   $home_url,   "", $old_url)   ] =   "'" . str_ireplace(   $home_url,   "", $new_url);
                            
                            $_relative_domain_url_replacements_dq[ '"' . str_ireplace(   array( $domain_url, $domain_url_ssl ),   "", $old_url)   ] =   '"' . str_ireplace(   array( $domain_url, $domain_url_ssl ),   "", $new_url);
                            $_relative_domain_url_replacements_sq[ "'" . str_ireplace(   array( $domain_url, $domain_url_ssl ),   "", $old_url)   ] =   "'" . str_ireplace(   array( $domain_url, $domain_url_ssl ),   "", $new_url);
                            //$_relative_domain_url_replacements_ssl_dq[ '"' . str_ireplace(   $domain_url_ssl,   "", $old_url)   ] =   '"' . str_ireplace(   $domain_url_ssl,   "", $new_url);
                            //$_relative_domain_url_replacements_ssl_sq[ "'" . str_ireplace(   $domain_url_ssl,   "", $old_url)   ] =   "'" . str_ireplace(   $domain_url_ssl,   "", $new_url);
                            
                            //match urls without protocol
                            $_old_url    =   str_ireplace(   array('http:', 'https:'),   "", $old_url);
                            $_new_url    =   str_ireplace(   array('http:', 'https:'),   "", $new_url);
                            
                            $_replacements_np[$_old_url]    =   $_new_url;
                            
                            $_old_url    =   str_ireplace(   array('http://', 'https://'),   "", $old_url);
                            $_new_url    =   str_ireplace(   array('http://', 'https://'),   "", $new_url);
                            
                            $_replacements[$_old_url]    =   $_new_url;
                        }
                    
                    
                    /**
                    * Main replaments
                    * 
                    * @var mixed
                    */
                    $text =   str_ireplace(    array_keys($_replacements_np), array_values($_replacements_np)  ,$text   );
                    //$text =   str_ireplace(    array_keys($_replacements), array_values($_replacements)  ,$text   );
                    
                    
                    /**
                    * Relative tp domain urls replacements;  using subfolder e.g. 127.0.0.1/wp01/wordpress_site, this will be /wp01/wordpress_site
                    * 
                    * @var mixed
                    */
                    $text =   str_ireplace(    array_keys($_relative_domain_url_replacements_sq), array_values($_relative_domain_url_replacements_sq)  ,$text   );
                    $text =   str_ireplace(    array_keys($_relative_domain_url_replacements_dq), array_values($_relative_domain_url_replacements_dq)  ,$text   );
                    //$text =   str_ireplace(    array_keys($_relative_domain_url_replacements_ssl_sq), array_values($_relative_domain_url_replacements_ssl_sq)  ,$text   );
                    //$text =   str_ireplace(    array_keys($_relative_domain_url_replacements_ssl_dq), array_values($_relative_domain_url_replacements_ssl_dq)  ,$text   );
                    
                    
                    /**
                    * Relative urls replacements
                    * @var mixed
                    */
                    //single quote
                    $text =   str_ireplace(    array_keys($_relative_url_replacements_sq), array_values($_relative_url_replacements_sq)  ,$text   );
                    $text =   str_ireplace(    array_keys($_relative_url_replacements_dq), array_values($_relative_url_replacements_dq)  ,$text   );
                    
                    
                    $home_url_protocol_strip    =   str_ireplace(   array('http://', 'https://'),   "", $home_url);
                    
                    /**
                    * precise match search
                    * e.g. "\/wp-content\/themes\/wprentals"
                    */
                    /*
                    foreach($_relative_domain_url_replacements_dq   as $old_url =>  $new_url)
                        {
                            
                            //JSON some might not using the end forward slash
                            if ( rtrim( $old_url , '/' )    !=  $old_url )
                                {
                                    //if the url include 
                                    $text   =   str_ireplace(   trim( json_encode( rtrim( trim( $old_url, '"'), '/') ), '"' ) . '"'  , trim( json_encode( rtrim( trim ( $new_url, '"'), '/' ) ), '"' ) . '"'  ,$text   );
                                }

                        }
                    */
                    
                    //check for json encoded urls
                    /*
                    foreach($_replacements_np   as $old_url =>  $new_url)
                        {
                            $old_url    =   trim(json_encode($old_url), '"');   
                            $new_url    =   trim(json_encode($new_url), '"'); 
                            
                            $text =   str_ireplace(    $old_url, $new_url  ,$text   );
                            
                            $old_url    =   trim(urlencode($old_url), '"');   
                            $new_url    =   trim(urlencode($new_url), '"'); 
                            
                            $text =   str_ireplace(    $old_url, $new_url  ,$text   );
                        }
                    */
                       
                    /**
                    * Check for json encoded urls
                    * Format    domain/old-slug  =>  domain/ne-slug
                    * 
                    * Some might not include the domain to ensure repalcing in specific instances  e.g admin url, ajax url
                    */                    
                    foreach($_replacements   as $old_url =>  $new_url)
                        {
                            //JSON some might not using the end forward slash
                            //add ending double quote to ensure end of url, to avoid replacing parts of the data
                            if ( rtrim( $old_url , '/' )    !=  $old_url )
                                {
                                    $text   =   str_ireplace(   trim( json_encode( rtrim( trim( $old_url, '"'), '/') ), '"' ) . '"'  , trim( json_encode( rtrim( trim ( $new_url, '"'), '/' ) ), '"' ) . '"'  ,$text   );    
                                }
                            
                            $old_url    =   trim(json_encode($old_url), '"');   
                            $new_url    =   trim(json_encode($new_url), '"'); 
                            
                            $text =   str_ireplace(    $old_url, $new_url  ,$text   );
                            
                            $old_url    =   trim(urlencode($old_url), '"');   
                            $new_url    =   trim(urlencode($new_url), '"'); 
                            
                            $text =   str_ireplace(    $old_url, $new_url  ,$text   );
                        }
                    
         
                    foreach($_relative_domain_url_replacements_dq   as $old_url =>  $new_url)
                        {
                            /*
                            *   JSON always use double quotes
                            *   use double quote type at the start of the string (per json encodync) to avoid replacing for non-local domains    
                            *   e.g. "collectionThumbnail":"https:\/\/wp.envatoextensions.com\/kit-57\/wp-content\/uploads\/sites\/60\/2018\/08\/screenshot-20-1540279812-300x997.jpg"
                            */
                            //$text   =   str_ireplace(   "'" .  trim( json_encode( trim( $old_url, '"')), '"' ) , "'" . trim( json_encode( trim ( $new_url, '"')), '"' )  ,$text   );
                            $text   =   str_ireplace(   '"' .  trim( json_encode( trim( $old_url, '"')), '"' ) , '"' . trim( json_encode( trim ( $new_url, '"')), '"' )  ,$text   );
                                           
                            //$text   =   str_ireplace(    "'" . trim( urlencode(trim( $old_url, '"')), '"' ) ,  "'" . trim( urlencode(trim ( $new_url, '"')), '"' )  ,$text   );
                            $text   =   str_ireplace(    '"' . trim( urlencode(trim( $old_url, '"')), '"' ) ,  '"' . trim( urlencode(trim ( $new_url, '"')), '"' )  ,$text   );
                        }
                        
                        
                    /**
                    * Restore absolute paths
                    */                      
                    //Preserve absolute paths
                    $text   =   str_ireplace( '%WPH-PLACEHOLDER-PRESERVE-ABSPATH%', ABSPATH, $text);
                    //jsonencoded
                    $text   =   str_ireplace( '%WPH-PLACEHOLDER-PRESERVE-JSON-ABSPATH%', trim(json_encode(ABSPATH), '"'), $text);
                    //urlencode
                    $text   =   str_ireplace( '%WPH-PLACEHOLDER-PRESERVE-URLENCODE-ABSPATH%', trim(urlencode(ABSPATH), '"'), $text);
                                      
                    return $text;   
                }
                
                
            
            /**
            * Replace preserved links
            * 
            * @param mixed $text
            * @param mixed $replacements
            */
            function content_preserved_urls_replacement( $text, $replacements )
                {
                    $text =   str_ireplace(    array_keys($replacements), array_values($replacements)  ,$text   );
                       
                    return $text;
                       
                }
                
            
            function default_scripts_styles_replace($object, $replacements)
                {
                    //update default dirs
                    if(isset($object->default_dirs))
                        {
                            foreach($object->default_dirs    as  $key    =>  $value)
                                {
                                    $object->default_dirs[$key]  =   str_replace(array_keys($replacements), array_values($replacements), $value);
                                }
                        }
                       
                    foreach($object->registered    as  $script_name    =>  $script_data)
                        {
                            $script_data->src   =   str_replace(array_keys($replacements), array_values($replacements), $script_data->src);
                            
                            $object->registered[$script_name]  =   $script_data;      
                        }
                        
                    return $object;
                }
                
                
            function check_headers_content_type($header_name, $header_value)
                {
                    
                    $headers    =   headers_list();
                    
                    foreach($headers    as  $header)
                        {
                            if(stripos($header, $header_name)   !== FALSE)
                                {
                                    if(stripos($header, $header_value)   !== FALSE)
                                        return TRUE;     
                                }
                        }
                        
                    
                    return FALSE;
                
                }
                
                
            function array_sort_by_processing_order($a, $b)
                {
                    return $a['processing_order'] - $b['processing_order'];
                }
            
            
            
            /**
            * Return the recovey code
            * 
            */
            function get_recovery_code()
                {
                    global $blog_id;
                    
                    $settings   =   $this->get_site_settings( $blog_id );
                        
                    $recovery_code  =   isset ( $settings['recovery_code'] ) ?  $settings['recovery_code']  :   '';
                    
                    if(empty($recovery_code))
                        {
                            global $blog_id;
                            
                            $recovery_code              =   $this->generate_recovery_code();
                            $settings['recovery_code']  =   $recovery_code;
                            
                            $this->update_site_settings( $settings, $blog_id );
                        }
                    
                    return $recovery_code;
                }
            
            
            /**
            * Generate a recovery code
            * 
            */
            function generate_recovery_code()
                {

                    $recovery_code  =   md5(rand(1,9999) . microtime());
                                       
                    return $recovery_code;
                }
                
                
            /**
            * Trigger the recovery actions
            * 
            */
            function do_recovery()
                {
                    //feetch a new set of settings
                    $recovery_code  =   $this->get_recovery_code();
                    
                    $wph_recovery   =   isset($_GET['wph-recovery']) ?  sanitize_text_field($_GET['wph-recovery'])   :   '';
                    if(empty($wph_recovery) ||  $wph_recovery   !=  $recovery_code)
                        return;
                    
                    global $blog_id;
                    
                    $settings   =   $this->get_current_site_settings();
                                           
                    //change certain settings to default
                    $settings['module_settings']['new_wp_login_php']  =   '';
                    $settings['module_settings']['admin_url']         =   '';
                    
                    //update the settings
                    $this->update_site_settings( $settings, $blog_id );
                    
                    //available for mu-plugins
                    do_action( 'wph/do_recovery' );                    
                    
                    
                    //add filter for rewriting the rules
                    add_action('wp_loaded',  array($this,    'wp_loaded_trigger_do_recovery'));
                    
                }
            
                
            function wp_loaded_trigger_do_recovery()
                {
                    /** WordPress Misc Administration API */
                    require_once(ABSPATH . 'wp-admin/includes/misc.php');
                    
                    /** WordPress Administration File API */
                    require_once(ABSPATH . 'wp-admin/includes/file.php');
                    
                    flush_rewrite_rules();
                    
                    $wph_rewrite_manual_install =   get_option('wph-rewrite-manual-install');
                    if  ( empty ($wph_rewrite_manual_install ))
                        {
                            wp_redirect( get_site_url() );
                            die();
                        }    
                        
                    $rewrite_process    =   new WPH_Rewrite_Process( TRUE );
                             
                    $this->wph->disable_components[]    =   'remove_html_new_lines';
                    
                    //instruct to replace the rewrite with new data
                    if ( is_multisite() )
                        {
                            
                                
                            ?><!DOCTYPE html>
                                <html>
                                <body>

                            <p><?php _e('Network Admin has been informed upon changes, once he operate the rewrite updates you will be able to use new set-up ', 'wp-hide-security-enhancer') ?> </p>
                            
                            <p><br /></p>
                            <p><a href="<?php echo get_site_url() ?>"><?php _e('Continue to your Site', 'wp-hide-security-enhancer') ?></a></p>
                            </body>
                            </html><?php
                            
                        }
                        else
                        {
                            ?><!DOCTYPE html>
                                <html>
                                <body>

                            <?php
                                
                                if (  $this->wph->server_htaccess_config  === TRUE )
                                    {
                                        ?>
                                        <p><?php _e('Add the following to your', 'wp-hide-security-enhancer') ?> <code>.htaccess</code> <?php _e('file in', 'wp-hide-security-enhancer') ?> <code><?php echo ABSPATH ?></code> <?php _e('<strong>above</strong> all other code', 'wp-hide-security-enhancer') ?>.</p>
                                        <p><?php _e('Remove any existing rewrite rules within', 'wp-hide-security-enhancer') ?> <strong># BEGIN WP Hide & Security Enhancer</strong> <?php _e('and', 'wp-hide-security-enhancer') ?> <strong># END WP Hide & Security Enhancer</strong></p>
                                        <?php 
                                    }
                                    
                                if (  $this->wph->server_web_config  === TRUE )
                                    {
                                        ?>
                                        <p><?php _e('Add the following to your', 'wp-hide-security-enhancer') ?> <code>web.config</code> <?php _e('file in', 'wp-hide-security-enhancer') ?> <code><?php echo ABSPATH ?></code></p>
                                        <p><?php _e('Remove any existing rewrite rules named <b>wph</b>, then add the following into &#x3C;rules&#x3E;, above any other rule.', 'wp-hide-security-enhancer') ?></p>
                                        <?php 
                                    }
                                
                                
                            ?>

                            <textarea onclick="this.focus();this.select()" class="code" readonly="readonly" style="width: 100%" rows="12"><?php echo $rewrite_process->get_readable_rewrite_data(); ?></textarea>
                            <p><br /></p>
                            <p><?php _e('Once updated', 'wp-hide-security-enhancer') ?> <a href="<?php echo get_site_url() ?>"><?php _e('Continue to your Site', 'wp-hide-security-enhancer') ?></a></p>
                            </body>
                            </html><?php
                            
                            $this->rewrite_applied_correctly_to_site();   
                            wp_logout();
                        }
                        
                    die();
      
                }
            
            
            /**
            * Check if filter / action exists for anonymous object
            * 
            * @param mixed $tag
            * @param mixed $class
            * @param mixed $method
            */
            function anonymous_object_filter_exists($tag, $class, $method)
                {
                    if ( !  isset( $GLOBALS['wp_filter'][$tag] ) )
                        return FALSE;
                    
                    $filters = $GLOBALS['wp_filter'][$tag];
                    
                    if ( !  $filters )
                        return FALSE;
                        
                    foreach ( $filters as $priority => $filter ) 
                        {
                            foreach ( $filter as $identifier => $function ) 
                                {
                                    if ( ! is_array( $function ) )
                                        continue;
                                    
                                    if ( ! $function['function'][0] instanceof $class )
                                        continue;
                                    
                                    if ( $method == $function['function'][1] ) 
                                        {
                                            return TRUE;
                                        }
                                }
                        }
                        
                    return FALSE;
                }
            
            /**
            * Replace a filter / action from anonymous object
            * 
            * @param mixed $tag
            * @param mixed $class
            * @param mixed $method
            */
            function remove_anonymous_object_filter( $tag, $class, $method ) 
                {
                    $filters = false;

                    if ( isset( $GLOBALS['wp_filter'][$tag] ) )
                        $filters = $GLOBALS['wp_filter'][$tag];

                    if ( $filters )
                    foreach ( $filters as $priority => $filter ) 
                        {
                            foreach ( $filter as $identifier => $function ) 
                                {
                                    if ( ! is_array( $function ) )
                                        continue;
                                    
                                    if ( ! $function['function'][0] instanceof $class )
                                        continue;
                                    
                                    if ( $method == $function['function'][1] ) 
                                        {
                                            remove_filter($tag, array( $function['function'][0], $method ), $priority);
                                        }
                                }
                        }
                }
                
            
            /**
            * An early instance of WordPress wp_mail core 
            * Unable to load pluggable.php where the function exists, as bein loaded using require
            *     
            * @param mixed $to
            * @param mixed $subject
            * @param mixed $message
            * @param mixed $headers
            * @param mixed $attachments
            */
            function wp_mail( $to, $subject, $message, $headers = '', $attachments = array() ) 
                {
                    // Compact the input, apply the filters, and extract them back out
                 
                    /**
                     * Filter the wp_mail() arguments.
                     *
                     * @since 2.2.0
                     *
                     * @param array $args A compacted array of wp_mail() arguments, including the "to" email,
                     *                    subject, message, headers, and attachments values.
                     */
                    $atts = apply_filters( 'wp_mail', compact( 'to', 'subject', 'message', 'headers', 'attachments' ) );
                 
                    if ( isset( $atts['to'] ) ) {
                        $to = $atts['to'];
                    }
                 
                    if ( isset( $atts['subject'] ) ) {
                        $subject = $atts['subject'];
                    }
                 
                    if ( isset( $atts['message'] ) ) {
                        $message = $atts['message'];
                    }
                 
                    if ( isset( $atts['headers'] ) ) {
                        $headers = $atts['headers'];
                    }
                 
                    if ( isset( $atts['attachments'] ) ) {
                        $attachments = $atts['attachments'];
                    }
                 
                    if ( ! is_array( $attachments ) ) {
                        $attachments = explode( "\n", str_replace( "\r\n", "\n", $attachments ) );
                    }
                    global $phpmailer;
                 
                    // (Re)create it, if it's gone missing
                    if ( ! ( $phpmailer instanceof PHPMailer ) ) {
                        require_once ABSPATH . WPINC . '/class-phpmailer.php';
                        require_once ABSPATH . WPINC . '/class-smtp.php';
                        $phpmailer = new PHPMailer( true );
                    }
                 
                    // Headers
                    if ( empty( $headers ) ) {
                        $headers = array();
                    } else {
                        if ( !is_array( $headers ) ) {
                            // Explode the headers out, so this function can take both
                            // string headers and an array of headers.
                            $tempheaders = explode( "\n", str_replace( "\r\n", "\n", $headers ) );
                        } else {
                            $tempheaders = $headers;
                        }
                        $headers = array();
                        $cc = array();
                        $bcc = array();
                 
                        // If it's actually got contents
                        if ( !empty( $tempheaders ) ) {
                            // Iterate through the raw headers
                            foreach ( (array) $tempheaders as $header ) {
                                if ( strpos($header, ':') === false ) {
                                    if ( false !== stripos( $header, 'boundary=' ) ) {
                                        $parts = preg_split('/boundary=/i', trim( $header ) );
                                        $boundary = trim( str_replace( array( "'", '"' ), '', $parts[1] ) );
                                    }
                                    continue;
                                }
                                // Explode them out
                                list( $name, $content ) = explode( ':', trim( $header ), 2 );
                 
                                // Cleanup crew
                                $name    = trim( $name    );
                                $content = trim( $content );
                 
                                switch ( strtolower( $name ) ) {
                                    // Mainly for legacy -- process a From: header if it's there
                                    case 'from':
                                        $bracket_pos = strpos( $content, '<' );
                                        if ( $bracket_pos !== false ) {
                                            // Text before the bracketed email is the "From" name.
                                            if ( $bracket_pos > 0 ) {
                                                $from_name = substr( $content, 0, $bracket_pos - 1 );
                                                $from_name = str_replace( '"', '', $from_name );
                                                $from_name = trim( $from_name );
                                            }
                 
                                            $from_email = substr( $content, $bracket_pos + 1 );
                                            $from_email = str_replace( '>', '', $from_email );
                                            $from_email = trim( $from_email );
                 
                                        // Avoid setting an empty $from_email.
                                        } elseif ( '' !== trim( $content ) ) {
                                            $from_email = trim( $content );
                                        }
                                        break;
                                    case 'content-type':
                                        if ( strpos( $content, ';' ) !== false ) {
                                            list( $type, $charset_content ) = explode( ';', $content );
                                            $content_type = trim( $type );
                                            if ( false !== stripos( $charset_content, 'charset=' ) ) {
                                                $charset = trim( str_replace( array( 'charset=', '"' ), '', $charset_content ) );
                                            } elseif ( false !== stripos( $charset_content, 'boundary=' ) ) {
                                                $boundary = trim( str_replace( array( 'BOUNDARY=', 'boundary=', '"' ), '', $charset_content ) );
                                                $charset = '';
                                            }
                 
                                        // Avoid setting an empty $content_type.
                                        } elseif ( '' !== trim( $content ) ) {
                                            $content_type = trim( $content );
                                        }
                                        break;
                                    case 'cc':
                                        $cc = array_merge( (array) $cc, explode( ',', $content ) );
                                        break;
                                    case 'bcc':
                                        $bcc = array_merge( (array) $bcc, explode( ',', $content ) );
                                        break;
                                    default:
                                        // Add it to our grand headers array
                                        $headers[trim( $name )] = trim( $content );
                                        break;
                                }
                            }
                        }
                    }
                 
                    // Empty out the values that may be set
                    $phpmailer->ClearAllRecipients();
                    $phpmailer->ClearAttachments();
                    $phpmailer->ClearCustomHeaders();
                    $phpmailer->ClearReplyTos();
                 
                    // From email and name
                    // If we don't have a name from the input headers
                    if ( !isset( $from_name ) )
                        $from_name = 'WordPress';
                 
                    /* If we don't have an email from the input headers default to wordpress@$sitename
                     * Some hosts will block outgoing mail from this address if it doesn't exist but
                     * there's no easy alternative. Defaulting to admin_email might appear to be another
                     * option but some hosts may refuse to relay mail from an unknown domain. See
                     * https://core.trac.wordpress.org/ticket/5007.
                     */
                 
                    if ( !isset( $from_email ) ) {
                        // Get the site domain and get rid of www.
                        $sitename = strtolower( $_SERVER['SERVER_NAME'] );
                        if ( substr( $sitename, 0, 4 ) == 'www.' ) {
                            $sitename = substr( $sitename, 4 );
                        }
                 
                        $from_email = 'wordpress@' . $sitename;
                    }
                 
                    /**
                     * Filter the email address to send from.
                     *
                     * @since 2.2.0
                     *
                     * @param string $from_email Email address to send from.
                     */
                    $phpmailer->From = apply_filters( 'wp_mail_from', $from_email );
                 
                    /**
                     * Filter the name to associate with the "from" email address.
                     *
                     * @since 2.3.0
                     *
                     * @param string $from_name Name associated with the "from" email address.
                     */
                    $phpmailer->FromName = apply_filters( 'wp_mail_from_name', $from_name );
                 
                    // Set destination addresses
                    if ( !is_array( $to ) )
                        $to = explode( ',', $to );
                 
                    foreach ( (array) $to as $recipient ) {
                        try {
                            // Break $recipient into name and address parts if in the format "Foo <bar@baz.com>"
                            $recipient_name = '';
                            if ( preg_match( '/(.*)<(.+)>/', $recipient, $matches ) ) {
                                if ( count( $matches ) == 3 ) {
                                    $recipient_name = $matches[1];
                                    $recipient = $matches[2];
                                }
                            }
                            $phpmailer->AddAddress( $recipient, $recipient_name);
                        } catch ( phpmailerException $e ) {
                            continue;
                        }
                    }
                 
                    // Set mail's subject and body
                    $phpmailer->Subject = $subject;
                    $phpmailer->Body    = $message;
                 
                    // Add any CC and BCC recipients
                    if ( !empty( $cc ) ) {
                        foreach ( (array) $cc as $recipient ) {
                            try {
                                // Break $recipient into name and address parts if in the format "Foo <bar@baz.com>"
                                $recipient_name = '';
                                if ( preg_match( '/(.*)<(.+)>/', $recipient, $matches ) ) {
                                    if ( count( $matches ) == 3 ) {
                                        $recipient_name = $matches[1];
                                        $recipient = $matches[2];
                                    }
                                }
                                $phpmailer->AddCc( $recipient, $recipient_name );
                            } catch ( phpmailerException $e ) {
                                continue;
                            }
                        }
                    }
                 
                    if ( !empty( $bcc ) ) {
                        foreach ( (array) $bcc as $recipient) {
                            try {
                                // Break $recipient into name and address parts if in the format "Foo <bar@baz.com>"
                                $recipient_name = '';
                                if ( preg_match( '/(.*)<(.+)>/', $recipient, $matches ) ) {
                                    if ( count( $matches ) == 3 ) {
                                        $recipient_name = $matches[1];
                                        $recipient = $matches[2];
                                    }
                                }
                                $phpmailer->AddBcc( $recipient, $recipient_name );
                            } catch ( phpmailerException $e ) {
                                continue;
                            }
                        }
                    }
                 
                    // Set to use PHP's mail()
                    $phpmailer->IsMail();
                 
                    // Set Content-Type and charset
                    // If we don't have a content-type from the input headers
                    if ( !isset( $content_type ) )
                        $content_type = 'text/plain';
                 
                    /**
                     * Filter the wp_mail() content type.
                     *
                     * @since 2.3.0
                     *
                     * @param string $content_type Default wp_mail() content type.
                     */
                    $content_type = apply_filters( 'wp_mail_content_type', $content_type );
                 
                    $phpmailer->ContentType = $content_type;
                 
                    // Set whether it's plaintext, depending on $content_type
                    if ( 'text/html' == $content_type )
                        $phpmailer->IsHTML( true );
                 
                    // If we don't have a charset from the input headers
                    if ( !isset( $charset ) )
                        $charset = get_bloginfo( 'charset' );
                 
                    // Set the content-type and charset
                 
                    /**
                     * Filter the default wp_mail() charset.
                     *
                     * @since 2.3.0
                     *
                     * @param string $charset Default email charset.
                     */
                    $phpmailer->CharSet = apply_filters( 'wp_mail_charset', $charset );
                 
                    // Set custom headers
                    if ( !empty( $headers ) ) {
                        foreach ( (array) $headers as $name => $content ) {
                            $phpmailer->AddCustomHeader( sprintf( '%1$s: %2$s', $name, $content ) );
                        }
                 
                        if ( false !== stripos( $content_type, 'multipart' ) && ! empty($boundary) )
                            $phpmailer->AddCustomHeader( sprintf( "Content-Type: %s;\n\t boundary=\"%s\"", $content_type, $boundary ) );
                    }
                 
                    if ( !empty( $attachments ) ) {
                        foreach ( $attachments as $attachment ) {
                            try {
                                $phpmailer->AddAttachment($attachment);
                            } catch ( phpmailerException $e ) {
                                continue;
                            }
                        }
                    }
                 
                    /**
                     * Fires after PHPMailer is initialized.
                     *
                     * @since 2.2.0
                     *
                     * @param PHPMailer &$phpmailer The PHPMailer instance, passed by reference.
                     */
                    do_action_ref_array( 'phpmailer_init', array( &$phpmailer ) );
                 
                    // Send!
                    try {
                        return $phpmailer->Send();
                    } catch ( phpmailerException $e ) {
                 
                        $mail_error_data = compact( $to, $subject, $message, $headers, $attachments );
                 
                        /**
                         * Fires after a phpmailerException is caught.
                         *
                         * @since 4.4.0
                         *
                         * @param WP_Error $error A WP_Error object with the phpmailerException code, message, and an array
                         *                        containing the mail recipient, subject, message, headers, and attachments.
                         */
                        do_action( 'wp_mail_failed', new WP_Error( $e->getCode(), $e->getMessage(), $mail_error_data ) );
                 
                        return false;
                    }
                }
                                  
        
            /**
            * Check the plugins directory and retrieve all plugin files with plugin data.
            *
            * WordPress only supports plugin files in the base plugins directory
            * (wp-content/plugins) and in one directory above the plugins directory
            * (wp-content/plugins/my-plugin). The file it looks for has the plugin data
            * and must be found in those two locations. It is recommended to keep your
            * plugin files in their own directories.
            *
            * The file with the plugin data is the file that will be included and therefore
            * needs to have the main execution for the plugin. This does not mean
            * everything must be contained in the file and it is recommended that the file
            * be split for maintainability. Keep everything in one file for extreme
            * optimization purposes.
            *
            * @since 1.5.0
            *
            * @param string $plugin_folder Optional. Relative path to single plugin folder.
            * @return array Key is the plugin file path and the value is an array of the plugin data.
            */
            function get_plugins($plugin_folder = '') 
                {
                 
                    $wp_plugins = array ();
                    $plugin_root = WP_PLUGIN_DIR;
                    if ( !empty($plugin_folder) )
                        $plugin_root .= $plugin_folder;

                    // Files in wp-content/plugins directory
                    $plugins_dir = @ opendir( $plugin_root);
                    $plugin_files = array();
                    if ( $plugins_dir ) {
                        while (($file = readdir( $plugins_dir ) ) !== false ) {
                            if ( substr($file, 0, 1) == '.' )
                                continue;
                            if ( is_dir( $plugin_root.'/'.$file ) ) {
                                $plugins_subdir = @ opendir( $plugin_root.'/'.$file );
                                if ( $plugins_subdir ) {
                                    while (($subfile = readdir( $plugins_subdir ) ) !== false ) {
                                        if ( substr($subfile, 0, 1) == '.' )
                                            continue;
                                        if ( substr($subfile, -4) == '.php' )
                                            $plugin_files[] = "$file/$subfile";
                                    }
                                    closedir( $plugins_subdir );
                                }
                            } else {
                                if ( substr($file, -4) == '.php' )
                                    $plugin_files[] = $file;
                            }
                        }
                        closedir( $plugins_dir );
                    }

                    if ( empty($plugin_files) )
                        return $wp_plugins;

                    foreach ( $plugin_files as $plugin_file ) {
                        if ( !is_readable( "$plugin_root/$plugin_file" ) )
                            continue;

                        $plugin_data = $this->get_plugin_data( "$plugin_root/$plugin_file", false, false ); //Do not apply markup/translate as it'll be cached.

                        if ( empty ( $plugin_data['Name'] ) )
                            continue;

                        $wp_plugins[plugin_basename( $plugin_file )] = $plugin_data;
                    }

                    uasort( $wp_plugins, array($this, '_sort_uname_callback' ));
                    
                    return $wp_plugins;
                }
                
                
            
            /**
            * Callback to sort array by a 'Name' key.
            * 
            */
            function _sort_uname_callback( $a, $b ) 
                {
                    return strnatcasecmp( $a['Name'], $b['Name'] );
                }
                
            
            /**
            * Parse plugin headers data
            *     
            * @param mixed $plugin_file
            * @param mixed $markup
            * @param mixed $translate
            */
            function get_plugin_data( $plugin_file, $markup = true, $translate = true ) 
                {

                    $default_headers = array(
                        'Name' => 'Plugin Name',
                        'PluginURI' => 'Plugin URI',
                        'Version' => 'Version',
                        'Description' => 'Description',
                        'Author' => 'Author',
                        'AuthorURI' => 'Author URI',
                        'TextDomain' => 'Text Domain',
                        'DomainPath' => 'Domain Path',
                        'Network' => 'Network',
                        // Site Wide Only is deprecated in favor of Network.
                        '_sitewide' => 'Site Wide Only',
                    );

                    $plugin_data = get_file_data( $plugin_file, $default_headers, 'plugin' );

                    // Site Wide Only is the old header for Network
                    if ( ! $plugin_data['Network'] && $plugin_data['_sitewide'] ) {
                        /* translators: 1: Site Wide Only: true, 2: Network: true */
                        _deprecated_argument( __FUNCTION__, '3.0', sprintf( __( 'The %1$s plugin header is deprecated. Use %2$s instead.' ), '<code>Site Wide Only: true</code>', '<code>Network: true</code>' ) );
                        $plugin_data['Network'] = $plugin_data['_sitewide'];
                    }
                    $plugin_data['Network'] = ( 'true' == strtolower( $plugin_data['Network'] ) );
                    unset( $plugin_data['_sitewide'] );

                    if ( $markup || $translate ) {
                        $plugin_data = $this->_get_plugin_data_markup_translate( $plugin_file, $plugin_data, $markup, $translate );
                    } else {
                        $plugin_data['Title']      = $plugin_data['Name'];
                        $plugin_data['AuthorName'] = $plugin_data['Author'];
                    }

                    return $plugin_data;
                }
                
                
                
            /**
            * Sanitizes plugin data, optionally adds markup, optionally translates.
            *
            * @since 2.7.0
            * @access private
            * @see get_plugin_data()
            */
            function _get_plugin_data_markup_translate( $plugin_file, $plugin_data, $markup = true, $translate = true ) 
                {

                    // Sanitize the plugin filename to a WP_PLUGIN_DIR relative path
                    $plugin_file = plugin_basename( $plugin_file );

                    // Translate fields
                    if ( $translate ) {
                        if ( $textdomain = $plugin_data['TextDomain'] ) {
                            if ( ! is_textdomain_loaded( $textdomain ) ) {
                                if ( $plugin_data['DomainPath'] ) {
                                    load_plugin_textdomain( $textdomain, false, dirname( $plugin_file ) . $plugin_data['DomainPath'] );
                                } else {
                                    load_plugin_textdomain( $textdomain, false, dirname( $plugin_file ) );
                                }
                            }
                        } elseif ( 'hello.php' == basename( $plugin_file ) ) {
                            $textdomain = 'default';
                        }
                        if ( $textdomain ) {
                            foreach ( array( 'Name', 'PluginURI', 'Description', 'Author', 'AuthorURI', 'Version' ) as $field )
                                $plugin_data[ $field ] = translate( $plugin_data[ $field ], $textdomain );
                        }
                    }

                    // Sanitize fields
                    $allowed_tags = $allowed_tags_in_links = array(
                        'abbr'    => array( 'title' => true ),
                        'acronym' => array( 'title' => true ),
                        'code'    => true,
                        'em'      => true,
                        'strong'  => true,
                    );
                    $allowed_tags['a'] = array( 'href' => true, 'title' => true );

                    // Name is marked up inside <a> tags. Don't allow these.
                    // Author is too, but some plugins have used <a> here (omitting Author URI).
                    $plugin_data['Name']        = wp_kses( $plugin_data['Name'],        $allowed_tags_in_links );
                    $plugin_data['Author']      = wp_kses( $plugin_data['Author'],      $allowed_tags );

                    $plugin_data['Description'] = wp_kses( $plugin_data['Description'], $allowed_tags );
                    $plugin_data['Version']     = wp_kses( $plugin_data['Version'],     $allowed_tags );

                    $plugin_data['PluginURI']   = esc_url( $plugin_data['PluginURI'] );
                    $plugin_data['AuthorURI']   = esc_url( $plugin_data['AuthorURI'] );

                    $plugin_data['Title']      = $plugin_data['Name'];
                    $plugin_data['AuthorName'] = $plugin_data['Author'];

                    // Apply markup
                    if ( $markup ) {
                        if ( $plugin_data['PluginURI'] && $plugin_data['Name'] )
                            $plugin_data['Title'] = '<a href="' . $plugin_data['PluginURI'] . '">' . $plugin_data['Name'] . '</a>';

                        if ( $plugin_data['AuthorURI'] && $plugin_data['Author'] )
                            $plugin_data['Author'] = '<a href="' . $plugin_data['AuthorURI'] . '">' . $plugin_data['Author'] . '</a>';

                        $plugin_data['Description'] = wptexturize( $plugin_data['Description'] );

                        if ( $plugin_data['Author'] )
                            $plugin_data['Description'] .= ' <cite>' . sprintf( __('By %s.'), $plugin_data['Author'] ) . '</cite>';
                    }

                    return $plugin_data;
                }
                
                
            /**
            * Alternative when apache_response_headers() not available
            * 
            */
            function parseRequestHeaders() 
                {
                    $headers = array();
                    foreach($_SERVER as $key => $value) 
                        {
                            if (substr($key, 0, 5) <> 'HTTP_') 
                                continue;
                                
                            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
                            $headers[$header] = $value;
                        }
                    
                    return $headers;
                }
                
                
            
            function update_headers( $headers, $response_headers )
                {
                    
                    $replacement_list   =   $this->get_replacement_list();
                    
                    foreach ( $headers as $header )
                        {
                            if(isset($response_headers[ $header ]))
                                {
                                    $header_value   =   $response_headers[ $header ];
                                    $new_header_value   =   $this->content_urls_replacement($header_value,  $replacement_list );
                                    
                                    if($header_value    !=  $new_header_value)
                                        {
                                            header_remove("Location");
                                            header( 'Location: ' . $new_header_value );
                                        }
                                }
                        }
                    
                }
            
            
            
            /**
            * Check if current content is filterable, depending on header content type
            * 
            */
            function is_filterable_content_type()
                {
                    
                    $headers        =   headers_list();
                    
                    $is_filterable  =   TRUE;
                    
                    //there is no header to check
                    if  ( ! is_array( $headers )  ||  count ( $headers ) < 1 )
                        return $is_filterable;
                        

                    $found  =   preg_grep('/^Content-Type\s?:.*/i', $headers);
                    if  ( ! is_array ( $found ) ||    count ( $found ) <  1   )
                        return $is_filterable;
                        
                    reset( $found );
                    $header_field           =   $headers[ key( $found ) ];
                    $header_field           =   preg_replace('/Content-Type\s?:/i', '', $header_field);
                    $header_field           =   trim ( $header_field );
                    $header_field_parts     =   explode(";", $header_field);
                    $header_content_type    =   trim( $header_field_parts[0] );
                    
                    $allow_type    =   array(
                                                'text/css',
                                                'text/html',
                                                'text/csv',
                                                'application/javascript',
                                                'text/javascript',
                                                'application/json'
                                                );
                    if  ( ! in_array( $header_content_type , $allow_type ) )
                        $is_filterable  =   FALSE;
                        
                    return $is_filterable;    
                    
                }
            
            
            /**
            * Get available themes
            * 
            * @param mixed $args
            */
            function get_themes( $args = array() ) 
                {
                    global $wp_theme_directories;

                    $defaults = array( 'errors' => false, 'allowed' => null, 'blog_id' => 0 );
                    $args = wp_parse_args( $args, $defaults );

                    if  ( is_null($wp_theme_directories))
                        $wp_theme_directories   =   array();    
                    
                    // Register the default theme directory root
                    if ( count( $wp_theme_directories ) < 1  ) 
                        register_theme_directory( get_theme_root() );
                    
                    $theme_directories = search_theme_directories();

                    if ( count( $wp_theme_directories ) > 1 ) {
                        // Make sure the current theme wins out, in case search_theme_directories() picks the wrong
                        // one in the case of a conflict. (Normally, last registered theme root wins.)
                        $current_theme = get_stylesheet();
                        if ( isset( $theme_directories[ $current_theme ] ) ) {
                            $root_of_current_theme = get_raw_theme_root( $current_theme );
                            if ( ! in_array( $root_of_current_theme, $wp_theme_directories ) )
                                $root_of_current_theme = WP_CONTENT_DIR . $root_of_current_theme;
                            $theme_directories[ $current_theme ]['theme_root'] = $root_of_current_theme;
                        }
                    }

                    if ( empty( $theme_directories ) )
                        return array();

                    if ( is_multisite() && null !== $args['allowed'] ) {
                        $allowed = $args['allowed'];
                        if ( 'network' === $allowed )
                            $theme_directories = array_intersect_key( $theme_directories, WP_Theme::get_allowed_on_network() );
                        elseif ( 'site' === $allowed )
                            $theme_directories = array_intersect_key( $theme_directories, WP_Theme::get_allowed_on_site( $args['blog_id'] ) );
                        elseif ( $allowed )
                            $theme_directories = array_intersect_key( $theme_directories, WP_Theme::get_allowed( $args['blog_id'] ) );
                        else
                            $theme_directories = array_diff_key( $theme_directories, WP_Theme::get_allowed( $args['blog_id'] ) );
                    }

                    return $theme_directories;
                    
                }
            
            
            /**
            * Parse available themes headers
            * 
            */
            function parse_themes_headers( $all_templates )
                {
                    
                    if ( ! is_array($all_templates) )
                        return $all_templates;
                    
                    foreach( $all_templates as  $directory  =>  $theme_data)
                        {
                            
                            $theme_headers  =   $this->get_theme_headers( trailingslashit( $theme_data['theme_root']) . $theme_data['theme_file']);
                            $all_templates[$directory]['headers']   =  $theme_headers;
                            
                        }
                    
                    return $all_templates;
                       
                }
            
            
            
            /**
            * Return headers for a theme
            * 
            * @param mixed $stylesheet_path
            */
            function get_theme_headers($stylesheet_path)
                {
                    
                    $file_headers = array(
                                            'Name'        => 'Theme Name',
                                            'ThemeURI'    => 'Theme URI',
                                            'Description' => 'Description',
                                            'Author'      => 'Author',
                                            'AuthorURI'   => 'Author URI',
                                            'Version'     => 'Version',
                                            'Template'    => 'Template',
                                            'Status'      => 'Status',
                                            'Tags'        => 'Tags',
                                            'TextDomain'  => 'Text Domain',
                                            'DomainPath'  => 'Domain Path',
                                        );
                    
                    $theme_headers = get_file_data( $stylesheet_path, $file_headers, 'theme' );   
                    
                    return $theme_headers;
                    
                }
            
            
            /**
            * Return if a theme is child or not
            * 
            * @param mixed $theme_slug
            * @param mixed $all_themes
            */
            function is_child_theme($theme_slug, $all_themes)
                {
                    
                    $theme_data =   $all_themes[$theme_slug];
                        
                    if( isset($theme_data['headers']['Template']) &&  !empty($theme_data['headers']['Template']))
                        return TRUE;
                        
                    return FALSE;
                      
                }
                
                
            /**
            * Return main theme directory slug
            * 
            * @param mixed $theme_slug
            * @param mixed $all_themes
            */
            function get_main_theme_directory($theme_slug, $all_themes)
                {
                      
                    $theme_data         =   $all_themes[$theme_slug];
                    $theme_directory    =   $theme_slug;
                    
                    if( isset($theme_data['headers']['Template']) &&  !empty($theme_data['headers']['Template']))
                        {
                            $theme_directory    =   $theme_data['headers']['Template'];
                        }        
                    
                    return $theme_directory;
                    
                }
            
            
            
            function get_site_template_data( )
                {
                              
                    $data   =   array();
                    
                    $data['themes_url']                 =   home_url() . $this->wph->default_variables['templates_directory'];
                    
                    $all_templates  =   $this->get_themes();
                    $all_templates  =   $this->parse_themes_headers($all_templates);
                    
                    $stylesheet     =   get_option( 'stylesheet' );
                                        
                    $data['use_child_theme']            =   $this->is_child_theme($stylesheet, $all_templates);
                    
                    $main_theme_directory                               =   $this->get_main_theme_directory($stylesheet, $all_templates);
                    $data['main']                       =   array();
                    $data['main']['folder_name']        =   $main_theme_directory;
                    
                    if($data['use_child_theme'])
                        {
                            $data['child']         =   array();        
                            $data['child']['folder_name']  =   $stylesheet;
                        }
                        
                    return $data;
                    
                }
            
            
            /**
            * Recreate a url from a parsed array
            * 
            * @param mixed $parts
            */
            function build_parsed_url( $parse_url )
                {
                    $url    =   (isset($parse_url['scheme']) ? "{$parse_url['scheme']}:" : '') . 
                                ((isset($parse_url['user']) || isset($parse_url['host'])) ? '//' : '') . 
                                (isset($parse_url['user']) ? "{$parse_url['user']}" : '') . 
                                (isset($parse_url['pass']) ? ":{$parse_url['pass']}" : '') . 
                                (isset($parse_url['user']) ? '@' : '') . 
                                (isset($parse_url['host']) ? "{$parse_url['host']}" : '') . 
                                (isset($parse_url['port']) ? ":{$parse_url['port']}" : '') . 
                                (isset($parse_url['path']) ? "{$parse_url['path']}" : '') . 
                                (isset($parse_url['query']) ? "?{$parse_url['query']}" : '') . 
                                (isset($parse_url['fragment']) ? "#{$parse_url['fragment']}" : '');
   
                    return $url;
                    
                }
            
            
            
            /**
            * Return upload paths and dirs
            * 
            */
            function get_wp_upload_dir()
                {
                    
                    global $blog_id;
                    
                    $siteurl = get_option( 'siteurl' );
                    $upload_path = trim( get_option( 'upload_path' ) );

                    if ( empty( $upload_path ) || 'wp-content/uploads' == $upload_path ) {
                        $dir = WP_CONTENT_DIR . '/uploads';
                    } elseif ( 0 !== strpos( $upload_path, ABSPATH ) ) {
                        // $dir is absolute, $upload_path is (maybe) relative to ABSPATH
                        $dir = path_join( ABSPATH, $upload_path );
                    } else {
                        $dir = $upload_path;
                    }

                    
                    if(is_multisite())
                        {
                            $blog_details = get_blog_details( $blog_id );
                            
                            $protocol   =   (is_ssl())  ?   'https://' :   'http://';
                            
                            if ( empty($upload_path) || ( 'wp-content/uploads' == $upload_path ) || ( $upload_path == $dir ) )
                                    $url = $protocol . $blog_details->domain . $blog_details->path . ltrim($this->wph->default_variables['network']['content_path'], '/') .'/uploads';
                                else
                                    $url = $protocol . $blog_details->domain . $blog_details->path . $upload_path;    
                        }
                        else
                        {
                            if ( !$url = get_option( 'upload_url_path' ) ) 
                                {
                                    if ( empty($upload_path) || ( 'wp-content/uploads' == $upload_path ) || ( $upload_path == $dir ) )
                                        $url = WP_CONTENT_URL . '/uploads';
                                    else
                                        $url = trailingslashit( $siteurl ) . $upload_path;
                                }
                        }

                    /*
                     * Honor the value of UPLOADS. This happens as long as ms-files rewriting is disabled.
                     * We also sometimes obey UPLOADS when rewriting is enabled -- see the next block.
                     */
                    if ( defined( 'UPLOADS' ) && ! ( is_multisite() && get_site_option( 'ms_files_rewriting' ) ) ) {
                        $dir = ABSPATH . UPLOADS;
                        $url = trailingslashit( $siteurl ) . UPLOADS;
                    }

                    // If multisite (and if not the main site in a post-MU network)
                    if ( is_multisite() && ! ( is_main_network() && is_main_site() && defined( 'MULTISITE' ) ) ) {

                        if ( ! get_site_option( 'ms_files_rewriting' ) ) {
                            /*
                             * If ms-files rewriting is disabled (networks created post-3.5), it is fairly
                             * straightforward: Append sites/%d if we're not on the main site (for post-MU
                             * networks). (The extra directory prevents a four-digit ID from conflicting with
                             * a year-based directory for the main site. But if a MU-era network has disabled
                             * ms-files rewriting manually, they don't need the extra directory, as they never
                             * had wp-content/uploads for the main site.)
                             */

                            if ( defined( 'MULTISITE' ) )
                                $ms_dir = '/sites/' . get_current_blog_id();
                            else
                                $ms_dir = '/' . get_current_blog_id();

                            $dir .= $ms_dir;
                            $url .= $ms_dir;

                        } elseif ( defined( 'UPLOADS' ) && ! ms_is_switched() ) {
                            /*
                             * Handle the old-form ms-files.php rewriting if the network still has that enabled.
                             * When ms-files rewriting is enabled, then we only listen to UPLOADS when:
                             * 1) We are not on the main site in a post-MU network, as wp-content/uploads is used
                             *    there, and
                             * 2) We are not switched, as ms_upload_constants() hardcodes these constants to reflect
                             *    the original blog ID.
                             *
                             * Rather than UPLOADS, we actually use BLOGUPLOADDIR if it is set, as it is absolute.
                             * (And it will be set, see ms_upload_constants().) Otherwise, UPLOADS can be used, as
                             * as it is relative to ABSPATH. For the final piece: when UPLOADS is used with ms-files
                             * rewriting in multisite, the resulting URL is /files. (#WP22702 for background.)
                             */

                            if ( defined( 'BLOGUPLOADDIR' ) )
                                $dir = untrailingslashit( BLOGUPLOADDIR );
                            else
                                $dir = ABSPATH . UPLOADS;
                            $url = trailingslashit( $siteurl ) . 'files';
                        }
                    }

                    $basedir = $dir;
                    $baseurl = $url;

                    $subdir = '';
                    if ( get_option( 'uploads_use_yearmonth_folders' ) ) {
                        // Generate the yearly and monthly dirs
                        $time   = current_time( 'mysql' );
                        $y      = substr( $time, 0, 4 );
                        $m      = substr( $time, 5, 2 );
                        $subdir = "/$y/$m";
                    }

                    $dir .= $subdir;
                    $url .= $subdir;

                    return array(
                        'path'    => wp_normalize_path ($dir),
                        'url'     => $url,
                        'subdir'  => $subdir,
                        'basedir' => wp_normalize_path ($basedir),
                        'baseurl' => $baseurl,
                        'error'   => false,
                    );    
                }
                
            /**
            * Return active blogs where the plugin is available
            * 
            */
            function ms_get_plugin_active_blogs()
                {
                    
                    $plugin_slug    =   'wp-hide-security-enhancer-pro/wp-hide.php';
                       
                    $args   =   array(
                                        'public'    =>  1,
                                        'archived'  =>  0,
                                        'spam'      =>  0,
                                        'deleted'   =>  0,
                                        'limit'     =>  9999
                                        );
                    
                    $network_sites  =   get_sites( $args );
                    
                    if ( !function_exists( 'get_plugins' ) )
                        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    
                    //check if plugin available to all sites, being network active
                    if(is_plugin_active_for_network( $plugin_slug ))
                        return $network_sites;
                    
                    //filter out the sites where plugin is not active
                    if ( !function_exists( 'is_plugin_active' ) )
                        include_once(ABSPATH.'wp-admin/includes/plugin.php');
                    
                    foreach ( $network_sites    as   $key   =>  $network_site )
                        {
                    
                            switch_to_blog( $network_site->blog_id );
                            
                            if ( ! is_plugin_active( $plugin_slug ) )
                                unset ( $network_sites[ $key ] );
                            
                            restore_current_blog();
                        }
                        
                    //reindex
                    $network_sites  =   array_values($network_sites);
                    
                    return $network_sites;    
                    
                }

            /**
            * Create a Lock functionality using the MySql 
            * 
            * @param mixed $lock_name
            * @param mixed $release_timeout
            * 
            * @return bool False if a lock couldn't be created or if the lock is still valid. True otherwise.
            */
            function create_lock( $lock_name, $release_timeout = null ) 
                {
                    
                    global $wpdb, $blog_id;
                    
                    if ( ! $release_timeout ) {
                        $release_timeout = 10;
                    }
                    $lock_option = $lock_name . '.lock';
                                     
                    // Try to lock.
                    $lock_result = $wpdb->query( $wpdb->prepare( "INSERT INTO `". $wpdb->sitemeta ."` (`site_id`, `meta_key`, `meta_value`) 
                                                                    SELECT %s, %s, %s FROM DUAL
                                                                    WHERE NOT EXISTS (SELECT * FROM `". $wpdb->sitemeta ."` 
                                                                          WHERE `meta_key` = %s AND `meta_value` != '') 
                                                                    LIMIT 1", $blog_id, $lock_option, time(), $lock_option) );
                                        
                    if ( ! $lock_result ) 
                        {
                            $lock_result    =   $this->get_lock( $lock_option );

                            // If a lock couldn't be created, and there isn't a lock, bail.
                            if ( ! $lock_result ) {
                                return false;
                            }

                            // Check to see if the lock is still valid. If it is, bail.
                            if ( $lock_result > ( time() - $release_timeout ) ) {
                                return false;
                            }

                            // There must exist an expired lock, clear it and re-gain it.
                            $this->release_lock( $lock_name );

                            return $this->create_lock( $lock_name, $release_timeout );
                        }

                    // Update the lock, as by this point we've definitely got a lock, just need to fire the actions.
                    $this->update_lock( $lock_option, time() );

                    return true;
                    
                }

            
            /**
            * Retrieve a lock value
            * 
            * @param mixed $lock_name
            * @param mixed $return_full_row
            */
            private function get_lock( $lock_name, $return_full_row =   FALSE )
                {
                    
                    global $wpdb;
                    
                    $mysq_query =   $wpdb->get_row( $wpdb->prepare("SELECT `site_id`, `meta_key`, `meta_value` FROM  `". $wpdb->sitemeta ."`
                                                                    WHERE `meta_key`    =   %s", $lock_name ) );
                    
                    
                    if ( $return_full_row   === TRUE )
                        return $mysq_query;
                        
                    if ( is_object($mysq_query) && isset ( $mysq_query->meta_value ) )
                        return $mysq_query->meta_value;
                        
                    return FALSE;
                    
                }
                
                
            /**
            * Update lock value
            *     
            * @param mixed $lock_name
            * @param mixed $lock_value
            */
            private function update_lock( $lock_name, $lock_value )
                {
                    
                    global $wpdb;
                    
                    $mysq_query =   $wpdb->query( $wpdb->prepare("UPDATE `". $wpdb->sitemeta ."` 
                                                                    SET meta_value = %s
                                                                    WHERE meta_key = %s", $lock_value, $lock_name) );
                    
                    
                    return $mysq_query;
                    
                }
                
            
            /**
            * Releases an upgrader lock.
            *
            * @param string $lock_name The name of this unique lock.
            * @return bool True if the lock was successfully released. False on failure.
            */
            function release_lock( $lock_name ) 
                {
                    
                    global $wpdb;
                    
                    $lock_option = $lock_name . '.lock';
                    
                    $mysq_query =   $wpdb->query( $wpdb->prepare( "DELETE FROM `". $wpdb->sitemeta ."` 
                                                                    WHERE meta_key = %s", $lock_option ) );
                    
                    return $mysq_query;
                    
                }
                
                
            
            
            /**
            * Delete an opition from all sites
            * 
            * @param mixed $option_name
            */
            function delete_all_sites_option( $option_name )
                {
                        global  $wpdb;
                        
                        $active_sites   =   $this->ms_get_plugin_active_blogs();
                        
                        foreach ( $active_sites as  $active_site) 
                            {
                                $mysql_query    =   "DELETE FROM " . $wpdb->base_prefix . ( $active_site->id > 1 ?  $active_site->id .'_' : '') . "options
                                                            WHERE option_name   =   '". $option_name  ."'";
                                $results   =   $wpdb->get_results( $mysql_query );
                            }
                    
                }
                
                
                
            /**
            * Save the current options list for all sites, to be used further, if any seting changes and rewrite still not applied
            * 
            */
            function  save_current_options_list( $_blog_id = '' )
                {
                    if ( empty ( $_blog_id ) )
                        {
                            global $blog_id; 
                            $_blog_id   =   $blog_id;
                        }
                    
                    $site_modules_settings  =   $this->get_site_modules_settings( $_blog_id );
                    
                    if ( $_blog_id  ==  'network' )                                   
                        update_site_option('wph-previous-options-list', $site_modules_settings);
                        else
                        update_option('wph-previous-options-list', $site_modules_settings);
                    
                }
                
            function save_all_sites_options_list()
                {
                    $active_sites   =   $this->ms_get_plugin_active_blogs();

                    foreach ( $active_sites as  $active_site) 
                        {
                            
                            switch_to_blog( $active_site->blog_id );
                            
                            $this->save_current_options_list( );
                            
                            restore_current_blog();
                            
                        }    
                    
                }
                
                
            
            /**
            * Check any POST actions for this plugin
            * 
            */
            function check_post_actions()
                {
                    
                    //check for rewrite-update-confirm action within SETUP interface
                    if( isset( $_POST['wph-action'] )   &&  $_POST['wph-action']    ==  'ruc'  &&  isset($_POST['_nonce'])  &&  wp_verify_nonce( $_POST['_nonce'], 'ruc-nonce' ) )
                        {
 
                            global $blog_id;
                            
                            $response       =   array();
                            $found_error    =   FALSE;
                            
                            if (is_multisite() )
                                {
                                    
                                    $ms_settings    =   $this->get_site_settings('network');
                                    
                                    if ( $ms_settings['allow_every_site_to_change_options']  ==  'yes')
                                        {
                                            
                                            if ( $this->wph->server_nginx_config   === TRUE )
                                                {
                                                    $nginx_rewrite_status =   $this->nginx_test_sample_rewrite(); 
                                                    
                                                    if  ( $nginx_rewrite_status   === FALSE ) 
                                                        {
                                                            $found_error            =   TRUE;
                                                            $response['status']     =   'error';
                                                            $response['message']    =   __('Rewrite does not appear to apply! Try changing the option "Using Simple Rewrite" and replace on server with new rules.', 'wp-hide-security-enhancer');
                                                        }
                                                        else
                                                        {
                                                            $this->rewrite_applied_correctly_to_site();    
                                                        }
                                                }
                                                else
                                                {
                                               
                                                    $sites  =   $this->ms_get_plugin_active_blogs();
                                                    foreach($sites  as  $site)  
                                                        {
                                                            switch_to_blog( $site->blog_id );
                                                            
                                                            $settings   =   $this->get_site_settings($blog_id);
                                                           
                                                            $get_write_check_string_from_server =   $this->get_write_check_string_from_server();   
                                                            $write_check_string =   isset($settings['write_check_string']) ?    $settings['write_check_string'] :   '';
                                                            if( !empty($write_check_string))
                                                                {
                                                                    if ( $get_write_check_string_from_server ==  $write_check_string )
                                                                        {
                                                                            $this->rewrite_applied_correctly_to_site();
                                                                        }
                                                                        else
                                                                        {   
                                                                            $found_error    =   TRUE;
                                                                        }
                                                                }
                                                                else
                                                                {
                                                                    if ( empty ( $get_write_check_string_from_server ) )
                                                                        {
                                                                            $this->rewrite_applied_correctly_to_site();
                                                                        }
                                                                        else
                                                                        {   
                                                                            $found_error    =   TRUE;
                                                                        }   
                                                                }
                                                   
                                                                    
                                                                    restore_current_blog();
                                                                    
                                                                    if ($found_error === TRUE )
                                                                        break;
                                                        }
                                                        
                                                   
                                                    if ( $found_error   === TRUE )
                                                        {
                                                            $response['status']     =   'error';
                                                            $response['message']    =   __('Unable to retrieve specific environment variables. Please check again the rewrite data on your server.', 'wp-hide-security-enhancer');    
                                                        }
                                         
                                                   
                                                }
                                                 
                                                
                                            if ( $found_error   === FALSE )
                                                {
                                                    delete_site_option( 'wph-rewrite-manual-install' );
                                                    
                                                    $response['status'] =   'success';    
                                                }
                                
                                        }
                                        else
                                        {
                                            if ( $this->wph->server_nginx_config   === TRUE )
                                                {
                                    
                                                    $nginx_rewrite_status =   $this->nginx_test_sample_rewrite(); 
                                                                    
                                                    if  ( $nginx_rewrite_status   === FALSE ) 
                                                        {
                                                            $found_error            =   TRUE;
                                                            $response['status']     =   'error';
                                                            $response['message']    =   __('Rewrite does not appear to apply! Try changing the option "Using Simple Rewrite" and replace on server with new rules.', 'wp-hide-security-enhancer');
                                                        }
                                                        else
                                                        {
                                                            delete_site_option( 'wph-rewrite-manual-install' );
                                                            delete_site_option( 'wph-errors-rewrite-to-file' );
                                            
                                                            $this->save_current_options_list( 'network' );
                                                            $response['status'] =   'success';    
                                                            
                                                        }
                                                }
                                                else
                                                {
                                                    //nothing to check
                                                    delete_site_option( 'wph-rewrite-manual-install' );
                                                    delete_site_option( 'wph-errors-rewrite-to-file' );
                                    
                                                    $this->save_current_options_list( 'network' );
                                                    $response['status'] =   'success';         
                                                    
                                                }
       
                                        }
                                        
                                }
                                else
                                {    
                                    if ( $this->wph->server_nginx_config   === TRUE )
                                        {
                                                
                                            $nginx_rewrite_status =   $this->nginx_test_sample_rewrite(); 
                                                                 
                                            if  ( $nginx_rewrite_status   === FALSE ) 
                                                {
                                                    $found_error            =   TRUE;
                                                    $response['status']     =   'error';
                                                    
                                                    $response['message']    =   __('Rewrite does not appear to apply! Try changing the option "Using Simple Rewrite" and replace on server with new rules.', 'wp-hide-security-enhancer'); 
                                                }
                                                else
                                                {
                                                        
                                                    delete_site_option( 'wph-rewrite-manual-install' );
                                                    delete_site_option( 'wph-errors-rewrite-to-file' );
                                    
                                                    $this->save_current_options_list( 'network' );
                                                            
                                                    $response['status'] =   'success';
                                                }
                                        }
                                        else
                                        {
                                            $settings   =   $this->get_site_settings($blog_id);
                                            
                                            $get_write_check_string_from_server =   $this->get_write_check_string_from_server();
                                            $write_check_string =   isset($settings['write_check_string']) ?    $settings['write_check_string'] :   '';
                                            if( !empty($write_check_string))
                                                {
                                                    if ( $get_write_check_string_from_server ==  $write_check_string )
                                                        {
                                                            $this->rewrite_applied_correctly_to_site();
                                                            $response['status'] =   'success';
                                                        }
                                                        else
                                                        {   
                                                            $found_error            =   TRUE;
                                                            $response['status']     =   'error';
                                                            $response['message']    =   __('Unable to retrieve specific environment variables. Please check again the rewrite data on your server.', 'wp-hide-security-enhancer');
                                                        }
                                                }
                                                else
                                                {
                                                    if ( empty ( $get_write_check_string_from_server ) )
                                                        {
                                                            $this->rewrite_applied_correctly_to_site();
                                                            $response['status'] =   'success';
                                                        }
                                                        else
                                                        {   
                                                            $found_error            =   TRUE;
                                                            $response['status']     =   'error';
                                                            $response['message']    =   __('Unable to retrieve specific environment variables. Please check again the rewrite data on your server.', 'wp-hide-security-enhancer');
                                                        }  
                                                }
                                        }
                                }    
                            
                            echo json_encode( $response );
                            
                            if ( $found_error   === FALSE )
                                wp_logout();
                            
                            die();
                            
                        }
                    
                }
                
                
            /**
            * Try to access a specific sample url to test the rewrite engine functinality
            * 
            */
            function nginx_test_sample_rewrite()
                {
                    
                    $global_settings    =   $this->get_global_settings ( );
                    
                    $response = wp_remote_get( trailingslashit ( site_url() ) . $global_settings['sample_rewrite_hash'] . '/rewrite_test' );
                    
                    if ( is_array( $response ) ) 
                        {
                            
                            if  ( ! isset( $response['response']['code'] )  ||  $response['response']['code'] !=  200 )
                                return FALSE;
                                
                            $body       =   json_decode( $response['body'] );
                            if ( $body  === null || !isset($body->name) )
                                return FALSE;
                                
                                
                            return TRUE;
                                
                        }
                        else if ( is_a( $response, 'WP_Error' ))
                        {
                            //some will return errors:    cURL error 60: SSL certificate problem: unable to get local issuer certificate
                            //presume it works, as there is no other way to retrieve the url
                            if (isset($response->errors)    &&  isset($response->errors['http_request_failed']))
                                {
                                    reset( $response->errors['http_request_failed'] );
                                    if ( strpos( current($response->errors['http_request_failed']), "cURL error 60") !== FALSE )
                                        return TRUE;
                                }
                                
                            return FALSE;
                        }
                          
                    return FALSE;
                
                }    
                
            
            /**
            * Apply appropiate code for site where the rewrite appear to be correct
            *     
            */
            function rewrite_applied_correctly_to_site( )
                {
                    
                    $blog_id_settings   =   $this->get_blog_id();
                    
                    if  ( $blog_id_settings     ==  'network' ) 
                        {
                            delete_site_option('wph-rewrite-manual-install');
                            delete_site_option('wph-errors-rewrite-to-file');   
                        }
                        else
                        {
                            delete_option('wph-rewrite-manual-install');
                            delete_option('wph-errors-rewrite-to-file');
                        }
                    
                                                
                    $this->save_current_options_list( $this->get_blog_id() );
                    
                }
                
            
            /**
            * Specific cache code to run on cron trigger
            * 
            */
            function do_cron_cache()
                {
                    
                    //disabled until figure out a better approach
                    
                        
                    if ( ! is_dir( WPH_CACHE_PATH ) )
                        return FALSE;
                        
                    $files  =   glob(   WPH_CACHE_PATH  .   "*" );

                    foreach ($files as $file) 
                        {
                            if (    !   is_file( $file ))
                                continue;
                                
                            //delete after 5 days
                            if (time() - filemtime( $file ) >= 60 * 60 * 24 * 5) 
                                {
                                    @unlink( $file );
                                }
                        }   
                    
                }
                
                
            
            /**
            * Clear the cache
            * 
            */
            function do_cache_clear()
                {
                    $nonce  =   $_POST['_wpnonce'];
                    if ( ! wp_verify_nonce( $nonce, 'wp-hide-cache-clear' ) )
                        return FALSE;   
                    
                    //only for admins
                    If ( !  current_user_can ( 'manage_options' ) )
                        return FALSE;
                        
                    $this->cache_clear();
                    
                }
                
                
            /**
            * Get cache size
            * 
            */
            function get_cache_size()
                {
                    
                    $dir        =   WPH_CACHE_PATH;
                    $cache_size =   0;
                    
                    if ( is_dir( $dir ) ) 
                        {
                            $objects = scandir( $dir );
                            
                            foreach ($objects as $object) 
                                {
                                    if ( is_file( $dir    .   $object ))
                                        $cache_size++;
                                }
                        }
                
                    
                    return $cache_size;                    
                    
                }
                
            
            
            /**
            * Internal cache clear
            * 
            */
            function cache_clear()
                {
                    
                    do_action('wp-hide/before_cache_clear');
                        
                    $this->rrmdir( WPH_CACHE_PATH, TRUE );
                    
                    //clear any plugin cache data
                    $this->site_cache_clear();
                    
                    do_action('wp-hide/after_cache_clear');   

                }
                
                
            /**
            * Clear any cache plugins
            *     
            */
            function site_cache_clear()
                {
                    if (function_exists('wp_cache_clear_cache'))
                        wp_cache_clear_cache();
                    
                    if (function_exists('w3tc_flush_all'))
                        w3tc_flush_all();
                        
                    if (function_exists('opcache_reset')    &&  ! ini_get( 'opcache.restrict_api' ) )
                        @opcache_reset();
                    
                    if ( function_exists( 'rocket_clean_domain' ) )
                        rocket_clean_domain();
                        
                    if (function_exists('wp_cache_clear_cache')) 
                        wp_cache_clear_cache();
                
                    global $wp_fastest_cache;
                    if ( method_exists( 'WpFastestCache', 'deleteCache' ) && !empty( $wp_fastest_cache ) )
                        $wp_fastest_cache->deleteCache();
                
                    //If your host has installed APC cache this plugin allows you to clear the cache from within WordPress
                    if (function_exists('apc_clear_cache'))
                        apc_clear_cache();

                    //WPEngine
                    if ( class_exists( 'WpeCommon' ) ) 
                        {
                            if ( method_exists( 'WpeCommon', 'purge_memcached' ) )
                                WpeCommon::purge_memcached();
                            if ( method_exists( 'WpeCommon', 'clear_maxcdn_cache' ) )
                                WpeCommon::clear_maxcdn_cache();
                            if ( method_exists( 'WpeCommon', 'purge_varnish_cache' ) )
                                WpeCommon::purge_varnish_cache();
                        }
                        
                    if (class_exists('Cache_Enabler_Disk') && method_exists('Cache_Enabler_Disk', 'clear_cache'))
                        Cache_Enabler_Disk::clear_cache();

                }
            
            
            
            /**
            * Recursivelly remove all fodlers and files within a directory
            * 
            * @param mixed $dir
            */
            function rrmdir( $dir, $xclude_parent   =   FALSE ) 
                {
                    if (is_dir($dir)) 
                        {
                            $objects = scandir($dir);
                            
                            foreach ($objects as $object) 
                                {
                                    if ( is_file( $dir    .   $object ))
                                        @unlink   ( $dir    .   $object);
                                }
                                
                            reset($objects);
                            
                            if($xclude_parent   !== TRUE)
                                rmdir($dir);
                        }
                }
                
            
            /**
            * Filter width htmlspecialchars_decode for multidimensional array 
            *     
            * @param mixed $value
            */
            function filter_htmlspecialchars_decode(    &$value )
                {
                    
                    $value = htmlspecialchars_decode($value);
                        
                }
                
                
            
            
            /**
            * Return the home path relative to domain base
            * e.g. http://develop.com/dev/wp-hide  returns /dev/wp-hide/
            * 
            */
            function get_home_root()
                {
                    
                    if(is_multisite())
                        {
                            $slashed_home      = trailingslashit( network_site_url() );
                            $home_root         = parse_url( $slashed_home, PHP_URL_PATH );   
                            
                        }
                        else
                        {
                            $home_root = parse_url(home_url());
                            if ( isset( $home_root['path'] ) )
                                    $home_root = trailingslashit($home_root['path']);
                                else
                                    $home_root = '/';
                        }
                        
                    return $home_root;   
                    
                }
         
            
            /**
            * Safe Print_r to be used inside buffering
            *     
            * @param mixed $var
            * @param mixed $return
            * @param mixed $html
            * @param mixed $level
            */
            function obsafe_print_r($var, $return = false, $html = false, $level = 0) 
                {
                    $spaces = "";
                    $space = $html ? "&nbsp;" : " ";
                    $newline = $html ? "<br />" : "\n";
                    for ($i = 1; $i <= 6; $i++) {
                        $spaces .= $space;
                    }
                    $tabs = $spaces;
                    for ($i = 1; $i <= $level; $i++) {
                        $tabs .= $spaces;
                    }
                    if (is_array($var)) {
                        $title = "Array";
                    } elseif (is_object($var)) {
                        $title = get_class($var)." Object";
                    }
                    $output = $title . $newline . $newline;
                    foreach($var as $key => $value) {
                        if (is_array($value) || is_object($value)) {
                            $level++;
                            $value = $this->obsafe_print_r($value, true, $html, $level);
                            $level--;
                        }
                        $output .= $tabs . "[" . $key . "] => " . $value . $newline;
                    }
                    if ($return) return $output;
                      else echo $output;
                }
                
            
            /**
            * Save a message log to a debug file
            *     
            * @param mixed $text
            */
            function log_save($text)
                {
                    
                    $myfile     = fopen(WPH_PATH . "/debug.txt", "a") or die("Unable to open file!");
                    $txt        =  $text   .   "\n";
                    fwrite($myfile, $txt);
                    fclose($myfile);   
                    
                }
            
               
        }
        
?>