<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_general_scripts extends WPH_module_component
        {
            function get_component_title()
                {
                    return "Scripts";
                }
                                    
            function get_module_component_settings()
                {
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'scripts_remove_version',
                                                                    'label'         =>  __('Remove Version',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Remove version number from enqueued script files.', 'wp-hide-security-enhancer'),
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array('sanitize_title', 'strtolower')
                                                                    
                                                                    );
                                                                    
                    return $this->component_settings;   
                }
                
                
                
            function _init_scripts_remove_version($saved_field_data)
                {
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                        
                    add_filter( 'script_loader_src',        array(&$this, 'remove_file_version'), 999 );   
                    
                }
                
            function remove_file_version($src)
                {
                    
                    if( empty($src) )   
                        return $src;
                        
                    $parse_url  =   parse_url( $src );
                    
                    if(empty($parse_url['query']))
                        return $src;
                    
                    parse_str( $parse_url['query'], $query );
                    
                    if(!isset( $query['ver'] ))
                        return $src;
                    
                    unset($query['ver']);    
                    
                    $parse_url['query'] =   http_build_query( $query );
                    if(empty($parse_url['query']))
                        unset( $parse_url['query'] );
                    
                    $url    =   $this->wph->functions->build_parsed_url( $parse_url );
                    
                    return $url;
                    
                }


        }
?>