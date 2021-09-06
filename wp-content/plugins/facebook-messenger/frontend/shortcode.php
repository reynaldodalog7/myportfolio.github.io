<?php
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
function facebook_messenger_shortcode( $atts, $content = null){
ob_start();
    $facebook_messenger_display = get_option("facebook_messenger_display");
	$array = shortcode_atts( array(
        'url' => get_option("facebook_messenger_user"),
        'hide_cover' => ($facebook_messenger_display==0)?"true":"false",
        'lagre_header' => ($facebook_messenger_display==2)?"true":"false",
        'button' => "false",
        'id' =>"false"
    ), $atts );
    if ( $array["id"] == "false" ){
        $id ="nj-facebook-messenger-".rand ( 100 , 999 );
    ?>
  <a class="nj-facebook-messenger <?php echo $id ?>_open" href="#"><?php if( $array["button"] == "false"){?><?php echo get_option("facebook_messenger_text_botton") ?> <?php }else{ echo $array["button"];} ?></a>
    <?php }else{
        $id = $array["id"];
    } ?>
  <div id="<?php echo $id ?>" class="facebook_messenger_popup">
        <?php if( $content ){?>
        <div class="facebook-messenger-popup-container">
            <?php echo $content ?>
        </div>
        <?php } ?>
        <div class="fb-page" data-with="350" data-height="310" data-href="<?php echo $array['url'] ?>" data-tabs="messages" data-small-header="<?php if( $array["lagre_header"] == "false"){echo "true";}else{echo "false";} ?>" data-adapt-container-width="true" data-hide-cover="<?php echo $array["hide_cover"] ?>" data-show-facepile="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="<?php echo $array['url'] ?>"><a href="<?php echo $array['url'] ?>">Loading...</a></blockquote></div></div>
        <?php if( wp_is_mobile() ) : ?>
        <div class="send-app">
            <?php  $ms = explode("https://www.facebook.com/",$array['url'] ); ?>
            <a href="https://www.messenger.com/t/<?php echo $ms[1] ?>"><?php _e("Send message via your Messenger App","fb_messenger") ?></a>
        </div>
        <?php endif; ?>
  </div>
  <script type="text/javascript">
  jQuery(document).ready(function($) {
      $('#<?php echo $id ?>').popup({
          transition: 'all 0.3s',
          scrolllock: true, // optional
          closebutton: true
        });
    });
  </script>
    <?php
return ob_get_clean();
}
add_shortcode( 'messenger', 'facebook_messenger_shortcode' );