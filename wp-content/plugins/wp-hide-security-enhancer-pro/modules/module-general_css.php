<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_general_css extends WPH_module
        {
      
            function load_components()
                {
                    
                    //add components
                    include_once(WPH_PATH . "/modules/components/general-css-combine.php");
                    $this->components[]  =   new WPH_module_general_css_combine();
                    
                    include_once(WPH_PATH . "/modules/components/general-css-id-replace.php");
                    $this->components[]  =   new WPH_module_general_css_id_replace();
                    
                    include_once(WPH_PATH . "/modules/components/general-css-class-replace.php");
                    $this->components[]  =   new WPH_module_general_css_class_replace();
                    
                    //action available for mu-plugins
                    do_action('wp-hide/module_load_components', $this);
                    
                }
            
            function use_tabs()
                {
                    
                    return TRUE;
                }
            
            function get_module_id()
                {
                    
                    return 'general-css';
                }
                
            function get_module_slug()
                {
                    
                    return 'wp-hide-general-css';   
                }
    
            function get_interface_menu_data()
                {
                    $interface_data                     =   array();
                    
                    $interface_data['menu_title']       =   __('General / CSS',    'wp-hide-security-enhancer');
                    $interface_data['menu_slug']        =   self::get_module_slug();
                    $interface_data['menu_position']    =   30;
                    
                    return $interface_data;
                }
    
            function get_interface_data()
                {
      
                    $interface_data                     =   array();
                    
                    $interface_data['title']              =   __('WP Hide & Security Enhancer - General / CSS',    'wp-hide-security-enhancer');
                    $interface_data['description']        =   '';
                    $interface_data['handle_title']       =   '';
                    
                    return $interface_data;
                    
                }

                
        }
    
 
?>