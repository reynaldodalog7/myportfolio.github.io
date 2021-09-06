<?php
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
include_once FACEBOOK_MESSENGER_PLUGIN_DIR ."frontend/shortcode.php";
/*
* Add css
*/
add_action( 'wp_print_styles', 'facebook_messenger_chat_add_styles' );
function facebook_messenger_chat_add_styles() {
   wp_enqueue_style( 'popup-messenger',FACEBOOK_MESSENGER_PLUGIN_URL."frontend/css/popup.css",array(),"1.0.0" );
   if( facebook_messenger_chek_page() &&  facebook_messenger_chek_mobile() ){
        wp_enqueue_style( 'messenger',FACEBOOK_MESSENGER_PLUGIN_URL."frontend/css/messenger.css",array(),"1.0.1" );
   }
}
/*
* Add scripts
*/
add_action( 'wp_enqueue_scripts', 'facebook_messenger_add_scripts' );
function facebook_messenger_add_scripts() {
   wp_enqueue_script('jquery');
   wp_enqueue_script('popup-messenger',FACEBOOK_MESSENGER_PLUGIN_URL."frontend/js/popup.js",array(),false,true);
   if( facebook_messenger_chek_page() &&  facebook_messenger_chek_mobile()){
        wp_enqueue_script('move',FACEBOOK_MESSENGER_PLUGIN_URL."frontend/js/jquery.event.move.js",array(),false,true);
        wp_enqueue_script('rebound',FACEBOOK_MESSENGER_PLUGIN_URL."frontend/js/rebound.min.js",array(),false,true);
        if( get_option("facebook_messenger_postion") == "1" ) {
            wp_enqueue_script('index-messenger',FACEBOOK_MESSENGER_PLUGIN_URL."frontend/js/index-left.js",array(),false,true);
        }else{
            wp_enqueue_script('index-messenger1',FACEBOOK_MESSENGER_PLUGIN_URL."frontend/js/index.js",array(),false,true);
        }

   }
}
/*
* Add box chat bottom
*/
add_action("wp_footer","facebook_messenger_add_box_chat");
function facebook_messenger_add_box_chat() {
    $lang = get_option("facebook_messenger_lang");

    if (!$lang) {
        $lang = "en_US";
    }
    if (function_exists('icl_object_id')) {
        $depends_on_wpml = (get_option('facebook_messenger_lang_depends_on_wpml', '0') == '1');
        if ($depends_on_wpml) {
            $lang = ICL_LANGUAGE_CODE;
            $country_code = '';
            if (count($ex = explode('-', $lang)) > 1) {
                $lang = $ex[0] . '_' . strtoupper($ex[1]);
            } else {
                $lang = njt_language_code_to_locale($lang, $country_code);
                if (is_null($lang)) {
                    $lang = 'en_US';
                }
            }
        }
    }
    ?>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/<?php echo $lang ?>/sdk.js#xfbml=1&version=v2.5";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <?php
}
/*
*
*/
add_action("wp_footer", "facebook_mesenger_set_footer_page");
function facebook_mesenger_set_footer_page()
{    
    $hide_on_mobile = (get_option('facebook_messenger_is_hide_on_mobile', false) == '1');
    if ($hide_on_mobile && wp_is_mobile()) {
        return;
    }
    if(facebook_messenger_chek_page() && facebook_messenger_chek_mobile()){
        $facebook_messenger_display = get_option("facebook_messenger_display");
        $img = get_option("facebook_messenger_text_img");
        if( is_numeric($img)) {
            $img_arr = wp_get_attachment_image_src($img,"full");
           $img = $img_arr[0];
        }
    ?>
        <div class="drag-wrapper <?php echo (get_option("facebook_messenger_postion")== 1)?"drag-wrapper-left":'drag-wrapper-right'; ?>">
    		<div data-drag="data-drag" class="thing">
    			<div class="circle facebook-messenger-avatar facebook-messenger-avatar-type<?php echo get_option("facebook_messenger_type") ?>">
    				<img class="facebook-messenger-avatar" src="<?php echo $img ?>" />
    			</div>
    			<div class="content">
    				<div class="inside">
    					<div class="fb-page" data-width="310" data-height="310" data-href="<?php echo get_option("facebook_messenger_user") ?>" data-tabs="messages" data-small-header="<?php echo ($facebook_messenger_display == '1') ? "true" : "false"; ?>" data-hide-cover="<?php echo ($facebook_messenger_display == '0') ? "true" : "false"; ?>" data-show-facepile="true" data-adapt-container-width="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="<?php echo get_option("facebook_messenger_user") ?>"><a href="<?php echo get_option("facebook_messenger_user") ?>">Loading...</a></blockquote></div></div>
     				</div>
                    <?php if( wp_is_mobile() && get_option("facebook_messenger_app") == 1 ) : ?>
                    <div class="send-app">
                        <?php  $ms = explode("https://www.facebook.com/",get_option("facebook_messenger_user")  );
                        ?>
                        <a href="https://www.messenger.com/t/<?php echo $ms[1] ?>"><?php echo get_option("facebook_messenger_app_text") ?></a>
                    </div>
                    <?php endif; ?>
    			</div>
    		</div>
    		<div class="magnet-zone">
    			<div class="magnet"></div>
    		</div>
    	</div>
    <?php
    }
}
/*
* Set background
*/
add_action("wp_head","facebook_messenger_setting_head");
function facebook_messenger_setting_head(){
    $fb_mess_position = get_option('facebook_messenger_v_postion', 'top');
    $facebook_messenger_v_space = (int)get_option('facebook_messenger_v_space', 0);
    ?>
    <style type="text/css">

        .chatHead{
            background: <?php echo get_option("facebook_messenger_backgroud") ?> url(<?php echo get_option("facebook_messenger_text_img") ?>) center center no-repeat;
            background-size: 50% auto;
        }
        .drag-wrapper .thing .circle {
            background: <?php echo get_option("facebook_messenger_backgroud") ?>;
        }
        .nj-facebook-messenger {
            background: <?php echo get_option("facebook_messenger_backgroud") ?> url(<?php echo get_option("facebook_messenger_text_img") ?>) 15px center no-repeat;
            background-size: auto 55%;
            padding: 8px 15px;
            color: #fff !important;
            border-radius: 3px;
            padding-left: 40px;
            display: inline-block;
            margin-top: 5px;
        }
        .send-app a {
            background: <?php echo get_option("facebook_messenger_backgroud") ?>
        }
        .nj-facebook-messenger:hover {
            opacity: 0.8;
        }

    </style>
    <script type="text/javascript">
        var fb_mess_position = '<?php echo $fb_mess_position; ?>';
        var fb_mess_position_space = <?php echo (string)$facebook_messenger_v_space; ?>;
    </script>
    <?php
}
function facebook_messenger_chek_mobile(){
    $type = get_option("facebook_messenger_mobile_display");
    switch ($type) {
        case 1:
            return wp_is_mobile();
            break;
        case 2:
            return !(wp_is_mobile());
            break;
        default:
            return true;
            break;
    }
}
function facebook_messenger_chek_page(){
    global $wp_query;
    $show = false;
    $post_id = (isset($wp_query->post) ? $wp_query->post->ID : '');
    if (empty($post_id)) {
        return $show;
    }
    $type = get_option("facebook_messenger_hide_display");
    if ($type == "1") {
        /*
        * Display for pages...
        */
        $all_page = get_option("facebook_messenger_show_page");
        if( is_array( $all_page ) ) {
            if ( is_page() && in_array($post_id, $all_page) ) {
               $show = true;
            }
        }
    }else{
        $all_page = get_option("facebook_messenger_hide_page");
        if( is_array($all_page) ){
            if ( is_page() && in_array($post_id,$all_page) ) {
               $show = false;
            }else{
                $show =true;
            }
        }else{
            $show = true;
        }
    }
    return $show;
}

