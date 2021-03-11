<?php
/**
 * Modification Cart Page
 *
 * 
 * @version 1.0.0
 */
defined( 'ABSPATH' ) || exit;

/**
 * Including modules for a cart, checkout, orders
 */
require 'guarantee.php';
require 'insurance.php';
require 'surprise.php';
require 'delivery.php';

require 'orders.php';

/**
 * Helper
 */

 function show($param){
     echo "<pre>";
     print_r($param);
     echo "</per>";
 }

/**
 * Including scripts for a child theme
 */
function wsh_register_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );
	
	wp_enqueue_script( 'modification-js', get_stylesheet_directory_uri() . '/assets/js/modification.js', array(), $theme_version, true );	

}
add_action( 'wp_enqueue_scripts', 'wsh_register_scripts' );

/**
 * Remove blocks of the header (cart)
 *
 * @return void
 */
function wsh_remove_header_cart(){
    if( is_cart() ){
        remove_all_actions ('storefront_header');
        remove_all_actions ( 'storefront_before_content');                
    }
}
add_action('wp_head', 'wsh_remove_header_cart' );

/**
 * Remove a title of cart
 */

function storefront_page_header() {
    if ( is_front_page() && is_page_template( 'template-fullwidth.php' ) ) {
        return;
    }
    ?>
    <header class="entry-header">
        <?php
        storefront_post_thumbnail( 'full' );
       // the_title( '<h1 class="entry-title">', '</h1>' );
        ?>
    </header><!-- .entry-header -->
    <?php
}

/**
 * Remove blocks of the header (checkout)
 *
 * @return void
 */
function wsh_remove_header_checkout(){
    if( is_checkout() ){
        remove_all_actions ('storefront_header');
        remove_all_actions ( 'storefront_before_content');
        remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );         
    }
}
add_action('wp_head', 'wsh_remove_header_checkout' );

/**
 * Timer in the header (checkout)
 *
 * @return void
 */
function wsh_adding_time_header_checkout(){
    if( ( is_checkout() )&&( !is_order_received_page() ) ){ ?>
        <div class="checkout-timer">
            <p><?php esc_html_e( 'Due to the high interest in a given product, its availability decreases very quickly. Your order has been reserved on', 'wsh' );  ?>
                <span id="worked">10:00</span>
                <?php esc_html_e( 'minute', 'wsh' );  ?>
            </p>
        </div>        
    <?php }
}
add_action('wp_head', 'wsh_adding_time_header_checkout' );

/**
 * Get order total html including inc tax if needed.
 */
function wsh_cart_totals_order_total_html() {   
    
	$value = '<strong>' . WC()->cart->get_total() . '</strong> ';
    
	// If prices are tax inclusive, show taxes here.
	if ( wc_tax_enabled() && WC()->cart->display_prices_including_tax() ) {
		$tax_string_array = array();
		$cart_tax_totals  = WC()->cart->get_tax_totals();

		if ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) {
			foreach ( $cart_tax_totals as $code => $tax ) {
				$tax_string_array[] = sprintf( '%s %s', $tax->formatted_amount, $tax->label );
			}
		} elseif ( ! empty( $cart_tax_totals ) ) {
			$tax_string_array[] = sprintf( '%s %s', wc_price( WC()->cart->get_taxes_total( true, true ) ), WC()->countries->tax_or_vat() );
		}

		if ( ! empty( $tax_string_array ) ) {
			$taxable_address = WC()->customer->get_taxable_address();
			if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
				$country = WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ];
				/* translators: 1: tax amount 2: country name */
				$tax_text = wp_kses_post( sprintf( __( '(includes %1$s estimated for %2$s)', 'woocommerce' ), implode( ', ', $tax_string_array ), $country ) );
			} else {
				/* translators: %s: tax amount */
				$tax_text = wp_kses_post( sprintf( __( '(includes %s)', 'woocommerce' ), implode( ', ', $tax_string_array ) ) );
			}

			$value .= '<small class="includes_tax">' . $tax_text . '</small>';
           
		}
	}    
   
	echo apply_filters( 'woocommerce_cart_totals_order_total_html', $value ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    
}

/**
 * Display a block benefit
 */
