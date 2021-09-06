<?php


    class WPH_conflict_handle_wp_fastest_cache
        {
                        
            static function init()
                {
                    if( !   self::is_plugin_active())
                        return FALSE;
                        
                    add_filter( 'wpfc_buffer_callback_filter', array( 'WPH_conflict_handle_wp_fastest_cache' , 'wpfc_cache_callback_filter' ), 99, 2 );   
                }                        
            
            static function is_plugin_active()
                {
                    
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    
                    if(is_plugin_active( 'wp-fastest-cache/wpFastestCache.php' ))
                        return TRUE;
                        else
                        return FALSE;
                }
            
            static function wpfc_cache_callback_filter( $buffer, $extension )
                {
                    
                    global $wph;
                    
                    switch ( $extension ) 
                        {
                            case  'css' :
                                            $WPH_module_general_css_combine =   new WPH_module_general_css_combine();
                                            
                                            $option__css_combine_code    =   $wph->functions->get_site_module_saved_value('css_combine_code',  $wph->functions->get_blog_id_setting_to_use());
                                            if ( $option__css_combine_code   !=  'yes')
                                                $buffer =   $WPH_module_general_css_combine->_process_url_replacements( $buffer );
                                            break;
                                            
                            case  'js' :
                                            $WPH_module_general_js_combine =   new WPH_module_general_js_combine();
                                            
                                            $option__js_combine_code    =   $wph->functions->get_site_module_saved_value('js_combine_code',  $wph->functions->get_blog_id_setting_to_use());
                                            if ( $option__js_combine_code   !=  'yes')
                                                $buffer =   $WPH_module_general_js_combine->_process_url_replacements( $buffer );
                                            
                                            break;   
                            
                            default:
                                            
                                            $buffer =   $wph->ob_start_callback( $buffer );
                                            break;        
                        }
                    
                                        
                    return $buffer;
                        
                }
   
        }


?>