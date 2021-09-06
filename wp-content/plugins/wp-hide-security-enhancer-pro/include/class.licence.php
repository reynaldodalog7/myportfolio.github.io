<?php   
    
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
           
    class WPH_licence
        {
         
            function __construct()
                {
                    $this->licence_deactivation_check();   
                }
                
            function __destruct()
                {
                    
                }
            
            /**
            * Retrieve licence details
            * 
            */
            public function get_licence_data()
                {
                    $licence_data = get_site_option('wph_licence');
                    
                    $default =   array(
                                            'key'               =>  '',
                                            'last_check'        =>  '',
                                            'licence_status'    =>  '',
                                            'licence_expire'    =>  ''
                                            );    
                    $licence_data           =   wp_parse_args( $licence_data, $default );
                    
                    return $licence_data;
                }
                
                
            public function reset_licence_data( $licence_data )
                {
                    if  ( ! is_array( $licence_data ) ) 
                        $licence_data   =   array();
                        
                    $licence_data['key']                =   '';
                    $licence_data['last_check']         =   '';
                    $licence_data['licence_status']     =   '';
                    $licence_data['licence_expire']     =   '';
                    
                    return $licence_data;
                }
            
            /**
            * Set licence data
            *     
            * @param mixed $licence_data
            */
            public function update_licence_data( $licence_data )
                {
                    update_site_option('wph_licence', $licence_data);   
                }
            
                
            public function licence_key_verify()
                {
                    return TRUE;
                }
            
                
            function is_local_instance()
                {
                    return FALSE;
                    
                    if( defined('WPH_REQUIRE_KEY') &&  WPH_REQUIRE_KEY    === TRUE    )
                        return FALSE;
                                            
                    $instance   =   trailingslashit( WPH_INSTANCE );
                    if(
                            stripos($instance, base64_decode('bG9jYWxob3N0Lw==')) !== FALSE
                        ||  stripos($instance, base64_decode('MTI3LjAuMC4xLw==')) !== FALSE
                        ||  stripos($instance, base64_decode('LmRldg==')) !== FALSE
                        ||  stripos($instance, base64_decode('c3RhZ2luZy53cGVuZ2luZS5jb20=')) !== FALSE
                        )
                        {
                            return TRUE;   
                        }
                        
                    return FALSE;
                    
                }
                
                
            function licence_deactivation_check()
                {

                    if(!$this->licence_key_verify() ||  $this->is_local_instance()  === TRUE)
                        return;
                    
                    //do not trigger if on server API
                    $api_parse_url  =   parse_url( WPH_UPDATE_API_URL );
                    if ( $api_parse_url['host'] ==  WPH_INSTANCE )
                        return;
                    
                    $licence_data = $this->get_licence_data();
                    
                    if(isset($licence_data['last_check']))
                        {
                            if(time() < ($licence_data['last_check'] + 86400))
                                {
                                    return;
                                }
                        }
                    
                    $licence_key = $licence_data['key'];
                    $args = array(
                                                'woo_sl_action'         => 'status-check',
                                                'licence_key'           => $licence_key,
                                                'product_unique_id'     => WPH_PRODUCT_ID,
                                                'domain'                => WPH_INSTANCE,
                                                
                                                '_get_product_meta'     =>  '_sl_new_version'
                                            );
                    $request_uri    = WPH_UPDATE_API_URL . '?' . http_build_query( $args , '', '&');
                    $data           = wp_remote_get( $request_uri );
                    
                    if(is_wp_error( $data ) || $data['response']['code'] != 200)
                        return;   
                    
                    $response_block = json_decode($data['body']);
                    $response_block = $response_block[count($response_block) - 1];
                    $response = $response_block->message;
                    
                    if(isset($response_block->status))
                        {                            
                            if($response_block->status == 'success')
                                {
                                    if($response_block->status_code == 's203' || $response_block->status_code == 's204')
                                        {
                                            $licence_data   =   $this->reset_licence_data( $licence_data );
                                        }
                                        else
                                        {
                                            $licence_data['licence_status']         = isset( $response_block->licence_status ) ?    $response_block->licence_status :   ''  ;
                                            $licence_data['licence_expire']         = isset( $response_block->licence_expire ) ?    $response_block->licence_expire :   ''  ;   
                                            $licence_data['_sl_new_version']        = isset( $response_block->_sl_new_version ) ?    $response_block->_sl_new_version :   ''  ;   
                                        }
                                }
                                
                            if($response_block->status == 'error')
                                {
                                    $licence_data   =   $this->reset_licence_data( $licence_data );
                                } 
                        }
                    
                    $licence_data['last_check']   = time();    
                    $this->update_licence_data( $licence_data );
                    
                }
            
            
        }
            

        
    
?>