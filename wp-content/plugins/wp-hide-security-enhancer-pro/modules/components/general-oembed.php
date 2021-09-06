<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_general_oembed extends WPH_module_component
        {
            function get_component_title()
                {
                    return "Oembed";
                }
                                    
            function get_module_component_settings()
                {
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'remove_oembed',
                                                                    'label'         =>  __('Remove Oembed',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Remove Oembed tags from header.', 'wp-hide-security-enhancer') . ' ' .
                                                                                        __('More details at ', 'wp-hide-security-enhancer') . '<a target="_blank" href="https://www.wp-hide.com/request-headers/">Oembed</a>',
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                    'processing_order'  =>  75
                                                                    );
                                                                    
                    return $this->component_settings;   
                }
                
            function _init_remove_oembed($saved_field_data)
                {
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                        
                    remove_action( 'wp_head',                'wp_oembed_add_discovery_links'         );
                    remove_action( 'wp_head',                'wp_oembed_add_host_js'                 );
                    
                }

        }
?>