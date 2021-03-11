<?php
/**
 * Function for Insurance
 */


/**
 * Adding a custom field ( insurance ) to products 
 * @see Admin panel, Products, General
 */
add_action( 'woocommerce_product_options_general_product_data', 'wsh_add_custom_field_insurance' );
function wsh_add_custom_field_insurance() {
	global $product, $post; 

    $post_id = $post->ID;
    $meta_key_field = '_insurance_field';
    
    $value =  get_post_meta( $post_id, $meta_key_field, true);  

	echo '<div class="options_group">';
    woocommerce_wp_text_input( array(
        'id'                => '_insurance_field',
        'label'             => __( 'Insurance '.'('.get_woocommerce_currency_symbol().')', 'woocommerce' ),
        'placeholder'       => 'price',
        'description'       => __( 'Shipment insurance', 'woocommerce' ),
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
 * Storege meta_field "insurance" (BD, $products)
 */
add_action( 'woocommerce_process_product_meta', 'wsh_custom_fields_insurance_save', 20 );
function wsh_custom_fields_insurance_save( $post_id ) {
 
	$product = wc_get_product( $post_id );	
	
	$number_field = isset( $_POST['_insurance_field'] ) ? sanitize_text_field( $_POST['_insurance_field'] ) : '';
	$product->update_meta_data( '_insurance_field', $number_field );

    $product->update_meta_data( '_insurance_flag', 1 );

    $product->save();

    $user_id =  get_current_user_id();
    $meta_key_insurance = 'flag__insurance';
    $meta_value_insurance = 1;

    update_user_meta( $user_id, $meta_key_insurance, $meta_value_insurance );

}


/**
 * Transfer Insurance
 * 
 * @param $product_id, $flag - method (POST)
 * @return void
 */
add_action( 'wp_ajax_transfer_insurance', 'wsh_transfer_insurance' );
add_action( 'wp_ajax_nopriv_transfer_insurance','wsh_transfer_insurance' );
function wsh_transfer_insurance() {

    if ( isset( $_POST['product_id'] ) ) {
        $product_id = sanitize_text_field( $_POST['product_id'] );        
    }

    if ( isset( $_POST['flag'] ) ) {
        $flag = sanitize_text_field( $_POST['flag'] );        
    }
    
    $meta_key_field = '_insurance_field';
    $temp_value =  get_post_meta( $product_id, $meta_key_field, true);

    $user_id =  get_current_user_id();


    if (1==$flag) {  
        
        $meta_key_insurance = 'flag__insurance';
        $meta_key_field = 'total__insurance';
        $meta_value_insurance = 1;

        update_user_meta( $user_id, $meta_key_insurance, $meta_value_insurance );        
        update_user_meta( $user_id, $meta_key_field, $temp_value );


    } else {

        $meta_key_insurance = 'flag__insurance';
        $meta_value_insurance = 0;

        update_user_meta( $user_id, $meta_key_insurance, $meta_value_insurance );

    }
    die();
}




 /**
 * Display insurance checkbox
 *
 * @return void
 */
function wsh_cart_totals_insurance_html() {

    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
            
    }  

    $meta_key_field = '_insurance_field';
    
    $price =  get_post_meta( $product_id, $meta_key_field, true); 
    ?>   
    <div class="wrapper_insurance_checkbox">
        <input type="checkbox" name="insurance_checkbox" id="insurance_checkbox" checked><span><?php esc_html_e( '  Insure your cargo for only', 'wsh' );  ?><?php echo get_woocommerce_currency_symbol(); ?><?php echo esc_html($price); ?><?php esc_html_e( '(optional)', 'wsh' );  ?></span>
    </div>
<?php
}

/**
 * Insurance (Find max price of flag=1)
 * 
 */
function whs_cart_insurance_html($arr_products_id){
    $total = 0;

    $unique = array_unique($arr_products_id);
    $meta_key_flag = '_insurance_flag';
    $meta_key_price = '_insurance_field';  
    
    $max_price = 0;
    for( $i = 0; $i < count($unique); $i++ ){             

        $falg = get_post_meta( $unique[ $i] , $meta_key_flag, true );

        if (1== $falg) {
            $value = get_post_meta( $unique[ $i] , $meta_key_price, true );
            if ( $value > $max_price ) {
                $max_price = $value;               
            }
        }       
            
    }

    $user_id = get_current_user_id();
    $meta_key = 'total__insurance';
    $meta_value = $max_price;

    update_user_meta( $user_id, $meta_key, $meta_value );    

    return get_woocommerce_currency_symbol() . $max_price;
}


?>