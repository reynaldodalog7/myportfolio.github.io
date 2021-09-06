<?php

    /**
    * Plugin Compatibility      :   Autoptimize
    * Introduced at version     :   2.5.0
    */


    class WPH_conflict_handle_autoptimize
        {
                        
            static function init()
                {
                    if( !   self::is_plugin_active())
                        return FALSE;
                    
                    add_filter( 'autoptimize_css_after_minify',     array( 'WPH_conflict_handle_autoptimize', 'autoptimize_css_after_minify' ), 999);
                    add_filter( 'autoptimize_js_after_minify',      array( 'WPH_conflict_handle_autoptimize', 'autoptimize_js_after_minify' ),  999);
                    
                    //ignore css optimisation if WPH already use CSS combine
                    add_filter( 'autoptimize_filter_css_noptimize', array( 'WPH_conflict_handle_autoptimize', 'autoptimize_filter_css_noptimize' ),  999);
                    //ignore js optimisation if WPH already use JS combine
                    add_filter( 'autoptimize_filter_js_noptimize',  array( 'WPH_conflict_handle_autoptimize', 'autoptimize_filter_js_noptimize' ),  999);
                    
                    
                }                        
            
            static function is_plugin_active()
                {
                    
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    
                    if(is_plugin_active( 'autoptimize/autoptimize.php' ))
                        return TRUE;
                        else
                        return FALSE;
                }
            
            static public function autoptimize_css_after_minify( $code )
                {   
                    global $wph; 
                    
                    //applay the replacements
                    $code  =   $wph->ob_start_callback( $code );
                    
                    return $code;
                                 
                }
                      
            static public function autoptimize_js_after_minify( $code )
                {   
                    global $wph; 

                    //applay the replacements
                    $code  =   $wph->ob_start_callback( $code );
                    
                    return $code;
                                 
                }
            
            
            /**
            * Ignore the JS optmisation if WPH JS Combine turned on
            *     
            * @param mixed $noptimizeJS
            */
            static public function autoptimize_filter_css_noptimize( $noptimizeCSS ) 
                {
                    global $wph;
                    
                    $option__css_combine_code    =   $wph->functions->get_site_module_saved_value('css_combine_code',  $wph->functions->get_blog_id_setting_to_use());
                    if ( $option__css_combine_code   ==  'yes')
                        return TRUE;
                        
                    
                    return $noptimizeJS; 
                    
                }
                
            
            /**
            * Ignore the JS optmisation if WPH JS Combine turned on
            *     
            * @param mixed $noptimizeJS
            */
            static public function autoptimize_filter_js_noptimize( $noptimizeJS ) 
                {
                    global $wph;
                    
                    $option__js_combine_code    =   $wph->functions->get_site_module_saved_value('js_combine_code',  $wph->functions->get_blog_id_setting_to_use());
                    if ( $option__js_combine_code   ==  'yes')
                        return TRUE;
                        
                    
                    return $noptimizeJS; 
                    
                }
                            
        }


?>