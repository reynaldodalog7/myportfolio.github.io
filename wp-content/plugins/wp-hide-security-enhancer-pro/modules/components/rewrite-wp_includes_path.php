<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_rewrite_new_include_path extends WPH_module_component
        {
                                    
            function get_component_title()
                {
                    return "WP includes";
                }
            
            function get_module_component_settings()
                {
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'new_include_path',
                                                                    'label'         =>  __('New Includes Path',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('The default theme path is set to',    'wp-hide-security-enhancer') . ' <strong>wp-include</strong>
                                                                                         '. __('More details can be found at',    'wp-hide-security-enhancer') .' <a href="https://www.wp-hide.com/documentation/rewrite-wp-includes/" target="_blank">Link</a>',
                                                                    
                                                                    'value_description' =>  __('e.g. my_includes',    'wp-hide-security-enhancer'),
                                                                    'input_type'    =>  'text',
                                                                    
                                                                    'sanitize_type' =>  array(array($this->wph->functions, 'sanitize_file_path_name')),
                                                                    'processing_order'  =>  20
                                                                    );
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'block_wpinclude_url',
                                                                    'label'         =>  __('Block wp-includes URL',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Block wp-includes files from being accesible through default urls. <br />Apply only if <b>New Includes Path</b> is not empty. It block only for non loged-in users.',    'wp-hide-security-enhancer'),
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                    'processing_order'  =>  21
                                                                    );
                                                                    
                    return $this->component_settings;   
                }
                
                
                
            function _init_new_include_path($saved_field_data)
                {
                    if(empty($saved_field_data))
                        return FALSE;

                    $new_include_path   =   trailingslashit(    home_url()  )   . untrailingslashit(  $saved_field_data    );
                    $this->wph->functions->add_replacement( trailingslashit(    site_url()  ) . 'wp-includes', $new_include_path );

                }
                
            function _callback_saved_new_include_path($saved_field_data)
                {
                    
                    //check if the field is noe empty
                    if(empty($saved_field_data))
                        return  FALSE;
                        
                    $processing_response    =   array(); 
                                                           
                    global $blog_id;
                    if(is_multisite())
                        {
                            $blog_details   =   get_blog_details( $blog_id );
                            $ms_settings    =   $this->wph->functions->get_site_settings('network');
                        }
                        
                    $rewrite                            =  '';
                        
                    $rewrite_base   =   $this->wph->functions->get_rewrite_base( $saved_field_data, FALSE );
                    $rewrite_to     =   $this->wph->functions->get_rewrite_to_base( $this->wph->default_variables['network']['include_path'], TRUE, TRUE, 'full_path' );
                    
                    if($this->wph->server_htaccess_config   === TRUE)           
                        {
                            if( is_multisite()   &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=    "\nRewriteCond %{HTTP_HOST} ^". $blog_details->domain .'$';
                                }
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite .= "\nRewriteRule ^"    .   $rewrite_base   .   '(.+) '. $rewrite_to .'$1 [QSA,END]';
                                }
                                else
                                {
                                    $rewrite .= "\nRewriteRule ^([_0-9a-zA-Z-]+/)?"    .   $rewrite_base   .   '(.+) '. $rewrite_to .'$2 [QSA,END]';    
                                }    
                        }
                        
                    if($this->wph->server_web_config   === TRUE)
                        {
                            $rewrite    =   "\n" . '<rule name="wph-new_include_path" stopProcessing="true">';
                            
                            if(is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=      "\n" .    '   <conditions>'  
                                                    . "\n" .    '       <add input="{HTTP_HOST}" matchType="Pattern" pattern="^'. $blog_details->domain .'$"  />'
                                                    . "\n" .    '   </conditions>';
                                }
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^'.  $rewrite_base   .'(.+)"  />';
                                    $rewrite .=   "\n" .    '    <action type="Rewrite" url="'.  $rewrite_to .'{R:1}"  appendQueryString="true" />';
                                }
                                else
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^([_0-9a-zA-Z-]+/)?'.  $rewrite_base   .'(.+)"  />';
                                    $rewrite .=   "\n" .    '    <action type="Rewrite" url="'.  $rewrite_to .'{R:2}"  appendQueryString="true" />';
                                }
                            
                            $rewrite .=  "\n" . '</rule>';
                        }
                        
                    if($this->wph->server_nginx_config   === TRUE)           
                        {
                            $rewrite        =   array();
                            $rewrite_list   =   array();
                            $rewrite_rules  =   array();
                            
                            $global_settings    =   $this->wph->functions->get_global_settings ( );
                            
                            $home_root_path =   $this->wph->functions->get_home_root();
                               
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite_list['blog_id'] =   $blog_id;
                                    if( is_multisite() )
                                        {
                                            $rewrite_base   =   ltrim($this->wph->functions->string_left_replacement($rewrite_base, ltrim($blog_details->path, '/')));
                                        }
                                }
                                else
                                    $rewrite_list['blog_id'] =   'network';
                                
                            $rewrite_list['type']        =   'location';
                            $rewrite_list['description'] =   '~ ^__WPH_SITES_SLUG__/' . untrailingslashit($rewrite_base) ;
                            
                            if( $global_settings['nginx_generate_simple_rewrite']   !=  'yes' )
                                {
                                    $rewrite_rules[]  =   '         set $wph_remap  "${wph_remap}wp_includes__";';
                                }
                            
                            $rewrite_data   =   '';
                            
                            if( $global_settings['nginx_generate_simple_rewrite']   !=  'yes'   &&  is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite_data  .=    "\n" .'         if ($http_host ~ ^__WPH_SITES_HOST__$ ){';
                                }
                            
                            $rewrite_data .= "\n         rewrite ^". untrailingslashit($home_root_path) ."__WPH_SITES_SLUG__/". $rewrite_base ."(.+) ". $rewrite_to .'$__WPH_REGEX_MATCH_2__ last;';
                                
                            if( $global_settings['nginx_generate_simple_rewrite']   !=  'yes'   &&  is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite_data  .=    "\n         }";
                                }
                            
                            $rewrite_rules[]            =   $rewrite_data;
                            $rewrite_list['data']       =   $rewrite_rules;
                            
                            $rewrite[]  =   $rewrite_list;
                        }
                    
                    $processing_response['rewrite'] =   $rewrite;
                                
                    return  $processing_response;   
                }
                      
                
            function _callback_saved_block_wpinclude_url($saved_field_data)
                {
                    
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                        
                    $processing_response    =   array();
                    
                    global $blog_id;
                    
                    if ( is_multisite() )
                        {
                            $blog_details   =   get_blog_details( $blog_id );
                            $ms_settings    =   $this->wph->functions->get_site_settings('network'); 
                        }
                    
                    //prevent from blocking if the wp-include is not modified
                    $new_path       =   $this->wph->functions->get_site_module_saved_value('new_include_path',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                    if (empty(  $new_path ))
                        return FALSE;
                                        
                    $rewrite                            =  '';
                    
                    $rewrite_base   =   $this->wph->functions->get_rewrite_base( 'wp-includes', FALSE, FALSE, 'wp_path' );
                    $rewrite_to     =   $this->wph->functions->get_rewrite_to_base( 'index.php?wph-throw-404', TRUE, FALSE, 'site_path' );
                    
                    if($this->wph->server_htaccess_config   === TRUE)
                        {                    
                            if(is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
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
                                    $rewrite   .=  "\nRewriteRule ^". $rewrite_base ."(.+) ".  $rewrite_to ." [END]";
                                }
                                else
                                {
                                    $rewrite   .=  "\nRewriteRule ^([_0-9a-zA-Z-]+/)?". $rewrite_base ."(.+) ".  $rewrite_to ." [END]";
                                }
                            
                        }
                    
                    if($this->wph->server_web_config   === TRUE)
                        {
                            $rewrite    =   "\n" . '<rule name="wph-block_wpinclude_url" stopProcessing="true">';
                            
                            if(is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=      "\n" .    '   <conditions>'  
                                                    . "\n" .    '       <add input="{HTTP_HOST}" matchType="Pattern" pattern="^'. $blog_details->domain .'$"  />'
                                                    . "\n" .    '   </conditions>';
                                }
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^'.  $rewrite_base   .'(.+)"  />';
                                    $rewrite .=   "\n" .    '    <action type="Rewrite" url="'.  $rewrite_to .'"  appendQueryString="false" />';
                                }
                                else
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^([_0-9a-zA-Z-]+/)?'.  $rewrite_base   .'(.+)"  />';
                                    $rewrite .=   "\n" .    '    <action type="Rewrite" url="'.  $rewrite_to .'"  appendQueryString="false" />';
                                }
                            
                            $rewrite .=  "\n" . '</rule>';
                            
                        }
                        
                    if($this->wph->server_nginx_config   === TRUE)           
                        {
                            $global_settings    =   $this->wph->functions->get_global_settings ( );
                            
                            $home_root_path =   $this->wph->functions->get_home_root();
                            
                            if ( $global_settings['nginx_generate_simple_rewrite']   ==  'yes' )
                                {
                                    
                                    if ( ! is_multisite()   ||  (   is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'no'   &&  SUBDOMAIN_INSTALL   === FALSE ))
                                        {
                                            $rewrite        =   array();    
                                            $rewrite_list   =   array();
                                            $rewrite_rules  =   array();
                                            
                                            $rewrite_list['blog_id']        =   'network';
                                            $rewrite_list['type']           =   'location';
                                            $rewrite_list['description']    =   '~ ^__WPH_SITES_SLUG__/' . untrailingslashit($rewrite_base) . '(/.*\.php)'; 
                                            
                                            $rewrite_data               =   "rewrite ^". untrailingslashit($home_root_path) ."__WPH_SITES_SLUG__/". $rewrite_base ."(.+) ". $rewrite_to .' last;';    
                                            
                                            $rewrite_rules[]            =   $rewrite_data;
                                            $rewrite_list['data']       =   $rewrite_rules; 
                                            
                                            $rewrite[]                  =   $rewrite_list; 
                                        }
                                    
                                    $processing_response['rewrite'] = $rewrite;            
                                    return  $processing_response;    
                                }
                            
                            if ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes'   &&  SUBDOMAIN_INSTALL   === FALSE )
                                {
                                    $blog_details   =   get_blog_details( $blog_id );
                                    $blog_path      =   trim($blog_details->path, '/');
                                    if ( ! empty ( $blog_path ) )
                                        {
                                            $processing_response['rewrite'] = $rewrite;            
                                            return  $processing_response;  
                                        }
                                }
                            
                            $rewrite        =   array();    
                            $rewrite_list   =   array();
                            $rewrite_rules  =   array();
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite_list['blog_id'] =   $blog_id;
                                    if( is_multisite() )
                                        {
                                            $rewrite_base   =   ltrim($this->wph->functions->string_left_replacement($rewrite_base, ltrim($blog_details->path, '/')));
                                        }
                                }
                                else
                                    $rewrite_list['blog_id'] =   'network';
                                 
                            $rewrite_list['type']        =   'location';
                            $rewrite_list['description'] =   '~ ^__WPH_SITES_SLUG__/' . untrailingslashit($rewrite_base) . '(/.*\.php)';
                            
                            $rewrite_data   =   '';
                            if(is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite_data  .=    "\n" .'         set $conditional_test ""; if ($http_host ~ ^__WPH_SITES_HOST__$ ){ set $conditional_test "${conditional_test}A";}  if ( $wph_remap = "" ) { set $conditional_test "${conditional_test}B"; }';
                                    $rewrite_data  .=    "\n" .'         if ( $conditional_test = AB ){';
                                    $rewrite_data  .=    "\n             rewrite ^__WPH_SITES_SLUG__/". $rewrite_base ."(.+) ". $rewrite_to .' last;';
                                    $rewrite_data  .=    "\n" .'         }';
                                    $rewrite_data  .=    "\n\n         #" . __('REPLACE THE FOLLOWING LINE WITH YOUR OWN INCLUDE! This can be found within block', 'wp-hide-security-enhancer') ."  location ~ \.php$";
                                    $rewrite_data  .=    "\n" .'         include snippets/fastcgi-php.conf; fastcgi_pass unix:/run/php/php7.0-fpm.sock;';
                                    
                                }
                                else
                                {
                                    $rewrite_data  .=    "\n".'         if ( $wph_remap = "" ) {';
                                    $rewrite_data  .= "\n             rewrite ^__WPH_SITES_SLUG__/". $rewrite_base ."(.+) ". $rewrite_to .' last;';
                                    $rewrite_data  .=    "\n         }";                           
                                }
                            
                            $rewrite_rules[]            =   $rewrite_data;
                            $rewrite_list['data']       =   $rewrite_rules;
                            $rewrite[]                  =   $rewrite_list;
                            
                            
                            
                            $rewrite_list   =   array();
                            $rewrite_rules  =   array();
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite_list['blog_id'] =   $blog_id;
                                }
                                else
                                    $rewrite_list['blog_id'] =   'network';
                                    
                            $rewrite_list['type']        =   'location';
                            $rewrite_list['description'] =   '~ ^__WPH_SITES_SLUG__/' . untrailingslashit($rewrite_base) . '';
                                                        
                            $rewrite_data   =   '';
                            if(is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite_data  .=    "\n" .'         set $conditional_test ""; if ($http_host ~ ^__WPH_SITES_HOST__$ ){ set $conditional_test "${conditional_test}A";}  if ( $wph_remap = "" ) { set $conditional_test "${conditional_test}B"; }';
                                    $rewrite_data  .=    "\n" .'         if ( $conditional_test = AB ){';
                                    $rewrite_data  .=    "\n             rewrite ^__WPH_SITES_SLUG__/". $rewrite_base ."(.+) ". $rewrite_to .' last;';
                                    $rewrite_data  .=    "\n" .'         }';
                                }
                                else
                                {
                                    $rewrite_data  .=    "\n".'         if ( $wph_remap = "" ) {';
                                    $rewrite_data  .= "\n             rewrite ^__WPH_SITES_SLUG__/". $rewrite_base ."(.+) ". $rewrite_to .' last;';
                                    $rewrite_data  .=    "\n         }";
                                }
                            
                            $rewrite_rules[]            =   $rewrite_data;
                            $rewrite_list['data']       =   $rewrite_rules;
                            
                            $rewrite[]  =   $rewrite_list;    
                        }
                               
                    $processing_response['rewrite'] = $rewrite;            
                                
                    return  $processing_response;     
                    
                }    
                


        }
?>