<?php
/*
Plugin Name:  Hide Shipping Fields For Local Pickup
Description:  Hides shipping fields in WooCommerce checkout, if local pickup shipping method is selected
Version:      1.0
Author:       Linas Kondratavicius 
Author URI:   https://www.linkedin.com/in/l%C3%ACnas/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

add_action( 'woocommerce_after_checkout_form', 'hide_shipping_for_local_pickup' );

function hide_shipping_for_local_pickup() {
    $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
    $chosen_shipping = $chosen_methods[0];
    if ( 0 === strpos( $chosen_shipping, 'local_pickup' ) ) {
        wc_enqueue_js(
            "$('#ship-to-different-address input').prop('checked', false).change().closest('h3').hide();"
        );
    }

    wc_enqueue_js(
        "$('form.checkout').on('change','input[name^=\"shipping_method\"]',function() {
            var val = $( this ).val();
            if (val.match('^local_pickup')) {
                $('#ship-to-different-address input').prop('checked', false).change().closest('h3').hide();
            } else {
                $('#ship-to-different-address input').prop('checked', true).change().closest('h3').show();
            }
        });"
    );  
}