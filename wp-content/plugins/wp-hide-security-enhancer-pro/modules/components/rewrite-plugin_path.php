<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_rewrite_new_plugin_path extends WPH_module_component
        {
            
            function get_component_title()
                {
                    return "Plugins";
                }
                                    
            function get_module_component_settings()
                {
                    $this->component_settings[]                  =   array(
                                                                        'id'            =>  'new_plugin_path',
                                                                        'label'         =>  __('New Plugins Path',    'wp-hide-security-enhancer'),
                                                                        'description'   =>  __('The default plugins path is set to',    'wp-hide-security-enhancer') . ' <strong>'. $this->wph->default_variables['plugins_directory']  .'</strong>
                                                                                             '. __('More details can be found at',    'wp-hide-security-enhancer') .' <a href="https://www.wp-hide.com/documentation/rewrite-plugins/" target="_blank">Link</a>',
                                                                        
                                                                        'value_description' =>  'e.g. my_plugins',
                                                                        'input_type'    =>  'text',
                                                                        
                                                                        'sanitize_type' =>  array(array($this->wph->functions, 'sanitize_file_path_name')),
                                                                        'processing_order'  =>  17
                                                                        );
                                                                    
                    $this->component_settings[]                  =   array(
                                                                        'id'            =>  'block_plugins_url',
                                                                        'label'         =>  __('Block plugins URL',    'wp-hide-security-enhancer'),
                                                                        'description'   =>  __('Block plugins files from being accesible through default urls.',    'wp-hide-security-enhancer') . '<br />'.__('Apply only if ',    'wp-hide-security-enhancer') . '<b>New Plugin Path</b> ' . __('is not empty.',    'wp-hide-security-enhancer'),
                                                                        
                                                                        'input_type'    =>  'radio',
                                                                        'options'       =>  array(
                                                                                                    'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                    'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                    ),
                                                                        'default_value' =>  'no',
                                                                        
                                                                        'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                        'processing_order'  =>  18
                                                                        
                                                                        );
                    
                    
                    $this->component_settings[]                  =   array(
                                                                        'type'            =>  'split'
                                                                        
                                                                        );
                    
                    $all_plugins = $this->wph->functions->get_plugins();
                    
                                      
                    if(is_multisite())
                        {
                            
                            if ( !function_exists( 'get_plugins' ) )
                                require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                            
                            $ms_settings    =   $this->wph->functions->get_site_settings('network');
                                   
                            if ( $ms_settings['allow_every_site_to_change_options']  ==  'no' )
                                $plugins    =   array();
                                else
                                $plugins = (array) get_option( 'active_plugins', array() );
                                
                            if(count($all_plugins)  >   0)
                                {
                                    foreach($all_plugins    as  $plugin_path    =>  $plugin_data)
                                        {
                                            if ( $ms_settings['allow_every_site_to_change_options']  ==  'no' )
                                                {
                                                    $plugins[]  =   $plugin_path;   
                                                }
                                                else
                                                {
                                                    if(is_plugin_active_for_network( $plugin_path ) &&  !is_network_only_plugin( $plugin_path ) &&  !in_array($plugin_path, $plugins))
                                                        $plugins[]  =   $plugin_path;
                                                }
                                        }
                                }    
                            
                        }
                        else
                        {
                            $plugins = (array) get_option( 'active_plugins', array() );
                            sort( $plugins );
                        }
                        
                    foreach($plugins as  $active_plugin)
                        {
                            //exclude this plugins
                            if( in_array($active_plugin, array('wp-hide-security-enhancer/wp-hide.php', 'wp-hide-security-enhancer-pro/wp-hide.php')) )
                                continue; 
                            
                            $plugin_slug    =   sanitize_title($active_plugin);
                            
                            if(!isset($all_plugins[$active_plugin]))
                                continue; 
                                
                            $pluding_data   =   $all_plugins[$active_plugin];
                                                                            
                            $this->component_settings[]                  =   array(
                                                                                'id'            =>  'new_plugin_path_' . $plugin_slug,
                                                                                'label'         =>  __('New Path for',    'wp-hide-security-enhancer') . " <i>" . $pluding_data['Name'] ."</i> ". __('plugin',    'wp-hide-security-enhancer'),
                                                                                'description'   =>  __('This setting overwrites the',    'wp-hide-security-enhancer') . ' ' . __('New Plugin Path',    'wp-hide-security-enhancer') . ' ' . __('setting for this plugin, if set.',    'wp-hide-security-enhancer'),
                                                                                'value_description' =>  'e.g. module' . rand( 1,999 ),
                                                                                'input_type'    =>  'text',
                                                                                
                                                                                'sanitize_type' =>  array(array($this->wph->functions, 'sanitize_file_path_name')),
                                                                                
                                                                                'processing_order'  =>  16
                                                                                );
                                                                        
                        }
                                                                    
                    return $this->component_settings;   
                }
                
                
                
            function _init_new_plugin_path($saved_field_data)
                {
                    
                    //add custom plugins path replacements
                    //get active plugins
                    $active_plugins = (array) get_option( 'active_plugins', array() );
                    
                    if(is_multisite())
                        {
                            $active_sitewide_plugins = get_site_option('active_sitewide_plugins');    
                            
                            if(is_array($active_sitewide_plugins)   &&  count($active_sitewide_plugins) >   0)
                                foreach($active_sitewide_plugins    as  $active_sitewide_plugin =>  $time)
                                    {
                                        $active_plugins[]   =   $active_sitewide_plugin;
                                    }                            
                        }
                    
                    
                    global $blog_id;
                    
                    foreach($active_plugins as  $active_plugin)
                        {
                            //exclude this plugins
                            if( in_array($active_plugin, array('wp-hide-security-enhancer/wp-hide.php', 'wp-hide-security-enhancer-pro/wp-hide.php')) )
                                continue;
                            
                            $active_plugin_split        =   explode('/', $active_plugin);
                            $active_plugin_directory    =   $active_plugin_split[0];
                                     
                            $plugin_slug        =   sanitize_title($active_plugin);
                            $option_namespace   =   'new_plugin_path_' . $plugin_slug;
                                
                            //check if plugin have custom url
                            $plugin_custom_path =   $this->wph->functions->get_site_module_saved_value($option_namespace,  $this->wph->functions->get_blog_id_setting_to_use());
                            if(empty($plugin_custom_path))
                                continue;
                                
                            //add custom path
                            $new_url    =   trailingslashit(    site_url()  ) .  $plugin_custom_path;
                            if(!empty($path))
                                $new_url    =   trailingslashit(    $new_url  ) .  $path;
                                
                            //add replacement
                            $replace_url            =   trailingslashit(    trailingslashit(    WP_PLUGIN_URL  )   . $active_plugin_directory );
                            $replacement_url        =   trailingslashit(    trailingslashit(    home_url()  ) .  $plugin_custom_path    );
                            $this->wph->functions->add_replacement( $replace_url, $replacement_url);
 
                        }
                    
                    
                    if(empty($saved_field_data))
                        return FALSE;
                    
                    //add default plugin path replacement
                    $new_plugin_path        =   $this->wph->functions->untrailingslashit_all(    $this->wph->functions->get_site_module_saved_value('new_plugin_path',  $this->wph->functions->get_blog_id_setting_to_use())  );
                    $new_plugin_path        =   trailingslashit(    home_url()  )   . untrailingslashit(  $new_plugin_path    );
                    $this->wph->functions->add_replacement( WP_PLUGIN_URL, $new_plugin_path );
                    
                    return TRUE;
                }
        
                
            function _callback_saved_new_plugin_path($saved_field_data)
                {
                    $processing_response    =   array();
                    
                    global $blog_id;
                    
                    if(is_multisite())
                        {
                            $blog_details   =   get_blog_details( $blog_id );
                            $ms_settings    =   $this->wph->functions->get_site_settings('network');
                        }
                    
                    $global_settings    =   $this->wph->functions->get_global_settings ( );
                    
                    if($this->wph->server_nginx_config   === TRUE)           
                        $rewrite        =   array();
                        else
                        $rewrite        =  '';
                    
                    $plugin_path =   trailingslashit( $this->wph->default_variables['network']['plugins_path'] );
                    
                    $path           =   '';
                    $path           .=  trailingslashit(   $saved_field_data   );
                    
                    //add custom rewrite for plugins
                    //get active plugins
                    if(is_multisite())
                        {
                            
                            if ( !function_exists( 'get_plugins' ) )
                                require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                            
                            $ms_settings    =   $this->wph->functions->get_site_settings('network');
                                   
                            if ( $ms_settings['allow_every_site_to_change_options']  ==  'no' )
                                $active_plugins    =   array();
                                else
                                $active_plugins = (array) get_option( 'active_plugins', array() );
                            
                            $all_plugins = $this->wph->functions->get_plugins();
                                
                            if(count($all_plugins)  >   0)
                                {
                                    foreach($all_plugins    as  $a_plugin_path    =>  $plugin_data)
                                        {
                                            if ( $ms_settings['allow_every_site_to_change_options']  ==  'no' )
                                                {
                                                    $active_plugins[]  =   $a_plugin_path;   
                                                }
                                                else
                                                {
                                                    if(is_plugin_active_for_network( $a_plugin_path ) &&  !is_network_only_plugin( $a_plugin_path ) )
                                                        $active_plugins[]  =   $a_plugin_path;
                                                }
                                        }
                                }    
                            
                        }
                        else
                        {
                            $active_plugins = (array) get_option( 'active_plugins', array() );
                            sort( $active_plugins );
                        }
                        
                    foreach($active_plugins as  $active_plugin)
                        {
                            $active_plugin_split        =   explode('/', $active_plugin);
                            $active_plugin_directory    =   $active_plugin_split[0];
                              
                            $plugin_slug        =   sanitize_title($active_plugin);
                            $option_namespace   =   'new_plugin_path_' . $plugin_slug;  
                                
                            //check if plugin have custom url
                            $plugin_custom_path =   $this->wph->functions->get_site_module_saved_value($option_namespace,  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                            if(empty($plugin_custom_path))
                                continue;
               
                            $rewrite_base   =   trailingslashit( $plugin_custom_path );
                            $rewrite_to     =   $this->wph->functions->get_rewrite_to_base( $plugin_path . $active_plugin_directory , TRUE, TRUE, 'full_path' );
                                                     
                            if($this->wph->server_htaccess_config   === TRUE)
                                {
                                    if( is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                        {
                                            $rewrite  .=    "\nRewriteCond %{HTTP_HOST} ^". $blog_details->domain .'$';
                                        }
                                    
                                    if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                        {
                                            $rewrite    .= "\nRewriteRule ^"    .   $rewrite_base   .   '(.+) '. $rewrite_to .'$1 [END,QSA]';
                                        }
                                        else
                                        {
                                            $rewrite    .= "\nRewriteRule ^([_0-9a-zA-Z-]+/)?"    .   $rewrite_base   .   '(.+) '. $rewrite_to .'$2 [END,QSA]';
                                        }
                                }
                                
                            if($this->wph->server_web_config   === TRUE)
                                {
                                    $rewrite    .=   "\n" . '<rule name="wph-new_plugin_path-'.  $plugin_slug    .'" stopProcessing="true">';
                            
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
                                    $rewrite_list   =   array();
                                    $rewrite_rules  =   array();
                                    
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
                                            $rewrite_rules[]  =   '         set $wph_remap  "${wph_remap}wp_plugin__";';
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
                            
                        }
                    
                    $rewrite_base   =   trailingslashit( $saved_field_data );
                    $rewrite_to     =   $this->wph->functions->get_rewrite_to_base( $plugin_path, TRUE, TRUE, 'full_path' );
                    
                    if( !empty($rewrite_base) &&  !empty($saved_field_data))           
                        {
                            if($this->wph->server_htaccess_config   === TRUE)
                                {
                                    if(is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes')
                                        {
                                            $rewrite  .=    "\nRewriteCond %{HTTP_HOST} ^". $blog_details->domain .'$';
                                        }
                                    
                                    if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                        {
                                            $rewrite  .= "\nRewriteRule ^"    .   $rewrite_base   .   '(.+) '. $rewrite_to .'$1 [END,QSA]';
                                        }
                                        else
                                        {
                                            $rewrite  .= "\nRewriteRule ^([_0-9a-zA-Z-]+/)?"    .   $rewrite_base   .   '(.+) '. $rewrite_to .'$2 [END,QSA]';
                                        }
                                    
                                }
                                
                            if($this->wph->server_web_config   === TRUE)
                                {
                                    $rewrite    .=   "\n" . '<rule name="wph-new_plugin_path" stopProcessing="true">';
                            
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
                                    $rewrite_list   =   array();
                                    $rewrite_rules  =   array();
                                    
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
                                            $rewrite_rules[]  =   '         set $wph_remap  "${wph_remap}wp_plugins__";';
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
                        }
                    
                    if ( ! empty ( $rewrite ) )    
                        $processing_response['rewrite']    =   $rewrite;
                        else
                        $processing_response    =   FALSE;
                                
                    return  $processing_response;   
                }
                  
                
            function _callback_saved_block_plugins_url($saved_field_data)
                {
                    
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                    
                    $processing_response    =   array();
                    
                    global $blog_id;
                    if ( is_multisite() )
                        {
                            $ms_settings    =   $this->wph->functions->get_site_settings('network'); 
                        }    
                                       
                    //prevent from blocking if the wp-include is not modified
                    $new_path     =   $this->wph->functions->untrailingslashit_all ( $this->wph->functions->get_site_module_saved_value( 'new_plugin_path',  $this->wph->functions->get_blog_id_setting_to_use() , 'display') );
                    if (empty(  $new_path ))
                        return FALSE;
                    
                    if(is_multisite())
                        $blog_details = get_blog_details( $blog_id );
                        
                    $rewrite                            =  '';
                          
                    $rewrite_base   =   $this->wph->functions->get_rewrite_base( $this->wph->default_variables['network']['plugins_path'], FALSE, FALSE, 'wp_path' );
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
                                    $rewrite   .=   "\nRewriteRule ^".   $rewrite_base   ."(.+) ".  $rewrite_to ." [END]";
                                }
                                else
                                {
                                    $rewrite   .=   "\nRewriteRule ^([_0-9a-zA-Z-]+/)?".   $rewrite_base   ."(.+) ".  $rewrite_to ." [END]";
                                }

                        }
                        
                    if($this->wph->server_web_config   === TRUE)
                        {
                            $rewrite    =   "\n" . '<rule name="wph-block_plugins_url" stopProcessing="true">';
                            
                            if( is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=      "\n" .    '   <conditions>'  
                                                    . "\n" .    '       <add input="{HTTP_HOST}" matchType="Pattern" pattern="^'. $blog_details->domain .'$"  />'
                                                    . "\n" .    '   </conditions>';
                                }
                            
                            if( !is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
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
                                    $rewrite_data  .=    "\n\n         #" . __('REPLACE THE FOLLOWING LINE WITH YOUR OWN INCLUDE! This can be found within block', 'wp-hide-security-enhancer') ."  location ~ \.php$";
                                    $rewrite_data  .=    "\n" .'         include snippets/fastcgi-php.conf; fastcgi_pass unix:/run/php/php7.0-fpm.sock;';
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