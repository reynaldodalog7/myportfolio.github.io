<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_general_css_id_replace extends WPH_module_component
        {
            private $current_placeholder        =   '';
            public  $placeholders               =   array();
            public  $placeholders_map           =   array();
            
            public $placeholder_hash            =   '';
            
            public $buffer                      =   '';
            
            private $text_replacement_pair      =   array();
            
            
            function get_component_title()
                {
                    return "CSS ID Replace";
                }
                                        
            function get_module_component_settings()
                {
                              
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'css_id_replace',
                                                                    'label'         =>  __('CSS ID Replace',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  '<span class="info">' . __('This require the ', 'wp-hide-security-enhancer') . '<a href="admin.php?page=wp-hide-general-css&component=css-combine">' . __('CSS Combine', 'wp-hide-security-enhancer') . '</a>' . __(' to be set to Yes.', 'wp-hide-security-enhancer') . '</span>' .
                                                                                        '<br />' .  __('This option apply only for front side.', 'wp-hide-security-enhancer') .  __('Arbitrary CSS ID replacement for HTML and Cascading Style Sheets. The word case it used acordingly.',  'wp-hide-security-enhancer') 
                                                                                        ,
                                                                    
                                                                    'input_type'    =>  'custom',
                                                                    'default_value' =>  array(),
                                                                    
                                                                    'module_option_html_render' =>  array( $this, '_module_option_html' ),
                                                                    
                                                                    'module_option_processing'  =>  array( $this, '_module_option_processing' ),
                                                                    'processing_order'  =>  70
                                                                    ); 
                     
                                                                    
                    return $this->component_settings;  
                     
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
                        <p><input name="<?php echo $module_setting['id'] ?>[replaced][]" class="<?php echo $class ?>" value="" placeholder="Variable to be Replaced" type="text"> <span alt="f345" class="dashicons dashicons-arrow-right-alt2">&nbsp;</span> <input name="<?php echo $module_setting['id'] ?>[replace][]" class="<?php echo $class ?>" value="" placeholder="Variable to Replace" type="text"> <a href="javascript: void(0);" onClick="WPH.replace_text_remove_row( jQuery(this).closest('p'))"><span alt="f335" class="close dashicons dashicons-no-alt">&nbsp;</span></a> </p>
                    </div>
                    <?php
                    
                    $values =   $this->wph->functions->get_site_module_saved_value('css_id_replace',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                    
                    if ( ! is_array($values))
                        $values =   array();
                    
                    if ( count ( $values )  >   0 )
                        {
                            foreach ( $values   as  $block)
                                {
                                    ?><p>
                                        <input name="<?php echo $module_setting['id'] ?>[replaced][]" class="<?php echo $class ?>" value="<?php echo htmlspecialchars(stripslashes($block[0])) ?>" placeholder="Variable to be Replaced" type="text"> <span alt="f345" class="dashicons dashicons-arrow-right-alt2">&nbsp;</span> 
                                        <input name="<?php echo $module_setting['id'] ?>[replace][]" class="<?php echo $class ?>" value="<?php echo htmlspecialchars(stripslashes($block[1])) ?>" placeholder="Variable to Replace" type="text"> 
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
                                        
                    $data       =   $_POST['css_id_replace'];
                    $values     =   array();
                    
                    if  ( is_array($data )  &&  count ( $data )   >   0     &&  isset($data['replaced'])  )
                        {
                            foreach(    $data['replaced']   as  $key =>  $text )
                                {
                                    $replaced_text  =   stripslashes($text);
                                    $replaced_text  =   trim($replaced_text);
                                    $replaced_text  =   preg_replace("/[^A-Za-z0-9_-]/", '', $replaced_text);
                                    
                                    $replace_text   =   stripslashes($data['replace'][$key]);
                                    $replace_text   =   trim($replace_text);
                                    $replace_text  =   preg_replace("/[^A-Za-z0-9_-]/", '', $replace_text);
                                    
                                    if ( $replaced_text !=  $replace_text   &&  ! empty( $replaced_text ) )
                                        {
                                            $values[]  =  array($replaced_text, $replace_text);   
                                            
                                        }
                                    
                                }
                        }
                    
                    $results['value']   =   $values;  
                    
                    return $results;
                    
                }
                
       
  
        }
?>