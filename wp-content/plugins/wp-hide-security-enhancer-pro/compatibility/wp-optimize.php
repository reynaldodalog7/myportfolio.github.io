<?php

/**
* Compatibility for Plugin Name: WP-Optimize - Clean, Compress, Cache
* Compatibility checked on Version: 3.0.11
*/

    class WPH_conflict_handle_wp_optimize
        {
                        
            static function init()
                {
                    if( !   self::is_plugin_active())
                        return FALSE;
                        
                    add_filter( 'wpo_pre_cache_buffer', array( 'WPH_conflict_handle_wp_optimize' , 'wpo_pre_cache_buffer' ), 99, 2 );   
                }                        
            
            static function is_plugin_active()
                {
                    
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    
                    if(is_plugin_active( 'wp-optimize/wp-optimize.php' ))
                        return TRUE;
                        else
                        return FALSE;
                }
            
            static function wpo_pre_cache_buffer( $buffer, $flags )
                {
                    
                    global $wph;
                    
                    $buffer =   $wph->ob_start_callback( $buffer );                    
                                        
                    return $buffer;
                        
                }
   
        }
        
    WPH_conflict_handle_wp_optimize::init();


?>