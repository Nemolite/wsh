<?php
/**
 * Function for Delivery 
 */


/**
 * Adding a custom field ( Commission cash on delivery ) to products 
 * @see Admin panel, Products, General
 */
add_action( 'woocommerce_product_options_general_product_data', 'wsh_add_custom_field_delivery' );
function wsh_add_custom_field_delivery() {
	global $product, $post; 

    $post_id = $post->ID;
    $meta_key_field = '_delivery_field';
    
    $value =  get_post_meta( $post_id, $meta_key_field, true);  

	echo '<div class="options_group">';
    woocommerce_wp_text_input( array(
        'id'                => '_delivery_field',
        'label'             => __( 'Сash on delivery '.'('.get_woocommerce_currency_symbol().')', 'woocommerce' ),
        'placeholder'       => 'price',
        'description'       => __( 'Commission', 'woocommerce' ),
        'type'              => 'number',
        'value'            => $value,
        'custom_attributes' => array(
           'step' => 'any',
           'min'  => '0',
        ),
     ) );
	echo '</div>';
}

/**
 * Storege meta_field "delivery" (BD, $products)
 */
add_action( 'woocommerce_process_product_meta', 'wsh_custom_fields_delivery_save', 20 );
function wsh_custom_fields_delivery_save( $post_id ) {
 
	$product = wc_get_product( $post_id );	
	
	$number_field = isset( $_POST['_delivery_field'] ) ? sanitize_text_field( $_POST['_delivery_field'] ) : '';
	$product->update_meta_data( '_delivery_field', $number_field );
   
    $product->save();

}

/**
 * Add a custom fee (fixed or based cart subtotal percentage) by payment
 */
add_action( 'woocommerce_cart_calculate_fees', 'custom_handling_fee' );
function custom_handling_fee ( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    $chosen_payment_id = WC()->session->get('chosen_payment_method');

    if ( empty( $chosen_payment_id ) )
        return;

    // $subtotal = $cart->subtotal;

    $arr_product_id = array();
    $wsh_cart = WC()->session->get('cart');
        foreach($wsh_cart as $k =>$inner){
	        $arr_product_id[] = $inner['product_id'];     
        }
        $product_id = $arr_product_id[0];
    
    $meta_key_delivery = '_delivery_field';
    $delivery  = intval(get_post_meta( $product_id,  $meta_key_delivery , true ));

    // SETTINGS: Here set in the array the (payment Id) / (fee cost) pairs
    $targeted_payment_ids = array(
        'cod' => $delivery, // Fixed fee     
    );

    // Loop through defined payment Ids array
    foreach ( $targeted_payment_ids as $payment_id => $fee_cost ) {
        if ( $chosen_payment_id === $payment_id ) {
            $cart->add_fee( __('Commission for payment after delivery', 'woocommerce'), $fee_cost, true );
        }
    }
}


// jQuery - Update checkout on payment method change
add_action( 'wp_footer', 'custom_checkout_jquery_script' );
function custom_checkout_jquery_script() {
    if ( is_checkout() && ! is_wc_endpoint_url() ) :
    ?>
    <script type="text/javascript">
    jQuery( function($){
        $('form.checkout').on('change', 'input[name="payment_method"]', function(){
            $(document.body).trigger('update_checkout');
        });
    });
    </script>
    <?php
    endif;
}



?>