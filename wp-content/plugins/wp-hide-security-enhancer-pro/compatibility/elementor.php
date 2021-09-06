<?php

/**
* Compatibility for Plugin Name: Elementor
* Compatibility checked on Version: 2.5.16
*/

    use Elementor\Core\Files\Manager as Files_Manager;
    
    class WPH_conflict_elementor
        {
                        
            static function init()
                {
                    if( !   self::is_plugin_active())
                        return FALSE;
                    
                    global $wph;
                    
                    add_action( 'wph/settings_changed',         array( 'WPH_conflict_elementor',    'settings_changed') );
                    
                    //change any internal urls
                    //add_action( 'elementor/element/parse_css',  array( 'WPH_conflict_elementor',    'elementor_element_parse_css') ); 
                    
                    if ( isset( $_GET['elementor-preview'] ) )                    
                        add_filter ('wph/components/css_combine_code', '__return_false');
                        
                    add_filter( 'wph/components/components_run/ignore_field_id', array( 'WPH_conflict_elementor',    'ignore_field_id'), 999, 3 );
                    
                    //filter the urls of the outputed widget content since there's no way to catch the outrputed buffer, elementor does this on it's own..
                    add_filter( 'elementor/widget/render_content',              array( 'WPH_conflict_elementor', 'elementor_widget_render_content'), 999, 2);
                }                        
            
            static function is_plugin_active()
                {
                    
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    
                    if(is_plugin_active( 'elementor/elementor.php' ))
                        return TRUE;
                        else
                        return FALSE;
                }
                
                
            static function settings_changed()
                {
                    
                    $files_manager = new Files_Manager();
                    $files_manager->clear_cache();
                    
                }
                
            
            static function ignore_field_id( $ignore_field, $field_id, $saved_field_value )
                {
                    
                    if  ( in_array( $field_id, array( 'js_combine_code', 'css_combine_code' ) ) )
                        {
                            if  (  isset( $_GET['elementor-preview'] ) )
                                {
                                    $ignore_field   =   TRUE;
                                }
                            
                        }
                    
                    return $ignore_field;
                    
                }
                
            static function elementor_widget_render_content( $widget_content, $class )
                {
                    global $wph;
                    
                    //do replacements for this url
                    $widget_content    =   $wph->functions->content_urls_replacement($widget_content,  $wph->functions->get_replacement_list() );                    
                                       
                    return $widget_content;
                }
                            
        }


?>