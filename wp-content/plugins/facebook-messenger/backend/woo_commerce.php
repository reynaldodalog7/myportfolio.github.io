<?php
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
/*
* Add Upload style and script
*/
add_action( 'admin_enqueue_scripts', 'facebook_messenger_woo_admin_enqueue_scripts' );
function facebook_messenger_woo_admin_enqueue_scripts(){
    wp_enqueue_script('facebook_messenger', FACEBOOK_MESSENGER_PLUGIN_URL . 'backend/js/script.js');
}
/* Adds a meta box to the post edit screen */
add_action( 'add_meta_boxes', 'facebook_messenger_add_custom_box' );
function facebook_messenger_add_custom_box() {
        add_meta_box(
            'facebook_messenger',            // Unique ID
            'Facebook Messenger',      // Box title
            'facebook_messenger_callback',  // Content callback
             array("product")
        );
}
function facebook_messenger_callback($post){
 wp_nonce_field( plugin_basename( __FILE__ ), 'facebook_messenger_meta' );
    ?>
    <table class="form-table" id="formthemtap">
        <tr valign="top" >
            <th><?php echo __("Enable","bhd") ?></th>
            <td>
                <input <?php checked(1,get_post_meta($post->ID,"_facebook_messenger_enable",true)) ?> value="1" name="facebook_messenger_enable" type="checkbox"/>
             </td>
        </tr>
        <tr valign="top" >
            <th><?php echo __("Custom Fanpage Facebook","bhd") ?></th>
            <td>
                <input <?php checked(1,get_post_meta($post->ID,"_facebook_messenger_custom",true)) ?> value="1" name="facebook_messenger_custom" id="facebook_messenger_custom" type="checkbox"/>
             </td>
        </tr>
        <tr valign="top" class="nj-facebook_messenger <?php if( get_post_meta($post->ID,"_facebook_messenger_custom",true) != 1 ){echo 'hidden';} ?>" >
            <th><?php echo __("Custom Fanpage Facebook URL","bhd") ?></th>
            <td>
                <input value="<?php echo get_post_meta($post->ID,"_facebook_messenger_url",true) ?>" name="facebook_messenger_url" type="text" class="regular-text"/>
             </td>
        </tr>

    </table> <?php
}
add_action( 'save_post', 'facebook_messenger_save_postdata' );
function facebook_messenger_save_postdata( $post_id ) {
     global $wpdb;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return;
  if ( !wp_verify_nonce( @$_POST['facebook_messenger_meta'], plugin_basename( __FILE__ ) ) )
      return;

  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }
    $facebook_messenger_enable = $_POST["facebook_messenger_enable"];
    add_post_meta($post_id, '_facebook_messenger_enable', $facebook_messenger_enable,true) or update_post_meta($post_id, '_facebook_messenger_enable', $facebook_messenger_enable);

    $facebook_messenger_custom = $_POST["facebook_messenger_custom"];
    add_post_meta($post_id, '_facebook_messenger_custom', $facebook_messenger_custom,true) or update_post_meta($post_id, '_facebook_messenger_custom', $facebook_messenger_custom);

    $facebook_messenger_url = $_POST["_facebook_messenger_url"];
    add_post_meta($post_id, '_facebook_messenger_url', $facebook_messenger_url,true) or update_post_meta($post_id, '_facebook_messenger_url', $facebook_messenger_url);
}