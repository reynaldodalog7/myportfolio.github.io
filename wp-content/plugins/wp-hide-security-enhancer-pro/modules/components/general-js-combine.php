<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_general_js_combine extends WPH_module_component
        {
            private $current_placeholder            =   '';
            public  $placeholders                   =   array();
            public  $placeholders_map               =   array();
            
            public  $ie_conditionals_placeholders   =   array();
            
            public $placeholder_hash                =   '';
            
            public $buffer                          =   '';
            
            private $text_replacement_pair          =   array();
            
            private $settings_hash                  =   '';
            private $buffer_hash                    =   '';
            
            private $filename_js_ignore             =   FALSE;
            private $content_js_ignore              =   FALSE;
            
            
            function get_component_title()
                {
                    return "JavaScript Combine";
                }
                                        
            function get_module_component_settings()
                {
                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'js_combine_code',
                                                                    'label'         =>  __('JavaScript Combine Code',    'wp-hide-security-enhancer'),
                                                                    'description'   =>   __('All JavaScript links and inline JavaScript will be combined in 2 files, one in header and another in footer.', 'wp-hide-security-enhancer') .
                                                                                        '<br />'    .   __('If the site use a plugin (e.g. cache plugin) to concatenate/compress JavaScript files, this functionality may fail. .', 'wp-hide-security-enhancer'),
                                                                    
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
                                                                    'id'            =>  'js_combine_excludes',
                                                                    'label'         =>  __('Exclude script from JavaScript Combine',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Specify any script which will be excluded when using JavaScript Combine.', 'wp-hide-security-enhancer') .
                                                                                        '<br />'    .   __('Use only script name e.g. mediaelement-and-player.min.js, one per row.', 'wp-hide-security-enhancer'),
                                                                    
                                                                    'input_type'    =>  'textarea',
                                                                    'default_value' =>  '',
                                                                    
                                                                    'sanitize_type' =>  array(),
                                                                    'processing_order'  =>  70
                                                                    );
                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'js_combine_block_excludes',
                                                                    'label'         =>  __('Exclude JavaScript Block from Combine',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Specify partial JavaScript code block to be excluded from Combine. Use a full line or part of it to avoid matching other codes, avoid simple words which can match other JavaScript.', 'wp-hide-security-enhancer'),
                                                                    
                                                                    'input_type'    =>  'custom',
                                                                    'default_value' =>  array(),
                                                                    
                                                                    'module_option_html_render' =>  array( $this, '_module_option_html' ),
                                                                    
                                                                    'module_option_processing'  =>  array( $this, '_module_option_processing' ),
                                                                    'processing_order'  =>  70
                                                                    ); 
                                                                    
                    return $this->component_settings;  
                     
                }
                
                
                
            function _init_js_combine_code (   $saved_field_data   )
                {
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                    
                    if( defined('WP_ADMIN') &&  ( !defined('DOING_AJAX') ||  ( defined('DOING_AJAX') && DOING_AJAX === FALSE )) && ! apply_filters('wph/components/force_run_on_admin', FALSE ) )
                        return;
                        
                    add_filter('wp-hide/ob_start_callback/pre_replacements',                                array( $this, '_do_html_replacements'));
                    add_filter('wp-hide/module/general_js_variables_replace/placeholder_ignore_inline_js',  array( $this, '_placeholder_ignore_inline_js'), 10, 2);
                }
                
                
           
            
            
            function _do_html_replacements( $buffer )
                {
                    
                    if  ( empty ( $buffer ) )
                        return $buffer;
                    
                    //if not a HTML page, return the buffer
                    if  ( stripos($buffer, '<body')    ===    FALSE )
                        return $buffer;
                    
                    global $wp_filesystem;

                    if (empty($wp_filesystem)) 
                        {
                            
                            require_once (ABSPATH . '/wp-includes/l10n.php');
                            require_once (ABSPATH . '/wp-includes/formatting.php');
                            require_once (ABSPATH . '/wp-admin/includes/file.php');
                            WP_Filesystem();
                        }    
                        
                    $access_type = get_filesystem_method();
                    if($access_type !== 'direct')
                        return FALSE;
                    
                    //crate a hash using content and current settings to prevent js_content re-proecessing
                    if  ( empty ( $this->settings_hash ) )
                        {
                            $this->settings_hash    =   $this->wph->functions->get_current_site_settings_hash();   
                        }
                        
                    $this->buffer_hash  =   md5( $buffer . $this->settings_hash ) ;
                    
                    //add placeholders for IE conditionals
                    $modified_buffer               =   preg_replace_callback( '/<!--[\s]?\[if(.|\s)+?-->/ism' ,array($this, 'add_placeholder_for_ie_conditionals') , $buffer);
                    
                    $this->placeholder_hash =   '%WPH-PLACEHOLDER-REPLACEMENT';
                       
                    //split the buffer
                    list( $header_content, $body_content )    =   preg_split('/<body/i', $modified_buffer);
                    
                    if (    empty($header_content)  ||  empty ( $body_content ) )
                        return $buffer;
                    
                    $this->current_placeholder  =   'header';
                    $this->placeholders[ $this->current_placeholder ]   =   array();
                    $this->buffer               =   $header_content;    
                    $this->buffer               =   preg_replace_callback( '/(\s*)<script(\b[^>]*?>)([\s\S]*?)<([\s\/]+)script>(\s*)/i' ,array($this, 'add_js_placeholders_callback') , $this->buffer);
                   
                    $js_recipient_content       =   $this->placeholders_process();
                    $status                     =   $this->write_to_cache( $js_recipient_content );
                    if  ( $status === FALSE )
                        return $buffer;
                    $this->content_process( );
                    $header_content             =   $this->buffer;
                    
                    
                    $this->current_placeholder  =   'footer'; 
                    $this->placeholders[ $this->current_placeholder ]   =   array();   
                    $this->buffer               =   $body_content;    
                    $this->buffer               =   preg_replace_callback( '/(\s*)<script(\b[^>]*?>)([\s\S]*?)<([\s\/]+)script>(\s*)/i' ,array($this, 'add_js_placeholders_callback') , $this->buffer);
                   
                    $js_recipient_content       =   $this->placeholders_process();
                    $status                     =   $this->write_to_cache( $js_recipient_content );
                    if  ( $status === FALSE )
                        return $buffer;
                    $this->content_process( );
                    $body_content               =   $this->buffer;
                    
                    
                    $buffer =   $header_content .   '<body'  .   $body_content;
                    
                    //restore the IE conditionals 
                    if ( count ( $this->ie_conditionals_placeholders ) >    0 )
                        {
                            foreach ( $this->ie_conditionals_placeholders   as  $placeholder    =>  $code_block )
                                {
                                     $buffer  =   str_replace($placeholder, $code_block, $buffer);   
                                }       
                        }
                                        
                    return $buffer;   
                }
                
                
                
            /**
            * Preserve any IE conditionals
            * 
            * @param mixed $match
            */
            function add_placeholder_for_ie_conditionals( $match )
                {
                    
                    $match_block    =   $match[0];
                    
                    $placeholder    =   $this->placeholder_hash . '-ie-conditional-' . count( $this->ie_conditionals_placeholders ) . '%';
                    $this->ie_conditionals_placeholders[ $placeholder ] =   $match_block;
                    
                    return $placeholder;

                }
            
            
            /**
            * Extract all JS
            *                 
            * @param mixed $match
            */
            function add_js_placeholders_callback( $match )
                {
                    
                    $pre_space      =   $match[1] === '' ? ''   :   ' ';
                    $tag_attrs      =   $match[2];
                    $tag_content    =   $match[3];
                    $post_space     =   $match[4] === '' ? ''   :   ' ';
                    
                    $match_block    =   $pre_space . '<script' . $tag_attrs . $tag_content . '</script>' . $post_space;
                    
                    $placeholder    =   $this->placeholder_hash . '-js-' . count( $this->placeholders[ $this->current_placeholder ] ) . '%';
                    $this->placeholders[ $this->current_placeholder ][ $placeholder ] =   preg_replace('/\n(\s*\n){2,}/', "\n\n", trim($match_block) );
                    
                    return $placeholder;
                    
                }
                
            
            /**
            * Process the placeholders
            * 
            */
            function placeholders_process()
                {
                    
                    $js_recipient_content   =   array();
                    
                    $local_url_parsed   =   parse_url( home_url() );
                    $use_cdn            =   $this->wph->functions->get_site_module_saved_value('cdn_url',  $this->wph->functions->get_blog_id_setting_to_use());
                    
                    $document_root      =   isset($_SERVER['DOCUMENT_ROOT'])    &&  ! empty( $_SERVER['DOCUMENT_ROOT'] )    ?   $_SERVER['DOCUMENT_ROOT']   :   ABSPATH;
                    
                    libxml_use_internal_errors(true);
                    
                    foreach ( $this->placeholders[ $this->current_placeholder ]   as  $placeholder    =>  $code_block )
                        {
                            
                            $doc = new DOMDocument();
                            $doc->loadHTML( $code_block );

                            //$element_content    =   $doc->getElementsByTagName('script')[0]->nodeValue;
                            //use prg_math to avoid tag strip
                            preg_match('/<script[^>]*>(.*)<\/script>/is', $code_block, $matches );
                            $element_content    =   isset ( $matches[1] ) ?     $matches[1] :   '';
                            
                            $element_type       =   $doc->getElementsByTagName('script')[0]->getAttribute('type');
                            $element_src        =   $doc->getElementsByTagName('script')[0]->getAttribute('src');
                            
                            if  ( ! empty ( $element_src ) ) 
                                $resurce_url_parsed =   parse_url( $element_src );
                            
                            //check for valid script
                            if ( ! empty ( $element_type )  &&  strtolower($element_type)   !=  'text/javascript')
                                {
                                    $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'non-js';
                                    continue;
                                }
                            
                            //check if the resource is on local    
                            if ( ! empty ( $element_src )    &&  $local_url_parsed['host']  !=  $resurce_url_parsed['host']     &&  $use_cdn    !=  $resurce_url_parsed['host']) 
                                {
                                    $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'remote-file-js';
                                    continue;
                                }

                            if  (   ! empty ( $element_content ) )
                                {
                                    
                                    $ignore =   apply_filters('wp-hide/module/general_js_variables_replace/placeholder_ignore_inline_js', FALSE, $element_content);
                                    
                                    //check for content ignore
                                    if  ( $this->_js_content_ignore_check( $element_content ) )
                                        {
                                            $ignore =   TRUE;    
                                        }
                                    
                                    if ( $ignore )
                                        {
                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'ignore-inline-js';   
                                        }
                                        else
                                        {
                                            
                                            //Allow pre-processing 
                                            $element_content =    apply_filters( 'wp-hide/module/general_js_combine/placeholders_process/element_content', $element_content, FALSE );
                                            
                                            $js_recipient_content[$placeholder]   =  "\n"  .  $element_content;
                                         
                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'inline-js';
                                        }
                                    
                                }
                                else
                                {
                
                                    //check for filename ignore
                                    if  ( $this->_js_file_ignore_check( $element_src ) ||   strpos( $element_src, '/cache/wph/')   !== FALSE    )
                                        {
                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'ignore-local-file-js';
                                            continue;    
                                        }
                                    
                                    $resurce_path   =   $resurce_url_parsed['path'];
                                    if  ( is_multisite() &&  $this->wph->default_variables['network']['current_blog_path']  !=  '/' )
                                        {
                                            $resurce_path   =   preg_replace("/^". preg_quote( $this->wph->default_variables['network']['current_blog_path'], '/' ) ."/i", "", $resurce_url_parsed['path']);
                                            if ( strpos($resurce_path, "/") !== 0 )
                                                $resurce_path   =   '/' .   $resurce_path;
                                        }
                                              
                                    //attempt to retrieve the file locally
                                    $local_file_path    =   $document_root .    $resurce_path;
                                    if ( !  file_exists ( $local_file_path ) )
                                        {
                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'local-not-found-file-js';
                                            continue;
                                        }
                                        
                                    $resurce_url_file_info =   pathinfo( $resurce_path );
                                    if  ( ! isset($resurce_url_file_info['extension'])  ||  $resurce_url_file_info['extension'] !=  'js')
                                        {
                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'local-no-js-file';
                                            continue;
                                        }
                                    
                                    $local_file_content =   @file_get_contents ( $local_file_path );
                                    
                                    if ( $local_file_content    === FALSE )
                                        continue;
                                                                            
                                    //check for content ignore
                                    if  ( $this->_js_content_ignore_check( $local_file_content ) )
                                        {
                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'ignore-local-file-js';
                                            continue;    
                                        }
                                    
                                    //Allow pre-processing 
                                    $local_file_content =    apply_filters( 'wp-hide/module/general_js_combine/placeholders_process/element_content', $local_file_content, $local_file_path );
                                        
                                    $js_recipient_content[$placeholder]   =  "\n"  .  $local_file_content;
                                    
                                    if ( !empty ( $use_cdn )    &&  $use_cdn    ==  $resurce_url_parsed['host'] )
                                        $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'cdn-local-file-js';
                                        else
                                        $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'local-file-js';
                                    
                                }

                        }
                        
                    libxml_clear_errors();
                    
                    return $js_recipient_content;
                    
                }
            
            
            
            /**
            * Write the $js_recipient_content to cache
            * 
            * @param mixed $js_recipient_content
            */
            function write_to_cache( $js_recipient_content )
                {
                    $CDN_url                    =   $this->wph->functions->get_site_module_saved_value('cdn_url',                   $this->wph->functions->get_blog_id_setting_to_use());
                    if ( ! empty ( $CDN_url ) )
                        {
                            $cdn_use_for_cache_files    =   $this->wph->functions->get_site_module_saved_value('cdn_use_for_cache_files',   $this->wph->functions->get_blog_id_setting_to_use());
                            $home_url           =   home_url();
                            $home_url_parsed    =   parse_url($home_url);
                        }
                        
                    $js_content =   '';
                    foreach ( $this->placeholders[ $this->current_placeholder ]   as  $placeholder    =>  $code_block )
                        {
                            if  ( in_array( $this->placeholders_map[ $this->current_placeholder ][$placeholder], array( "non-js" ) ) )
                                continue;
                            
                            if  ( in_array( $this->placeholders_map[ $this->current_placeholder ][$placeholder], array( "inline-js", "local-file-js", "cdn-local-file-js" ) ) )
                                {
                                    $js_content .=   '#! WPH-JS-Content-Start' . "\n" . $js_recipient_content[$placeholder] ."\n";
                                    $this->placeholders[ $this->current_placeholder ][$placeholder]   =   '';
                                }
                                else if    ( in_array( $this->placeholders_map[ $this->current_placeholder ][$placeholder], array( "ignore-inline-js" ) ) )
                                {
                                    //process the ignore-inline-js
                                    $this->placeholders[ $this->current_placeholder ][$placeholder]   =  $this->js_recipient_process( $this->placeholders[ $this->current_placeholder ][$placeholder] );                                    
                                }
                                else  if    ( in_array( $this->placeholders_map[ $this->current_placeholder ][$placeholder], array( "remote-file-js", "local-no-js-file", "ignore-local-file-js" ) )    &&  ! empty ( $js_content ) )
                                {
                                    
                                    $file_url   =   $this->write_file( $js_content );
                                    if  (   $file_url   === FALSE )
                                        return FALSE;
                                        
                                    //check if using CDN with url replace for cached files
                                    if  (   ! empty ( $CDN_url )    &&  $cdn_use_for_cache_files  ==  'yes'   )
                                        $file_url   =   str_ireplace(   $home_url_parsed['host'],   $CDN_url, $file_url );
                                    
                                    $this->placeholders[ $this->current_placeholder ][ $placeholder ]   =   '<script type="text/javascript" src="'. $file_url   .'"></script>'  .   $this->placeholders[ $this->current_placeholder ][ $placeholder ];
                                        
                                    $js_content =   '';
                                }
                        }
                        
                    if  (  ! empty ( $js_content ) )
                        {
                            //add insert for the last js block
                            $placeholder    =   $this->content_last_placeholder();
                            
                            $file_url   =   $this->write_file( $js_content );
                            if  (   $file_url   === FALSE )
                                return FALSE;
                                
                            //check if using CDN with url replace for cached files
                            if  (   ! empty ( $CDN_url )    &&  $cdn_use_for_cache_files  ==  'yes'   )
                                $file_url   =   str_ireplace(   $home_url_parsed['host'],   $CDN_url, $file_url );
                            
                            $this->placeholders[ $this->current_placeholder ][ $placeholder ]   =   '<script type="text/javascript" src="'. $file_url   .'"></script>';
                                
                            $js_content =   '';
                        }
                    
                }
            
            
            /**
            * Write the js content and to the replacements
            * 
            * @param mixed $filename_path
            * @param mixed $content
            */
            function write_file( $js_content )
                {
                    global $wp_filesystem;
                    
                    //explode the blocks
                    $js_content_blocks  =   explode('#! WPH-JS-Content-Start', $js_content );
                    $js_content_blocks  =   array_map("trim", $js_content_blocks);
       
                    $js_content =   '';
       
                    foreach ( $js_content_blocks    as $key =>  $js_content_block )
                        {
                            if  (  empty ( $js_content_block ) )
                                continue;
                            
                            $hash   =   md5 ( $js_content_block ); 
                            
                            $file_path  =   WPH_CACHE_PATH  .   'block_' . $this->settings_hash . '_' . $hash   .'.js';
                            
                            //if block already processed, just load it
                            if ( file_exists ( $file_path ) )
                                {
                                    $js_content .=  "\n" .  $wp_filesystem->get_contents( $file_path ) ;                                            
                                    continue;   
                                }
                                
                            $js_content_block   =   $this->js_recipient_process( $js_content_block );
                            
                            //write the file for later usage
                            $wp_filesystem->put_contents( $file_path, $js_content_block, FS_CHMOD_FILE );
                                                      
                            //do the replcaements
                            $js_content .=   "\n" . $js_content_block;  
                            
                        }
                    
                    
                    
                    $hash   =   md5 ( $js_content );
                                    
                    $file_path  =   WPH_CACHE_PATH  .   $this->settings_hash . '_' . $hash   .'.js';
                    $file_url   =   WPH_CACHE_URL   .   $this->settings_hash . '_' . $hash   .'.js';
                    
                    if ( file_exists ( $file_path ) )
                        return $file_url;
  
                    //check if the file alreadyexists
                    if ( ! file_exists ( $file_path ) )
                        {                                

                            $fp = @fopen( $file_path, 'wb' );
                            if ( ! $fp )
                                return false;
                                
                            if ( ! flock($fp, LOCK_EX)) 
                                return false;

                            mbstring_binary_safe_encoding();

                            $data_length = strlen( $js_content );

                            $bytes_written = fwrite( $fp, $js_content );

                            reset_mbstring_encoding();
                            
                            //flush output before releasing the lock
                            fflush($fp);
                            
                            // release the lock
                            flock($fp, LOCK_UN);

                            fclose( $fp );

                            if ( $data_length !== $bytes_written )
                                return false;

                            $wp_filesystem->chmod( $file_path, FS_CHMOD_FILE );

                            
                        }
                        
                    return $file_url;
                    
                }
                
                
            /**
            * Do the replacements
            * 
            * @param mixed $js_recipient_content
            */
            function js_recipient_process( $js_content )
                {
                                        
                    $values =   $this->wph->functions->get_site_module_saved_value('js_variables_replace',  $this->wph->functions->get_blog_id_setting_to_use());
                    
                    if ( is_array($values)    &&  count($values)  >   0   )
                        {
                    
                            foreach( $values    as  $value_block )
                                {
                                    $this->text_replacement_pair  =   $value_block;
                                    $js_content   =   preg_replace_callback('/\b('    .  $this->text_replacement_pair[0] .   ')\b/m', array($this, 'replace_callback'), $js_content);
                                }
                        }
                    
                        
                    /**
                    * Attempt to process any ID/Class replacements   
                    */
                    //ID replace                     
                    $values =   $this->wph->functions->get_site_module_saved_value('css_id_replace',  $this->wph->functions->get_blog_id_setting_to_use());
                    
                    if ( is_array($values)    &&  count($values)  >   0   )
                        {
                            foreach( $values    as  $value_block )
                                {
                                    $this->text_replacement_pair  =   $value_block;
                                    $js_content   =   preg_replace('/(.*(\'|")#)('    .  $this->text_replacement_pair[0] .   ')((\'|").*)/m', '$1' . $this->text_replacement_pair[1] . '$4', $js_content);      
                                }
                        }
                        
                         
                    //Class replace
                    $values =   $this->wph->functions->get_site_module_saved_value('css_class_replace',  $this->wph->functions->get_blog_id_setting_to_use());
                    //$values    =   '';
                    if ( is_array($values)    &&  count($values)  >   0   )
                        {
                           
                            foreach( $values    as  $value_block )
                                {
                                    $this->text_replacement_pair  =   $value_block;
                                    $find_me        =   $this->text_replacement_pair[0];
                                    $replacement    =   $this->text_replacement_pair[1];
                                    
                                    //check if global or simple
                                    $global_match   =   FALSE;
                                    $regex_data     =   '';
                                    
                                    if ( strpos($find_me, '*') === 0    ||  strrpos($find_me, '*') == strlen($find_me) - 1 )
                                        $global_match   =   TRUE;
                                        
                                    if ( $global_match )
                                        {
                                            $find_me    =   ltrim($find_me, '*');
                                            $find_me    =   rtrim($find_me, '*');
                                            
                                            $this->text_replacement_pair[0] =   $find_me;
                                            
                                            $regex_data =   '(?:[\'"]|(?!^)\G)[\h\>\:\,]*(?:([\w.-]*(?<![^\W_])'. $find_me .'(?![^\W_])[\w.-]*)|[\w.-]+)';
                                        }
                                        else
                                        {
                                            $regex_data =   '[\'"\h](?:[.])?('. $find_me .')[\h\'"]';
                                        }
                                    
                                    $js_content   =   preg_replace_callback('/' . $regex_data . '/', 
                                                    function ( $matches) {
                                                        
                                                        if  ( ! isset ( $matches[1] ) )
                                                            return $matches[0];
                                                                                                                                                                                                  
                                                        $replace        =   $this->text_replacement_pair[0];
                                                        $replacement    =   $this->text_replacement_pair[1];
                                                        
                                                        return str_replace($replace, $replacement, $matches[0]);
                                                            
                                                    } , $js_content);
                                    
                                }

                        }
                        
                        
                    
                    $js_content    =   $this->_process_url_replacements( $js_content );
                    
                    return $js_content;    
                }
                
            
            /**
            * Do url replacements
            *     
            * @param mixed $js_content
            */
            function _process_url_replacements( $js_content )
                {
                    //apply the urs replacements
                    $replacement_list       =   $this->wph->functions->get_replacement_list();
                   
                    //replace the urls
                    $js_content            =   $this->wph->functions->content_urls_replacement($js_content,  $replacement_list );
                    
                    return $js_content;
                    
                }    
            
                
            /**
            * Callback function for replacement
            * 
            * @param mixed $matches
            */
            function replace_callback( $matches ) 
                {
                    $text   =   substr($matches[0], 0, strlen( $matches[0] ) - strlen( $matches[1] ));
                    $text   .=  $this->text_replacement_pair[1];
                          
                    return $text;    
                }
            
            
            /**
            * Add a placeholder for the last js code to be inserted
            * 
            * @param mixed $content
            */
            function content_last_placeholder( )
                {
                    $insert_above_tag    =   '';
                    switch ($this->current_placeholder)
                        {
                            case    'header'   :
                                                                $insert_above_tag   =   'head';
                                                                break;
                                                                
                            case    'footer'   :
                                                                $insert_above_tag   =   'body';
                                                                break;
                        }
                        
                    list( $first_part, $seccond_part )    =   preg_split('/<\/'    .   $insert_above_tag   .'>/i', $this->buffer);   
                    
                    $placeholder    =   $this->placeholder_hash . '-js-' . count( $this->placeholders[ $this->current_placeholder ] ) . '%';
                    $this->placeholders[ $this->current_placeholder ][ $placeholder ] =   '';
                                                                
                    $this->buffer    =   $first_part . $placeholder  .   '</'.$insert_above_tag.'>' .   $seccond_part;
                    
                    return $placeholder;    
                    
                    
                }
            
            
            /**
            * Process the content by removing processed placeholders or restore
            * 
            * @param mixed $content
            */
            function content_process( )
                {
                    
                    //put back the remaining placeholders content
                    foreach ( $this->placeholders[ $this->current_placeholder ]   as  $placeholder    =>  $code_block )
                        {
                             $this->buffer  =   str_replace($placeholder, $code_block, $this->buffer);   
                        }
            
                }
                
                
            
            /**
            * Return the scripts to exclude from js combine
            *     
            */
            function _get_js_combine_excludes()
                {
                    
                    $values =   $this->wph->functions->get_site_module_saved_value( 'js_combine_excludes',  $this->wph->functions->get_blog_id_setting_to_use() );
                    
                    $values =   trim( $values );
                    
                    $lines  =   preg_split ('/\r\n|\n|\r/', $values);
                    
                    $lines  =   array_filter($lines, 'trim');
                    $lines  =   array_filter($lines);
                    $lines  =   array_values($lines);
                    
                    return (array)$lines;
                    
                }
                
            
            
            /**
            * Check for filename ignore
            *     
            * @param mixed $element_href
            */
            function _js_file_ignore_check ( $element_href ) 
                {
                    if ( $this->filename_js_ignore === FALSE )
                        $this->filename_js_ignore    =   $this->_get_js_combine_excludes();
                
                    //check the file name ignore    
                    if ( count ( $this->filename_js_ignore ) >  0 )
                        {
                            //check if in the ignore list
                            foreach ( $this->filename_js_ignore   as  $local_js_ignore_item )
                                {
                                    if ( strpos( $element_href , $local_js_ignore_item ) !==   FALSE )
                                        {
                                            return TRUE;
                                        }   
                                }   
                        }
                    
                    return FALSE;
                    
                }
                
            
            function _js_content_ignore_check( $element_content )
                {
                    if ( $this->content_js_ignore === FALSE )
                        {
                            $this->content_js_ignore    =   (array)$this->wph->functions->get_site_module_saved_value('js_combine_block_excludes',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                            $this->content_js_ignore    =   array_filter( $this->content_js_ignore, 'trim');
                            $this->content_js_ignore    =   array_filter( $this->content_js_ignore);
                            
                            if  ( count ( $this->content_js_ignore ) < 1 )
                                return FALSE;
                            
                            //replace all new lines
                            foreach ( $this->content_js_ignore as   $key    =>  $value )
                                {
                                    $value  =   preg_quote( $value );
                                    $value  =   preg_split('/\r\n|\n|\r/', $value);
                                    $value  =   array_map('trim', $value );
                                    $value  =   implode('([\s]+)?', $value);
                                    
                                    $this->content_js_ignore[ $key ]    =   $value;
                                }   
                            
                        }
                        
                    if  ( count ( $this->content_js_ignore ) < 1 )
                        return FALSE;
                    
                    foreach ( $this->content_js_ignore as   $value )
                        {
                            if ( preg_match( '/' . $value .'/' , $element_content))
                                return TRUE;   
                            
                        }
                                                 
                    return FALSE;   
                }
                
                
            function _module_option_html( $module_setting )
                {
                    if(!empty($module_setting['value_description'])) 
                        { 
                            ?><p class="description"><?php echo $module_setting['value_description'] ?></p><?php 
                        }
                    
                    $class          =   'ex_block';
                    
                    ?>
                    <!-- WPH Preserve - Start -->
                    <div id="replacer_read_root" style="display: none">
                        <p><textarea name="<?php echo $module_setting['id'] ?>[ignore_block][]" class="<?php echo $class ?>" placeholder="JavaScript code block to ignore" type="text"></textarea>  <a href="javascript: void(0);" onClick="WPH.replace_text_remove_row( jQuery(this).closest('p'))"><span alt="f335" class="close dashicons dashicons-no-alt">&nbsp;</span></a> </p>
                    </div>
                    <?php
                    
                    $values =   $this->wph->functions->get_site_module_saved_value('js_combine_block_excludes',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                    
                    if ( ! is_array($values))
                        $values =   array();
                    
                    if ( count ( $values )  >   0 )
                        {
                            foreach ( $values   as  $block)
                                {
                                    ?>
                                    <p><textarea name="<?php echo $module_setting['id'] ?>[ignore_block][]" class="<?php echo $class ?>" placeholder="JavaScript code block to ignore" type="text"><?php echo htmlspecialchars(stripslashes($block)) ?></textarea>  <a href="javascript: void(0);" onClick="WPH.replace_text_remove_row( jQuery(this).closest('p'))"><span alt="f335" class="close dashicons dashicons-no-alt">&nbsp;</span></a> </p>
                                    <?php
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
                                        
                    $data       =   $_POST['js_combine_block_excludes'];
                    $values     =   array();
                    
                    if  ( is_array($data )  &&  count ( $data )   >   0     &&  isset($data['ignore_block'])  )
                        {
                            foreach(    $data['ignore_block']   as  $key =>  $text )
                                {
                                    $ignore_block   =   stripslashes($text);
                                    $ignore_block   =   trim($ignore_block);
                                         
                                    $values[]       =  $ignore_block;
                                    
                                }
                        }
                    
                    $values =   array_filter($values);
                    
                    $results['value']   =   $values;  
                    
                    return $results;
                    
                }
                
                
            
            /**
            * Ignore specific inline 
            * 
            * @param mixed $ignore
            * @param mixed $element_content
            */
            function _placeholder_ignore_inline_js( $ignore, $element_content)
                {
                    //on POST actions, ignore inline content as might create issues when returning JS data being called through POST
                    if  (   count ( $_POST ) > 0 )
                        return TRUE;                    
                    
                    //ignore the inline 'var userSettings = {.. definitiion as it always changes
                    if  ( preg_match( '/.*(var userSettings \= ).*/im', $element_content ))
                        return TRUE;
                        
                    //ignore 'document.write'
                    if  ( preg_match( '/.*document\.write.*/im', $element_content ))
                        return TRUE;
                    
                    return $ignore;
                       
                }
                
  
        }
?>