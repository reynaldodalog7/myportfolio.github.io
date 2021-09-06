
    class WPH_Class {
            
               
            replace_text_add_row   () {
                
                var html    =   jQuery('#replacer_read_root').html();
                
                jQuery( html ).insertBefore( '#replacer_insert_root' );    
                
            }
            
            replace_text_remove_row   ( element ) {
                                
                jQuery( element ).remove();    
                
            }
            
            
            options_field_changed  ( field_id ) {
                
                switch (field_id)
                    {
                        case 'nginx_generate_simple_rewrite'    :
                                                                    var field_value =   jQuery( '#' + field_id  + ' option:selected').val();
                                                                    if  ( field_value == 'yes' )
                                                                        jQuery('#allow_every_site_to_change_options').val('no');
                                                                    break;
                        
                        case 'allow_every_site_to_change_options'    :
                                                                    var field_value =   jQuery( '#' + field_id  + ' option:selected').val();
                                                                    if  ( field_value == 'yes' )
                                                                        jQuery('#nginx_generate_simple_rewrite').val('no');
                                                                    break;
                        
                        
                    }
                
            }
            
            
    }
    
    var WPH = new WPH_Class();
