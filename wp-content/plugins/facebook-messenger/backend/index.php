<?php
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
/*delete_site_transient( 'update_plugins' );
wp_cache_delete( 'plugins', 'plugins' );*/

add_action('admin_notices', 'njt_t_fb_mess_adminNotices');
function njt_t_fb_mess_adminNotices()
{
    // Get the remote version
    $remote_version = njt_t_fb_mess_get_remote_ver();
    if ($remote_version !== false) {
        if (version_compare(FACEBOOK_MESSENGER_PLUGIN_VER, $remote_version, '<')) {
            $redirectto = 'https://codecanyon.net/item/facebook-messenger-for-wordpress/16392065?utm_source=upgrade';
            ?>
            <div class="warning notice notice-warning">
                <?php
                echo '<p><strong>' . __( 'An additional update is required for Facebook Messenger!', 'fb_messenger' ) . '</strong></p><a class="button button-primary" href="' . $redirectto . '" target="_blank">' . __( 'Progress Update now', 'fb_messenger' ) . '</a></p>';
                ?>
            </div>
            <?php
        }
    }
}

add_action('admin_footer', 'njt_t_fb_mess_admin_footer');
function njt_t_fb_mess_admin_footer() {
    ?>
    <script>
        jQuery(document).ready(function($) {
            jQuery('a[href="https://m.me/ninjateam.org?ref=support"]').attr('target', '_blank');
        });
    </script>
    <?php
}
function njt_t_fb_mess_get_remote_ver()
{
    if (false === ($remote_ver = get_transient('njt_t_fb_mess_remote_ver'))) {
        //get current site
        $current_site = preg_replace('#https?:\/\/#', '', get_bloginfo('url'));
        $request = new WP_Http;
        $str = $request->request('http://update.ninjateam.org/fb-messenger/' . $current_site);
        if (!is_wp_error($str) || wp_remote_retrieve_response_code($str) === 200) {
            $str = json_decode($str['body']);
            $remote_ver = $str->version;
        } else {
            $remote_ver = '';
        }
        set_transient('njt_t_fb_mess_remote_ver', $remote_ver, HOUR_IN_SECONDS);
    }
    return $remote_ver;
}
add_filter('pre_set_site_transient_update_plugins', 'njt_t_fbmess_check_update');
function njt_t_fbmess_check_update($transient)
{
    // Get the remote version
    $remote_version = njt_t_fb_mess_get_remote_ver();
    if ($remote_version !== false) {
        // If a newer version is available, add the update
        if (version_compare(FACEBOOK_MESSENGER_PLUGIN_VER, $remote_version, '<')) {
            $plugin_slug = FACEBOOK_MESSENGER_PLUGIN_SLUG;
            $slug = njt_t_fbmess_get_plugin_slug();

            $obj = new stdClass();
            $obj->slug = $slug;
            $obj->new_version = $remote_version;
            $obj->url = '';
            $obj->package = '';
            $obj->name = FACEBOOK_MESSENGER_PLUGIN_NAME;
            $transient->response[FACEBOOK_MESSENGER_PLUGIN_SLUG] = $obj;
        }
    }
    return $transient;
}
add_action('in_plugin_update_message-' . FACEBOOK_MESSENGER_PLUGIN_SLUG, 'njt_t_fbmess_add_upgrade_message');
function njt_t_fbmess_add_upgrade_message()
{
    echo sprintf('<a href="%1$s">%2$s</a>', 'https://codecanyon.net/item/facebook-messenger-for-wordpress/16392065?s_rank=16', __('Click here to update', 'fb_messenger'));
}

add_filter('plugins_api', 'njt_t_fbmess_check_info_plugin', 10, 3);
function njt_t_fbmess_check_info_plugin($false, $action, $arg)
{
    if (isset($arg->slug) && ($arg->slug === njt_t_fbmess_get_plugin_slug())) {

        $information = false;

        $request = new WP_Http;
        $str = $request->request('http://update.ninjateam.org/fb-messenger-infor');
        if (!is_wp_error($str) || wp_remote_retrieve_response_code($str) === 200) {
            $information = json_decode($str['body']);
        }

        if ($information !== false) {
            $array_pattern = array(
                '/^([\*\s])*(\d\d\.\d\d\.\d\d\d\d[^\n]*)/m',
                '/^\n+|^[\t\s]*\n+/m',
                '/\n/',
            );
            $array_replace = array(
                '<h4>$2</h4>',
                '</div><div>',
                '</div><div>',
            );
            $information->name = FACEBOOK_MESSENGER_PLUGIN_NAME;
            $information->sections = (array) $information->sections;
            $information->sections['changelog'] = '<div>' . preg_replace( $array_pattern, $array_replace, $information->sections['changelog'] ) . '</div>';
        }
        
        return $information;
    }

    return $false;
}

