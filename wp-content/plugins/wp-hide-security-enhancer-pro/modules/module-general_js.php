<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_general_js extends WPH_module
        {
      
            function load_components()
                {
                    
                    //add components
                    include_once(WPH_PATH . "/modules/components/general-js-combine.php");
                    $this->components[]  =   new WPH_module_general_js_combine();
                    
                    include_once(WPH_PATH . "/modules/components/general-js-variables-replace.php");
                    $this->components[]  =   new WPH_module_general_js_variables_replace();
                    
                    //action available for mu-plugins
                    do_action('wp-hide/module_load_components', $this);
                    
                }
            
            function use_tabs()
                {
                    
                    return TRUE;
                }
            
            function get_module_id()
                {
                    
                    return 'general-js';
                }
                
            function get_module_slug()
                {
                    
                    return 'wp-hide-general-js';   
                }
    
            function get_interface_menu_data()
                {
                    $interface_data                     =   array();
                    
                    $interface_data['menu_title']       =   __('General / JavaScript',    'wp-hide-security-enhancer');
                    $interface_data['menu_slug']        =   self::get_module_slug();
                    $interface_data['menu_position']    =   40;
                    
                    return $interface_data;
                }
    
            function get_interface_data()
                {
      
                    $interface_data                     =   array();
                    
                    $interface_data['title']              =   __('WP Hide & Security Enhancer - General / JavaScript',    'wp-hide-security-enhancer');
                    $interface_data['description']        =   '';
                    $interface_data['handle_title']       =   '';
                    
                    return $interface_data;
                    
                }

                
        }
    
 
?>