jQuery(document).ready(function($) {
    $("#facebook_messenger_custom").change(function(){
        $(".nj-facebook_messenger").toggleClass("hidden");
    })
    $(".facebook_messenger_backgroud_default").click(function(e){
        $(".wp-color-result").css("background-color","#0075ff");
        $("#facebook_messenger_backgroud").val("#0075ff");
        return false;
    });
});
