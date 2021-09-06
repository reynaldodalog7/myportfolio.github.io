(function( $ ) {
    var frame;
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('#facebook_messenger_backgroud').wpColorPicker();
    });
    var fileInput = '';
    
    jQuery('#fecebook-messenger-upload').click(function() {
        event.preventDefault();
         var js_this = $(this);
         if (frame) {
              frame.open();
              return;
            }
            frame = wp.media({
              multiple: false,
            });
            frame.on('select', function() {
               var attachment = frame.state().get('selection').first().toJSON();
               js_this.prev().val(attachment.id);
            });
            frame.open();
            $("#fecebook-messenger-default-icon").removeClass("hidden");
        return false;
    });
    $("#facebook_messenger_text_img").change(function(e){
        $("#fecebook-messenger-default-icon").removeClass("hidden");
    })
    $("#facebook_messenger_backgroud").change(function(e){
        $(".facebook_messenger_backgroud_default").removeClass("hidden");
    })
    $("#facebook-messenger-checkall").change(function(){
        $(".facebook_messenger_hide_page").prop('checked', $(this).prop("checked"));
    })
    $("#facebook-messenger-checkall-1").change(function(){
        $(".facebook_messenger_show_page").prop('checked', $(this).prop("checked"));
    })
    $("#ninja-display-messenger").change(function(){
        var id = $(this).val();
        if ( id == 1 ) {
            $("#facebook-messenger-tr-show").removeClass("hidden");
            $("#facebook-messenger-tr-hide").addClass("hidden");
        }else{
            $("#facebook-messenger-tr-hide").removeClass("hidden");
            $("#facebook-messenger-tr-show").addClass("hidden");
        }
    })
    $("#fecebook-messenger-default-icon").click(function(e){
        $("#facebook_messenger_text_img").val(njt_t_fb_mess.url);
        return false;
    })
})( jQuery );