function wsh_checkout_order_review(){
    ?>
    <div class="benefit">   
        <div class="icons-block">
            <div class="icon-top">
            <img class="icon_shop lazyload loaded" src="https://pl.easy-shop.eu/wp-content/themes/itereon/assets/dist/img/shield.svg" data-ll-status="loaded">
            </div>
            <div class="text-botton">
            <?php esc_html_e( '100% safe shopping', 'wsh' );  ?>
            </div>  
        </div>
        <div class="icons-block">
            <div class="icon-top">
            <img class="icon_shop lazyload loaded" src="https://pl.easy-shop.eu/wp-content/themes/itereon/assets/dist/img/boy-broad-smile.svg" data-ll-status="loaded">
            </div>
            <div class="text-botton">
            <?php esc_html_e( '100% satisfaction guarantee', 'wsh' );  ?>
            </div>  
        </div>
        <div class="icons-block">
            <div class="icon-top">
            <img class="icon_shop lazyload loaded" src="https://pl.easy-shop.eu/wp-content/themes/itereon/assets/dist/img/delivery.svg" data-ll-status="loaded">
            </div>
            <div class="text-botton">
            <?php esc_html_e( 'Free fast shipping', 'wsh' );  ?>
            </div> 
        </div>
        <div class="icons-block">
            <div class="icon-top">
            <img class="icon_shop lazyload loaded" src="https://pl.easy-shop.eu/wp-content/themes/itereon/assets/dist/img/shopping.svg" data-ll-status="loaded">
            </div>
            <div class="text-botton">
            <?php esc_html_e( 'Payment also on delivery', 'wsh' );  ?>
            </div>  
        </div>       
    </div>
    <?php
 }

 add_action('woocommerce_checkout_order_review','wsh_checkout_order_review',30);

/**
 *  Modification shipping a block
 * 
 */

function wsh_cart_totals_shipping_html() {
	$packages = WC()->shipping()->get_packages(); 
    
 	$first    = true;

	foreach ( $packages as $i => $package ) {

		$chosen_method = isset( WC()->session->chosen_shipping_methods[ $i ] ) ? WC()->session->chosen_shipping_methods[ $i ] : '';
		$product_names = array();

		if ( count( $packages ) > 1 ) {
			foreach ( $package['contents'] as $item_id => $values ) {
				$product_names[ $item_id ] = $values['data']->get_name() . ' &times;' . $values['quantity'];
			}
			$product_names = apply_filters( 'woocommerce_shipping_package_details_array', $product_names, $package );
		}

		wc_get_template(
			'cart/cart-shipping.php',
			array(
				'package'                  => $package,
				'available_methods'        => $package['rates'],
				'show_package_details'     => count( $packages ) > 1,
				'show_shipping_calculator' => is_cart() && apply_filters( 'woocommerce_shipping_show_shipping_calculator', $first, $i, $package ),
				'package_details'          => implode( ', ', $product_names ),
				/* translators: %d: shipping package number */
				'package_name'             => apply_filters( 'woocommerce_shipping_package_name', ( ( $i + 1 ) > 1 ) ? sprintf( _x( 'Shipping %d', 'shipping packages', 'woocommerce' ), ( $i + 1 ) ) : _x( 'Shipping', 'shipping packages', 'woocommerce' ), $i, $package ),
				'index'                    => $i,
				'chosen_method'            => $chosen_method,
				'formatted_destination'    => WC()->countries->get_formatted_address( $package['destination'], ', ' ),
				'has_calculated_shipping'  => WC()->customer->has_calculated_shipping(),
			)
		);

		$first = false;
	}
}

/**
 * Cart ajax btn (arrows)
 * 
 */  
  function wsh_cart_refresh_update_qty() {
    if (is_cart()) {
       ?>
       <script type="text/javascript">
          jQuery('div.woocommerce').on('click', 'input.qty', function(){
             jQuery("[name='update_cart']").trigger("click");
          });
       </script>
       <?php
    }
 }
 add_action( 'wp_footer', 'wsh_cart_refresh_update_qty' ); 

/**
 * tooltip
 * 
 * @param $product_id
 * @return void
 */
