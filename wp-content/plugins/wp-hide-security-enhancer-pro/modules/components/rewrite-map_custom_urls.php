<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_rewrite_map_custom_urls extends WPH_module_component
        {
            function get_component_title()
                {
                    return "Map Urls";
                }
                                        
            function get_module_component_settings()
                {
                    if ( $this->_display_condition_available_for_site()   === FALSE )
                        return;
                        
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'map_custom_urls',
                                                                    'label'         =>  __('Map Custom Urls',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Custom URLs mapping for links in HTML. The substitution is case-insensitive.',  'wp-hide-security-enhancer') . '<br />'. __('Example', 'wp-hide-security-enhancer') . ': domain.dev/wp-includes/js/jquery/jquery.js <span alt="f345" class="dashicons dashicons-arrow-right-alt2">&nbsp;</span>  domain.dev/engine.js <br />' . 
                                                                                        __('More details at ', 'wp-hide-security-enhancer') . '<a target="_blank" href="https://www.wp-hide.com/replace-arbitrary-urls-with-custom-ones/">Replace arbitrary URL\'s with custom ones</a>',
                                                                                        
                                                                    'input_type'    =>  'custom',
                                                                    'default_value' =>  array(),
                                                                    
                                                                    'module_option_html_render' =>  array( $this, '_module_option_html' ),
                                                                    
                                                                    'module_option_processing'  =>  array( $this, '_module_option_processing' ),
                                                                    
                                                                    ); 
                     
                                                                    
                    return $this->component_settings;  
                     
                }
                
                
                
            function _init_map_custom_urls (   $saved_field_data   )
                {
                    if( empty($saved_field_data) ||  ! is_array($saved_field_data) )
                        return FALSE;
                        
                    add_filter('wp-hide/ob_start_callback/text_preserve', array($this, '_do_html_replacements'), 999 );
                }
                
            
            function _callback_saved_map_custom_urls( $saved_field_data )
                {
                    $values =   $this->_filter_values( $saved_field_data ); 
                    
                    if ( ! is_array( $values ) ||   count ( $values ) < 1 )
                        return  FALSE;
                        
                        
                    $processing_response    =   array();
                              
                    $rewrite                            =  '';
                    
                    foreach ( $values   as  $key    =>  $block)
                        {
                            $replaced_protocol          =   'http://'   .   str_replace(array ("https://" , "http://"), "", $block[1] );
                            $replacement_protocol       =   'http://'   .   str_replace(array ("https://" , "http://"), "", $block[0] );
                            
                            $replaced_parsed     =   parse_url ( $replaced_protocol );
                            $replacement_parsed =   parse_url ( $replacement_protocol );
                            
                            $rewrite_base   =   $this->wph->functions->get_rewrite_base( $replaced_parsed['path'], FALSE, FALSE );
                            $rewrite_to     =   $this->wph->functions->get_rewrite_to_base( $replacement_parsed['path'], TRUE, FALSE);
                            
                            //append query if exists
                            if  ( isset( $replaced_parsed['query'] ) &&  ! empty ( $replaced_parsed['query'] ) )
                                $rewrite_base   .=  '?' .   $replaced_parsed['query'];
                            if  ( isset( $replacement_parsed['query'] ) &&  ! empty ( $replacement_parsed['query'] ) )
                                $rewrite_to   .=  '?' .   $replacement_parsed['query'];                                
                            
                            $global_match   =   FALSE;
                            if (substr( $block[0] , -1) == '/')
                                $global_match   =   TRUE;
                                
                            if ( $global_match  === TRUE )
                                {
                                    $rewrite_base   .=  '/(.+)'; 
                                    $rewrite_to     .=  '/$1';  
                                }
                                       
                            if($this->wph->server_htaccess_config   === TRUE)
                                {
                                    $rewrite .= "\nRewriteRule ^"    .   $rewrite_base   .   ' '. $rewrite_to .' [L]'; 
                                }
                                
                            if($this->wph->server_web_config   === TRUE)
                                {
                                    $rewrite    =   "\n" . '<rule name="wph-map_custom_urls" stopProcessing="true">';
                                    
                                    $rewrite .=  "\n"  .    '    <match url="^'.  $rewrite_base   .'"  />';
                                    $rewrite .=   "\n" .    '    <action type="Rewrite" url="'.  $rewrite_to .'"  appendQueryString="true" />';
                                    
                                    $rewrite .=  "\n" . '</rule>';
                  
                                }
                                
                            if($this->wph->server_nginx_config   === TRUE)           
                                {
                                    $rewrite        =   array();
                                    $rewrite_list   =   array();
                                    $rewrite_rules  =   array();
                                       
                                       
                                }    
                        }
                    
                    $processing_response['rewrite'] =   $rewrite;
                                
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
                        <p><input name="<?php echo $module_setting['id'] ?>[replaced][]" class="<?php echo $class ?>" value="" placeholder="URL to be Replaced" type="text"> <span alt="f345" class="dashicons dashicons-arrow-right-alt2">&nbsp;</span> <input name="<?php echo $module_setting['id'] ?>[replace][]" class="<?php echo $class ?>" value="" placeholder="URL to Replace" type="text"> <a href="javascript: void(0);" onClick="WPH.replace_text_remove_row( jQuery(this).closest('p'))"><span alt="f335" class="close dashicons dashicons-no-alt">&nbsp;</span></a> </p>
                    </div>
                    <?php
                    
                    $values =   $this->wph->functions->get_site_module_saved_value('map_custom_urls',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                    
                    if ( ! is_array($values))
                        $values =   array();
                    
                    if ( count ( $values )  >   0 )
                        {
                            foreach ( $values   as  $block)
                                {
                                    ?><p>
                                        <input name="<?php echo $module_setting['id'] ?>[replaced][]" class="<?php echo $class ?>" value="<?php echo htmlspecialchars($block[0]) ?>" placeholder="URL to be Replaced" type="text"> <span alt="f345" class="dashicons dashicons-arrow-right-alt2">&nbsp;</span> 
                                        <input name="<?php echo $module_setting['id'] ?>[replace][]" class="<?php echo $class ?>" value="<?php echo htmlspecialchars($block[1]) ?>" placeholder="URL to Replace" type="text"> 
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
                                        
                    $data       =   $_POST['map_custom_urls'];
                    $values     =   array();
                    
                    if  ( is_array($data )  &&  count ( $data )   >   0     &&  isset($data['replaced'])  )
                        {
                            foreach(    $data['replaced']   as  $key =>  $text )
                                {
                                    $replaced_text  =   stripslashes($text);
                                    $replaced_text  =   trim($replaced_text);
                                    $replace_text   =   stripslashes($data['replace'][$key]);
                                    $replace_text   =   trim($replace_text);
                                    
                                    if ( $replaced_text !=  $replace_text   &&  ! empty( $replaced_text ) )
                                        {
                                            $values[]  =  array($replaced_text, $replace_text);   
                                            
                                        }
                                    
                                }
                        }
                    
                    $results['value']   =   $values;  
                    
                    return $results;
                    
                }
                
            function _do_html_replacements( $buffer )
                {
                    
                    $values =   $this->wph->functions->get_site_module_saved_value( 'map_custom_urls',  $this->wph->functions->get_blog_id_setting_to_use() );
                    
                    $values =   $this->_filter_values( $values );
                    
                        
                    if ( count ( $values )  >   0 )
                        {
                            foreach ( $values   as  $block)
                                {
                                    $buffer =   str_replace( $block[0], $block[1], $buffer);
                                }
                        }   
                    
                    return $buffer;   
                }
            
            
            
            function _filter_values( $values )
                {
                    
                    $site_url           =   site_url();
                    $site_url_parsed    =   parse_url( $site_url );
                    
                    $filtered_data  =   array();
                        
                    foreach ( $values  as   $key    =>  $value )
                        {
                            $replace        =   $this->wph->functions->ltrim_array(  trim ( $value[0] ) , array( 'https', 'http', ':', '//' ) );
                            $replacement    =   $this->wph->functions->ltrim_array(  trim ( $value[1] ) , array( 'https', 'http', ':', '//' ) );
                            
                            $replace_protocol       =   'http://'   .   $replace;
                            $replacement_protocol   =   'http://'   .   $replacement;
                            
                            $replace_parsed     =   parse_url ( $replace_protocol );
                            $replacement_parsed =   parse_url ( $replacement_protocol );
                            
                            if (    !isset( $replace_parsed['host'] )   ||  $replace_parsed['host'] !=  $site_url_parsed['host']   ||   !isset( $replacement_parsed['host'] )   ||  $replacement_parsed['host'] !=  $site_url_parsed['host']  )
                                continue;
                                
                            $filtered_data[]    =   array(
                                                            $replace,
                                                            $replacement  
                                                            );
                        
                        }    
                    
                    
                    return $filtered_data;
                    
                }
      
                
            function _display_condition_available_for_site( $module_setting_args    =   array() )
                {
                    if  ( is_multisite() )
                        return FALSE;
                    
                    return TRUE;

                }
                
  
        }
?>