<?php

/**
* Compatibility for Plugin Name: Yoast SEO Premium
* Compatibility checked on Version: 11.4
*/


    class WPH_conflict_handle_yseop
        {
                        
            static function init()
                {
                    if( !   self::is_plugin_active())
                        return FALSE;
                    
                    add_action('plugins_loaded',        array('WPH_conflict_handle_yseop', 'run') , -1);    
                }                        
            
            static function is_plugin_active()
                {
                    
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    
                    if(is_plugin_active( 'wordpress-seo-premium/wp-seo-premium.php' )   ||  is_plugin_active( 'wordpress-seo/wp-seo.php' ) )
                        return TRUE;
                        else
                        return FALSE;
                }
            
            static public function run()
                {   
                                        
                    global $wph;
                                        
                    add_filter ( 'wpseo_stylesheet_url' , array('WPH_conflict_handle_yseop', 'urls_replacement'), 10, 2);
                               
                }
                 
            static function urls_replacement( $block )
                {
                    global $wph;
                    
                    $replacement_list   =   $wph->functions->get_replacement_list();
                                            
                    //replace the urls
                    $block =   $wph->functions->content_urls_replacement( $block,  $replacement_list );    
                    
                    return $block;    
                }
                            
        }
        
        
    WPH_conflict_handle_yseop::init();


?>