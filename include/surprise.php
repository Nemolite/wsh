<?php
/**
 * Function for Surprise
 */  

 /**
 * Adding a custom field ( random surprise ) to products 
 * @see Admin panel, Products, General
 */
add_action( 'woocommerce_product_options_general_product_data', 'wsh_add_custom_field_surprise' );
function wsh_add_custom_field_surprise() {
	global $product, $post; 

    $post_id = $post->ID;
    $meta_key_field = '_surprise_field';
    
    $value =  get_post_meta( $post_id, $meta_key_field, true);  

	echo '<div class="options_group">';
    woocommerce_wp_text_input( array(
        'id'                => '_surprise_field',
        'label'             => __( 'Random surprise '.'('.get_woocommerce_currency_symbol().')', 'woocommerce' ),
        'placeholder'       => 'price',
        'description'       => __( 'Only upon delivery', 'woocommerce' ),
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
 * Storege meta_field "random surprise" (BD, $products)
 */
add_action( 'woocommerce_process_product_meta', 'wsh_custom_fields_surprise_save', 20 );
function wsh_custom_fields_surprise_save( $post_id ) {

	$product = wc_get_product( $post_id );	
	
	$number_field = isset( $_POST['_surprise_field'] ) ? sanitize_text_field( $_POST['_surprise_field'] ) : '';
	$product->update_meta_data( '_surprise_field', $number_field );    

    $product->save();

}

/**
 * Display "random surprise" 
 * 
 * @return html
 */
// add_action('woocommerce_checkout_order_review','wsh_show_random_surprise',30);
function wsh_show_random_surprise(){

    $arr_product_id = array();
    $wsh_cart = WC()->session->get('cart');
        foreach($wsh_cart as $k =>$inner){
	        $arr_product_id[] = $inner['product_id'];     
        }
        $product_id = $arr_product_id[0];
    ?>

<div class="random_surprise">
    <p>
        <?php esc_html_e( 'Insurance covers damage in transit - if the item is damaged during shipping, we will send you a new item immediately.', 'wsh' );  ?>
    </p>
    <input type="checkbox" data-random_surprise="<?php echo esc_html($product_id);?>" name="surprise_checkbox" id="surprise_checkbox_flag"><span><?php esc_html_e( 'Surprise from 22 (optional)', 'wsh' );  ?></span>
    <p>
        <?php esc_html_e( 'You cannot miss this unique surprise! A gift worth over 90 is available at a surprisingly low price of 22', 'wsh' );  ?>
    </p>
</div>    
   <?php
}

/**
 * Transfer Surprise
 * 
 * @param $product_id, $flag - method (POST)
 * @return void
 */
add_action( 'wp_ajax_transfer_surprise', 'wsh_transfer_surprise' );
add_action( 'wp_ajax_nopriv_transfer_surprise','wsh_transfer_surprise' );
function wsh_transfer_surprise() {

    global $post, $woocommerce;

    if ( isset( $_POST['product_id'] ) ) {
        $product_id = sanitize_text_field( $_POST['product_id'] );        
    }

    if ( isset( $_POST['flag'] ) ) {
        $flag = sanitize_text_field( $_POST['flag'] );        
    }
    
    $meta_key_field = '_surprise_field';
    $temp_value =  get_post_meta( $product_id, $meta_key_field, true);

  

show(WC()->cart);
	
    die();

}

/**
 * Show Surprise in the Your Order 
 * 
 */
function whs_cart_totals_surprise_html($arr_products_id){
    $total = 0;

    $unique = array_unique($arr_products_id); 
    $meta_key_price = '_surprise_field';  
    
    $max_price = 0;
    for( $i = 0; $i < count($unique); $i++ ){             

        $value = get_post_meta( $unique[ $i] , $meta_key_price, true );
            if ( $value > $max_price ) {
                $max_price = $value;               
            }
    }      
    return get_woocommerce_currency_symbol() . $max_price;
}

// Добавление радио-кнопок
add_action( 'woocommerce_review_order_before_payment', 'truemisha_checkout_options', 25 );
 
function truemisha_checkout_options() {
 
	// сначала получаем объект из сессий
	$surprise = WC()->session->get( 'surprise' );


    $products_id = array();
    foreach(WC()->session->cart as $key => $value){
        $products_id[] = $value['product_id'];
    }

	// если пусто, то ставим значение product_id
	$surprise = empty( $surprise ) ? $products_id[0] : $surprise;
 
	// выводим чекбокс
	//echo '<div id="truemisha-checkout-radio"><h3>Подарочная упаковка</h3>';

 
    woocommerce_form_field(
		'surprise',
		array(          
            'label' => __( 'Surprise from == ' ) . get_woocommerce_currency_symbol(). $products_id[0],
            'type'  => 'checkbox',
			'class' => array( 'form-row-wide' ),           
		),
		$selected 
	);
 
	//echo '</div>';
 
}
 
// пересчитываем заказ и добавляем сбор за сюрприз, если нужно
add_action( 'woocommerce_cart_calculate_fees', 'truemisha_radio_choice_fee', 25 );
 
function truemisha_radio_choice_fee( $cart ) {
 
	// ничего не делаем в админке и если не AJAX-запрос
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		return;
	}
 
	// получаем данные из сессий
	$value = WC()->session->get( 'surprise' );

    $products_id = array();
    foreach(WC()->session->cart as $key => $v){
        $products_id[] = $v['product_id'];
    }
 
    $value = $value + $products_id[0];
	// добавляем соответствующий сбор
	if ( $value ) {
		$cart->add_fee( 'Сюрприз==', $value );
	}
 
}
 
// сохраняем выбор в сессии
add_action( 'woocommerce_checkout_update_order_review', 'truemisha_set_session' );
 
function truemisha_set_session( $posted_data ) {
 
	parse_str( $posted_data, $output );
 
	if ( isset( $output[ 'surprise' ] ) ){
		WC()->session->set( 'surprise', $output[ 'surprise' ] );
	}
 
}





?>