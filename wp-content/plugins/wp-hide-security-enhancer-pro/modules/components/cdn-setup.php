<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_cdn_setup extends WPH_module_component
        {
            function get_component_title()
                {
                    return "CDN";
                }
                                    
            function get_module_component_settings()
                {
                    $this->module_settings[]                  =   array(
                                                                    'id'            =>  'cdn_url',
                                                                    'label'         =>  __('CDN Url',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Some CDN providers (like stackpath.com ) replace site assets with custom url, enter here such url. Oterwise this option should stay empy.', 'wp-hide-security-enhancer'),
                                                                    
                                                                    'input_type'    =>  'text',
                                                         
                                                                    
                                                                    'sanitize_type' =>  array()
                                                                    
                                                                    );
                                                                    
                    $this->module_settings[]                  =   array(
                                                                    'id'            =>  'cdn_use_for_cache_files',
                                                                    'label'         =>  __('Load Cache Files through CDN',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('When creating Cache files, mainly used when using CSS Combine and JavaScript Cobine, the cache files should be loaded through CDN.', 'wp-hide-security-enhancer'),
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                    'processing_order'  =>  80
                                                                    );
                                                                    
                    $this->module_settings[]                  =   array(
                                                                    'id'            =>  'cdn_use_for_assets_inside_cache_files',
                                                                    'label'         =>  __('Load assets within Cache Files through CDN',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('When creating Cache files, mainly used when using CSS Combine and JavaScript Cobine, any assets ( images, fonts) inside cache files should be loaded through CDN.', 'wp-hide-security-enhancer'),
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                    'processing_order'  =>  80
                                                                    );
                                                                    
                    return $this->module_settings;   
                }
                
                
                
            function _init_scripts_remove_version($saved_field_data)
                {
   
                    
                }


        }
?>