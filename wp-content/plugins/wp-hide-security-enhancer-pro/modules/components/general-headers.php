<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_general_headers extends WPH_module_component
        {
            function get_component_title()
                {
                    return "Headers";
                }
                                    
            function get_module_component_settings()
                {
                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'remove_header_link',
                                                                    'label'         =>  __('Remove Link Header',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Remove Link Header being set as default by WordPress which outputs the site JSON url.', 'wp-hide-security-enhancer') . ' ' .
                                                                                        __('More details at ', 'wp-hide-security-enhancer') . '<a target="_blank" href="http://www.wp-hide.com/documentation/request-headers/">Request Headers</a>',
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                    'processing_order'  =>  70
                                                                    );
                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'remove_x_powered_by',
                                                                    'label'         =>  __('Remove X-Powered-By Header',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Remove X-Powered-By Header if being set.', 'wp-hide-security-enhancer') . ' ' .
                                                                                        __('More details at ', 'wp-hide-security-enhancer') . '<a target="_blank" href="https://www.wp-hide.com/documentation/request-headers/">Request Headers</a>',
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                    'processing_order'  =>  70
                                                                    );
                                                                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'remove_x_pingback',
                                                                    'label'         =>  __('Remove X-Pingback Header',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Remove X-Pingback Header if being set.', 'wp-hide-security-enhancer') . ' ' .
                                                                                        __('More details at ', 'wp-hide-security-enhancer') . '<a target="_blank" href="https://www.wp-hide.com/documentation/request-headers/">Request Headers</a>',
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                    'processing_order'  =>  70
                                                                    );
                                                                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'remove_custom_header',
                                                                    'label'         =>  __('Remove Custom Header',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Remove a Custom Header if being set. ', 'wp-hide-security-enhancer') . ' ' .
                                                                                        __('More details at ', 'wp-hide-security-enhancer') . '<a target="_blank" href="http://www.wp-hide.com/documentation/request-headers/">Request Headers</a>' .
                                                                                        '<br /><span class="info"> '. __('Use with caution, removing specific headers produce malfunction to the site. Generally all headers which stats with X are safe to remove.', 'wp-hide-security-enhancer') . '</span>',
                                                                                            
                                                                                        
                                                                    
                                                                    'input_type'    =>  'custom',
                                                                    'default_value' =>  array(),
                                                                    
                                                                    'module_option_html_render' =>  array( $this, '_module_option_html' ),
                                                                    'module_option_processing'  =>  array( $this, '_module_option_processing' ),
                                                    
                                                                    'processing_order'  =>  70
                                                                    );
                                                                    
                    return $this->component_settings;   
                }
                
                
            function _init_remove_header_link( $saved_field_data )
                {
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                    
                    remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );    
                    
                }
                
            function _init_remove_x_powered_by($saved_field_data)
                {
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                        
                    
                }
                
            function _callback_saved_remove_x_powered_by($saved_field_data)
                {
                    $processing_response    =   array();
                    
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                        
                    global $blog_id;
                    if(is_multisite())
                        {
                            $blog_details   =   get_blog_details( $blog_id );
                            $ms_settings    =   $this->wph->functions->get_site_settings('network');
                        } 
                    
                    if($this->wph->server_htaccess_config   === TRUE)                               
                        {
                            if( ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'no' ) ||    ! is_multisite() )
                                {
                                    $processing_response['rewrite'] = '
                                                                        <FilesMatch "">
                                                                                <IfModule mod_headers.c>
                                                                                    Header unset X-Powered-By
                                                                                </IfModule>
                                                                            </FilesMatch>';
                                }
                        }
                            
                    if($this->wph->server_web_config   === TRUE)
                        {
                            //to be implemented
                            
                            $processing_response['rewrite'] =   '';
                        }
                                
                    return  $processing_response;   
                }
                
                
            function _init_remove_x_pingback($saved_field_data)
                {
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                        
                    
                }
                
            function _callback_saved_remove_x_pingback($saved_field_data)
                {
                    $processing_response    =   array();
                    
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE; 
                    
                    global $blog_id;
                    if(is_multisite())
                        {
                            $blog_details   =   get_blog_details( $blog_id );
                            $ms_settings    =   $this->wph->functions->get_site_settings('network');
                        }
                    
                    if($this->wph->server_htaccess_config   === TRUE)
                        {                               
                            if( ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'no' ) ||    ! is_multisite() )
                                {
                                    $processing_response['rewrite'] = '
                                                                        <FilesMatch "">
                                                                            <IfModule mod_headers.c>
                                                                                Header unset X-Pingback
                                                                            </IfModule>
                                                                        </FilesMatch>';
                                }
                        }
                            
                    if($this->wph->server_web_config   === TRUE)
                        {
                            //Not implemented
                        }
                    
                    if($this->wph->server_nginx_config   === TRUE)           
                        {
                            //Not Implemented
                            //Require a custom module to deply on the server https://github.com/openresty/headers-more-nginx-module#more_set_headers   
                        }
                                
                    return  $processing_response;   
                }
                
                
            function _module_option_html( $module_setting )
                {
                    if(!empty($module_setting['value_description'])) 
                        { 
                            ?><p class="description"><?php echo $module_setting['value_description'] ?></p><?php 
                        }
                    
                    $class          =   'replacement_field text';
                    
                    ?>
                    <!-- WPH Preserve - Start -->
                    <div id="replacer_read_root" style="display: none">
                        <p><input name="<?php echo $module_setting['id'] ?>[replaced][]" class="<?php echo $class ?>" value="" placeholder="Header to Replace" type="text">  <a href="javascript: void(0);" onClick="WPH.replace_text_remove_row( jQuery(this).closest('p'))"><span alt="f335" class="close dashicons dashicons-no-alt">&nbsp;</span></a> </p>
                    </div>
                    <?php
                    
                    $values =   $this->wph->functions->get_site_module_saved_value('remove_custom_header',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                    
                    if ( ! is_array($values))
                        $values =   array();
                    
                    if ( count ( $values )  >   0 )
                        {
                            foreach ( $values   as  $header)
                                {
                                    ?><p>
                                        <input name="<?php echo $module_setting['id'] ?>[replaced][]" class="<?php echo $class ?>" value="<?php echo htmlspecialchars(stripslashes( $header )) ?>" placeholder="Header to Replace" type="text">
                                        <a href="javascript: void(0);" onClick="WPH.replace_text_remove_row( jQuery(this).closest('p'))"><span alt="f335" class="close dashicons dashicons-no-alt">&nbsp;</span></a> 
                                    </p><?php
                                }
                        }
                                                                        
                    ?>
                        <div id="replacer_insert_root">&nbsp;</div>
                        
                        <p>
                            <button type="button" class="button alignleft" onClick="WPH.replace_text_add_row()">Add New</button>
                        </p>
                        
                        <!-- WPH Preserve - Stop -->
                    <?php
                }
                
                
                
            function _module_option_processing( $field_name )
                {
                    
                    $results            =   array();
                                        
                    $data       =   $_POST['remove_custom_header'];
                    $values     =   array();
                    
                    if  ( is_array($data )  &&  count ( $data )   >   0     &&  isset($data['replaced'])  )
                        {
                            foreach(    $data['replaced']   as  $key =>  $text )
                                {
      
                                    $replaced_text  =   stripslashes($text);
                                    $replaced_text  =   trim($replaced_text);
                                                       
                                    if ( ! empty( $replaced_text ) )
                                        {
                                            $values[]  =  $replaced_text;   
                                            
                                        }
                                    
                                }
                        }
                    
                    $results['value']   =   $values;  
                    
                    return $results;
                    
                }
                
                
            function _callback_saved_remove_custom_header( $saved_field_data )
                {
                    $processing_response    =   array();
                    
                    if( ! is_array($saved_field_data)   ||  count ( $saved_field_data ) < 1 )
                        return FALSE; 
                    
                    global $blog_id;
                    if(is_multisite())
                        {
                            $blog_details   =   get_blog_details( $blog_id );
                            $ms_settings    =   $this->wph->functions->get_site_settings('network');
                        }
                    
                    if($this->wph->server_htaccess_config   === TRUE)
                        {                               
                            if( ( is_multisite() &&  $ms_settings['allow_every_site_to_change_options']  ==  'no' ) ||    ! is_multisite() )
                                {
                                    $processing_response['rewrite'] = '
                                                                        <FilesMatch "">
                                                                            <IfModule mod_headers.c>
                                                                                ';
                                    foreach ( $saved_field_data as $header )
                                        {
                                            $processing_response['rewrite'] .=   '  Header unset ' . $header . "\n";
                                        }
                                        
                                    $processing_response['rewrite'] .=   ' </IfModule>
                                                                        </FilesMatch>';
                                }
                        }
                            
                    if($this->wph->server_web_config   === TRUE)
                        {
                            //Not implemented
                        }
                    
                    if($this->wph->server_nginx_config   === TRUE)           
                        {
                            //Not Implemented
                            //Require a custom module to deply on the server https://github.com/openresty/headers-more-nginx-module#more_set_headers   
                        }
                                
                    return  $processing_response;   
                }    


        }
?>