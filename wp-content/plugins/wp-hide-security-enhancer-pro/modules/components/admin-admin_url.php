<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_admin_admin_url extends WPH_module_component
        {
            function get_component_title()
                {
                    return "Admin URL";
                }
                                    
            function get_module_component_settings()
                {
                    $component_description  =   array(
                                                        __('Create a new admin url instead default /wp-admin and /login.',  'wp-hide-security-enhancer') . '<br />'
                                                        . __('More details can be found at',    'wp-hide-security-enhancer') .' <a href="https://www.wp-hide.com/documentation/admin-change-wp-admin/" target="_blank">Link</a>'
                                                        );
                    
                    if(!is_network_admin())
                        {
                            $component_description[]    =      '<div class="notice-error"><div class="dashicons dashicons-warning important" alt="f534">warning</div> <span class="important">' . __('Write down your new admin url, or if lost, will not be able to log-in.',  'wp-hide-security-enhancer') . " " . __('An e-mail will be sent to',  'wp-hide-security-enhancer') . " " . get_option('admin_email') . " " . __('with the new Login URL',  'wp-hide-security-enhancer') . '</span></div>';
                            $component_description[]    =      '<div class="notice-error"><div class="dashicons dashicons-warning important" alt="f534">warning</div> <span class="important">' . __('If unable to access the login / admin section anymore, use the Recovery Link which reset links to default: ',  'wp-hide-security-enhancer') . '<br /><b class="pointer">' . site_url() . '?wph-recovery='.  $this->wph->functions->get_recovery_code()  .'</b></div>';
                        }
                    
                    $this->component_settings[]                  =   array(
                                                                        'id'            =>  'admin_url',
                                                                        'label'         =>  __('New Admin Url',    'wp-hide-security-enhancer'),
                                                                        'description'   =>  $component_description,                                                                        
                                                                        'input_type'    =>  'text',
                                                                        
                                                                        'sanitize_type' =>  array(array($this->wph->functions, 'sanitize_file_path_name'), array($this, 'sanitize_path_name')),
                                                                        'processing_order'  =>  60
                                                                        
                                                                        );
                                                                    
                    $this->component_settings[]                  =   array(
                                                                        'id'            =>  'block_default_admin_url',
                                                                        'label'         =>  __('Block default Admin Url',    'wp-hide-security-enhancer'),
                                                                        'description'   =>  array(
                                                                                                    __('Block default admin url and files from being accesible.',  'wp-hide-security-enhancer')
                                                                                                    ),
                                                                        'input_type'    =>  'radio',
                                                                        'options'       =>  array(
                                                                                                    'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                    'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                    ),
                                                                        'default_value' =>  'no',
                                                                        
                                                                        'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                        'processing_order'  =>  65
                                                                        
                                                                        );
                                                                    
                    return $this->component_settings;   
                }
                
                
                
            function _init_admin_url($saved_field_data)
                {
                    
                    global $blog_id;
                    
                    $admin_url_to_apply =   $this->wph->functions->get_site_module_saved_value('admin_url',  $this->wph->functions->get_blog_id_setting_to_use());
                    if ( ! empty ( $admin_url_to_apply ) )
                        add_action('set_auth_cookie',       array($this,'set_auth_cookie'), 999, 5);
                        
                    //check if the value has changed, e-mail the new url to site administrator
                    $previous_url   =   get_option('wph-previous-admin-url');
                    if($saved_field_data    !=  $previous_url)
                        {
                            $this->new_url_email_notice($saved_field_data); 
                            update_option('wph-previous-admin-url', $saved_field_data);  
                        }
                    
                    if(empty($saved_field_data))
                        return FALSE;
                        
                    //remove redirects for /admin and /dashboard
                    remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );
                    
                    //conflict handle with other plugins
                    include_once(WPH_PATH . 'compatibility/wp-simple-firewall.php');
                    WPH_conflict_handle_wp_simple_firewall::custom_login_check();
                               
                    //add replacement
                    $this->wph->functions->add_replacement( trailingslashit(    site_url()  ) .  'wp-admin' , trailingslashit(    home_url()  ) .  $saved_field_data );
                         
                    //make sure the admin url redirect url is updated when updating WordPress Core
                    add_filter('user_admin_url',    array($this, 'wp_core_update_user_admin_url'), 999, 2);
                    add_filter('admin_url',         array($this, 'wp_core_update_admin_url'),      999, 3);
                    
                    //ensure admin_url() return correct url
                    add_filter('admin_url',         array($this, 'update_admin_url'),      999, 3);
                                        
                }
                
            function set_auth_cookie($auth_cookie, $expire, $expiration, $user_id, $scheme) 
                {
                    global $blog_id;
                    
                    $new_admin_url =   $this->wph->functions->get_site_module_saved_value('admin_url',  $this->wph->functions->get_blog_id_setting_to_use());

                    if ( $scheme == 'secure_auth' ) 
                        {
                            $auth_cookie_name = SECURE_AUTH_COOKIE;
                            $secure = TRUE;
                        } 
                    else 
                        {
                            $auth_cookie_name = AUTH_COOKIE;
                            $secure = FALSE;
                        }        
                    
                    $sitecookiepath =   empty($this->wph->default_variables['wordpress_directory']) ?   SITECOOKIEPATH  :   rtrim(SITECOOKIEPATH, trailingslashit($this->wph->default_variables['wordpress_directory']));
                    if (empty ($sitecookiepath))
                        $sitecookiepath =   '/';
                    
                    setcookie($auth_cookie_name, $auth_cookie, $expire, $sitecookiepath  .   $new_admin_url, COOKIE_DOMAIN, $secure, true);
                  
                    $manager            =   WP_Session_Tokens::get_instance( $user_id );
                    $token              =   $manager->create( $expiration );
                    
                    $logged_in_cookie   =   wp_generate_auth_cookie( $user_id, $expiration, 'logged_in', $token );
                   
                }

                
            function _callback_saved_admin_url($saved_field_data)
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
                    $rewrite_to         =   $this->wph->functions->get_rewrite_to_base( 'wp-admin', TRUE, FALSE, 'full_path' );
                    
                    if($this->wph->server_htaccess_config   === TRUE)
                        {
                            if(is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=    "\nRewriteCond %{HTTP_HOST} ^". $blog_details->domain .'$';
                                }
                                
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite   .=      "\nRewriteCond %{REQUEST_URI} /".  $rewrite_base ."$";
                                    $rewrite   .=      "\nRewriteRule ^(.*)$ /".  $rewrite_base ."/ [R=301,END]";
                                }
                                else
                                {
                                    $rewrite   .=      "\nRewriteCond %{REQUEST_URI} (/[_0-9a-zA-Z-]+/)?/".  $rewrite_base ."$";
                                    $rewrite   .=      "\nRewriteRule ^(.*)$ /".  $rewrite_base ."/ [R=301,END]";    
                                }
                            
                            
                            if(is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=    "\nRewriteCond %{HTTP_HOST} ^". $blog_details->domain .'$';
                                }
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite   .=      "\nRewriteRule ^"    .   $rewrite_base    .   '(.*) '. $rewrite_to .'$1 [END,QSA]';
                                }
                                else
                                {
                                    $rewrite   .=      "\nRewriteRule ^([_0-9a-zA-Z-]+/)?"    .   $rewrite_base    .   '(.*) '. $rewrite_to .'$2 [END,QSA]';    
                                }
                            
                        }
                        
                    if($this->wph->server_web_config   === TRUE)
                        {
                            $rewrite    =   "\n" . '<rule name="wph-admin_url1" stopProcessing="true">';
                            $rewrite   .=   "\n" . '   <conditions>';
                            if(is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=      "\n" .    '       <add input="{HTTP_HOST}" matchType="Pattern" pattern="^'. $blog_details->domain .'$"  />';
                                }
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite   .=      "\n" .   '       <add input="{REQUEST_URI}" matchType="Pattern" pattern="/'. $rewrite_base  .'$"  />';
                                }
                                else
                                {
                                    $rewrite   .=      "\n" .   '       <add input="{REQUEST_URI}" matchType="Pattern" pattern="(/[_0-9a-zA-Z-]+/)?/'. $rewrite_base  .'$"  />';
                                }
                            $rewrite   .=   "\n" . '   </conditions>';
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^'.  $rewrite_base   .'(.*)"  />';
                                    $rewrite .=   "\n" .    '    <action type="Rewrite" url="'.  $rewrite_to .'{R:1}"  appendQueryString="true" />';
                                }
                                else
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^([_0-9a-zA-Z-]+/)?'.  $rewrite_base   .'(.*)"  />';
                                    $rewrite .=   "\n" .    '    <action type="Rewrite" url="'.  $rewrite_to .'{R:2}"  appendQueryString="true" />';
                                }
                            
                            $rewrite .=  "\n" . '</rule>';
                            
                            
                            $rewrite    .=   "\n\n" . '<rule name="wph-admin_url2" stopProcessing="true">';
                            
                            if(is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=      "\n" .    '   <conditions>'  
                                                    . "\n" .    '       <add input="{HTTP_HOST}" matchType="Pattern" pattern="^'. $blog_details->domain .'$"  />'
                                                    . "\n" .    '   </conditions>';
                                }
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^'.  $rewrite_base   .'(.*)"  />';
                                    $rewrite .=   "\n" .    '    <action type="Rewrite" url="'.  $rewrite_to .'{R:1}"  appendQueryString="true" />';
                                }
                                else
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^([_0-9a-zA-Z-]+/)?'.  $rewrite_base   .'(.*)"  />';
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
                                    $rewrite_rules[]  =   '         set $wph_remap  "${wph_remap}new_wp_admin__";';
                                }
                            
                            $rewrite_data   =   '';
                            
                            $rewrite_data .= "\n         rewrite ^". untrailingslashit($home_root_path) ."__WPH_SITES_SLUG__/". trailingslashit($rewrite_base) ."$ /wp-admin/index.php last;";
                            
                            if( $global_settings['nginx_generate_simple_rewrite']   !=  'yes'   &&  is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite_data  .=    "\n" .'         if ($http_host ~ ^__WPH_SITES_HOST__$ ){';
                                }
                            
                            $rewrite_data .= "\n         rewrite ^". untrailingslashit($home_root_path) ."__WPH_SITES_SLUG__/". $rewrite_base ."(.*) ". $rewrite_to .'$__WPH_REGEX_MATCH_2__ last;';
                                
                            if( $global_settings['nginx_generate_simple_rewrite']   !=  'yes'   &&  is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite_data  .=    "\n         }";
                                }
                            
                            $rewrite_rules[]            =   $rewrite_data;
                            $rewrite_list['data']       =   $rewrite_rules;
                            
                            $rewrite[]  =   $rewrite_list;
                        }    
                        
                    $processing_response['rewrite']         =   $rewrite;
                                                    
                    return  $processing_response;   
                }
                
            
            function new_url_email_notice($new_url)
                {
                    if(empty($new_url))
                        $new_url    =   'wp-admin';
                    
                    $to         =   get_option('admin_email');
                    $subject    =   'New Login Url for your WordPress - ' .get_option('blogname');
                    $message    =   __('Hello',  'wp-hide-security-enhancer') . ", \n\n" 
                                    . __('This is an automated message to inform that your login url has been changed at',  'wp-hide-security-enhancer') . " " .  trailingslashit(site_url()) . "\n"
                                    . __('The new login url is',  'wp-hide-security-enhancer') .  ": " . trailingslashit( trailingslashit(site_url()) .  $new_url) . "\n\n"
                                    . __('Additionality you can use this to recover the old login / admin links ',  'wp-hide-security-enhancer') .  ": " . site_url() . '?wph-recovery='.  $this->wph->functions->get_recovery_code() . "\n\n"
                                    . __('Please keep this url safe for recover, if forgot',  'wp-hide-security-enhancer') . ".";
                    $headers = 'From: '.  get_option('blogname') .' <'.  get_option('admin_email')  .'>' . "\r\n";
                    $this->wph->functions->wp_mail( $to, $subject, $message, $headers );   
                }
            
            
            function _init_block_default_admin_url($saved_field_data)
                {
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
       
                }
                
            function _callback_saved_block_default_admin_url($saved_field_data)
                {
                    
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return  FALSE;
                    
                    $processing_response    =   array();
                    
                    global $blog_id;
                    
                    if ( is_multisite() )
                        {
                            $blog_details   =   get_blog_details( $blog_id );
                            $ms_settings    =   $this->wph->functions->get_site_settings('network'); 
                        }
                    
                    //prevent from blocking if the admin_url is empty
                    $new_path       =   $this->wph->functions->get_site_module_saved_value('admin_url',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                    if (empty(  $new_path ))
                        return FALSE;
                        
                    $rewrite                            =  '';
                               
                    $rewrite_to         =   $this->wph->functions->get_rewrite_to_base( 'index.php?wph-throw-404' , TRUE, FALSE, 'site_path' ); 

                                
                    if($this->wph->server_htaccess_config   === TRUE)
                        {           
                            $rewrite_base       =   $this->wph->functions->get_rewrite_base( 'wp-admin', FALSE, FALSE, 'wp_path' );
                            if(is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=    "\nRewriteCond %{HTTP_HOST} ^". $blog_details->domain .'$';
                                }
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite   .=       "\nRewriteCond %{ENV:REDIRECT_STATUS} ^$";
                                    $rewrite   .=      "\nRewriteRule ^" . $rewrite_base ."(.+) " . $rewrite_to . " [L]";
                                }
                                else
                                {
                                    $rewrite   .=       "\nRewriteCond %{ENV:REDIRECT_STATUS} ^$";
                                    $rewrite   .=      "\nRewriteRule ^([_0-9a-zA-Z-]+/)?" . $rewrite_base ."(.+) " . $rewrite_to . " [L]";
                                }
                            
                            
               
                        }
                        
                    if($this->wph->server_web_config   === TRUE)
                        {
                            $rewrite_base       =   $this->wph->functions->get_rewrite_base( 'wp-admin', FALSE, FALSE );
                            $rewrite    =   "\n" . '<rule name="wph-block_default_admin_url1" stopProcessing="true">';
                            
                            if(is_multisite()  &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes' )
                                {
                                    $rewrite  .=      "\n" .    '   <conditions>'  
                                                    . "\n" .    '       <add input="{HTTP_HOST}" matchType="Pattern" pattern="^'. $blog_details->domain .'$"  />'
                                                    . "\n" .    '   </conditions>';
                                }
                            
                            if(!is_multisite()   ||     ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'yes') )
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^'.  $rewrite_base   .'(.+)"  />';
                                    $rewrite .=   "\n" .    '    <action type="Rewrite" url="'.  $rewrite_to .'"  appendQueryString="true" />';
                                }
                                else
                                {
                                    $rewrite .=  "\n"  .    '    <match url="^([_0-9a-zA-Z-]+/)?'.  $rewrite_base   .'(.+)"  />';
                                    $rewrite .=   "\n" .    '    <action type="Rewrite" url="'.  $rewrite_to .'"  appendQueryString="true" />';
                                }
                            
                            $rewrite .=  "\n" . '</rule>';
                                                        
                        }
                        
                    
                    if($this->wph->server_nginx_config   === TRUE)           
                        {
                            
                            $rewrite_base       =   $this->wph->functions->get_rewrite_base( 'wp-admin', FALSE, FALSE );
                            
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
                            
                            
                        }
                               
                    $processing_response['rewrite'] = $rewrite;
                                
                    return  $processing_response;   
                }
                
            
            /**
            * Replace any dots in the slug, as it will confuse the server uppon being an actual file
            *     
            * @param mixed $value
            */
            function sanitize_path_name( $value )
                {
                    
                    $value  =   str_replace(".","-", $value);
                    
                    return $value;   
                    
                }
                
                
                
            function wp_core_update_user_admin_url( $url, $path )
                {
                    
                    if( strpos( $_SERVER['REQUEST_URI'], "/update-core.php")    === FALSE )
                        return $url;
                        
                    //replace the wp-admin with custom slug
                    $admin_url     =   $this->wph->functions->get_site_module_saved_value('admin_url',  $this->wph->functions->get_blog_id_setting_to_use());
                    
                    $url    =   str_replace('/wp-admin', '/' . $admin_url, $url);

                    return $url;
                       
                }

            function wp_core_update_admin_url( $url, $path, $blog_id )
                {
                    if( strpos( $_SERVER['REQUEST_URI'], "/update-core.php")    === FALSE && strpos( $_SERVER['REQUEST_URI'], "/update.php")    === FALSE)
                        return $url;
                    
                    //replace the wp-admin with custom slug
                    $admin_url     =   $this->wph->functions->get_site_module_saved_value('admin_url',  $this->wph->functions->get_blog_id_setting_to_use());
                    
                    $url    =   str_replace('/wp-admin', '/' . $admin_url, $url);
                        
                    return $url;
                       
                }
                
                
            function update_admin_url( $url, $path, $blog_id )
                {
                   
                    //replace the wp-admin with custom slug
                    $admin_url     =   $this->wph->functions->get_site_module_saved_value('admin_url',  $this->wph->functions->get_blog_id_setting_to_use());
                    
                    $url    =   str_replace('/wp-admin', '/' . $admin_url, $url);
                        
                    return $url;
                       
                }

                
        }
?>