function njt_t_fbmess_get_plugin_slug()
{
    $t = explode('/', FACEBOOK_MESSENGER_PLUGIN_SLUG);
    $slug = str_replace('.php', '', $t[1]);

    return $slug;
}
/*
 * Add menu admin options
 */
add_action('admin_menu', 'facebook_messenger_menu_options');
function facebook_messenger_menu_options()
{
    global $submenu;
    
    add_menu_page(
        __('Facebook Messenger', 'fb_messenger'),
        __('Messenger', 'fb_messenger'),
        'manage_options',
        'facebook_messenger_options_page',
        'facebook_messenger_options_page',
        FACEBOOK_MESSENGER_PLUGIN_URL . '/backend/images/menu-icon.svg'
    );

    add_submenu_page(
        'facebook_messenger_options_page',
        __('Facebook Messenger', 'fb_messenger'),
        __('Settings', 'fb_messenger'),
        'manage_options',
        'facebook_messenger_options_page',
        'facebook_messenger_options_page'
    );

    add_submenu_page(
        'facebook_messenger_options_page',
        __('Messenger Plugins', 'fb_messenger'),
        __('Messenger Plugins', 'fb_messenger'),
        'manage_options',
        'facebook_messenger_plugins',
        'facebook_messenger_plugins'
    );

    $submenu['facebook_messenger_options_page'][] = array(
        __('Support', 'fb_messenger'),
        'manage_options',
        esc_url('https://m.me/ninjateam.org?ref=support'),
    );
}

/*
 * Add Upload style and script
 */
add_action('admin_enqueue_scripts', 'facebook_messenger_admin_enqueue_scripts');
function facebook_messenger_admin_enqueue_scripts()
{
    $page = ((isset($_GET["page"])) ? $_GET["page"] : '');
    if (in_array($page, array('facebook_messenger_options_page', 'facebook_messenger_plugins'))) {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('media-upload');
        wp_register_script('facebook-messenger-settings', FACEBOOK_MESSENGER_PLUGIN_URL . 'backend/js/settings.js', array('jquery', 'wp-color-picker'), '', true);
        wp_localize_script('facebook-messenger-settings', 'njt_t_fb_mess', array("url" => FACEBOOK_MESSENGER_PLUGIN_URL."frontend/images/facebook-messenger.svg"));
        wp_enqueue_script('facebook-messenger-settings');
    }
}
function facebook_messenger_admin_style()
{
    wp_enqueue_media();
    wp_enqueue_style('thickbox');
    wp_enqueue_style('facebook-messenger-style', FACEBOOK_MESSENGER_PLUGIN_URL . 'backend/css/style.css');
}
add_action('admin_print_styles', 'facebook_messenger_admin_style');

/**
 * Admin dashboard page
 *
 * @return Void
 */
