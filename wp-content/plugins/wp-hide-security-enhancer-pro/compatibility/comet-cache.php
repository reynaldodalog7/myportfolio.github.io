<?php

                               
    class WPH_conflict_handle_comet_cache
        {
                        
            static function init()
                {
                    if( !   self::is_plugin_active())
                        return FALSE;
                    add_action('plugins_loaded',        array('WPH_conflict_handle_comet_cache', 'run') , -1);    
                }                        
            
            static function is_plugin_active()
                {
                    
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    
                    if(is_plugin_active( 'comet-cache/comet-cache.php' ))
                        return TRUE;
                        else
                        return FALSE;
                }
            
            static function run()
                {   
                    global $wph;
                                        
                    add_action('plugins_loaded', array('WPH_conflict_handle_comet_cache', 'plugins_loaded'));
                               
                }
                
            static function plugins_loaded()
                {
                    ob_start(array('WPH_conflict_handle_comet_cache', "callback"));
                }
            
            
            static function callback( $content )
                {
                    
                    global $wph; 
                    
                    //applay the replacements
                    $content  =   $wph->ob_start_callback( $content );
                    
                    return $content;
                    
                }
                            
        }

        WPH_conflict_handle_comet_cache::init();

        
?>