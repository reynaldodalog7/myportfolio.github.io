<?php

     if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
     
     class WPH_Compatibility
        {
            
            var $wph                            =   '';
            var $functions                      =   '';
         
            function __construct()
                {
                    global $wph;

                    $this->wph          =   $wph;
                    $this->functions    =   new WPH_functions();
                    
                    $this->init();
                    
                }
                
                
                
            function init()
                {
                    
                    /**
                    * General
                    */
                    include_once(WPH_PATH . 'compatibility/general.php');
                    
                       
                    //w3-cache compatibility handle
                    include_once(WPH_PATH . 'compatibility/w3-cache.php');
                    WPH_conflict_handle_w3_cache::init();
                    
                    //super-cache compatibility handle
                    include_once(WPH_PATH . 'compatibility/super-cache.php');
                    WPH_conflict_handle_super_cache::init(); 
                    
                    //BuddyPress handle
                    include_once(WPH_PATH . 'compatibility/buddypress.php');
                    WPH_conflict_handle_BuddyPress::init();                    
                    
                    
                    //WP Fastest Cache handle
                    include_once(WPH_PATH . 'compatibility/wp-fastest-cache.php');
                    WPH_conflict_handle_wp_fastest_cache::init();
                    
                    //WP Rocket
                    include_once(WPH_PATH . 'compatibility/wp-rocket.php');
                    WPH_conflict_handle_wp_rocket::init();
                                        
                    //WooCommerce
                    include_once(WPH_PATH . 'compatibility/woocommerce.php');
                    WPH_conflict_handle_woocommerce::init();
                    
                    //WPML
                    include_once(WPH_PATH . 'compatibility/wpml.php');
                    WPH_conflict_handle_wpml::init();   
                    
                    //WooGlobalCart
                    include_once(WPH_PATH . 'compatibility/woo-global-cart.php');
                    WPH_conflict_handle_wgc::init();
                    
                    //ShortPixel Adaptive Images
                    include_once(WPH_PATH . 'compatibility/shortpixel-adaptive-images.php');
                    WPH_conflict_shortpixel_ai::init();
                    
                    //Elementor
                    include_once(WPH_PATH . 'compatibility/elementor.php');
                    WPH_conflict_elementor::init();
                    
                    //Hummingbird
                    include_once(WPH_PATH . 'compatibility/wp-hummingbird.php');
                    WPH_conflict_handle_hummingbird::init();
                    
                    //Autoptimize
                    include_once(WPH_PATH . 'compatibility/autoptimize.php');
                    WPH_conflict_handle_autoptimize::init();
                    
                    //Easy Digital Downloads
                    include_once(WPH_PATH . 'compatibility/easy-digital-downloads.php');
                    
                    //Comet Cache
                    include_once(WPH_PATH . 'compatibility/comet-cache.php');
                    
                    //Comet Cache
                    include_once(WPH_PATH . 'compatibility/fusion-builder.php');
                    
                    //Comet Cache
                    include_once(WPH_PATH . 'compatibility/wordpress-seo-premium.php');
                    
                    //WP Optimize
                    include_once(WPH_PATH . 'compatibility/wp-optimize.php');
                    
                    
                    /**
                    * Servers             
                    */
                    include_once(WPH_PATH . 'compatibility/host/kinsta.php');
                    
                    /**
                    * Themes
                    */
                    
                    $theme  =   wp_get_theme();
                    
                    if( ! $theme instanceof WP_Theme )
                        return FALSE;
                        
                    $compatibility_themes   =   array(
                                                        'avada'             =>  'avada.php',
                                                        'divi'              =>  'divi.php',
                                                        );
                    
                    if (isset( $theme->template ) )
                        {
                            
                            foreach ( $compatibility_themes as  $theme_slug     =>  $compatibility_file )
                                {
                                    if ( strtolower( $theme->template ) == $theme_slug  ||   strtolower( $theme->display( 'Name' ) ) == $theme_slug )
                                        {
                                            include_once(WPH_PATH . 'compatibility/themes/' .   $compatibility_file );    
                                        }
                                }
                              
                        }
      
                          
                    do_action('wph/compatibility/init');
                    
                }
            
    
                
        }   
            



?>