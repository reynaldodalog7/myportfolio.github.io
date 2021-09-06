<?php   
        
        if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

        global $wph;

        $blog_id_settings   =   $wph->functions->get_blog_id();
        
        $global_settings    =   $wph->functions->get_global_settings ( );
        $settings           =   $wph->functions->get_site_settings ( $blog_id_settings );
                        
        ?>
        <div id="wph" class="wrap">
            <h1><span class="dashicons dashicons-admin-tools"></span> WP Hide & Security Enhancer - Settings</h1>
            
            <?php  
                
                if ( ! is_multisite() )
                    {
                        if( !   $wph->licence->licence_key_verify() )
                            include( WPH_PATH . 'include/admin-interfaces/_licence.php' );
                            else
                            include( WPH_PATH . 'include/admin-interfaces/_licence_deactivate.php' );
                    }
            
            if(  $wph->licence->licence_key_verify() )
                {
            ?>
            
            <h3><?php _e( "Settings", 'wp-hide-security-enhancer' ) ?></h3>
                             
            <form id="form_data" name="form" method="post">
                <input type="hidden" name="wph-interface-fields" value="true" />
                <?php wp_nonce_field( 'wph/interface_fields', 'wph-interface-nonce' ); ?>   
                <table class="form-table">
                    <tbody>
                        
                        <tr valign="top">
                            <th scope="row">
                                <a class="button" href="javascript: void(0)" onClick="jQuery('#export_settings').slideDown('fast')">Export Settings</a>
                            </th>
                            <td>
                                <p><label><?php _e( "Export current settings", 'wp-hide-security-enhancer' ) ?></label></p>
                                <!-- WPH Preserve - Start -->
                                <p><textarea onclick="this.focus();this.select()" id="export_settings" class="code" readonly="readonly" style="width: 100%; display: none" rows="12"><?php  echo htmlspecialchars(json_encode($settings['module_settings']))  ?></textarea></p>
                                <!-- WPH Preserve - Stop -->
                            </td>
                        </tr>
                
                        <tr valign="top">
                            <th scope="row">
                                <a class="button" href="javascript: void(0)" onClick="jQuery('#import_settings').slideDown('fast')">Import Settings</a>
                            </th>
                            <td>
                                <p><label><?php _e( "Import previously saved settings", 'wp-hide-security-enhancer' ) ?></label></p>
                                <p><textarea id="import_settings" class="code" name="import_settings" style="width: 100%; display: none" rows="12"></textarea></p>
                            </td>
                        </tr>
                        
                        
                        <?php  if ( $wph->server_nginx_config   === TRUE ) {   ?>
                        <tr valign="top">
                            <th scope="row">
                                <select onClick="WPH.options_field_changed('nginx_generate_simple_rewrite')" id="nginx_generate_simple_rewrite"  name="nginx_generate_simple_rewrite" <?php if ( $wph->functions->server_is_wpengine() ||   $wph->functions->server_is_kinsta() )  { ?>disabled="disabled"<?php } ?>>
                                    <option value="no" <?php selected('no', $global_settings['nginx_generate_simple_rewrite']); ?>><?php _e( "No", 'wp-hide-security-enhancer' ) ?></option>
                                    <option value="yes" <?php selected('yes', $global_settings['nginx_generate_simple_rewrite']); ?>><?php _e( "Yes", 'wp-hide-security-enhancer' ) ?></option>
                                </select>
                            </th>
                            <td>
                                <label for="nginx_generate_simple_rewrite"><?php _e( "Generate simple Rewrite Rules for Nginx.", 'wp-hide-security-enhancer' ) ?> <?php if ( $wph->functions->server_is_wpengine()  ||  $wph->functions->server_is_kinsta())  { ?><span class="warning">You use <?php if ( $wph->functions->server_is_wpengine() ) { echo 'WPEngine';} if ( $wph->functions->server_is_kinsta() ) { echo 'Kinsta';} ?> which require simple rewrite.</span><?php } ?><span class='tips' data-tip='<?php _e( "Not all servers runing Nginx can handle full Rewrite rules as recommended by developers at", 'wp-hide-security-enhancer' ) ?> https://www.nginx.com/blog/creating-nginx-rewrite-rules/  <?php _e( "When active, this option generate simple version. Generally a server works with either full or simple style rewrite rules.", 'wp-hide-security-enhancer' ) ?>'> <span class="dashicons dashicons-info"></span></span></label>
                            </td>
                        </tr>
                        <?php   }  ?>
                        
                                
                        <?php  
                
                            if ( ! is_multisite() ) {
                        ?>
                        <tr valign="top">
                            <th scope="row">
                                <select name="self_setup" id="self_setup">
                                    <option value="no" <?php selected('no', $global_settings['self_setup']); ?>><?php _e( "No", 'wp-hide-security-enhancer' ) ?></option>
                                    <option value="yes" <?php selected('yes', $global_settings['self_setup']); ?>><?php _e( "Yes", 'wp-hide-security-enhancer' ) ?></option>
                                </select>
                            </th>
                            <td>
                                <label for="self_setup"><?php _e( "I'll set-up the rewrite data myself.", 'wp-hide-security-enhancer' ) ?> <span class='tips' data-tip='<?php _e( "Use this option if don`t want the application to attempt to modify rewrite data on your server and prefer to do that manually. The plugin try to automatically apply the rewrite when using mod_rewrite or IIS rewrite.", 'wp-hide-security-enhancer' ) ?>'><span class="dashicons dashicons-info"></span></span></label>
                            </td>
                        </tr>
                        <?php } ?>
                        
                    </tbody>
                </table>
                                
                <p class="submit">
                    <input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Settings', 'woo-global-cart') ?>">
                </p>
                
            </form>
            
            <br /><br />
            <form id="form_data" name="form" method="post">
                <?php wp_nonce_field( 'wp-hide-cache-clear', '_wpnonce' ); ?>
                <input type="hidden" name="wph-cache-clear" value="true" />
                 
                <h3><?php _e( "Cache Status", 'wp-hide-security-enhancer' ) ?></h3>
                <p><?php _e( "The cache files consist on a collection of post-processed assets, used internally and being generated when using Css Combine or/and JavaScript Combine options.", 'wp-hide-security-enhancer' ) ?><br /><?php _e( "The cache is NOT required to be cleared, unless the layout appear broken.", 'wp-hide-security-enhancer' ) ?></p>
                <p><?php _e( "Cache size", 'wp-hide-security-enhancer' ) ?>: <b><?php echo $wph->functions->get_cache_size(); ?></b></p>
                <a class="button" href="javascript: void(0)" onclick="jQuery(this).closest('form').submit();"><?php _e( "Cache Clear", 'wp-hide-security-enhancer' ) ?></a>
            </form>
            
            <?php  }  ?>
        </div>