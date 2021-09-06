<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_general_feed extends WPH_module_component
        {
            function get_component_title()
                {
                    return "Feed";
                }
                                        
            function get_module_component_settings()
                {
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'remove_feed_links',
                                                                    'label'         =>  __('Remove feed|rdf|rss|rss2|atom links',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Remove feed|rdf|rss|rss2|atom links within head. Also block such content functionality.',  'wp-hide-security-enhancer'),
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    );
                                                                    
                    $this->component_settings[]                  =   array(
                                                                        'id'            =>  'block_feed_links',
                                                                        'label'         =>  __('Block feed|rdf|rss|rss2|atom links',            'wp-hide-security-enhancer'),
                                                                        'description'   =>  __('Block default feed|rdf|rss|rss2|atom links.',    'wp-hide-security-enhancer'),
                                                                        
                                                                        'input_type'    =>  'radio',
                                                                        'options'       =>  array(
                                                                                                    'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                    'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                    ),
                                                                        'default_value' =>  'no',
                                          
                                                                        
                                                                        ); 
                  
                                                                    
                    return $this->component_settings;   
                }
                
                
                
            function _init_remove_feed_links($saved_field_data)
                {
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                        
                    remove_action('wp_head',    'feed_links',          2);
                    remove_action('wp_head',    'feed_links_extra',    3); 
 
                    
                }
                          
            function _callback_saved_block_feed_links($saved_field_data)
                {

                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                    
                    $processing_response    =   array();
                    
                    global $blog_id;
                    if(is_multisite())
                        {
                            $blog_details   =   get_blog_details( $blog_id );
                            $ms_settings    =   $this->wph->functions->get_site_settings('network');
                        }
                                                         
                    $rewrite                            =  '';
                    
                    $rewrite_to     =   $this->wph->functions->get_rewrite_to_base( 'index.php?wph-throw-404', TRUE, FALSE, 'site_path' );
                    
                    if($this->wph->server_htaccess_config   === TRUE)                               
                        {
                            if(is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=    "\nRewriteCond %{HTTP_HOST} ^". $blog_details->domain .'$';
                                    //prevent blocking other subdirectory
                                    if ( (  $blog_id   ==     '1'   ||    $blog_details->path ==  '/'  ) &&  SUBDOMAIN_INSTALL   === FALSE)
                                        {
                                            $rewrite  .=    "\n" . 'RewriteCond %{ENV:REDIRECT_WPH_IS_SUBSITE} !^ON$';
                                        }
                                }
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite    .=      "\nRewriteCond %{REQUEST_URI} ([^/]+)/(feed|rdf|rss|rss2|atom)/?$  [OR]"
                                                    .   "\nRewriteCond %{REQUEST_URI} ^(feed|rdf|rss|rss2|atom)/?$"
                                                    .   "\nRewriteRule . ". $rewrite_to ." [END]";
                                }
                                else
                                {
                                    $rewrite    .=      "\nRewriteCond %{REQUEST_URI} ([^/]+)/(feed|rdf|rss|rss2|atom)/?$  [OR]"
                                                    .   "\nRewriteCond %{REQUEST_URI} ^/(feed|rdf|rss|rss2|atom)/?$"
                                                    .   "\nRewriteRule . ". $rewrite_to ." [END]";    
                                }
                              
                        }
                        
                    if($this->wph->server_web_config   === TRUE)
                        {
                            //Not implemented   
                            
                        }
                    
                    $processing_response['rewrite'] =   $rewrite;                                       
                                      
                    return  $processing_response;     
                    
                    
                }    
            
        }

?>