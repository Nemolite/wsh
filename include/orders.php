<?php
/**
 * Function orders
 */

 /**
 * Prepare data and transfer in the Orders
 */
add_action('wsh_before_thankyou','wsh_before_thankyou_data',10,1);
function wsh_before_thankyou_data($order_id){

    $user_id =  get_current_user_id();

    $meta_key_flag = '_surprise_flag'; 
    $meta_key_field = '_surprise_field';

    $new_flag = get_user_meta( $user_id, $meta_key_flag, true );

    update_post_meta( $order_id, $meta_key_flag,  $new_flag );

    // insurance

    $meta_key_flag_insurance = '_surprise_flag'; 
    $meta_key_field_insurance = '_surprise_field';

    $new_flag_insurance = get_user_meta( $user_id, $meta_key_flag, true );

    update_post_meta( $order_id, $meta_key_flag_insurance,  $new_flag_insurance );

}


/**
 *  Data output in the orders section (Guarantee, Surprise, Insurance )
 */
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'wsh_show_data_orders_admin_panel', 40, 1 );
function wsh_show_data_orders_admin_panel() {
    global $woocommerce, $post;

    $order = new WC_Order($post->ID);    
    $order_id = $order->id;
?>
    <h3><?php esc_html_e( 'Additional Information', 'wsh' ); ?></h3>

 
   	
    <p class="none_set">
		<strong>							
			<?php esc_html_e( 'Guarantee on 1 year : ', 'wsh' ); ?>
		</strong>
			<?php esc_html_e( 'selected', 'wsh' );  ?>
	</p>


    <p class="none_set">
    <?php    
    
    $meta_key_flag = '_surprise_flag'; 

    $flag = get_post_meta( $order_id, $meta_key_flag, true );
   
    
     ?>
		<strong>							
			<?php esc_html_e( 'Random Surprise : ', 'wsh' ); ?>
		</strong>
        <?php if('yes'==$flag) { ?>
			<?php esc_html_e( 'selected', 'wsh' );  ?>
        <?php } else {?>
            <?php esc_html_e( 'disabled', 'wsh' );  ?>           
        <?php }?>   
	</p>


    <p class="none_set">

        <?php 
            $trenot = wc_get_order();    
            $order_id = $trenot->id;

            $meta_key_flag_insurance = '_surprise_flag'; 
            $meta_key_field_insurance = '_surprise_field';

            $flag_insurance = get_post_meta( $order_id, $meta_key_flag_insurance, true );
        ?>
		<strong>							
			<?php esc_html_e( 'Shipping insurance : ', 'wsh' ); ?>
		</strong>
		<?php if('yes'==$flag_insurance) { ?>
			<?php esc_html_e( 'selected', 'wsh' );  ?>
        <?php } else {?>
            <?php esc_html_e( 'disabled', 'wsh' );  ?>           
        <?php }?>  
	</p>

<?php		
}
?>