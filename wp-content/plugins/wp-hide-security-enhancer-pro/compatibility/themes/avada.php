<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_conflict_theme_avada
        {
                        
            static function init()
                {
                    add_action('plugins_loaded',        array('WPH_conflict_theme_avada', 'run') , -1);    
                }                        
              
            static public function run()
                {   
                    
                    global $wph;
                                        
                    add_filter ('fusion_dynamic_css_final', array('WPH_conflict_theme_avada', 'url_replacement'), 999);
                    
                    //flush avada cache when settings changes
                    add_action('wph/settings_changed',  'avada_reset_all_caches');
                               
                }
                 
            static function url_replacement( $buffer )
                {
                    
                    global $wph;
                                        
                    $buffer =   $wph->ob_start_callback( $buffer );
                    
                    return $buffer;
     
                }
                            
        }
        
        
    WPH_conflict_theme_avada::init();


?>