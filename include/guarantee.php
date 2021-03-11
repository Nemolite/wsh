<?php
/**
 * Function for Garantee
 */


/**
 * Adding a custom field ( Guarantee ) to products 
 * @see Admin panel, Products, General
 */
add_action( 'woocommerce_product_options_general_product_data', 'wsh_add_custom_field_guarantee' );
function wsh_add_custom_field_guarantee() {
	global $product, $post;    
	echo '<div class="options_group">';

    $post_id = $post->ID;
    $meta_key_field = '_guarantee_field';
    
    $value =  get_post_meta( $post_id, $meta_key_field, true);    
    
    woocommerce_wp_text_input( array(
        'id'                => '_guarantee_field',
        'label'             => __( 'Guarantee to product '.'('.get_woocommerce_currency_symbol().')', 'woocommerce' ),
        'placeholder'       => 'price',
        'description'       => __( 'Only one year', 'woocommerce' ),
        'type'              => 'number',
        'value'            =>  $value,
        'custom_attributes' => array(
           'step' => 'any',
           'min'  => '0',
        ),
     ) );
	echo '</div>';
}

/**
 * Storege meta_field guarantee (BD, $products)
 */
add_action( 'woocommerce_process_product_meta', 'wsh_custom_fields_save_guarantee', 10 );
function wsh_custom_fields_save_guarantee( $post_id ) {

	$product = wc_get_product( $post_id );	
	
	$number_field = isset( $_POST['_guarantee_field'] ) ? sanitize_text_field( $_POST['_guarantee_field'] ) : '';
	$product->update_meta_data( '_guarantee_field', $number_field );    
	
	$product->save();

}



 /**
 * Transfer
 * 
 * @param $product_id, $flag - method (POST)
 * @return void
 */
add_action( 'wp_ajax_transfer', 'wsh_transfer' );
add_action( 'wp_ajax_nopriv_transfer','wsh_transfer' );
function wsh_transfer() {

    $user_id = get_current_user_id();

    if ( isset( $_POST['product_id'] ) ) {
        $product_id = sanitize_text_field( $_POST['product_id'] );        
    }

    if ( isset( $_POST['flag'] ) ) {
        $flag = sanitize_text_field( $_POST['flag'] );        
    }

    $meta_key = '_guarantee_flag';   

    if ($flag) {        
        update_post_meta( $product_id, $meta_key, $flag );

        
        $meta_key_guarantee = 'flag__guarantee';
        $meta_value_guarantee = 1;

        update_user_meta( $user_id, $meta_key_guarantee, $meta_value_guarantee );

    } else {
        update_post_meta( $product_id, $meta_key, $flag );

        $meta_key_guarantee = 'flag__guarantee';
        $meta_value_guarantee = 0;

        update_user_meta( $user_id, $meta_key_guarantee, $meta_value_guarantee );
    }
	echo $product_id;
    die();

}


/**
 * Show Garantee in the Your Order 
 * 
 */
function whs_cart_totals_guarantee_html($arr_products_id){
    $total = 0;

    $unique = array_unique($arr_products_id);    
    $meta_key_price = '_guarantee_field';  
    
    for( $i = 0; $i < count($unique); $i++ ){             
     
        $total = $total + get_post_meta( $unique[ $i] , $meta_key_price, true );
    
    }

    $user_id = get_current_user_id();
    $meta_key = 'total__guarantee';
    $meta_value = $total;

    update_user_meta( $user_id, $meta_key, $meta_value );

    return get_woocommerce_currency_symbol() . $total;
}

/**
 * Checker
 */

function checker_style_html($product_id){

    $meta_key = '_guarantee_flag';  
    $value = get_post_meta( $product_id, $meta_key, true );
    if($value){
        return $value;
    } else {
        $value_zero = 0;
        return $value_zero;
    }

}

add_filter( 'wsh_checker_style_html', 'checker_style_html', 10, 1  );

?>