/**
/* Returns a locale from a language code that is provided.
/*
/* @param $language_code ISO 639-1-alpha 2 language code
/* @returns  a locale, formatted like en_US, or null if not found
/**/
if (!function_exists('njt_language_code_to_locale')) {
    function njt_language_code_to_locale($language_code, $country_code = '')
    {
        // Locale list taken from:
        // http://stackoverflow.com/questions/3191664/
        // list-of-all-locales-and-their-short-codes
        $locales = array('af-ZA',
                        'am-ET',
                        'ar-AE',
                        'ar-BH',
                        'ar-DZ',
                        'ar-EG',
                        'ar-IQ',
                        'ar-JO',
                        'ar-KW',
                        'ar-LB',
                        'ar-LY',
                        'ar-MA',
                        'arn-CL',
                        'ar-OM',
                        'ar-QA',
                        'ar-SA',
                        'ar-SY',
                        'ar-TN',
                        'ar-YE',
                        'as-IN',
                        'az-Cyrl-AZ',
                        'az-Latn-AZ',
                        'ba-RU',
                        'be-BY',
                        'bg-BG',
                        'bn-BD',
                        'bn-IN',
                        'bo-CN',
                        'br-FR',
                        'bs-Cyrl-BA',
                        'bs-Latn-BA',
                        'ca-ES',
                        'co-FR',
                        'cs-CZ',
                        'cy-GB',
                        'da-DK',
                        'de-AT',
                        'de-CH',
                        'de-DE',
                        'de-LI',
                        'de-LU',
                        'dsb-DE',
                        'dv-MV',
                        'el-GR',
                        'en-029',
                        'en-AU',
                        'en-BZ',
                        'en-CA',
                        'en-GB',
                        'en-IE',
                        'en-IN',
                        'en-JM',
                        'en-MY',
                        'en-NZ',
                        'en-PH',
                        'en-SG',
                        'en-TT',
                        'en-US',
                        'en-ZA',
                        'en-ZW',
                        'es-AR',
                        'es-BO',
                        'es-CL',
                        'es-CO',
                        'es-CR',
                        'es-DO',
                        'es-EC',
                        'es-ES',
                        'es-GT',
                        'es-HN',
                        'es-MX',
                        'es-NI',
                        'es-PA',
                        'es-PE',
                        'es-PR',
                        'es-PY',
                        'es-SV',
                        'es-US',
                        'es-UY',
                        'es-VE',
                        'et-EE',
                        'eu-ES',
                        'fa-IR',
                        'fi-FI',
                        'fil-PH',
                        'fo-FO',
                        'fr-BE',
                        'fr-CA',
                        'fr-CH',
                        'fr-FR',
                        'fr-LU',
                        'fr-MC',
                        'fy-NL',
                        'ga-IE',
                        'gd-GB',
                        'gl-ES',
                        'gsw-FR',
                        'gu-IN',
                        'ha-Latn-NG',
                        'he-IL',
                        'hi-IN',
                        'hr-BA',
                        'hr-HR',
                        'hsb-DE',
                        'hu-HU',
                        'hy-AM',
                        'id-ID',
                        'ig-NG',
                        'ii-CN',
                        'is-IS',
                        'it-CH',
                        'it-IT',
                        'iu-Cans-CA',
                        'iu-Latn-CA',
                        'ja-JP',
                        'ka-GE',
                        'kk-KZ',
                        'kl-GL',
                        'km-KH',
                        'kn-IN',
                        'kok-IN',
                        'ko-KR',
                        'ky-KG',
                        'lb-LU',
                        'lo-LA',
                        'lt-LT',
                        'lv-LV',
                        'mi-NZ',
                        'mk-MK',
                        'ml-IN',
                        'mn-MN',
                        'mn-Mong-CN',
                        'moh-CA',
                        'mr-IN',
                        'ms-BN',
                        'ms-MY',
                        'mt-MT',
                        'nb-NO',
                        'ne-NP',
                        'nl-BE',
                        'nl-NL',
                        'nn-NO',
                        'nso-ZA',
                        'oc-FR',
                        'or-IN',
                        'pa-IN',
                        'pl-PL',
                        'prs-AF',
                        'ps-AF',
                        'pt-BR',
                        'pt-PT',
                        'qut-GT',
                        'quz-BO',
                        'quz-EC',
                        'quz-PE',
                        'rm-CH',
                        'ro-RO',
                        'ru-RU',
                        'rw-RW',
                        'sah-RU',
                        'sa-IN',
                        'se-FI',
                        'se-NO',
                        'se-SE',
                        'si-LK',
                        'sk-SK',
                        'sl-SI',
                        'sma-NO',
                        'sma-SE',
                        'smj-NO',
                        'smj-SE',
                        'smn-FI',
                        'sms-FI',
                        'sq-AL',
                        'sr-Cyrl-BA',
                        'sr-Cyrl-CS',
                        'sr-Cyrl-ME',
                        'sr-Cyrl-RS',
                        'sr-Latn-BA',
                        'sr-Latn-CS',
                        'sr-Latn-ME',
                        'sr-Latn-RS',
                        'sv-FI',
                        'sv-SE',
                        'sw-KE',
                        'syr-SY',
                        'ta-IN',
                        'te-IN',
                        'tg-Cyrl-TJ',
                        'th-TH',
                        'tk-TM',
                        'tn-ZA',
                        'tr-TR',
                        'tt-RU',
                        'tzm-Latn-DZ',
                        'ug-CN',
                        'uk-UA',
                        'ur-PK',
                        'uz-Cyrl-UZ',
                        'uz-Latn-UZ',
                        'vi-VN',
                        'wo-SN',
                        'xh-ZA',
                        'yo-NG',
                        'zh-CN',
                        'zh-HANS',
                        'zh-HK',
                        'zh-MO',
                        'zh-SG',
                        'zh-TW',
                        'zu-ZA',
                        );

        foreach ($locales as $locale) {
            $locale_region = locale_get_region($locale);
            $locale_language = locale_get_primary_language($locale);
            $locale_array = array('language' => $locale_language,
                                 'region' => $locale_region);
            if ((strtolower($language_code) == $locale_language) && ($country_code == '')) {
                return locale_compose($locale_array);
            } elseif ((strtolower($language_code) == $locale_language) && (strtoupper($country_code) == $locale_region)) {
                return locale_compose($locale_array);
            }
        }

        return null;
    }
}
