<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_rewrite_slash extends WPH_module_component
        {
            function get_component_title()
                {
                    return "URL Slash";
                }
                                        
            function get_module_component_settings()
                {
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'add_slash',
                                                                    'label'         =>  __('URL\'s add Slash',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Add an end slash to any links without. This disguise any existance uppon a file, folder or a wrong url, they will be all slashed.',    'wp-hide-security-enhancer') . '<br /> '.   __('On certain systems this can produce a small lag measured in milliseconds.',    'wp-hide-security-enhancer'),

                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                    'processing_order'  =>  3
                                                                    );
                                                                    
                    return $this->component_settings;   
                }
                
            
            function _init_add_slash($saved_field_data)
                {
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return;
                        
                    //nothing to do at the moment
                }
                
            function _callback_saved_add_slash($saved_field_data)
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
                        
                    $rewrite                            =  '';
         
                    $rewrite_base       =   $this->wph->functions->get_rewrite_base( '', FALSE, FALSE );
                                    
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
                                    $rewrite    .=  "\nRewriteCond %{REQUEST_URI} /+[^\.]+$";
                                    $rewrite    .=  "\nRewriteCond %{REQUEST_METHOD} !POST";
                                    $rewrite    .=  "\nRewriteRule ^" . $rewrite_base . "(.+[^/])$ %{REQUEST_URI}/ [R=301,END]";
                                }
                                else
                                {
                                    $rewrite    .=  "\nRewriteCond %{REQUEST_URI} (/[_0-9a-zA-Z-]+/)?/+[^\.]+$";
                                    $rewrite    .=  "\nRewriteCond %{REQUEST_METHOD} !POST";
                                    $rewrite    .=  "\nRewriteRule ^([_0-9a-zA-Z-]+/)?" . $rewrite_base . "(.+[^/])$ %{REQUEST_URI}/ [R=301,END]";
                                }   
                            
                                                            
                        }
                                                            
                    if($this->wph->server_web_config   === TRUE)
                        {
                            $rewrite    =   "\n" . '<rule name="wph-add_slash" stopProcessing="true">';
                            $rewrite  .=      "\n" .    '   <conditions>';
                            if(is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=      "\n" .    '   <add input="{HTTP_HOST}" matchType="Pattern" pattern="^'. $blog_details->domain .'$"  />';
                                }
                            $rewrite  .=      "\n" .    '   <add input="{REQUEST_URI}" matchType="Pattern" pattern="/+[^\.]+$"  />';
                            $rewrite  .=      "\n" .    '   </conditions>';
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^(.+[^/])$" />';
                                    $rewrite .=   "\n" .    '    <action type="Redirect" redirectType="Permanent" url="{R:1}/" />';
                                }
                                else
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^(.+[^/])$" />';
                                    $rewrite .=   "\n" .    '    <action type="Redirect" redirectType="Permanent" url="{R:1}/" />';
                                }
                            
                            $rewrite .=  "\n" . '</rule>';
                  
                        }
                        
                    if($this->wph->server_nginx_config   === TRUE)           
                        {
                            //Not implemented
                               
                        }
                    
                    $processing_response['rewrite'] = $rewrite;
                                    
                    return  $processing_response;   
                }
                
           
         

        }
?>