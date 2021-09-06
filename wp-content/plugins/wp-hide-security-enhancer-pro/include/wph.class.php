<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH
        {
            
            var $default_variables          =   array();
            var $templates_data             =   array();
            var $urls_replacement           =   array();
            
            /**
            * Preserve text
            * 
            * @var mixed
            */
            var $text_preserve              =   array();
            
            /**
            * Prserve urls
            * 
            * @var mixed
            */
            var $url_preserve               =   array();
            
            var $server_htaccess_config     =   FALSE;
            var $server_web_config          =   FALSE;
            var $server_nginx_config        =   FALSE;
            
            var $modules                    =   array();
            
            /**
            * Disable specific component if need
            * e.g. html minify
            * 
            * @var mixed
            */
            var $disable_components         =   array();
            
            var $settings;
            
            var $functions;
            var $admin_interface;
            
            var $disable_filters            =   FALSE;
            var $disable_ob_start_callback  =   FALSE;
            
            /**
            * Custom rules applied correctly on the server
            * 
            * @var boolean
            */
            var $custom_permalinks_applied  =   FALSE;
            
            /**
            * Doing interfaces processing / save
            * 
            * @var boolean
            */
            var $doing_interface_save       =   FALSE;
            
            var $uninstall                  =   FALSE;
            
            var $is_initialised             =   FALSE;
            
            /**
            * Licence class
            * 
            * @var mixed
            */
            var $licence;
               
            
            /**
            * Constructor
            * 
            */
            function __construct()
                {
                    
                }
     
                
            function init()
                {
                    
                    //return;
                    
                    $this->functions    =   new WPH_functions();
                    
                    $this->functions->check_wp_config();
                    
                    $plugin_data    =   $this->functions->get_plugin_data( WPH_PATH . '/wp-hide.php', $markup = true, $translate = true );
                    define('WPH_CORE_VERSION'   ,   $plugin_data['Version']);
                    
                    define('WPH_PRODUCT_ID'     ,   'wph-pro');
                    define('WPH_INSTANCE'       ,   preg_replace('/:[0-9]+/', '', str_replace(array ("https://" , "http://"), "", network_site_url())));
                    define('WPH_UPDATE_API_URL' ,   'https://www.wp-hide.com/index.php');
                    
                    define('WPH_CACHE_PATH',        WP_CONTENT_DIR . '/cache/wph/' );
                    define('WPH_CACHE_URL',         content_url() . '/cache/wph/' );
                    
                    include_once(WPH_PATH . '/include/class.licence.php');
                    $this->licence      =   new WPH_licence();
                    
                    include_once(WPH_PATH . '/include/class.plugin-updater.php');
                    
                    
                    
                    
                    $this->_init_urls_replacements();
                       
                    $this->_get_default_variables();
                    
                    $this->_do_maintenance();
                                        
                    $this->_load_modules();                    
                    //fill in the settings which does not exists
                    $this->functions->fill_settings();
                    
                    $this->functions->set_server_type();
                    
                    //check for permalink issues
                    $this->custom_permalinks_applied   =   $this->functions->rewrite_rules_applied();
                    
                    $this->is_initialised       =   TRUE;
                    do_action('wp-hide/is_initialised');
                    
                    
                    /**
                    * After this point other code can securely run
                    */
                    
                    //check for recovery link run
                    if(isset($_GET['wph-recovery']))
                        $this->functions->do_recovery();
                    
                    //check for plugin update
                    $this->update();
                    
                    //handle the compatibility
                    $this->plugins_themes_compatibility();
                    
                    //RELOCATED !!
                    $this->_modules_components_run();
                        
                    $this->add_default_replacements();
                    
                    /**
                    * Filters
                    */
                    add_action('plugins_loaded',        array($this,    'plugins_loaded'));
                      
                    //change any links within email message
                    add_filter('wp_mail',               array($this,    'apply_for_wp_mail') , 999);
                    
                    //process redirects
                    add_action('wp_redirect',           array($this,    'wp_redirect') , 999, 2);
                    //hijack a redirect on permalink change
                    add_action('admin_head',            array($this,    'permalink_change_redirect') , 999, 2);
                    
                    add_action('logout_redirect',       array($this,    'logout_redirect') , 999, 3);
                                                            
                    //check if force 404 error
                    add_action('init',                  array($this,    'check_for_404'));
                                                           
                    //general styles
                    add_action('admin_print_styles' ,   array($this,    'admin_print_styles'));
                    
                    add_action('admin_init',            array($this,    'admin_init'), 11);
                    
                    add_action('admin_menu',            array($this,    'admin_menus'));
                    add_action('network_admin_menu',    array($this,    'network_admin_menu') );
                                                            
                    //rebuild and change uppon settings modified
                    add_action('wph/settings_changed',  array($this,    'settings_changed'));
                    add_action('wph/settings_reset',    array($this,    'settings_changed'));
                    
                    //create the static file which contain different environment variables which will be used on router
                    add_action('wph/settings_changed',  array($this,    'environment_check'), 999);
                                                  
                    //apache
                    if(is_network_admin()   === FALSE   &&  $this->server_htaccess_config    === TRUE)                    
                        add_filter('flush_rewrite_rules_hard',      array($this,    'flush_rewrite_rules_hard'), 999);

                    //IIS7 server
                    add_filter('iis7_url_rewrite_rules',            array($this,    'iis_url_rewrite_rules'), 999);
                                                            
                    //ensure the media urls are being saved using default WordPress urls
                    add_action( 'save_post',                        array($this,    'save_post'), 999 );
                    
                    //ensure meta data is being saved using default WordPress urls
                    add_action( 'update_post_metadata',             array($this,    'update_post_metadata'), 999, 5 );
                    
                    //restart the buffering if already outputed. This is usefull for plugin / theme update iframe
                    add_action('admin_print_footer_scripts',        array($this, 'admin_print_footer_scripts'), -1);
                    
                    add_action("after_switch_theme",                array($this,    'after_switch_theme'));
                    
                    //prevent the buffer processing if not filterable available
                    add_filter( 'wp-hide/ignore_ob_start_callback', array($this, 'ignore_ob_start_callback'), 999 );
                    
                    //extend admin bar class
                    if ( is_multisite() )
                        {
                            //add_filter( 'wp_admin_bar_class',    array($this, 'wp_admin_bar_class'), 999 );
                            remove_action( 'template_redirect', '_wp_admin_bar_init', 0 );
                            add_action( 'template_redirect',    array($this,  '_wp_admin_bar_init'), 0 );
                        }
                    
                }
            
            
            /**
            * Update wrapper
            * 
            */
            function update()
                {
                    
                    //no not run on plugin activation
                    if ( isset($_GET['action'])   &&  ( $_GET['action']     ==  'activate-plugin' || $_GET['action']     ==  'activate'  ) )
                        return;
                       
                    //check for update from older version
                    include_once(WPH_PATH . '/include/update.class.php');
                    new WPH_update();   
                    
                }
            
            
            /**
            * Reset the internal variable whihc held the replacements
            * 
            */
            function _init_urls_replacements()
                {
                    
                    $this->urls_replacement           =   array(
                                                                'high'      =>  array(),
                                                                'normal'    =>  array(),
                                                                'low'       =>  array()
                                                                );
                }
            
            
            /**
            * Load modules
            *      
            */
            function _load_modules()
                {
                    
                    $module_files   =   glob(WPH_PATH . "/modules/module-*.php");

                    foreach ($module_files as $filename)
                        {
                            $path_parts = pathinfo($filename);
                                                        
                            include_once(WPH_PATH . '/modules/' .   $path_parts['basename']);
                            
                            $module_name = str_replace('module-' , '', $path_parts['filename']);
                            $module_class_name      =   'WPH_module_'   .   $module_name;
                            $module                 =   new $module_class_name;
                            
                            //filter out components with no settings
                            foreach($module->components     as  $key    =>  $component)
                                {
                                    if ( $component->component_settings === FALSE ||    !is_array($component->component_settings)  ||   count ( $component->component_settings ) < 1 )
                                        unset  ($module->components[ $key ]);
                                }
                            
                            //re-index
                            $module->components =   array_values ( $module->components );
                            
                            //action available for mu-plugins
                            $module =   apply_filters('wp-hide/loaded_module', $module);
                            
                            $interface_menu_data    =   $module->get_interface_menu_data();
                            $menu_position          =   $interface_menu_data['menu_position'];
                            
                            $this->modules[$menu_position]        =   $module;

                        }
                        
                    //sort the modules array
                    ksort($this->modules);
                    
                    //filter available for mu-plugins 
                    $this->modules  =   apply_filters('wp-hide/loaded_modules', $this->modules);

           
                }
                
            
            /**
            * Runt the components of loaded modules
            * 
            */
            function _modules_components_run()
                {
                    
                    global $blog_id;
                    
                    foreach($this->modules  as  $module)
                        {
                            //process the module fields
                            $module_settings  =   $this->functions->filter_settings(   $module->get_module_components_settings(), TRUE    );
                            
                            usort($module_settings, array($this->functions, 'array_sort_by_processing_order'));
                           
                            
                            if($this->disable_filters   ||  $this->custom_permalinks_applied   !== TRUE ||  !is_array($module_settings)   || count($module_settings) < 1)
                                continue;
                            
                            $site_settings  =   $this->functions->get_site_modules_settings_to_apply( $this->functions->get_blog_id_setting_to_use());
                                
                            foreach($module_settings    as  $module_setting)
                                {
                                    
                                    $field_id           =   $module_setting['id'];
                                    $saved_field_value  =   isset($site_settings[ $field_id ]) ?   $site_settings[ $field_id ]    :   '';
                                    
                                    $_ignore_field_id   =   apply_filters( 'wph/components/components_run/ignore_field_id', FALSE, $field_id, $saved_field_value );
                                    
                                    $_class_instance    =   isset($module_setting['class_instance'])  ?   $module_setting['class_instance'] :   $module;
                                    
                                    //ignore callbacks if permalink is turned OFF
                                    if( $this->functions->is_permalink_enabled()    &&  $_ignore_field_id   === FALSE )
                                        {
                                            $_callback              =   isset($module_setting['callback'])  ?   $module_setting['callback'] :   '';
                                            $_callback_arguments    =   isset($module_setting['callback_arguments'])  ?   $module_setting['callback_arguments'] :   '';
                                            
                                            if(empty($_callback))
                                                $_callback      =   '_init_'    .   $field_id;
                                            
                                            if (method_exists($_class_instance, $_callback)   && is_callable(array($_class_instance, $_callback)))
                                                {
                                                    if ( ! empty($_callback_arguments)  &&  is_array($_callback_arguments) &&   count($_callback_arguments) >   0 )
                                                        $processing_data[]  =   call_user_func_array( array($_class_instance, $_callback), array_merge( array( 'field_value'    =>  $saved_field_value), $_callback_arguments));
                                                        else
                                                        $processing_data[]  =   call_user_func(array($_class_instance, $_callback), $saved_field_value);
                                                }
                                        }
                                    
                                    //action available for mu-plugins    
                                    do_action('wp-hide/module_settings_process', $field_id, $saved_field_value, $_class_instance, $module);
                                }   
                        
                        }
                    
                }
            
            
            /**
            * Trigger on plugins_loaded action
            * 
            */
            function plugins_loaded()
                {
                    
                    $this->functions->check_post_actions();   
                    
                }
                   
                
            /**
            * run on admin_init action
            *     
            */
            function admin_init()
                {
                    
                    //not for AJAX
                    if (defined ('DOING_AJAX')      &&  DOING_AJAX  === TRUE )
                        return;
                    
                    include_once(WPH_PATH . '/include/class.environment.php');
                    
                    if  ( ! is_a($this->admin_interface, 'WPH_interface') )
                        {
                            include_once(WPH_PATH . '/include/admin-interface.class.php');
                            $this->admin_interface =    new WPH_interface(); 
                        }
                        
                        
                    //check for cache clear
                    if(isset($_POST['wph-cache-clear']))
                        {
                            $this->functions->do_cache_clear();
                        }
                    
                    //check for settings reset
                    if(isset($_POST['wph-reset-settings']))
                        {
                            $this->admin_interface->reset_settings();
                        }
                     
                    //check for interface submit
                    if( isset($_POST['wph-interface-fields']) )
                        {
                            $this->admin_interface->process_interface_save();
                        }
                        
                    //check for interface licence submit
                    if( isset($_POST['wph_licence_form_submit']) )
                        {
                            $this->admin_interface->process_interface_licence_save();
                        }
                        
                        
                    if  (  $this->server_htaccess_config    === TRUE    &&  strpos($_SERVER['SCRIPT_NAME'], '/plugins.php' ) !== FALSE     &&  ( ( isset ( $_GET['activate'] )   &&   $_GET['activate']   ==  'true' ) ||  ( isset ( $_GET['deactivate'] ) && $_GET['deactivate']   ==  'true' ) ) )
                        {                            
                            //trigger the settings changed action
                            do_action('wph/settings_changed');    
                        }
                        
                    //check for any hide nitice actions
                    $this->admin_interface->notices_hide();
                    
                }
            
               
                
            /**
            * Load styles used sitewide
            * 
            */
            function admin_print_styles()
                {
                    wp_register_style('wph-general', WPH_URL . '/css/wph-general.css');
                    wp_enqueue_style( 'wph-general');    
                }
                
                
            function admin_menus()
                {
                    
                    //output menus for subsites if allow_every_site_to_change_options is yes
                    $network_settings   =   $this->functions->get_site_settings('network');
                    if( is_multisite()    &&  $network_settings['allow_every_site_to_change_options']   == 'no' )
                        return;
                    
                    include_once(WPH_PATH . '/include/admin-interface.class.php');
                    
                    $this->admin_interface =    new WPH_interface(); 
                    
                    $main_menu_slug =   'wp-hide-pro';
                    
                    $menu_title =   'WP Hide';
                    if ( ! is_multisite() )
                        {
                            //check if there's a wph-rewrite-manual-install notice
                            $notice     =   get_site_option('wph-rewrite-manual-install');
                            
                            
                            $licence_data       =   $this->licence->get_licence_data();
                            $licence_expired    =   FALSE;
                            if ( isset( $licence_data ) &&  ! empty ( $licence_data['licence_expire'] ) &&  strtotime( $licence_data['licence_expire'] )  <   strtotime( date('Y-m-d') ) )
                                $licence_expired    =   TRUE;
                            
                            $menu_title =   'WP Hide';
                            if( $notice == 'yes'    ||  $licence_expired ===    TRUE )
                                $menu_title .= ' <span class="update-plugins count-1"><span class="plugin-count">!</span></span>';    
                        }
                                
                    $hookID   =     add_menu_page('WP Hide', $menu_title, 'manage_options', $main_menu_slug);
                    
                    $menu_title =   'Settings';
                    if( $licence_expired ===    TRUE )
                        $menu_title .= ' <span class="update-plugins count-1"><span class="plugin-count">!</span></span>';
                    
                    $hookID   =     add_submenu_page( $main_menu_slug, 'WP Hide', $menu_title, 'manage_options', $main_menu_slug, array($this->admin_interface,'_settings_interface'));
                    add_action('admin_print_styles-' . $hookID ,    array($this->admin_interface, 'admin_print_styles'));
                    add_action('admin_print_scripts-' . $hookID ,   array($this->admin_interface, 'admin_print_scripts'));
                    
                    //add setup interface
                    if ( ! is_multisite() && $this->licence->licence_key_verify())
                        {
                            
                            $menu_title =   'Setup';
                            if( $notice == 'yes')
                                $menu_title .= ' <span class="update-plugins count-1"><span class="plugin-count">!</span></span>';
                            
                            $hookID   =             add_submenu_page( $main_menu_slug, 'WP Hide', $menu_title, 'manage_options', 'wp-hide-setup', array($this->admin_interface,'_setup_interface'));
                            
                            add_action('admin_print_styles-' . $hookID ,    array($this->admin_interface, 'admin_print_styles'));
                            add_action('admin_print_scripts-' . $hookID ,   array($this->admin_interface, 'admin_print_scripts'));
                        }
                    
                    if ( $this->licence->licence_key_verify() ) 
                        {         
                            foreach($this->modules   as  $module)
                                {
                                    $interface_menu_data    =   $module->get_interface_menu_data();
                                                            
                                    $hookID   =             add_submenu_page( $main_menu_slug, 'WP Hide', $interface_menu_data['menu_title'], 'manage_options', $interface_menu_data['menu_slug'], array($this->admin_interface,'_render'));
                                    
                                    add_action('admin_print_styles-' . $hookID ,    array($this->admin_interface, 'admin_print_styles'));
                                    add_action('admin_print_scripts-' . $hookID ,   array($this->admin_interface, 'admin_print_scripts'));
                                }
                        }
                        
                    //admin notices
                    add_action( 'admin_notices',        array($this->admin_interface,   'admin_notices'));
                    add_action( 'admin_notices',        array($this->admin_interface,   'admin_no_key_notices'));
                                        
                }
            
            
            /**
            * Add the menus for superadmin dashboard
            * 
            */
            function network_admin_menu()
                {
                    $settings   =   $this->functions->get_current_site_settings(); 
                    
                    include_once(WPH_PATH . '/include/admin-interface.class.php');
                    
                    $this->admin_interface =    new WPH_interface(); 
                    
                    //check if there's a wph-rewrite-manual-install notice
                    $notice             =   get_site_option('wph-rewrite-manual-install');
                    
                    $licence_data       =   $this->licence->get_licence_data();
                    $licence_expired    =   FALSE;
                    if ( isset( $licence_data ) &&  ! empty ( $licence_data['licence_expire'] ) &&  strtotime( $licence_data['licence_expire'] )  <   strtotime( date('Y-m-d') ) )
                        $licence_expired    =   TRUE;
                       
                    $menu_title =   'WP Hide';
                    if( $notice == 'yes'    ||  $licence_expired ===    TRUE )
                        $menu_title .= ' <span class="update-plugins count-1"><span class="plugin-count">!</span></span>';
                    
                    add_menu_page('WP Hide', $menu_title, 'manage_options', 'network-wp-hide');
                    $hookID   =             add_submenu_page( 'network-wp-hide', 'Network Settings', 'Settings' , 'manage_options', 'network-wp-hide', array($this->admin_interface,'_render_network_settings'));
                    
                    add_action('admin_print_styles-' . $hookID ,    array($this->admin_interface, 'network_admin_print_styles'));
                    add_action('admin_print_scripts-' . $hookID ,   array($this->admin_interface, 'network_admin_print_scripts'));
                    
                    
                    if ( $this->licence->licence_key_verify()  )
                        {
                            $menu_title =   'Setup';
                            if( $notice == 'yes')
                                $menu_title .= ' <span class="update-plugins count-1"><span class="plugin-count">!</span></span>';
                                
                            $hookID     =             add_submenu_page( 'network-wp-hide', 'WP Hide', $menu_title, 'manage_options', 'wp-hide-setup', array($this->admin_interface,'_setup_interface'));
                                    
                            add_action('admin_print_styles-' . $hookID ,    array($this->admin_interface, 'network_admin_print_styles'));
                            add_action('admin_print_scripts-' . $hookID ,   array($this->admin_interface, 'network_admin_print_scripts'));
                        }
         
                    //add menu options if subsites can manage their own settings
                    if ( isset ($settings['allow_every_site_to_change_options'] ) &&    $settings['allow_every_site_to_change_options']   != 'yes'  &&   $this->licence->licence_key_verify()  )
                        {
                            foreach($this->modules   as  $module)
                                {
                                    $interface_menu_data    =   $module->get_interface_menu_data();
                                                            
                                    $hookID   =             add_submenu_page( 'network-wp-hide', 'WP Hide', $interface_menu_data['menu_title'], 'manage_options', $interface_menu_data['menu_slug'], array($this->admin_interface,'_render'));
                                    
                                    add_action('admin_print_styles-' . $hookID ,    array($this->admin_interface, 'admin_print_styles'));
                                    add_action('admin_print_scripts-' . $hookID ,   array($this->admin_interface, 'admin_print_scripts'));        
                                    
                                }
                        }   
                    
                    //admin notices
                    add_action( 'network_admin_notices',        array($this->admin_interface,   'network_admin_notices'));
                    add_action( 'network_admin_notices',        array($this->admin_interface,   'admin_no_key_notices'));   
                    
                }
                
            
            
                        
            /**
            * Buffer Callback. This is the place to replace all data
            *     
            * @param mixed $buffer
            */
            function ob_start_callback( $buffer )
                {
                    
                    if ( empty ( $buffer ) )
                        {
                            //attempt to change the headers urls
                            if(function_exists('apache_response_headers'))
                                {
                                    $response_headers    =   apache_response_headers();
                                }
                                else  
                                    {
                                        if  ( ! is_null ($this->functions) )
                                            $response_headers   =   $this->functions->parseRequestHeaders();
                                    }
                            
                            if  ( ! is_null ($this->functions) )         
                                $this->functions->update_headers ( array ( 'Location' ) ,  $response_headers );
                            
                            return $buffer;
                        }
                        
                    //provide a filter to disable the replacements
                    if  ( apply_filters('wp-hide/ignore_ob_start_callback', FALSE, $buffer)     === TRUE   )
                        return $buffer;
                        
                    //if not initialised, it must be a cached server file
                    if  ( ! $this->is_initialised )
                        return $buffer;
                       
                    if($this->disable_ob_start_callback === TRUE)
                        return $buffer;
                        
                    //check headers fir content-encoding
                    if(function_exists('apache_response_headers'))
                        {
                            $response_headers    =   apache_response_headers();
                        }
                        else  
                            {
                                $response_headers = $this->functions->parseRequestHeaders();
                            }
                            
                    if(isset($response_headers['Content-Encoding']) &&  $response_headers['Content-Encoding']   ==  "gzip")
                        {
                            //Decodes the gzip compressed buffer
                            $decoded    =   gzdecode($buffer);
                            if($decoded === FALSE   ||  $decoded    ==  '')
                                return $buffer;
                                
                            $buffer =   $decoded;
                        }
                      
                    //feetch any text to be preserved
                    $buffer = $this->functions->text_preserve( $buffer ); 
                    
                    $buffer = apply_filters( 'wp-hide/ob_start_callback/pre_replacements', $buffer );                   
                    
                    //retrieve the replacements list
                    $replacement_list   =   $this->functions->get_replacement_list();
                    //$this->functions->log_save( $this->functions->obsafe_print_r ( $replacement_list, true) );
                    
                    //replace the urls
                    $buffer =   $this->functions->content_urls_replacement($buffer,  $replacement_list );
                    
                    $buffer = apply_filters( 'wp-hide/ob_start_callback/text_preserve', $buffer );
                    
                    //put back any preserved text
                    $buffer = $this->functions->text_preserve_restore( $buffer );
                    
                    //retrieve the replacements list
                    $preserved_urls_list   =   $this->functions->get_preserved_list();
                    //replace the urls
                    $buffer =   $this->functions->content_preserved_urls_replacement($buffer,  $preserved_urls_list );
                    
                    $buffer = apply_filters( 'wp-hide/ob_start_callback', $buffer );
                    
                    //check for redirect header and make updates
                    $this->functions->update_headers ( array ( 'Location' ) ,  $response_headers );
                    
                    if(isset($response_headers['Content-Encoding']) &&  $response_headers['Content-Encoding']   ==  "gzip")
                        {
                            //compress the buffer
                            $buffer    =   gzencode($buffer);
                        }
                    
                    return $buffer;
            
                }
                
            
            /**
            * Ignore the buffer processing if the content is not filterable by header content type
            *     
            * @param mixed $ignore
            */
            function ignore_ob_start_callback( $ignore )
                {
                    $is_filterable =   $this->functions->is_filterable_content_type();
                    
                    if ( $ignore ===    FALSE   &&  $is_filterable  === FALSE )
                        $ignore =   TRUE;
                    
                    return $ignore;    
                }
            
            
            /**
            * check for any query and headers change
            * 
            */
            function check_for_404()
                {
                    if(!isset($_GET['wph-throw-404']))
                        return;
                        
                    global $wp_query;

                    $wp_query->set_404();
                    status_header(404);
                    
                    add_action('request',               array($this, 'change_request'), 999);
                    add_action('parse_request',         array($this, 'change_parse_request'), 999);
                    
                    remove_action( 'template_redirect', 'redirect_canonical' );
                    remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );
                                        
                }
                
            
            /**
            * Modify the request data to allow a 404 error page to trigger
            * 
            * @param mixed $query_vars
            */
            function change_request($query_vars)
                {
                    
                    return array();
                       
                }
            
            function change_parse_request( $object )
                {
                    
                    $object->request            =   NULL;
                    $object->matched_rule       =   NULL;
                    $object->matched_query      =   NULL;
                    
                    $object->query_vars['error']    =   404;
                       
                }
            
            function wp_redirect($location, $status)
                {
                    if( $this->uninstall === TRUE    ||  $this->disable_filters   ||  $this->custom_permalinks_applied   !== TRUE )
                        return $location;
                    
                    //do not replace 404 pages
                    global $wp_the_query;
                    
                    if(!is_object($wp_the_query))
                        return $location;
                    
                    if($wp_the_query->is_404())
                        return $location;
                    
                    $location =   $this->functions->content_urls_replacement($location,  $this->functions->get_replacement_list() );
                    
                    /**
                    * Check if register link for to apply the replacement
                    * Unfortunate the default WordPress link does not contain a beginning backslash to make a replacement match in functions->content_urls_replacement
                    */
                    if(preg_match("/(wp-login.php?(.*)?checkemail=registered)/i", $location))
                        {
                            $updated_slug     =   $this->functions->get_site_module_saved_value( 'new_wp_login_php', $this->functions->get_blog_id_setting_to_use() );
                            if ( ! empty(  $updated_slug ))
                                $location =   str_replace('wp-login.php',  $updated_slug,  $location);     
                        }
                                        
                    $location   =   apply_filters('wp-hide/wp_redirect', $location);
                                            
                    return $location; 
                }
                
            
            function logout_redirect($redirect_to, $requested_redirect_to, $user)
                {
                    global $blog_id;
                    
                    $new_wp_login_php     =   $this->functions->get_site_module_saved_value('new_wp_login_php', $blog_id);
                    if (empty(  $new_wp_login_php ))
                        return $redirect_to;
                                        
                    $redirect_to =   str_replace('wp-login.php',  $new_wp_login_php,  $redirect_to);
                        
                    return $redirect_to; 
                }
                
            function get_setting_value($setting_name, $default_value    =   '')
                {
                    $setting_value  =   isset($this->settings['module_settings'][$setting_name])    ?   $this->settings['module_settings'][$setting_name]   :   $default_value;
                    
                    return $setting_value;
                }
                
            function generic_string_replacement($text)
                {
                    $text   =   $this->functions->content_urls_replacement($text,  $this->functions->get_replacement_list() );
                        
                    return $text;   
                    
                }
            
                
            function settings_changed()
                {
                    //always try to clear cache
                    $this->functions->cache_clear();
                    
                    //always presume write data is not possible
                    include_once( WPH_PATH . '/include/class.rewrite-process.php' );
                    WPH_Rewrite_Process::require_manual_setup_add_markers();
                    
                    //allow rewrite
                    if ( is_multisite() &&  is_network_admin() )
                        {
                            //call manually
                            if ( $this->server_htaccess_config  === TRUE )
                                $this->flush_rewrite_rules_hard();
                            if ( $this->server_web_config === TRUE )
                                $this->iis_url_rewrite_rules();
                            if ( $this->server_nginx_config === TRUE )
                                $this->nginx_rewrite_rules();
                        }
                        else
                        {
                            if ( $this->server_nginx_config === TRUE )
                                $this->nginx_rewrite_rules();
                                else
                                flush_rewrite_rules(); 
                        }
                }
            
                
            /**
            * Maintain Environment file 
            * 
            */
            function environment_check()
                {
                    include_once(WPH_PATH . '/include/class.environment.php');
                    $WPH_Environment    =   new WPH_Environment();
                    
                    if ( $WPH_Environment->is_correct_environment() )
                        return;

                    $WPH_Environment->write_environment();

                }
            
            /**
            * Process the rewrite datat for Apache
            * 
            * @param mixed $continue
            */
            function flush_rewrite_rules_hard( $continue    =   '' )
                {
                                        
                    if ( is_multisite() &&  ! is_network_admin() )
                        {
                            $have_lock  =   FALSE;
                            $_attempts  =   0;
                            while( $have_lock ===   FALSE )
                                {
                                    if ( $this->functions->create_lock( 'wph_rewrite_change', 10 ) )
                                        $have_lock  =   TRUE;
                                        else
                                        sleep( 1 );
                                        
                                    $_attempts++;
                                    
                                    if ( $_attempts >   10 )
                                        {
                                            $process_interface_save_errors  =   (array)get_option( 'wph-interface-save-errors');
                                            
                                            $process_interface_save_errors[]    =   array(
                                                                                            'type'      =>  'error',
                                                                                            'message'   =>  __('Server busy, unable to lock. Try again later.', 'wp-hide-security-enhancer')
                                                                                            );
                                            
                                            update_option( 'wph-interface-save-errors', $process_interface_save_errors );
                                             
                                            return;
                                        }
                                }
                        }
                    
                    include_once( WPH_PATH . '/include/class.rewrite-process.php' );
                    $rewrite_process    =   new WPH_Rewrite_Process();
                    
                    $rewrite_process->apache_process_rewrite_rules();
                    
                    //release the lock
                    if ( is_multisite() &&  ! is_network_admin() )
                        $this->functions->release_lock( 'wph_rewrite_change' );
                                               
                    return TRUE;
                        
                }
            
            
            
            /**
            * Process the rewrite data for IIS
            *     
            * @param mixed $wp_rules
            */
            function iis_url_rewrite_rules( $wp_rules  =   '' )
                {
                   
                    if ( is_multisite() &&  ! is_network_admin() )
                        {
                            $have_lock  =   FALSE;
                            $_attempts  =   0;
                            while( $have_lock ===   FALSE )
                                {
                                    if ( $this->functions->create_lock( 'wph_rewrite_change', 10 ) )
                                        $have_lock  =   TRUE;
                                        else
                                        sleep( 1 );
                                        
                                    $_attempts++;
                                    
                                    if ( $_attempts >   10 )
                                        {
                                            $process_interface_save_errors  =   (array)get_option( 'wph-interface-save-errors');
                                            
                                            $process_interface_save_errors[]    =   array(
                                                                                            'type'      =>  'error',
                                                                                            'message'   =>  __('Server busy, unable to lock. Try again later.', 'wp-hide-security-enhancer')
                                                                                            );
                                            
                                            update_option( 'wph-interface-save-errors', $process_interface_save_errors );
                                             
                                            return;
                                        }
                                }
                        }                        
                    
                    include_once( WPH_PATH . '/include/class.rewrite-process.php' );
                    $rewrite_process    =   new WPH_Rewrite_Process();
                    
                    $rewrite_process->iis_process_rewrite_rules();
                    
                    //release the lock
                    if ( is_multisite() &&  ! is_network_admin() )
                        $this->functions->release_lock( 'wph_rewrite_change' );

                    return $wp_rules;
                    
                }
                
                
                
            /**
            * Process the rewrite data for IIS
            *     
            * @param mixed $wp_rules
            */
            function nginx_rewrite_rules( $wp_rules  =   '' )
                {
                    
                    include_once( WPH_PATH . '/include/class.rewrite-process.php' );
                    $rewrite_process    =   new WPH_Rewrite_Process();
                    
                    $rewrite_process->nginx_process_rewrite_rules();


                    return $wp_rules;
                    
                }
                

            
            /**
            * Set default environment data/variables
            * 
            */
            function _get_default_variables()
                {   
                    
                    global $blog_id;
                    
                    //this site url
                    $this->default_variables['url']                 =   untrailingslashit ( site_url() );
                    $this->default_variables['home_url']            =   untrailingslashit ( home_url() );
                    
                    $this->default_variables['include_directory']   =   '/' .   WPINC;
                    
                    //catch the absolute siteurl in case wp folder is different than domain root
                    $this->default_variables['wordpress_directory']    =   '';
                    $this->default_variables['content_directory']      =   '';
                    
                    //content_directory
                    $content_directory   =   trim ( wp_normalize_path ( str_replace(ABSPATH, "", WP_CONTENT_DIR) ) );
                    $this->default_variables['content_directory']       =   '/' .   $content_directory;
                    
                    $plugins_directory   =   trim ( wp_normalize_path ( str_replace(ABSPATH, "", WP_PLUGIN_DIR) ) );
                    $this->default_variables['plugins_directory']       =   '/' .   $plugins_directory;                    
                    
                    $templates_directory   =   trim ( wp_normalize_path ( str_replace(ABSPATH, "", get_theme_root()) ) );
                    $this->default_variables['templates_directory']     =   '/' .   $templates_directory;
                    
                    $wp_upload_dir          =   wp_upload_dir();
                    $uploads_directory      =   trim ( wp_normalize_path ( str_replace(ABSPATH, "", $wp_upload_dir['basedir']) ) );
                    $this->default_variables['uploads_directory']          =   '/' .  $uploads_directory;
                    //upload_url
                    
                    $this->default_variables['template_url']        =   get_bloginfo('template_url');
                    $this->default_variables['stylesheet_uri']      =   get_stylesheet_directory_uri();
                                        
                    $home_url   =   defined('WP_HOME')  ?   WP_HOME         :   get_option('home');
                    $home_url   =   untrailingslashit($home_url);
                    //stripp the protocols to ensure there's no difference from home_ur to site_url 
                    $home_url   =   str_replace(array('http://', 'https://', 'http://www.', 'https://www.'), '', $home_url);
                    
                    $siteurl    =   defined('WP_HOME')  ?   WP_SITEURL      :   get_option('siteurl');
                    $siteurl    =   untrailingslashit($siteurl);
                    //stripp the protocols to ensure there's no difference from home_ur to site_url 
                    $siteurl   =   str_replace(array('http://', 'https://', 'http://www.', 'https://www.'), '', $siteurl);
                    
                    $wp_directory   =   str_replace($home_url, "" , $siteurl);
                    $wp_directory   =   trim(trim($wp_directory), '/');
                    
                    if($wp_directory    !=  '')
                        {
                            $this->default_variables['wordpress_directory'] =   '/' . trim($wp_directory, '/');
                        }
                                            
                    $home_root_path =   $this->functions->get_home_root();
                    
                    $this->default_variables['site_relative_path']  =   $home_root_path;
                    if ( empty ( $this->default_variables['site_relative_path'] ) )
                        $this->default_variables['site_relative_path']  =   '/';
                        
                    
                    //Set Network
                    $slashed_home      = untrailingslashit( network_site_url() );   
                            
                    $this->default_variables['network']['url']                  =   $slashed_home;   
                    
                    $this->default_variables['network']['include_path']         =   '/' . ltrim(WPINC, '/');
                    
                    $this->default_variables['network']['content_path']    =   '/' . $content_directory;
                                        
                    $plugins_url    =   plugins_url();
                    $plugins_url    =   str_replace( untrailingslashit( site_url() ), "", $plugins_url );
                    $this->default_variables['network']['plugins_path']         =   $plugins_url;
                    
                                                
                    //MultiSite
                    if(is_multisite())
                        {
                            global $blog_id;
                            
                            switch_to_blog(1);
                            
                            $wp_upload_dir          =   wp_upload_dir();
                            $this->default_variables['network']['uploads_path']         =  '/' .  trim ( wp_normalize_path ( str_replace(ABSPATH, "", $wp_upload_dir['basedir'] ) ) );
                            
                            restore_current_blog();
                            
                    
                            $blog_details = get_blog_details( $blog_id );
                            $this->default_variables['network']['current_blog_domain']  =   $blog_details->domain;
                            $this->default_variables['network']['current_blog_path']    =   $blog_details->path;
                            
                            $sites_to_process   =   $this->functions->ms_get_plugin_active_blogs();
                            foreach($sites_to_process   as  $site_to_process)        
                                {
                                    switch_to_blog( $site_to_process->blog_id );
                                                            
                                    $data  =  $this->functions->get_site_template_data();   
                                    
                                    $this->templates_data[$site_to_process->blog_id]    =   $data;
                                                 
                                    restore_current_blog();   
                                    
                                }
                        }
                        else
                        {
                            $this->templates_data[$blog_id]    =   $this->functions->get_site_template_data();    
                        }
                    
                }
            
            
            /**
            * Run maintenance tasks
            *     
            */
            function _do_maintenance()
                {
                    
                    $this->_check_required_folders();   
     
     
                    //register a schedule for cache work
                    if (! wp_next_scheduled ( 'WPH_event_cache' )) 
                        {
                            wp_schedule_event(time(), 'daily', 'WPH_event_cache');
                        }
                        
                    add_action('WPH_event_cache', array($this->functions, 'do_cron_cache'));
                    
                }
            
            /**
            * Attempt to create required folders
            * 
            */
            function _check_required_folders()
                {
                    
                    //cache
                    if ( ! is_dir( WPH_CACHE_PATH ) ) 
                        {
                           wp_mkdir_p( WPH_CACHE_PATH );
                        }   
                    
                }
                
            
            /**
            * Apply new changes for e-mail content too
            * 
            * @param mixed $atts
            */
            function apply_for_wp_mail($atts)
                {
                    if ( isset ( $atts['message'] ) )
                        $atts['message'] =   $this->functions->content_urls_replacement($atts['message'],  $this->functions->get_replacement_list() );
                       
                    return $atts;
                       
                }
                
            
            /**
            * Add default Url Replacements
            * 
            */
            function add_default_replacements()
                {
                    
                    do_action('wp-hide/add_default_replacements', $this->urls_replacement);   
                }
       
                
            function after_switch_theme()
                {
                    
                    $this->functions->cache_clear();
                       
                }
                
                
            function permalink_change_redirect()
                {
                    $screen = get_current_screen();
                    
                    if(empty($screen))
                        return;
                       
                    if($screen->base    !=  "options-permalink")
                        return;
                    
                    //recheck if the permalinks where sucesfully saved
                    $this->custom_permalinks_applied   =   $this->functions->rewrite_rules_applied();
                    
                    //ignore if permalinks are available
                    if($this->custom_permalinks_applied   === FALSE )
                        return;
                    
                    global $blog_id;
                                        
                    $new_location   =   trailingslashit(    site_url()  )   . "wp-admin/options-permalink.php";   
                    
                    if($this->functions->is_permalink_enabled())
                        {
                            $blog_id_settings   =   $blog_id;
                            
                            if(is_multisite() )
                                {
                                    $ms_settings    =   $this->functions->get_site_settings('network');
                                    
                                    if( is_multisite()   &&  $ms_settings['allow_every_site_to_change_options']  ==  'no')
                                        $blog_id_settings   =   'network';   
                                }
                            
                            $new_admin_url     =   $this->functions->get_site_module_saved_value('admin_url', $blog_id_settings );
                            if(!empty($new_admin_url))
                                $new_location      =   trailingslashit(    site_url()  )   . $new_admin_url .  "/options-permalink.php";
                        }
                        
                    $new_location   .=  '?settings-updated=true';
                    
                    //no need to redirect if it's on the same path
                    $request_uri    =   $_SERVER['REQUEST_URI'];
                    
                    $new_location_uri   =   $this->functions->get_url_path($new_location, TRUE);
                    if($request_uri ==  $new_location_uri)
                        return;
                    
                    wp_redirect( $new_location  );
                    die();
                }
                
            
            /**
            * General Plugins and Themes compatibility Handle
            *     
            */
            function plugins_themes_compatibility()
                {
                    
                    include_once( WPH_PATH . '/include/class.compatibility.php' );
                    $compatibility_handler    =   new WPH_Compatibility();
                    
                }
 
            
            /**
            * Revert back the files urls to default WordPress
            * 
            * @param mixed $post_id
            */
            function save_post( $post_id )
                {
                    if ( wp_is_post_revision( $post_id ) )
                        return;
                        
                    global $wpdb;
                    
                    //raw retrieve the post data
                    $mysql_query    =   $wpdb->prepare( "SELECT * FROM " .   $wpdb->posts  .  "   WHERE ID    =   %d", $post_id );
                    $post_data      =   $wpdb->get_row( $mysql_query );
                    
                    $replacement_list   =   $this->functions->get_replacement_list();
                    //reverse the list
                    $replacement_list   =   array_flip($replacement_list);
                    
                    //replace the urls
                    $post_content =   $this->functions->content_urls_replacement($post_data->post_content,  $replacement_list );
                    
                    //if there's a difference, update
                    if (  $post_content != $post_data->post_content )
                        {
                            $mysql_query    =   $wpdb->prepare( "   UPDATE " .   $wpdb->posts  .  "
                                                        SET post_content    =   %s   
                                                        WHERE ID    =   %d",  $post_content, $post_id);
                            $result         =   $wpdb->get_results( $mysql_query );
                        }
                    
                }
                
            
            
            /**
            * Revert back the files urls to default WordPress
            * 
            * @param mixed $check
            * @param mixed $object_id
            * @param mixed $meta_key
            * @param mixed $meta_value
            * @param mixed $prev_value
            */
            function update_post_metadata ( $check, $object_id, $meta_key, $meta_value, $prev_value)
                {
                    global $wpdb;
                    
                    $meta_type      =   'post';
                    
                    $table          = _get_meta_table( $meta_type );
                    $column         = sanitize_key( $meta_type . '_id' );
                    $id_column      = 'user' == $meta_type ? 'umeta_id' : 'meta_id';
                    
                    $replacement_list   =   $this->functions->get_replacement_list();
                    //reverse the list
                    $replacement_list   =   array_flip($replacement_list);
                    //replace the urls
                    $meta_value         =   $this->functions->content_urls_replacement( $meta_value,  $replacement_list );
                    
                    $raw_meta_key = $meta_key;
                    $passed_value   = $meta_value;
                       
                    // Compare existing value to new value if no prev value given and the key exists only once.
                    if ( empty( $prev_value ) ) {
                        $old_value = get_metadata( $meta_type, $object_id, $meta_key );
                        if ( count( $old_value ) == 1 ) {
                            if ( $old_value[0] === $meta_value ) {
                                return false;
                            }
                        }
                    }

                    $meta_ids = $wpdb->get_col( $wpdb->prepare( "SELECT $id_column FROM $table WHERE meta_key = %s AND $column = %d", $meta_key, $object_id ) );
                    if ( empty( $meta_ids ) ) {
                        return add_metadata( $meta_type, $object_id, $raw_meta_key, $passed_value );
                    }

                    $_meta_value = $meta_value;
                    $meta_value  = maybe_serialize( $meta_value );

                    $data  = compact( 'meta_value' );
                    $where = array(
                        $column    => $object_id,
                        'meta_key' => $meta_key,
                    );

                    if ( ! empty( $prev_value ) ) {
                        $prev_value          = maybe_serialize( $prev_value );
                        $where['meta_value'] = $prev_value;
                    }

                    foreach ( $meta_ids as $meta_id ) {
                        /**
                         * Fires immediately before updating metadata of a specific type.
                         *
                         * The dynamic portion of the hook, `$meta_type`, refers to the meta
                         * object type (comment, post, term, or user).
                         *
                         * @since 2.9.0
                         *
                         * @param int    $meta_id     ID of the metadata entry to update.
                         * @param int    $object_id   Object ID.
                         * @param string $meta_key    Meta key.
                         * @param mixed  $_meta_value Meta value.
                         */
                        do_action( "update_{$meta_type}_meta", $meta_id, $object_id, $meta_key, $_meta_value );

                        if ( 'post' == $meta_type ) {
                            /**
                             * Fires immediately before updating a post's metadata.
                             *
                             * @since 2.9.0
                             *
                             * @param int    $meta_id    ID of metadata entry to update.
                             * @param int    $object_id  Post ID.
                             * @param string $meta_key   Meta key.
                             * @param mixed  $meta_value Meta value. This will be a PHP-serialized string representation of the value if
                             *                           the value is an array, an object, or itself a PHP-serialized string.
                             */
                            do_action( 'update_postmeta', $meta_id, $object_id, $meta_key, $meta_value );
                        }
                    }

                    $result = $wpdb->update( $table, $data, $where );
                    if ( ! $result ) {
                        return false;
                    }

                    wp_cache_delete( $object_id, $meta_type . '_meta' );

                    foreach ( $meta_ids as $meta_id ) {
                        /**
                         * Fires immediately after updating metadata of a specific type.
                         *
                         * The dynamic portion of the hook, `$meta_type`, refers to the meta
                         * object type (comment, post, term, or user).
                         *
                         * @since 2.9.0
                         *
                         * @param int    $meta_id     ID of updated metadata entry.
                         * @param int    $object_id   Object ID.
                         * @param string $meta_key    Meta key.
                         * @param mixed  $_meta_value Meta value.
                         */
                        do_action( "updated_{$meta_type}_meta", $meta_id, $object_id, $meta_key, $_meta_value );

                        if ( 'post' == $meta_type ) {
                            /**
                             * Fires immediately after updating a post's metadata.
                             *
                             * @since 2.9.0
                             *
                             * @param int    $meta_id    ID of updated metadata entry.
                             * @param int    $object_id  Post ID.
                             * @param string $meta_key   Meta key.
                             * @param mixed  $meta_value Meta value. This will be a PHP-serialized string representation of the value if
                             *                           the value is an array, an object, or itself a PHP-serialized string.
                             */
                            do_action( 'updated_postmeta', $meta_id, $object_id, $meta_key, $meta_value );
                        }
                    }

                    return true;   
                    
                }
                
            
            /**
            * Restart the bufering if turned off already
            *             
            */
            function admin_print_footer_scripts()
                {
                    if ( ob_get_level() < 1 )
                        ob_start( array($this, 'ob_start_callback'));    
                }
                
            
            /**
            * Incldue custom class for admin bar
            *     
            */
            function _wp_admin_bar_init( $class )
                {
                    global $wp_admin_bar;

                    if ( ! is_admin_bar_showing() ) {
                        return false;
                    }

                    /* Load the admin bar class code ready for instantiation */
                    include_once( WPH_PATH  . 'include/class.custom-admin-bar.php');

                    /* Instantiate the admin bar */

                    /**
                     * Filters the admin bar class to instantiate.
                     *
                     * @since 3.1.0
                     *
                     * @param string $wp_admin_bar_class Admin bar class to use. Default 'WP_Admin_Bar'.
                     */
                    $admin_bar_class = 'WP_Admin_Bar';
                    if ( class_exists( $admin_bar_class ) ) 
                        $wp_admin_bar = new $admin_bar_class; 
                    else 
                        return false;
                    
                    $wp_admin_bar->initialize();
                    $wp_admin_bar->add_menus();

                    return true;
                    
                }
            
            
        } 


?>