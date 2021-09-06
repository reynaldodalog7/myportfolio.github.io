<?php
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
/**
 * Adds Foo_Widget widget.
 */
class Facebook_Messenger_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'facebook_messenger_widget', // Base ID
			__( 'Facebook Messenger', 'fb_messenger' ), // Name
			array( 'description' => __( 'Facebook Messenger', 'fb_messenger' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
        $url = $instance['url'];
        $facebook_messenger_display = $instance['header'];
        $hide_cover = ($facebook_messenger_display==0)?"true":"false";
        $lagre_header = ($facebook_messenger_display==2)?"true":"false";
		echo do_shortcode('[messenger url="'.$url.'" hide_cover="'.$hide_cover.'" lagre_header="'.$lagre_header.'"]');
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Contact Messenger', 'fb_messenger' );
        $url = ! empty( $instance['url'] ) ? $instance['url'] : get_option("facebook_messenger_user");
        $header = ! empty( $instance['header'] ) ? $instance['header'] : 1;
		?>
		<p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label>
    		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        <p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php _e( esc_attr( 'Your Facebook Fan Page URL:' ) ); ?></label>
    		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="text" value="<?php echo $url?>">
		</p>
        <p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'header' ) ); ?>"><?php _e( esc_attr( 'Display header cover:' ) ); ?></label>
    		<select name="header">
                <option value="0"><?php _e("Hide","fb_messenger")?></option>
                <option value="1" <?php if ( $header == 1 ){ echo 'selected="selected"'; } ?> ><?php _e("Small header","fb_messenger") ?></option>
                <option value="2" <?php if ( $header == 2 ){ echo 'selected="selected"'; } ?> ><?php _e("Large header","fb_messenger") ?></option>
           </select>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : __( 'Contact Messenger', 'fb_messenger' );
        $instance['url'] = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : get_option("facebook_messenger_user");
        $instance['header'] = ( ! empty( $new_instance['header'] ) ) ? strip_tags( $new_instance['header'] ) : 1;

		return $instance;
	}

}
function register_facebook_messenger_widget() {
    register_widget( 'Facebook_Messenger_Widget' );
}
add_action( 'widgets_init', 'register_facebook_messenger_widget' );