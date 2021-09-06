<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_general_text_replace extends WPH_module_component
        {
            function get_component_title()
                {
                    return "Text Replace";
                }
                                        
            function get_module_component_settings()
                {
                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'text_replace',
                                                                    'label'         =>  __('Text Replace',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Arbitrary text replacement from HTML. The substitution is case-sensitive, also spaces in front or at the end are being used. The replacements occur only on front-side.',  'wp-hide-security-enhancer') . '<br /><span class="info"> '. __('This can produce layout issues, use with caution. Mainly this should be used with long texts or html blocks, which allows exact and focused replacements. For other, the CSS class/ID and JavaScript Variables replacements should be considered. If something break, the replacement should be removed.', 'wp-hide-security-enhancer') . '</span>',
                                                                    
                                                                    'input_type'    =>  'custom',
                                                                    'default_value' =>  array(),
                                                                    
                                                                    'module_option_html_render' =>  array( $this, '_module_option_html' ),
                                                                    
                                                                    'module_option_processing'  =>  array( $this, '_module_option_processing' ),
                                                                    
                                                                    'processing_order'  =>  10
                                                                    
                                                                    ); 
                     
                                                                    
                    return $this->component_settings;  
                     
                }
                
                
                
            function _init_text_replace (   $saved_field_data   )
                {
                    if( empty($saved_field_data) ||  ! is_array($saved_field_data) )
                        return FALSE;
                    
                    //only for front side
                    if( defined('WP_ADMIN') &&  ( !defined('DOING_AJAX') ||  ( defined('DOING_AJAX') && DOING_AJAX === FALSE )) && ! apply_filters('wph/components/force_run_on_admin', FALSE ) )
                        return;
                        
                    add_filter('wp-hide/ob_start_callback/pre_replacements', array($this, '_do_html_replacements'), 5);
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
                        <p><input name="<?php echo $module_setting['id'] ?>[replaced][]" class="<?php echo $class ?>" value="" placeholder="String to be Replaced" type="text"> <span alt="f345" class="dashicons dashicons-arrow-right-alt2">&nbsp;</span> <input name="<?php echo $module_setting['id'] ?>[replace][]" class="<?php echo $class ?>" value="" placeholder="String to Replace" type="text"> <a href="javascript: void(0);" onClick="WPH.replace_text_remove_row( jQuery(this).closest('p'))"><span alt="f335" class="close dashicons dashicons-no-alt">&nbsp;</span></a> </p>
                    </div>
                    <?php
                    
                    $values =   $this->wph->functions->get_site_module_saved_value('text_replace',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                    
                    if ( ! is_array($values))
                        $values =   array();
                    
                    if ( count ( $values )  >   0 )
                        {
                            foreach ( $values   as  $block)
                                {
                                    ?><p>
                                        <input name="<?php echo $module_setting['id'] ?>[replaced][]" class="<?php echo $class ?>" value="<?php echo htmlspecialchars(stripslashes($block[0])) ?>" placeholder="String to be Replaced" type="text"> <span alt="f345" class="dashicons dashicons-arrow-right-alt2">&nbsp;</span> 
                                        <input name="<?php echo $module_setting['id'] ?>[replace][]" class="<?php echo $class ?>" value="<?php echo htmlspecialchars(stripslashes($block[1])) ?>" placeholder="String to Replace" type="text"> 
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
                                        
                    $data       =   $_POST['text_replace'];
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
                    
                    $values =   $this->wph->functions->get_site_module_saved_value( 'text_replace',  $this->wph->functions->get_blog_id_setting_to_use() );
                        
                    if ( count ( $values )  >   0 )
                        {
                            foreach ( $values   as  $block)
                                {
                                    $buffer =   str_replace( stripslashes(htmlspecialchars_decode($block[0])), stripslashes(htmlspecialchars_decode($block[1])), $buffer);
                                }
                        }   
                    
                    return $buffer;   
                }
                
  
        }
?>