add_action( 'wp_ajax_transfer_tooltip', 'wsh_transfer_tooltip' );
add_action( 'wp_ajax_nopriv_transfer_tooltip','wsh_transfer_tooltip' );
function wsh_transfer_tooltip() {
    global $post, $woocommerce;

    if ( isset( $_POST['product_id'] ) ) {
        $product_id = sanitize_text_field( $_POST['product_id'] );        
    }   

    $woocommerce->cart->add_to_cart( $product_id );
	
    die();
}

/**
 * Calculatros (Garantee,Insurance,Surprise,Commission)
 */
add_action( 'woocommerce_after_calculate_totals', 'woocommerce_calculate_total', 10, 1 ); 
    function woocommerce_calculate_total( $cart ) {
        global $post, $woocommerce;
        
        $user_id = get_current_user_id();
        $meta_key_guarantee_flag = 'flag__guarantee';
        $guarantee_flag = intval(get_user_meta( $user_id,  $meta_key_guarantee_flag, true ));
        
        if(1==$guarantee_flag) {
            $meta_key_guarantee = 'total__guarantee';         
            $guarantee = intval(get_user_meta( $user_id,  $meta_key_guarantee, true ));
            $cart->total += $guarantee;
        }    
        
        
        
        $meta_key_insurance_flag = 'flag__insurance';
        $insurance_flag = intval(get_user_meta( $user_id,  $meta_key_insurance_flag, true ));
      
        if(1==$insurance_flag) {
            $meta_key_insurance = 'total__insurance';
            $insurance  = intval(get_user_meta( $user_id,  $meta_key_insurance , true ));
            $cart->total += $insurance ;
        } 

        if(0==$insurance_flag) {
            $meta_key_insurance = 'total__insurance';
            $insurance  = intval(get_user_meta( $user_id,   $meta_key_insurance , true ));
            $cart->total -= $insurance;
        }        


}


/**
 * Discont
 * castem field o-discount
 */
add_filter( 'wsh_discount_percendtage', 'discount_percendtage', 10, 1 );
function discount_percendtage( $product_id ){
    $meta_key = 'o-discount';
    $meta_type = 'post';
    $object_id = $product_id;

    $check = metadata_exists( $meta_type, $object_id, $meta_key );

    if ($check) {      
        $check_discount = get_post_meta($product_id,$meta_key,false);
        if($check_discount[0]['type'] !== 'percentage'){
            $discount = get_post_meta($product_id,$meta_key,false);
        } else {
            $discount = array();
        }
    }  
              
    return $discount;
}

/**
 * Price for adding next item in cart
 * 
 */
function wsh_discount_show_total_html($product_id) {
    $total_price = 0;
	
	$current_quantity = wsh_get_product_quantity_in_cart_by_product_id($product_id);
	
	$product_meta = get_post_meta($product_id);
	$initial_product_price = (int)($product_meta["_price"][0]);
	$productDiscount = $product_meta['o-discount'][0];

	$posTwoDiscount = strripos($productDiscount, '";}i:1;a:3');
	$posThreeDiscount = strripos($productDiscount, '";}}}');

	$twoProductDiscount = ((int)substr($productDiscount, $posTwoDiscount - 2 , 2))/100;
	$threeProductDiscount = ((int)substr($productDiscount, $posThreeDiscount - 2 , 2))/100;
	
	$current_total_price = wsh_get_line_subtotal_in_cart_by_product_id($product_id);
	
	if( $current_quantity == 1) {
		$total_price_with_additional = $initial_product_price * (1 - $twoProductDiscount) * ($current_quantity + 1);
		return $total_price_with_additional - $current_total_price;
	}
	else {
		$total_price_with_additional = $initial_product_price * (1 - $threeProductDiscount) * ($current_quantity + 1);
		return $total_price_with_additional - $current_total_price;
	}
}

function wsh_get_product_quantity_in_cart_by_product_id($product_id){
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		if($cart_item["product_id"] == $product_id){
			return $cart_item["quantity"];
		}
	}
	
	return 0;
}

function wsh_get_line_subtotal_in_cart_by_product_id($product_id){
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		if($cart_item["product_id"] == $product_id){
			return $cart_item["line_subtotal"];
		}
	}
	
	return 0;	
}
?>