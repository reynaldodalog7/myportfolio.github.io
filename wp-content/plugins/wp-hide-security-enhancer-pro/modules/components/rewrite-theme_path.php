<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_rewrite_new_theme_path extends WPH_module_component
        {
            
            var $rewrite_global_output      =   FALSE;
            
            
            function get_component_title()
                {
                    return "Theme";
                }
            
                                     
            function get_module_component_settings()
                {
                    
                    $this->component_settings   =   array();
                       
                    $all_templates      =   $this->wph->functions->get_themes();
                    $all_templates      =   $this->wph->functions->parse_themes_headers($all_templates);    
               
                    $first  =   TRUE;
                    
                    if  (! is_array($all_templates))
                        return $this->component_settings;
                    
                    foreach ($all_templates as  $theme_slug =>  $theme_data )
                        {
                                 
                            if ( ! $first ) 
                                {
                                    $this->component_settings[]                  =   array(
                                                                        'type'            =>  'split',
                                                                        
                                                                        );   
                                }
                            
                            
                            $component_settings         =   $this->_get_component_theme_settings( $theme_slug, $theme_data); 
                            $this->component_settings   =   array_merge($this->component_settings, $component_settings);   
                            
                            
                            $first  =   FALSE;
                        }
                    
                    return $this->component_settings;
                     
                }
                
            
            
            function _get_component_theme_settings( $theme_slug, $theme_data)
                {
                    
                    $component_settings =   array();
                        
                    $component_settings[]                  =   array(
                                                                                'id'                =>  'new_theme_path_' . $theme_slug,
                                                                                'label'             =>  $theme_data['headers']['Name'] .'<br /><br />' .
                                                                                                        __('New Theme Path',    'wp-hide-security-enhancer'),
                                                                                'description'       =>  __('More details can be found at',    'wp-hide-security-enhancer') .' <a href="https://www.wp-hide.com/documentation/rewrite-theme/" target="_blank">Link</a>',
                                                                                
                                                                                'value_description' =>  __('e.g. my_template',    'wp-hide-security-enhancer'),
                                                                                'input_type'        =>  'text',
                                                                                
                                                                                'sanitize_type'     =>  array('sanitize_title', 'strtolower'),
                                                                                'processing_order'  =>  10,
                                                                                
                                                                                'callback'          =>  '_init_new_theme_path',
                                                                                'callback_saved'    =>  '_callback_saved_new_theme_path',
                                                                                'callback_arguments'=>  array('theme_slug'  =>  $theme_slug ),
                                                                                
                                                                                'display_conditions'=>  array( array($this, '_display_condition_available_for_site'))
                                                                                );
    
                        
                    $component_settings[]                  =   array(
                                                                                'id'            =>  'new_style_file_path_' . $theme_slug,
                                                                                'label'         =>  __('New Style File Path',    'wp-hide-security-enhancer'),
                                                                                'description'   =>  __('Change the default thme style filename to something else.',    'wp-hide-security-enhancer'),
                                                                                                                                                    
                                                                                'value_description' =>  __('e.g. custom-style-file.css',    'wp-hide-security-enhancer'),
                                                                                'input_type'    =>  'text',
                                                                                
                                                                                'sanitize_type' =>  array(array($this->wph->functions, 'sanitize_file_path_name'), array($this->wph->functions, 'extension_required', array('extension' => 'css'))),
                                                                                
                                                                                'processing_order'  =>  5,
                                                                                
                                                                                'callback'          =>  '_init_new_style_file_path',
                                                                                'callback_saved'    =>  '_callback_saved_new_style_file_path',
                                                                                'callback_arguments'=>  array('theme_slug'  =>  $theme_slug ),
                                                                                
                                                                                'display_conditions'=>  array( array($this, '_display_condition_available_for_site'))
                                                                                );
                    
                    
                    $component_description  =   array(
                                                        __('Strip out all meta data from style file e.g. Theme Name, Theme URI, Author etc. Those are important information to find out possible theme security breaches.',    'wp-hide-security-enhancer'),
                                                        __('This feature may not work if style file url not available on html (being concatenated).',    'wp-hide-security-enhancer'),
                                                        ''
                                                        );                                                
                        
                    $component_settings[]                  =   array(
                                                                        'id'            =>  'style_file_clean_' . $theme_slug,
                                                                        'label'         =>  __('Remove description header from Style file',    'wp-hide-security-enhancer'),
                                                                        'description'   =>  $component_description,
                                                                        
                                                                        'input_type'    =>  'radio',
                                                                        'options'       =>  array(
                                                                                                    'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                    'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                    ),
                                                                        'default_value' =>  'no',
                                                                        
                                                                        'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                        'processing_order'  =>  3,
                                                                        
                                                                        'callback'          =>  '_init_style_file_clean',
                                                                        'callback_saved'    =>  '_callback_saved_style_file_clean',
                                                                        'callback_arguments'=>  array('theme_slug'  =>  $theme_slug ),
                                                                        
                                                                        'display_conditions'=>  array( array($this, '_display_condition_available_for_site'))
                                                                        
                                                                        );
                
                    return $component_settings;
                
                }    
                
                
            /**
            * New Theme Path
            *     
            * @param mixed $saved_field_data
            */
            function _init_new_theme_path( $saved_field_data, $theme_slug )
                {
                    if(empty($saved_field_data))
                        return FALSE;

                    //add replacement url
                    $this->wph->functions->add_replacement( untrailingslashit( $this->wph->default_variables['url']) . trailingslashit( $this->wph->default_variables['templates_directory'] ) . trailingslashit( $theme_slug ) , trailingslashit( trailingslashit(    $this->wph->default_variables['home_url'])  )   .   trailingslashit( $saved_field_data ) );

                }
                
            function _callback_saved_new_theme_path( $saved_field_data, $theme_slug )
                {
                    $processing_response    =   array();
                    
                    //check if the field is noe empty
                    if(empty($saved_field_data))
                        return  FALSE; 
          
                    global $blog_id;
                    if(is_multisite())
                        {
                            $blog_details   =   get_blog_details( $blog_id );
                            $ms_settings    =   $this->wph->functions->get_site_settings('network');
                        }
          
                    $rewrite    =   '';
                        
                    $theme_path     =   trailingslashit( $this->wph->default_variables['templates_directory'] ) . trailingslashit( $theme_slug );
                    $theme_path     =   str_replace(' ', '%20', $theme_path);
                    
                    $rewrite_base   =   $this->wph->functions->get_rewrite_base( $saved_field_data, FALSE );
                    $rewrite_to     =   $this->wph->functions->get_rewrite_to_base( $theme_path, TRUE, TRUE, 'full_path' );
                               
                    if($this->wph->server_htaccess_config   === TRUE)
                        {
                            if( is_multisite() && $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=    "\nRewriteCond %{HTTP_HOST} ^". $blog_details->domain .'$';
                                }
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite .= "\nRewriteRule ^"    .   $rewrite_base   .   '(.+) '. $rewrite_to .'$1 [END,QSA]';
                                }
                                else
                                {
                                    $rewrite .= "\nRewriteRule ^([_0-9a-zA-Z-]+/)?"    .   $rewrite_base   .   '(.+) '. $rewrite_to .'$2 [QSA,END]';
                                }
                        }
                    
                    if($this->wph->server_web_config   === TRUE)
                        {
                            $rewrite    =   "\n" . '<rule name="wph-new_theme_path_'. $theme_slug .'" stopProcessing="true">';
                            
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
                                    $rewrite_rules[]  =   '         set $wph_remap  "${wph_remap}theme__";';
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
                      
          
            function _init_new_style_file_path( $saved_field_data, $theme_slug )
                {
                    if(empty($saved_field_data))
                        return FALSE;
                    
                    if($this->wph->functions->is_theme_customize())
                        return;    

                    $new_theme_path     =   $this->wph->functions->get_site_module_saved_value('new_theme_path_' . $theme_slug,  $this->wph->functions->get_blog_id_setting_to_use(), 'display' );
                    
                    //add default replacements
                    $template_url           =   untrailingslashit( $this->wph->default_variables['url']) . trailingslashit( $this->wph->default_variables['templates_directory'] ) . $theme_slug;
                    $old_style_file_path    =   trailingslashit( $template_url ) .   'style.css';
                    
                    if(!empty($new_theme_path))
                        {
                            $new_style_file_path    =  trailingslashit(    $this->wph->default_variables['home_url']  )   .   trailingslashit($new_theme_path) . $saved_field_data;
                            $this->wph->functions->add_replacement( $old_style_file_path ,  $new_style_file_path );
                        }
                        else
                        {
                            $new_style_file_path    =  trailingslashit( $template_url  )  .   $saved_field_data;
                            $this->wph->functions->add_replacement( $old_style_file_path ,  $new_style_file_path );
                        }
                            
                    
           
                    //add replacement for style.css when already template name replaced
                    if(!empty($new_theme_path))
                        {
                            $old_style_file_path    =   trailingslashit(    site_url()  ) . trailingslashit( $new_theme_path ) . 'style.css';
                            $this->wph->functions->add_replacement( $old_style_file_path ,  $new_style_file_path );
                        }
                  
                }
                
            function _callback_saved_new_style_file_path( $saved_field_data, $theme_slug )
                {
                    $processing_response    =   array();
                    
                    //check if the field is noe empty
                    if(empty($saved_field_data))
                        return  $processing_response; 
          
                    global $blog_id;
                    if(is_multisite())
                        {
                            $blog_details   =   get_blog_details( $blog_id );
                            $ms_settings    =   $this->wph->functions->get_site_settings('network');
                        }
                        
                    $rewrite                            =  '';
          
                    $current_stylesheet_uri     =   trailingslashit( $this->wph->default_variables['templates_directory'] ) . trailingslashit( $theme_slug ) . 'style.css';
                    $current_stylesheet_uri     =   str_replace(' ', '%20', $current_stylesheet_uri);
                    
                    $templates_directory           =   '';
                    $new_theme_path     =   $this->wph->functions->get_site_module_saved_value('new_theme_path_' . $theme_slug,  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                    if(!empty($new_theme_path))
                        {
                            $templates_directory    .=  trailingslashit($new_theme_path) . $saved_field_data;
                        }
                        else
                        {
                            $template_relative_url  =   trailingslashit( $this->wph->default_variables['templates_directory'] ) . trailingslashit( $theme_slug );
                            
                            //check for changed wp-content
                            $new_content_path     =   $this->wph->functions->get_site_module_saved_value('new_content_path',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                            if ( ! empty ( $new_content_path ) )
                                $template_relative_url  =    str_replace( 'wp-content', $new_content_path, $template_relative_url );
                            
                            $templates_directory    .=  trailingslashit($template_relative_url) . $saved_field_data;
                        }
                    
                    $rewrite_base   =   $this->wph->functions->get_rewrite_base( $templates_directory, FALSE, FALSE );
                    $rewrite_to     =   $this->wph->functions->get_rewrite_to_base( $current_stylesheet_uri, TRUE, FALSE, 'full_path' );
                    
                    
                               
                    if($this->wph->server_htaccess_config   === TRUE)
                        {
                            if( is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes'  )
                                {
                                    $rewrite  .=    "\nRewriteCond %{HTTP_HOST} ^". $blog_details->domain .'$';
                                }
                                
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite .= "\nRewriteRule ^"    .   $rewrite_base   .   ' '. $rewrite_to .' [END,QSA]';
                                }
                                else
                                {
                                    $rewrite .= "\nRewriteRule ^([_0-9a-zA-Z-]+/)?"    .   $rewrite_base   .   ' '. $rewrite_to .' [END,QSA]';   
                                }
                        }
                        
                    if($this->wph->server_web_config   === TRUE)
                        {
                            $rewrite    =   "\n" . '<rule name="wph-new_style_file_path_'. $theme_slug  .'" stopProcessing="true">';
                            
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
                                    $rewrite_rules[]  =   '         set $wph_remap  "${wph_remap}new_style_path__";';
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

            
           
            function _init_style_file_clean( $saved_field_data, $theme_slug )
                {
                    
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;   
                    
                    //nothing to do                    
                                        
                }
           
            
            function _callback_saved_style_file_clean( $saved_field_data, $theme_slug )
                {
                    
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                    
                    global $blog_id;
                    if ( is_multisite() )
                        {
                            $blog_details   =   get_blog_details( $blog_id );
                            $ms_settings    =   $this->wph->functions->get_site_settings('network'); 
                        }
                        
                    $processing_response    =   array();
                    
                    $current_stylesheet_uri     =   trailingslashit($this->wph->default_variables['templates_directory']) . $theme_slug;
                    $current_stylesheet_uri     =   trailingslashit( $current_stylesheet_uri ) . 'style.css'; 
                    $current_stylesheet_uri     =   str_replace(' ', '%20', $current_stylesheet_uri);
                                        
                    //current style file path
                    $path           =   '';
                    $new_theme_path         =   $this->wph->functions->get_site_module_saved_value('new_theme_path_' . $theme_slug ,  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                    $new_style_file_path    =   $this->wph->functions->get_site_module_saved_value('new_style_file_path_' . $theme_slug ,  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                    if(!empty($new_style_file_path))
                        {
       
                            if(!empty($new_theme_path))
                                {
                                    $path    .=  trailingslashit($new_theme_path) . $new_style_file_path;
                                }
                                else
                                {
                                    $template_relative_url  =   trailingslashit( $this->wph->default_variables['templates_directory'] ) . $theme_slug;
                                    
                                    //check for changed wp-content
                                    $new_content_path     =   $this->wph->functions->get_site_module_saved_value('new_content_path',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                                    if ( ! empty ( $new_content_path ) )
                                        $template_relative_url  =    str_replace( 'wp-content', $new_content_path, $template_relative_url );
                                    
                                    $path    .=  trailingslashit($template_relative_url) . $new_style_file_path;
                                }
     
                        }
                        else if(!empty($new_theme_path))
                            {
                                $path           =  trailingslashit( $new_theme_path ) . 'style.css';   
                            }
                            else
                            {

                                $default_path   =   $this->wph->default_variables['url']    .   trailingslashit($this->wph->default_variables['templates_directory'])    .   $theme_slug;
                                   
                                //check for modified wp-content folder
                                $new_content_path =   $this->wph->functions->get_site_module_saved_value('new_content_path',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                                if(!empty($new_content_path))
                                    {
                                        $path   =   str_replace( trailingslashit( WP_CONTENT_URL ) , "/", $default_path);
                                        $path   =   $new_content_path . $path;
                                    }
                                    else
                                    {
                                        $path   =   str_replace( trailingslashit( WP_CONTENT_URL ) , "/", $default_path);
                                        
                                        $wp_content_folder      =   str_replace( site_url() , '' , WP_CONTENT_URL);
                                        $wp_content_folder      =   trim($wp_content_folder, '/');
                                        
                                        $path   =   $wp_content_folder . $path;
                                    }
                                
                                //$path       =   $this->wph->functions->get_url_path( get_template_directory_uri() );
                                $path       =  trailingslashit( $path ) . 'style.css';
                            }
      
                    $path                   =   str_replace(' ', '%20', $path);
                    
                    $rewrite_base   =   $this->wph->functions->get_rewrite_base( $path, FALSE, FALSE );
                    
                    
                    //plugin File Processor router path
                    $file_processor =   $this->wph->default_variables['network']['plugins_path'];
                    $file_processor =   trailingslashit( $file_processor ) . 'wp-hide-security-enhancer-pro/router/file-process.php';    
                    
                    $rewrite_to     =   $this->wph->functions->get_rewrite_to_base( $file_processor, TRUE, FALSE, 'full_path' );
                    
                    
                    $rewrite =   '';
                             
                    
                    if($this->wph->server_htaccess_config   === TRUE)                               
                        {
                            if(is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=    "\nRewriteCond %{HTTP_HOST} ^". $blog_details->domain .'$';
                                }
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite .= "\nRewriteRule ^"    .   $rewrite_base   .   ' '. $rewrite_to . '?action=style-clean&file_path=' . $this->wph->functions->get_rewrite_to_base( $current_stylesheet_uri, TRUE, FALSE, 'full_path' ) .'&blog_id='. $blog_id .' [END,QSA]';
                                }
                                else
                                {
                                    $rewrite .= "\nRewriteRule ^([_0-9a-zA-Z-]+/)?"    .   $rewrite_base   .   ' '. $rewrite_to . '?action=style-clean&file_path=' . $this->wph->functions->get_rewrite_to_base( $current_stylesheet_uri, TRUE, FALSE, 'site_path' ) .'&blog_id='. $blog_id .' [END,QSA]';
                                }
                        }
                        
                    if($this->wph->server_web_config   === TRUE)
                        {
                            $rewrite    =   "\n" . '<rule name="wph-style_file_clean_'. $theme_slug .'" stopProcessing="true">';
                            
                            if(is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=      "\n" .    '   <conditions>'  
                                                    . "\n" .    '       <add input="{HTTP_HOST}" matchType="Pattern" pattern="^'. $blog_details->domain .'$"  />'
                                                    . "\n" .    '   </conditions>';
                                }
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^'.  $rewrite_base   .'"  />';
                                    $rewrite .=   "\n" .    '    <action type="Rewrite" url="'.  $rewrite_to .'?action=style-clean&amp;file_path=' . $this->wph->functions->get_rewrite_to_base( $current_stylesheet_uri, TRUE, FALSE, 'site_path' ) .'&amp;blog_id='. $blog_id .'"  appendQueryString="true" />';
                                }
                                else
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^([_0-9a-zA-Z-]+/)?'.  $rewrite_base   .'"  />';
                                    $rewrite .=   "\n" .    '    <action type="Rewrite" url="'.  $rewrite_to .'?action=style-clean&amp;file_path=' . $this->wph->functions->get_rewrite_to_base( $current_stylesheet_uri, TRUE, FALSE, 'site_path' ) .'&amp;blog_id='. $blog_id .'"  appendQueryString="true" />';
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
                                    $rewrite_rules[]  =   '         set $wph_remap  "${wph_remap}style_clean__";';
                                }
                            
                            $rewrite_data   =   '';
                            
                            if( $global_settings['nginx_generate_simple_rewrite']   !=  'yes'   &&  is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite_data  .=    "\n" .'         if ($http_host ~ ^__WPH_SITES_HOST__$ ){';
                                }
                            
                            $rewrite_data .= "\n         rewrite ^". untrailingslashit($home_root_path) ."__WPH_SITES_SLUG__/". $rewrite_base ." ". $rewrite_to . '?action=style-clean&file_path=' . $this->wph->functions->get_rewrite_to_base( $current_stylesheet_uri, TRUE, FALSE, 'site_path' ) .'&blog_id='. $blog_id . ' last;';
                                
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
            
            
            function _display_condition_available_for_site( $module_setting_args )
                {
                    if  ( ! is_multisite()  || (is_multisite() &&  is_network_admin()))
                        return TRUE;
                        
                    global $blog_id;
                    
                    $theme_slug             =   $module_setting_args['theme_slug'];
                    
                    $site_allowed_themes    =   WP_Theme::get_allowed($blog_id);
                    if ( isset($site_allowed_themes[$theme_slug]) ) 
                        return TRUE;
                    
                    return FALSE;    

                }
          
        }
?>