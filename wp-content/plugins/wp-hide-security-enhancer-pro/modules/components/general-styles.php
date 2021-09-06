<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_general_styles extends WPH_module_component
        {
            function get_component_title()
                {
                    return "Styles";
                }
                                    
            function get_module_component_settings()
                {
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'styles_remove_version',
                                                                    'label'         =>  __('Remove Version',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Remove version number from enqueued style files.', 'wp-hide-security-enhancer'),
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array('sanitize_title', 'strtolower')
                                                                    
                                                                    );
                                                                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'styles_remove_id_attribute',
                                                                    'label'         =>  __('Remove ID from link tags',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Remove ID attribute from all link tags which include a stylesheet.', 'wp-hide-security-enhancer'),
                                                                    
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
                
                
                
            function _init_styles_remove_version($saved_field_data)
                {
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                        
                    add_filter( 'style_loader_src',         array(&$this, 'remove_file_version'), 999 );
                    
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
                
                
            function _init_styles_remove_id_attribute( $saved_field_data )
                {
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                    
                    //run only on front syde
                    if( defined('WP_ADMIN') &&  ( !defined('DOING_AJAX') ||  ( defined('DOING_AJAX') && DOING_AJAX === FALSE )) && ! apply_filters('wph/components/force_run_on_admin', FALSE ) )
                        return;
                        
                    add_filter( 'wp-hide/ob_start_callback',         array(&$this, 'ob_start_callback_remove_id'));
                    
                }
                
            
            /**
            * Replace all ID's attribute for link tags
            * 
            * @param mixed $buffer
            */
            function ob_start_callback_remove_id( $buffer )
                {
                    
                    $result   = preg_match_all('/(<link([^>]+)rel=("|\')stylesheet("|\')([^>]+)?\/?>)/im', $buffer, $founds);
    
                    if(!isset($founds[0])   ||  count($founds[0])    <   1)
                        return $buffer;
    
                    if(count($founds[0]) > 0)
                        {
                            foreach ($founds[0]  as  $found)
                                {
                                    if(empty($found))
                                        continue;
                                        
                                    $found_replacement  =   preg_replace( '/(id=("|\')(.*?)("|\') )/i', "", $found );
                                    $buffer =   str_replace($found, $found_replacement, $buffer);
                                    
                                }
                            
                            
                        }
                    
                    return $buffer;
                       
                }
 

        }
?>