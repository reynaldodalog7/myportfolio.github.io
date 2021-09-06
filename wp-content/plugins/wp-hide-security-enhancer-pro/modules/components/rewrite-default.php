<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_rewrite_default extends WPH_module_component
        {
            
            function get_component_id()
                {
                    return '_rewrite_default_';
                    
                }
                                    
            function get_module_component_settings()
                {
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'rewrite_default',
                                                                    'visible'       =>  FALSE,
                                                                    'processing_order'  =>  1
                                                                    );
                                                                    
                    return $this->component_settings;   
                }
                

                
            function _callback_saved_rewrite_default($saved_field_data)
                {
                    $processing_response    =   array();
                    
                    global $blog_id, $_wph_rewrite_default_run;
                    
                    //run just once
                    if ( $_wph_rewrite_default_run  === TRUE )
                        return $processing_response;
                                        
                    $global_settings    =   $this->wph->functions->get_global_settings ( );
                    if ( ! isset( $global_settings['sample_rewrite_hash'] ))
                        {
                            $global_settings['sample_rewrite_hash'] =   md5(    microtime() );
                            $this->wph->functions->update_global_settings( $global_settings );
                        }
                        
                    
                    if($this->wph->server_htaccess_config   === TRUE)
                        {
                            $rewrite    =   '';
                            
                            $rewrite    =   'RewriteCond %{ENV:REDIRECT_STATUS} 200' .
                                            "\n" . 'RewriteRule ^ - [L]';
                        }
                    
                    //Add a sample rewrite to be used when Confirm
                    if( $global_settings['nginx_generate_simple_rewrite']   ==  'yes'   &&  $this->wph->server_nginx_config   === TRUE  && $blog_id ==  1)
                        {
                            $rewrite    =   array();
                            
                            $home_root_path =   $this->wph->functions->get_home_root();
                                
                            $rewrite_base   =   $this->wph->functions->get_rewrite_base( $home_root_path . $global_settings['sample_rewrite_hash'] . '/rewrite_test' , FALSE, FALSE );
                            $rewrite_to     =   $this->wph->functions->get_rewrite_to_base( trailingslashit($this->wph->default_variables['plugins_directory']) . 'wp-hide-security-enhancer-pro/include/rewrite-confirm.php' , TRUE, FALSE, 'full_path' );
                            
                            $rewrite_list   =   array();
                                               
                            $rewrite_list['blog_id'] =   1;
                                
                            $rewrite_list['type']        =   'default_variables';
                            $rewrite_list['description'] =   "\n         rewrite ^/". $rewrite_base ." ". $rewrite_to .' last;';
                            
                            $rewrite_data   =   '';
                            $rewrite_rules[]            =   $rewrite_data;                           
                            $rewrite_list['data']       =   $rewrite_rules;
                            
                            $rewrite[]  =   $rewrite_list;
                        }
                    if( $global_settings['nginx_generate_simple_rewrite']   !=  'yes'   &&  $this->wph->server_nginx_config   === TRUE  && $blog_id ==  1)
                        {
                            $home_root_path =   $this->wph->functions->get_home_root();
                                                            
                            $rewrite_base   =   $this->wph->functions->get_rewrite_base( $home_root_path . $global_settings['sample_rewrite_hash'] . '/rewrite_test' , FALSE, FALSE );
                            $rewrite_to     =   $this->wph->functions->get_rewrite_to_base( trailingslashit($this->wph->default_variables['plugins_directory']) . 'wp-hide-security-enhancer-pro/include/rewrite-confirm.php' , TRUE, FALSE, 'full_path' );
                            
                            $rewrite_list   =   array();
                                               
                            $rewrite_list['blog_id'] =   1;
                                
                            $rewrite_list['type']        =   'default_variables';
                            $rewrite_list['description'] =   "\n                location ~ ^/" . $rewrite_base  ." {
                                                                     rewrite ^/" . $rewrite_base  ." " . $rewrite_to ." last;
                                                                   }";
                            
                            $rewrite_data   =   '';
                            $rewrite_rules[]            =   $rewrite_data;                           
                            $rewrite_list['data']       =   $rewrite_rules;
                            
                            $rewrite[]  =   $rewrite_list;
                        }
                    
                    
                    if( $global_settings['nginx_generate_simple_rewrite']   !=  'yes'   &&  $this->wph->server_nginx_config   === TRUE)           
                        {
                            if ( is_multisite() )
                                $ms_settings    =   $this->wph->functions->get_site_settings('network');
                                
                            //add any map rules
                            if ( is_multisite() &&  SUBDOMAIN_INSTALL   === FALSE )
                                {
                                    $network_sites  =   $this->wph->functions->ms_get_plugin_active_blogs();
                                    $sites_subdomain_slug  =   array();
                                    
                                    if ( $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                        {
                                            foreach ( $network_sites    as  $network_site)
                                                {
                                                    switch_to_blog( $network_site->blog_id );
                                                    
                                                    //only if is subdiectory, not main domain
                                                    $blog_details   =   get_blog_details( $blog_id );
                                                    $blog_path      =   trim($blog_details->path, '/');
                                                    if ( empty ( $blog_path ) )
                                                        {
                                                            restore_current_blog();
                                                            continue;
                                                        }
                                                        
                                                    $sites_subdomain_slug[] =   $blog_path;
                                                                                                       
                                                    $section_block  =   $this->_build_exclude_map( $blog_id );
                                                    
                                                    $regex_exclude    =   "";    
                                                    if ( count($section_block) > 0 )
                                                        {
                                                            $regex_exclude  =   '(?!\/' . implode('|\/', $section_block) . ')';
                                                        }
                                                        
                      
                                                    $rewrite  =   array_merge($rewrite, $this->_get_roule_map ( $blog_id, $regex_exclude ));
                                                
                                                    restore_current_blog();
                                                }
                                        
                                        }
                                        else
                                        {
                                            $section_block  =   $this->_build_exclude_map( 'network' );
                                             
                                            $regex_exclude    =   "";    
                                            if ( count($section_block) > 0 )
                                                {
                                                    $regex_exclude  =   '(?!\/' . implode('|\/', $section_block) . ')';
                                                }

                                            $rewrite  =   array_merge($rewrite, $this->_get_roule_map ( 'network', $regex_exclude ));
                                        }        
                                }
                            
                            
                            
                            //add default variables
                            $rewrite_list   =   array();
                               
                            $rewrite_list['blog_id'] =   $blog_id;
                                
                            $rewrite_list['type']        =   'default_variables';
                            $rewrite_list['description'] =   '      set $wph_remap_url "";';
                            
                            $rewrite_data   =   '';
                            $rewrite_rules[]            =   $rewrite_data;                           
                            $rewrite_list['data']       =   $rewrite_rules;
                            
                            $rewrite[]  =   $rewrite_list;
                            
                            if ( is_multisite() &&  SUBDOMAIN_INSTALL   === FALSE )
                                {
                                    if ( $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                        {
                                            $sites_subdomain_slug   =  array_filter($sites_subdomain_slug);
                                            if ( count ( $sites_subdomain_slug )  > 0 )
                                                {
                                                    $sites_slug_map =   implode("|", $sites_subdomain_slug );
                                                    
                                                    $rewrite_list   =   array();
                                               
                                                    $rewrite_list['blog_id'] =   $blog_id;
                                                        
                                                    $rewrite_list['type']        =   'default_variables';
                                                    $rewrite_list['description'] =   '          if (-f $document_root$file_php_path_exists) {'
                                                                                    ."\n".'                set $wph_remap 1;'
                                                                                    ."\n".'                rewrite ^/('. $sites_slug_map .')(/.*\.php) $2 last;'
                                                                                    ."\n".'                '
                                                                                    ."\n".'            }'
                                                                                    ."\n".'            set $conditional_test ""; if ( -e $document_root$file_path_exists ){ set $conditional_test "${conditional_test}A";}  if ( $file_path_exists != "" ) { set $conditional_test "${conditional_test}B"; }'
                                                                                    ."\n".'                if ( $conditional_test = AB ){'
                                                                                    ."\n".'                set $wph_remap 2;'
                                                                                    ."\n".'                rewrite ^/('. $sites_slug_map .')(/wp-(content|admin|includes).*) $2 last;'
                                                                                    ."\n".'            }';
                                                    
                                                    $rewrite_data   =   '';
                                                    $rewrite_rules[]            =   $rewrite_data;                           
                                                    $rewrite_list['data']       =   $rewrite_rules;
                                                    
                                                    $rewrite[]  =   $rewrite_list;
                                                }
                                        }
                                        else
                                        {
                                            $rewrite_list   =   array();
                                               
                                            $rewrite_list['blog_id'] =   $blog_id;
                                                
                                            $rewrite_list['type']        =   'default_variables';
                                            $rewrite_list['description'] =   '          if (-f $document_root$file_php_path_exists) {'
                                                                            ."\n".'                set $wph_remap 1;'
                                                                            ."\n".'                rewrite ^/__WPH_SITES_SLUG__(/.*\.php) $2 last;'
                                                                            ."\n".'            }'
                                                                            ."\n".'            set $conditional_test ""; if ( -e $document_root$file_path_exists ){ set $conditional_test "${conditional_test}A";}  if ( $file_path_exists != "" ) { set $conditional_test "${conditional_test}B"; }'
                                                                            ."\n".'                if ( $conditional_test = AB ){'
                                                                            ."\n".'                set $wph_remap 2;'
                                                                            ."\n".'                rewrite ^/__WPH_SITES_SLUG__(/wp-(content|admin|includes).*) $2 last;'
                                                                            ."\n".'            }';
                                            
                                            $rewrite_data   =   '';
                                            $rewrite_rules[]            =   $rewrite_data;                           
                                            $rewrite_list['data']       =   $rewrite_rules;
                                            
                                            $rewrite[]  =   $rewrite_list;   
                                            
                                        }
                                }
                        }
                    
                    $processing_response['rewrite'] =   $rewrite;
                    
                    $_wph_rewrite_default_run   =   TRUE;
                                
                    return  $processing_response;   
                }
                
                
                
            private function _build_exclude_map( $blog_id_settings )
                {
                    
                    $section_block  =   array();
                                                    
                    //check wp-includes
                    $site_wp_includes           =   $this->wph->functions->get_site_module_saved_value('new_include_path',              $blog_id_settings, 'display');
                    $site_wp_includes_block     =   $this->wph->functions->get_site_module_saved_value('block_wpinclude_url',           $blog_id_settings, 'display');
                    if ( ! empty ( $site_wp_includes ) &&   $site_wp_includes_block ==  'yes' )
                        $section_block[]    =   'wp-includes';
                        
                    //check wp-content                                                                                                  
                    $site_wp_content            =   $this->wph->functions->get_site_module_saved_value('new_content_path',              $blog_id_settings, 'display');
                    $site_wp_content_block      =   $this->wph->functions->get_site_module_saved_value('block_wp_content_path',         $blog_id_settings, 'display');
                    if ( ! empty ( $site_wp_content ) &&   $site_wp_content_block ==  'yes' )
                        $section_block[]    =   'wp-content';
                        
                    //check plugins block
                    $site_plugins            =   $this->wph->functions->get_site_module_saved_value('new_plugin_path',                  $blog_id_settings, 'display');
                    $site_plugins_block      =   $this->wph->functions->get_site_module_saved_value('block_plugins_url',                $blog_id_settings, 'display');
                    if ( ! empty ( $site_plugins ) &&   $site_plugins_block ==  'yes' )
                        $section_block[]    =   'wp-content/plugins';
                        
                    //check uploads block
                    $site_option                =   $this->wph->functions->get_site_module_saved_value('new_upload_path',               $blog_id_settings, 'display');
                    $site_option_block          =   $this->wph->functions->get_site_module_saved_value('block_upload_url',              $blog_id_settings, 'display');
                    if ( ! empty ( $site_option ) &&   $site_option_block ==  'yes' )
                        $section_block[]    =   'wp-content/uploads';
                        
                    $site_option                =   $this->wph->functions->get_site_module_saved_value('new_wp_comments_post',          $blog_id_settings, 'display');
                    $site_option_block          =   $this->wph->functions->get_site_module_saved_value('block_wp_comments_post_url',    $blog_id_settings, 'display');
                    if ( ! empty ( $site_option ) &&   $site_option_block ==  'yes' )
                        $section_block[]    =   'wp-comments-post.php';
                        
                    $site_option                =   $this->wph->functions->get_site_module_saved_value('new_xml_rpc_path',              $blog_id_settings, 'display');
                    $site_option_block          =   $this->wph->functions->get_site_module_saved_value('block_xml_rpc',                 $blog_id_settings, 'display');
                    if ( ! empty ( $site_option ) &&   $site_option_block ==  'yes' )
                        $section_block[]    =   'xmlrpc.php';
                        
                    $site_option_block          =   $this->wph->functions->get_site_module_saved_value('block_wp_activate_php',         $blog_id_settings, 'display');
                    if ( $site_option_block ==  'yes' )
                        $section_block[]    =   'wp-activate.php';
                    
                    $site_option_block          =   $this->wph->functions->get_site_module_saved_value('block_wp_cron_php',             $blog_id_settings, 'display');
                    if ( $site_option_block ==  'yes' )
                        $section_block[]    =   'wp-cron.php';
                        
                    $site_option_block          =   $this->wph->functions->get_site_module_saved_value('block_default_wp_signup_php',   $blog_id_settings, 'display');
                    if ( $site_option_block ==  'yes' )
                        $section_block[]    =   'wp-signup.php';
                        
                    $site_option_block          =   $this->wph->functions->get_site_module_saved_value('block_default_wp_register_php', $blog_id_settings, 'display');
                    if ( $site_option_block ==  'yes' )
                        $section_block[]    =   'wp-register.php';             
                    
                    $site_option                =   $this->wph->functions->get_site_module_saved_value('new_wp_login_php',              $blog_id_settings, 'display');
                    $site_option_block          =   $this->wph->functions->get_site_module_saved_value('block_default_wp_login_php',    $blog_id_settings, 'display');
                    if ( ! empty ( $site_option ) &&   $site_option_block ==  'yes' )
                        $section_block[]    =   'wp-login.php';                                            
                        
                    //check wp-admin
                    $site_admin_url            =   $this->wph->functions->get_site_module_saved_value('admin_url',                      $blog_id_settings, 'display');
                    $site_admin_url_block      =   $this->wph->functions->get_site_module_saved_value('block_default_admin_url',        $blog_id_settings, 'display');
                    if ( ! empty ( $site_admin_url ) &&   $site_admin_url_block ==  'yes' )
                        $section_block[]    =   'wp-admin';
                    
                    
                    $section_block  =   apply_filters('wp-hide/components/rewrite-default/section_block', $section_block); 
                    
                    return $section_block;
                    
                }
                
        
            private function _get_roule_map ( $blog_id_settings, $regex_exclude )
                {
                    $rewrite    =   array();
                    
                    $rewrite_list                   =   array();
                                                                                   
                    $rewrite_list['blog_id']        =   $blog_id_settings;
                    $rewrite_list['type']           =   'map';
                    $rewrite_list['description']    =   '      $request_uri $file_php_path_exists';
                    
                    $rewrite_rules                  =   array();
                    $rewrite_rules[]                =   '           default     "";';
                    $rewrite_rules[]                =   "\n" . '           ~^__WPH_SITES_SLUG__(?<file_path>('.  $regex_exclude  .'(\/wp-(content|admin|includes))?\/.*\.php))   $file_path;';
                    $rewrite_list['data']           =   $rewrite_rules;
                    
                    $rewrite[]  =   $rewrite_list;
                    
                    
                    
                    $rewrite_list                   =   array();
       
                    $rewrite_list['blog_id']        =   $blog_id_settings;
                    $rewrite_list['type']           =   'map';
                    $rewrite_list['description']    =   '      $request_uri $file_path_exists';
                    
                    $rewrite_rules                  =   array();
                    $rewrite_rules[]                =   '           default     "";';
                    $rewrite_rules[]                =   "\n" . '           ~.*\.php(*SKIP)(*FAIL)|^__WPH_SITES_SLUG__(?<file_path>('.  $regex_exclude  .'(\/wp-(content|admin|includes))?([^?\s]*)))     $file_path;';
                    $rewrite_list['data']           =   $rewrite_rules;
                    
                    $rewrite[]  =   $rewrite_list;
                    
                    return $rewrite;                
                }
                 
        }
?>