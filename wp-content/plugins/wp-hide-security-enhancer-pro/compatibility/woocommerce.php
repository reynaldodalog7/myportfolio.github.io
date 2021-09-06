<?php


    class WPH_conflict_handle_woocommerce
        {
                        
            static function init()
                {
                    add_action('plugins_loaded',        array('WPH_conflict_handle_woocommerce', 'run') , -1);    
                }                        
            
            static function is_plugin_active()
                {
                    
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    
                    if(is_plugin_active( 'woocommerce/woocommerce.php' ))
                        return TRUE;
                        else
                        return FALSE;
                }
            
            static public function run()
                {   
                    if( !   self::is_plugin_active())
                        return FALSE;
                    
                    global $wph;
                                        
                    add_action('woocommerce_product_get_downloads', array('WPH_conflict_handle_woocommerce', 'woocommerce_product_get_downloads'), 99, 2);
                               
                }
                
            static function woocommerce_product_get_downloads( $data, $product)
                {
                    
                    //only when downloading a file
                    if( ! isset($_GET['download_file']) ||  ! isset($_GET['key'])   )
                        return $data;                    
                    
                    if( !is_array( $data )  ||  count( $data ) < 1)
                        return $data;
                    
                    global $wph;
                    
                    //if no change on the upload slug, return as is
                    $new_upload_path    =   $wph->functions->get_site_module_saved_value('new_upload_path');
                    if( empty ( $new_upload_path ) )
                        return $data;
                        
                    foreach ( $data as  $key    =>  $product_download )
                        {
                            $file  =   $product_download->get_file();
                            
                            $replace   =   trailingslashit ( site_url() ) .  $new_upload_path;
                            $replace   =   str_replace(array("http:", "https:") , "", $replace );
                            
                            $replace_with   =   $wph->default_variables['url'] . $wph->default_variables['uploads_directory'];
                            $replace_with   =   str_replace(array("http:", "https:") , "", $replace_with );
                            
                            $file           =   str_replace($replace, $replace_with , $file);
                            
                            //attempt to change back the url
                            $product_download->set_file( $file );
                            
                            $data[$key] =   $product_download;
                            
                        }
                    
                       
                    return $data;    
                }
  
                            
        }
        
        
        
?>