function facebook_messenger_plugins()
{
    ?>
    <div class="wrap">
        <h1>Messenger Plugins</h1>
        <p class="title-des">Our messenger plugins to help boost your sales</p>
        <div class="njt-t-fbmess-row">
            <div class="njt-t-fbmess-col-4">
                <div class="njt-t-fbmess-colinner">
                    <img src="<?php echo FACEBOOK_MESSENGER_PLUGIN_URL . '/backend/images/more-plugins/bulksender.png'; ?>" alt="Messenger Bulksender" />
                    <div class="njt-t-fb-mess-info">
                        <h3 class="njt-t-fb-mess-title"><a href="https://goo.gl/7VUKkl" target="_blank">Messenger Bulksender</a></h3>
                        <p class="des">
                            Send bulk messages to your subscribers who messaged your fan page, 100% inbox.
                        </p>
                        <a href="https://goo.gl/7VUKkl" target="_blank" class="njt-t-fbmess-btn">Demo & Details</a>
                    </div>
                </div>
            </div>
            <div class="njt-t-fbmess-col-4">
                <div class="njt-t-fbmess-colinner">
                    <img src="<?php echo FACEBOOK_MESSENGER_PLUGIN_URL . '/backend/images/more-plugins/private-reply.png'; ?>" alt="Messenger Auto-Reply" />
                    <div class="njt-t-fb-mess-info">
                        <h3 class="njt-t-fb-mess-title"><a href="https://goo.gl/ibxH5B" target="_blank">Messenger Auto-Reply</a></h3>
                        <p class="des">
                            Response to Facebook Comments with Private Messages & Public Replies
                        </p>
                        <a href="https://goo.gl/ibxH5B" target="_blank" class="njt-t-fbmess-btn">Demo & Details</a>
                    </div>
                </div>
            </div>
            <div class="njt-t-fbmess-col-4">
                <div class="njt-t-fbmess-colinner">
                    <img src="<?php echo FACEBOOK_MESSENGER_PLUGIN_URL . '/backend/images/more-plugins/ninja-team.png'; ?>" alt="NinjaTeam Plugins" />
                    <div class="njt-t-fb-mess-info">
                        <h3 class="njt-t-fb-mess-title"><a href="https://goo.gl/k5mT09" target="_blank">More Great Plugins</a></h3>
                        <p class="des">
                            View more our plugins to find great plugin for your WordPress website.
                        </p>
                        <a href="https://goo.gl/k5mT09" target="_blank" class="njt-t-fbmess-btn njt-t-fbmess-viewall">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/*
 * Add form options
 */
function facebook_messenger_options_page(){
    ?>
    <div class="wrap">
        <div class="ninja-support" style="display: none">
            <ul>
                <li class="document button"><a href=""><?php _e("Documenttation","fb_messenger") ?></a></li>
                <li class="suport button"> <a href=""><?php _e("Support","fb_messenger") ?></a></li>
                <li class="viewmore button button-primary"><a href=""><?php _e("View more plugin","fb_messenger") ?></a></li>
            </ul>
        </div>
        <h1>Facebook Messenger Settings</h1>
        <form action="options.php" method="post" id="nj-fb-class">
        <?php settings_fields("wap_form_messenger") ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="facebook_messenger_user"><?php echo __("Your Facebook Fan Page URL","fb_messenger") ?></label></th>
                    <td>
                        <input name="facebook_messenger_user" id="facebook_messenger_user" type="text" value="<?php echo get_option("facebook_messenger_user"); ?>" class="regular-text" />
                         <p class="description" ><?php echo __("Enter your fan page url. Example: https://www.facebook.com/ninjateam.org","fb_messenger") ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="facebook_messenger_text_botton"><?php echo __("Custom text for button","fb_messenger") ?></label></th>
                    <td>
                        <input name="facebook_messenger_text_botton" type="text" value="<?php echo get_option("facebook_messenger_text_botton") ?>"  class="regular-text"  />
                        <p class="description" ><?php echo __("Custom text for the button on WooCommerce product detail page","fb_messenger") ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="facebook_messenger_display"><?php echo __("Display header cover","fb_messenger") ?></label></th>
                    <td>
                        <select name="facebook_messenger_display">
                            <option value="0"><?php _e("Hide","fb_messenger")?></option>
                            <option value="1" <?php if ( get_option("facebook_messenger_display") == 1 ){ echo 'selected="selected"'; } ?> ><?php _e("Small header","fb_messenger") ?></option>
                            <option value="2" <?php if ( get_option("facebook_messenger_display") == 2 ){ echo 'selected="selected"'; } ?> ><?php _e("Large header","fb_messenger") ?></option>
                       </select>
                       <p class="description" ><?php echo __("Select Facebook header cover type on Messenger popup","fb_messenger") ?></p>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label><?php echo __("Messenger icon position","fb_messenger") ?></label></th>
                    <td>
                       <select name="facebook_messenger_postion" id="facebook_messenger_postion">
                            <option value="0"><?php _e("Right","fb_messenger")?></option>
                            <option value="1" <?php if ( get_option("facebook_messenger_postion") == 1 ){ echo 'selected="selected"'; } ?> ><?php _e("Left","fb_messenger") ?></option>
                       </select>
                       <?php $facebook_messenger_v_postion = get_option('facebook_messenger_v_postion', 'top'); ?>
                       <select name="facebook_messenger_v_postion" id="facebook_messenger_v_postion">
                            <option value="top" <?php selected($facebook_messenger_v_postion, 'top'); ?>><?php _e("Top", "fb_messenger")?></option>
                            <option value="middle" <?php selected($facebook_messenger_v_postion, 'middle'); ?>><?php _e("Middle", "fb_messenger") ?></option>
                            <option value="bottom" <?php selected($facebook_messenger_v_postion, 'bottom'); ?>><?php _e("Bottom", "fb_messenger") ?></option>
                       </select>
                       <span class="depends_on_facebook_messenger_v_postion" style="<?php echo ((in_array($facebook_messenger_v_postion, array('top', 'bottom'))) ? 'display: inline' : 'display: none'); ?>">
                           <?php _e('Position Space', 'fb_messenger'); ?>
                           <input type="text" name="facebook_messenger_v_space" class="facebook_messenger_v_space" id="facebook_messenger_v_space" value="<?php echo esc_attr(get_option('facebook_messenger_v_space')) ?>" />
                       </span>
                       
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="facebook_messenger_type"><?php echo __("Icon type","fb_messenger") ?></label></th>
                    <td>
                        <select name="facebook_messenger_type">
                            <option value="0"><?php _e("Icon","fb_messenger"); ?></option>
                            <option <?php if( get_option("facebook_messenger_type") == 1){ echo 'selected="selected"';} ?> value="1"><?php _e("Image","fb_messenger"); ?></option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="facebook_messenger_text_img"><?php echo __("Upload icon or image","fb_messenger") ?></label></th>
                    <td>
                        <input name="facebook_messenger_text_img" id="facebook_messenger_text_img"  type="text" value="<?php echo get_option("facebook_messenger_text_img") ?>"  class="regular-text"  />
                        <button class="button" id="fecebook-messenger-upload"><?php _e("Upload","fb_messenger") ?></button>
                        <button class="button <?php if( preg_match("#facebook-messenger#",get_option("facebook_messenger_text_img") ) ) {echo "hidden";} ?>" id="fecebook-messenger-default-icon"><?php _e("Use default icon","fb_messenger") ?></button>
                        <p class="description" ><?php echo __("Upload your icon or image, please make sure you select correct type above","fb_messenger") ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="facebook_messenger_backgroud"><?php echo __("Main Color","fb_messenger") ?></label></th>
                    <td>
                        <input name="facebook_messenger_backgroud"  class="color" id="facebook_messenger_backgroud" type="text" value="<?php echo get_option("facebook_messenger_backgroud"); ?>" class="regular-text" />
                        <a href="#" class=" button facebook_messenger_backgroud_default"><?php _e("Use default color","fb_messenger") ?></a>
                        <p class="description" ><?php echo __("Main color for Messenger icon and button","fb_messenger") ?></p>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label for="facebook_messenger_app"><?php echo __("Open Messenger app button","fb_messenger") ?></label></th>
                    <td>
                        <input <?php if( get_option("facebook_messenger_app") == 1) {echo 'checked="checked"';} ?> name="facebook_messenger_app" type="checkbox" value="1" />
                        <p class="description" ><?php echo __("Use this feature if you want user click to open Messenger app on smartphone (will display a button on Messenger popup)","fb_messenger") ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="facebook_messenger_app_text"><?php echo __("Custom text for open Messenger app button","fb_messenger") ?></label></th>
                    <td>
                        <input name="facebook_messenger_app_text" type="text" value="<?php echo get_option("facebook_messenger_app_text") ?>"  class="regular-text"  />
                        <p class="description" ><?php echo __("Custom text for button open Messenger app","fb_messenger") ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="facebook_messenger_lang"><?php echo __("Language","fb_messenger") ?></label></th>
                    <td>
                        <?php $config = array(
                            // Afrikaans
                            'af_ZA' => 'Afrikaans',
                            // Arabic
                            'ar_AR' => 'Arabic',
                            // Azerbaijani
                            'az_AZ' => 'Azerbaijani',
                            // Belarusian
                            'be_BY' => 'Belarusian',
                            // Bulgarian
                            'bg_BG' => 'Bulgarian',
                            // Bengali
                            'bn_IN' => 'Bengali',
                            // Bosnian
                            'bs_BA' => 'Bosnian',
                            // Catalan
                            'ca_ES' => 'Catalan',
                            // Czech
                            'cs_CZ' => 'Czech',
                            // Welsh
                            'cy_GB' => 'Welsh',
                            // Danish
                            'da_DK' => 'Danish',
                            // German
                            'de_DE' => 'German',
                            // Greek
                            'el_GR' => 'Greek',
                            // English (UK)
                            'en_GB' => 'English (UK)',
                            // English (Pirate)
                            'en_PI' => 'English (Pirate)',
                            // English (Upside Down)
                            'en_UD' => 'English (Upside Down)',
                            // English (US)
                            'en_US' => 'English (US)',
                            // Esperanto
                            'eo_EO' => 'Esperanto',
                            // Spanish (Spain)
                            'es_ES' => 'Spanish (Spain)',
                            // Spanish
                            'es_LA' => 'Spanish',
                            // Estonian
                            'et_EE' => 'Estonian',
                            // Basque
                            'eu_ES' => 'Basque',
                            // Persian
                            'fa_IR' => 'Persian',
                            // Leet Speak
                            'fb_LT' => 'Leet Speak',
                            // Finnish
                            'fi_FI' => 'Finnish',
                            // Faroese
                            'fo_FO' => 'Faroese',
                            // French (Canada)
                            'fr_CA' => 'French (Canada)',
                            // French (France)
                            'fr_FR' => 'French (France)',
                            // Frisian
                            'fy_NL' => 'Frisian',
                            // Irish
                            'ga_IE' => 'Irish',
                            // Galician
                            'gl_ES' => 'Galician',
                            // Hebrew
                            'he_IL' => 'Hebrew',
                            // Hindi
                            'hi_IN' => 'Hindi',
                            // Croatian
                            'hr_HR' => 'Croatian',
                            // Hungarian
                            'hu_HU' => 'Hungarian',
                            // Armenian
                            'hy_AM' => 'Armenian',
                            // Indonesian
                            'id_ID' => 'Indonesian',
                            // Icelandic
                            'is_IS' => 'Icelandic',
                            // Italian
                            'it_IT' => 'Italian',
                            // Japanese
                            'ja_JP' => 'Japanese',
                            // Georgian
                            'ka_GE' => 'Georgian',
                            // Khmer
                            'km_KH' => 'Khmer',
                            // Korean
                            'ko_KR' => 'Korean',
                            // Kurdish
                            'ku_TR' => 'Kurdish',
                            // Latin
                            'la_VA' => 'Latin',
                            // Lithuanian
                            'lt_LT' => 'Lithuanian',
                            // Latvian
                            'lv_LV' => 'Latvian',
                            // Macedonian
                            'mk_MK' => 'Macedonian',
                            // Malayalam
                            'ml_IN' => 'Malayalam',
                            // Malay
                            'ms_MY' => 'Malay',
                            // Norwegian (bokmal)
                            'nb_NO' => 'Norwegian (bokmal)',
                            // Nepali
                            'ne_NP' => 'Nepali',
                            // Dutch
                            'nl_NL' => 'Dutch',
                            // Norwegian (nynorsk)
                            'nn_NO' => 'Norwegian (nynorsk)',
                            // Punjabi
                            'pa_IN' => 'Punjabi',
                            // Polish
                            'pl_PL' => 'Polish',
                            // Pashto
                            'ps_AF' => 'Pashto',
                            // Portuguese (Brazil)
                            'pt_BR' => 'Portuguese (Brazil)',
                            // Portuguese (Portugal)
                            'pt_PT' => 'Portuguese (Portugal)',
                            // Romanian
                            'ro_RO' => 'Romanian',
                            // Russian
                            'ru_RU' => 'Russian',
                            // Slovak
                            'sk_SK' => 'Slovak',
                            // Slovenian
                            'sl_SI' => 'Slovenian',
                            // Albanian
                            'sq_AL' => 'Albanian',
                            // Serbian
                            'sr_RS' => 'Serbian',
                            // Swedish
                            'sv_SE' => 'Swedish',
                            // Swahili
                            'sw_KE' => 'Swahili',
                            // Tamil
                            'ta_IN' => 'Tamil',
                            // Telugu
                            'te_IN' => 'Telugu',
                            // Thai
                            'th_TH' => 'Thai',
                            // Filipino
                            'tl_PH' => 'Filipino',
                            // Turkish
                            'tr_TR' => 'Turkish',
                            //
                            'uk_UA' => 'Ukrainian',
                            // Vietnamese
                            'vi_VN' => 'Vietnamese',
                            //
                            'zh_CN' => 'Simplified Chinese (China)',
                            //
                            'zh_HK' => 'Traditional Chinese (Hong Kong)',
                            //
                            'zh_TW' => 'Traditional Chinese (Taiwan)',
                        );
                        $lang = get_option("facebook_messenger_lang");
                        if (!$lang) {
                            $lang = "en_US";
                        }
                        ?>
                         <select name="facebook_messenger_lang">
                             <?php foreach ( $config as $k => $v ) {
                             ?>
                             <option <?php if ( $lang == $k) {echo 'selected="selected"';} ?>  value="<?php echo $k ?>"><?php echo $v ?></option>
                             <?php
                             } ?>
                         </select>
                    </td>
                </tr>
                <?php if (function_exists('icl_object_id')) : ?>
                <tr valign="top">
                    <th scope="row">
                        <label for="facebook_messenger_lang_depends_on_wpml">
                            <?php echo __("Depends on WPML ?", "fb_messenger"); ?>
                        </label>
                    </th>
                    <td>
                        <input type="checkbox" value="1" name="facebook_messenger_lang_depends_on_wpml" id="facebook_messenger_lang_depends_on_wpml" <?php checked(get_option('facebook_messenger_lang_depends_on_wpml'), '1'); ?> />
                    </td>
                </td>
                <?php endif; ?>
                <?php
                if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                    ?>
                <tr valign="top">
                    <th scope="row"><label for="facebook_messenger_woo_position"><?php echo __("Position for button in product detail page","fb_messenger") ?></label></th>
                    <td>
                        <select name="facebook_messenger_woo_position">
                            <option value="0"><?php _e("Before button add to cart","fb_messenger") ?></option>
                            <option <?php if( get_option("facebook_messenger_woo_position") == 1){echo 'selected="selected"';} ?> value="1"><?php _e("After button add to cart","fb_messenger") ?></option>
                            <option <?php if( get_option("facebook_messenger_woo_position") == 2){echo 'selected="selected"';} ?> value="2"><?php _e("Hide","fb_messenger") ?></option>
                        </select>
                    </td>
                </tr>
                    <?php
                }
                ?>
                <tr valign="top">
                    <th scope="row"><label><?php echo __("Display","fb_messenger") ?></label></th>
                    <td>
                        <?php $display = get_option("facebook_messenger_hide_display"); ?>
                        <select name="facebook_messenger_hide_display" id="ninja-display-messenger">
                            <option <?php if ( $display != 1) {echo 'selected="selected"';} ?> value="0"><?php echo __("Display all pages but except","fb_messenger") ?></option>
                            <option <?php if ( $display == 1) {echo 'selected="selected"';} ?> value="1"><?php echo __("Display for pages...","fb_messenger") ?></option>
                        </select>
                        <p class="description" ><?php echo __("Select type you want to display Messenger (If it don't display in WooCommerce pages, please make sure you selected 'Display all pages but except' option)","fb_messenger") ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php echo __("Mobile","fb_messenger") ?></label></th>
                    <td>
                        <?php $display_m = get_option("facebook_messenger_mobile_display"); ?>
                        <select name="facebook_messenger_mobile_display" id="ninja-display-mobile">
                            <?php for ($count_i = 0; $count_i < 3; $count_i++){ ?>
                                <option <?php if ($display_m == $count_i) echo 'selected="selected"'; ?> value="<?php echo $count_i; ?>">
                                    <?php switch ($count_i) {
                                        case 0:
                                            echo __("Display on desktop & mobile","fb_messenger");
                                            break;

                                        case 1:
                                            echo __("Display only mobile","fb_messenger");
                                            break;
                                        
                                        default:
                                            echo __("Hide on mobile","fb_messenger");
                                            break;
                                    } ?>
                                </option>
                            <?php } ?>
                        </select>
                        <p class="description" ><?php echo __("Select type you want to display Messenger on mobile and desktop","fb_messenger") ?></p>
                    </td>
                </tr>
                <tr valign="top" id="facebook-messenger-tr-hide"  class="<?php if ( $display == 1) {echo 'hidden';} ?>">
                    <th scope="row"><label for="facebook_messenger_hide_page"><?php echo __("Display all pages but except","fb_messenger") ?></label></th>
                    <td>
                        <input type="checkbox" id="facebook-messenger-checkall" /> <label for="facebook-messenger-checkall">All</label>
                        <ul id="facebook_messenger_hide_page" class="facebook_messenger_hide_page">
                        <?php $new = new WP_Query(array("posts_per_page"=>-1,"post_type"=>"page"));
                            $array_hide = get_option( "facebook_messenger_hide_page");
                            if ( !$array_hide ){
                                $array_hide = array();
                            }
                            while ( $new->have_posts() ) : $new->the_post() ;
                            ?>
                            <li><input <?php
                                if ( in_array(get_the_ID(), $array_hide ) ) { echo 'checked="checked"'; }
                             ?> name="facebook_messenger_hide_page[]" class="facebook_messenger_hide_page" type="checkbox" value="<?php the_ID() ?>" id="facebook_messenger_hide_page_<?php the_ID() ?>" /> <label for="facebook_messenger_hide_page_<?php the_ID() ?>"><?php the_title() ?></label></li>
                            <?php
                            endwhile;wp_reset_postdata();
                         ?>
                         </ul>
                         <p class="description"><?php _e("Select where you want to display Facebook Messenger","fb_messenger") ?></p>
                    </td>
                </tr>
                <tr valign="top" id="facebook-messenger-tr-show" class="<?php if ( $display != 1) {echo 'hidden';} ?>">
                    <th scope="row"><label for="facebook_messenger_show_page"><?php echo __("Where you want to display","fb_messenger") ?></label></th>
                    <td>
                        <input type="checkbox" id="facebook-messenger-checkall-1" /> <label for="facebook-messenger-checkall-1">All</label>
                        <ul id="facebook_messenger_show_page" class="facebook_messenger_show_page">
                        <?php $new = new WP_Query(array("posts_per_page"=>-1,"post_type"=>"page"));
                            $array_show = get_option( "facebook_messenger_show_page");
                            if ( !get_option( "facebook_messenger_show_page") ) {
                               $array_show = array();
                            }
                            while ( $new->have_posts() ) : $new->the_post() ;
                            ?>
                            <li><input <?php
                                if ( in_array(get_the_ID(), $array_show ) ) { echo 'checked="checked"'; }
                            ?> name="facebook_messenger_show_page[]" class="facebook_messenger_show_page" type="checkbox" value="<?php the_ID() ?>" id="facebook_messenger_show_page_<?php the_ID() ?>" /> <label for="facebook_messenger_show_page_<?php the_ID() ?>"><?php the_title() ?></label></li>
                            <?php
                            endwhile;wp_reset_postdata();
                         ?>
                         </ul>
                         <p class="description"><?php _e("Select where you want to display Facebook Messenger","fb_messenger"); ?></p>
                    </td>
                </tr>
             </table>
             <?php submit_button("Save") ?>
          </form>
      </div>
      <script type="text/javascript">
          jQuery(document).ready(function($) {
              jQuery('#facebook_messenger_v_postion').change(function(event) {
                  var val = jQuery(this).val();
                  if ((val == 'top') || (val == 'bottom')) {
                    jQuery('.depends_on_facebook_messenger_v_postion').stop().show();
                  } else {
                    jQuery('.depends_on_facebook_messenger_v_postion').stop().hide();
                  }
              });
          });
      </script>
    <?php
}
/*
* Save options
*/
add_action("admin_init","facebook_messenger_save_form");
function facebook_messenger_save_form(){
    register_setting("wap_form_messenger","facebook_messenger_type");
    register_setting("wap_form_messenger","facebook_messenger_app");
    register_setting("wap_form_messenger","facebook_messenger_app_text");
    register_setting("wap_form_messenger","facebook_messenger_display");
    register_setting("wap_form_messenger","facebook_messenger_postion");
    register_setting("wap_form_messenger", "facebook_messenger_v_postion");
    register_setting("wap_form_messenger", "facebook_messenger_v_space");
    
    register_setting("wap_form_messenger","facebook_messenger_lang");
    register_setting("wap_form_messenger","facebook_messenger_lang_depends_on_wpml");
    register_setting("wap_form_messenger","facebook_messenger_backgroud");
    register_setting("wap_form_messenger","facebook_messenger_user");;
    register_setting("wap_form_messenger","facebook_messenger_hide_display");
    register_setting("wap_form_messenger","facebook_messenger_mobile_display");
    register_setting("wap_form_messenger","facebook_messenger_hide_page");
    register_setting("wap_form_messenger","facebook_messenger_show_page");
    register_setting("wap_form_messenger","facebook_messenger_text_img");
    register_setting("wap_form_messenger","facebook_messenger_text_botton");
    register_setting("wap_form_messenger","facebook_messenger_is_hide_on_mobile");
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        register_setting("wap_form_messenger","facebook_messenger_woo_position");
    }
}