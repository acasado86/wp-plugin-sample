/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery( function ( $ ) {
    /*global woocommerce_admin_meta_boxes, woocommerce_admin, accounting, woocommerce_admin_meta_boxes_order */
    $("#wp-plugin-sample-form input[type='submit']").on( 'click', function () {
        $("#wp-plugin-sample-form pre").remove();
        var data = {
                action:                 'wp_sample_plugin_email_search',
                email: $( "#wp-plugin-sample-form input[type='email']" ).val()
        };

        $.post( ajaxurl, data, function( response ) {
            $("#wp-plugin-sample-form").append('<pre>'+JSON.stringify(response)+'</pre>');
        });
    });    
});