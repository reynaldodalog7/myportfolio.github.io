<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_rewrite_new_xml_rpc_path extends WPH_module_component
        {
            
            function get_component_title()
                {
                    return "XML-RPC";
                }
                                                
            function get_module_component_settings()
                {
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'new_xml_rpc_path',
                                                                    'label'         =>  __('New XML-RPC Path',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('The default XML-RPC path is set to xmlrpc.php. If not used you can leave empty and block the service using the following area.',    'wp-hide-security-enhancer'),
                                                                    
                                                                    'value_description' =>  __('e.g. my-xml-rpc.php',    'wp-hide-security-enhancer'),
                                                                    'input_type'    =>  'text',
                                                                    
                                                                    'sanitize_type' =>  array(array($this->wph->functions, 'sanitize_file_path_name')),
                                                                    'processing_order'  =>  50
                                                                    );
                                                                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'block_xml_rpc',
                                                                    'label'         =>  __('Block default xmlrpc.php',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('XML-RPC gives others the ability to talk to your WordPress site. If not used you should disable. Keep in mind that some plugins like Jetpack use this API.',    'wp-hide-security-enhancer'),
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                    'processing_order'  =>  55
                                                                    
                                                                    );
                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'disable_xml_rpc_auth',
                                                                    'label'         =>  __('Disable XML-RPC authentication',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Filter whether XML-RPC methods requiring authentication, such as for publishing purposes, are enabled.',    'wp-hide-security-enhancer'),
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                    'processing_order'  =>  55
                                                                    
                                                                    );
                                                                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'remove_xml_rpc_tag',
                                                                    'label'         =>  __('Remove pingback',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Remove pingback link tag from theme.',    'wp-hide-security-enhancer'),
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                    'processing_order'  =>  58
                                                                    
                                                                    );
                                                                    
                    return $this->component_settings;   
                }
                
                
                
            function _init_new_xml_rpc_path($saved_field_data)
                {
                    if(empty($saved_field_data))
                        return FALSE;
                    
                    //add default plugin path replacement
                    $old_url    =   trailingslashit(    site_url()  )   . 'xmlrpc.php';
                    $new_url    =   trailingslashit(    home_url()  )   . $saved_field_data;
                    $this->wph->functions->add_replacement( $old_url ,  $new_url );
                }
                
            function _callback_saved_new_xml_rpc_path($saved_field_data)
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
                    
                    $rewrite_base       =   $this->wph->functions->get_rewrite_base( $saved_field_data, FALSE, FALSE );
                    $rewrite_to         =   $this->wph->functions->get_rewrite_to_base( 'xmlrpc.php' , TRUE, FALSE, 'full_path' );
                               
                    if($this->wph->server_htaccess_config   === TRUE)
                        {
                            if( is_multisite()    &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=    "\nRewriteCond %{HTTP_HOST} ^". $blog_details->domain .'$';
                                }
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite  .= "\nRewriteRule ^"    .   $rewrite_base  .   ' '. $rewrite_to .' [END,QSA]';
                                }
                                else
                                {
                                    $rewrite  .= "\nRewriteRule ^([_0-9a-zA-Z-]+/)?"    .   $rewrite_base  .   ' '. $rewrite_to .' [END,QSA]';    
                                }
                        }
                    
                    if($this->wph->server_web_config   === TRUE)
                        {
                            $rewrite    =   "\n" . '<rule name="wph-new_xml_rpc_path" stopProcessing="true">';
                            
                            if(is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=      "\n" .    '   <conditions>'  
                                                    . "\n" .    '       <add input="{HTTP_HOST}" matchType="Pattern" pattern="^'. $blog_details->domain .'$"  />'
                                                    . "\n" .    '   </conditions>';
                                }
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^'.  $rewrite_base   .'"  />';
                                    $rewrite .=   "\n" .    '    <action type="Rewrite" url="'.  $rewrite_to .'"  appendQueryString="true" />';
                                }
                                else
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^([_0-9a-zA-Z-]+/)?'.  $rewrite_base   .'"  />';
                                    $rewrite .=   "\n" .    '    <action type="Rewrite" url="'.  $rewrite_to .'"  appendQueryString="true" />';
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
                                    $rewrite_rules[]  =   '         set $wph_remap  "${wph_remap}xml_rpc__";';
                                }
                            
                            $rewrite_data   =   '';
                            
                            if( $global_settings['nginx_generate_simple_rewrite']   !=  'yes'   &&  is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite_data  .=    "\n" .'         if ($http_host ~ ^__WPH_SITES_HOST__$ ){';
                                }
                            
                            $rewrite_data .= "\n         rewrite ^". untrailingslashit($home_root_path) ."__WPH_SITES_SLUG__/". $rewrite_base ." ". $rewrite_to .' last;';
                                
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
                
   
            function _callback_saved_block_xml_rpc($saved_field_data)
                {
                    
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                        
                    $processing_response    =   array();
                    
                    global $blog_id;
                    
                    $_blog_id   =   $blog_id;
                    if ( is_multisite() )
                        {
                            $blog_details   =   get_blog_details( $blog_id );
                            $ms_settings    =   $this->wph->functions->get_site_settings('network'); 
                            if ( $ms_settings['allow_every_site_to_change_options']  !=  'yes' )
                                $_blog_id   =   'network';
                        }
                        
                    $rewrite                            =  '';
                                        
                    $rewrite_base       =   $this->wph->functions->get_rewrite_base( 'xmlrpc.php', FALSE, FALSE, 'wp_path' );
                    $rewrite_to         =   $this->wph->functions->get_rewrite_to_base( 'index.php?wph-throw-404' , TRUE, FALSE, 'site_path' );
                    
                    if($this->wph->server_htaccess_config   === TRUE)
                        {                                        
                            if( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
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
                                    $rewrite   .=   "\nRewriteRule ^" . $rewrite_base . " ".  $rewrite_to ." [END]";
                                }
                                else
                                {
                                    $rewrite   .=   "\nRewriteRule ^([_0-9a-zA-Z-]+/)?" . $rewrite_base . " ".  $rewrite_to ." [END]";
                                }
                            
                        }
                    
                    if($this->wph->server_web_config   === TRUE)
                        {
                            $rewrite    =   "\n" . '<rule name="wph-block_xml_rpc" stopProcessing="true">';
                            
                            if(is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=      "\n" .    '   <conditions>'  
                                                    . "\n" .    '       <add input="{HTTP_HOST}" matchType="Pattern" pattern="^'. $blog_details->domain .'$"  />'
                                                    . "\n" .    '   </conditions>';
                                }
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^'.  $rewrite_base   .'"  />';
                                    $rewrite .=   "\n" .    '    <action type="Rewrite" url="'.  $rewrite_to .'"  appendQueryString="false" />';
                                }
                                else
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^([_0-9a-zA-Z-]+/)?'.  $rewrite_base   .'"  />';
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
                                            $rewrite_list['description']    =   '~ ^__WPH_SITES_SLUG__/' . untrailingslashit($rewrite_base);
                                            
                                            $rewrite_data               =   "rewrite ^". untrailingslashit($home_root_path) ."__WPH_SITES_SLUG__/". $rewrite_base ." ". $rewrite_to .' last;';    
                                            
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
                                    $rewrite_data  .=    "\n             rewrite ^__WPH_SITES_SLUG__/". $rewrite_base ." ". $rewrite_to .' last;';
                                    $rewrite_data  .=    "\n" .'         }';  
                                    $rewrite_data  .=    "\n\n         #" . __('REPLACE THE FOLLOWING LINE WITH YOUR OWN INCLUDE! This can be found within block', 'wp-hide-security-enhancer') ."  location ~ \.php$";
                                    $rewrite_data  .=    "\n" .'         include snippets/fastcgi-php.conf; fastcgi_pass unix:/run/php/php7.0-fpm.sock;';
                                }
                                else
                                {
                                    $rewrite_data  .=    "\n".'         if ( $wph_remap = "" ) {';
                                    $rewrite_data  .= "\n             rewrite ^__WPH_SITES_SLUG__/". $rewrite_base ." ". $rewrite_to .' last;';
                                    $rewrite_data  .=    "\n         }";
                                    $rewrite_data  .=    "\n\n         #" . __('REPLACE THE FOLLOWING LINE WITH YOUR OWN INCLUDE! This can be found within block', 'wp-hide-security-enhancer') ."  location ~ \.php$";
                                    $rewrite_data  .=    "\n" .'         include snippets/fastcgi-php.conf; fastcgi_pass unix:/run/php/php7.0-fpm.sock;';
                                }                            
                            
                            $rewrite_rules[]            =   $rewrite_data;
                            $rewrite_list['data']       =   $rewrite_rules;
                            
                            $rewrite[]  =   $rewrite_list;    
                        }    
                    
                    
                               
                    $processing_response['rewrite'] = $rewrite;            
                                
                    return  $processing_response;     
                    
                    
                }
                
            function _init_disable_xml_rpc_auth($saved_field_data)
                {
                    
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                    
                    
                    add_filter( 'xmlrpc_enabled', '__return_false' ); 
                    
                }
            
                
            function _init_remove_xml_rpc_tag($saved_field_data)
                {
                    
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                    
                    
                    add_filter('wp-hide/ob_start_callback', array($this, 'remove_xml_rpc_tag'));
                    
                }
                
                
            function remove_xml_rpc_tag( $buffer )
                {
                    
                    $result   = preg_match_all('/(<link([^>]+)rel=("|\')pingback("|\')([^>]+)?\/?>)/im', $buffer, $founds);
    
                    if(!isset($founds[0])   ||  count($founds[0])    <   1)
                        return $buffer;
    
                    if(count($founds[0]) > 0)
                        {
                            foreach ($founds[0]  as  $found)
                                {
                                    if(empty($found))
                                        continue;

                                    $buffer =   str_replace($found, "", $buffer);
                                    
                                }
                            
                            
                        }
                    
                    return $buffer;
     
                }


        }
?>