jQuery(document).ready(function() {  
       
    function transfer( productID, flag ) {
        jQuery.ajax({
            url: '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'transfer',
                product_id: productID,
                flag: flag
            }
        });
    }	
    
    const hovertext = ( id ) => {
 
    jQuery( `#garantee-text_${id}` ).hover(
        function(){ 
	        jQuery( `#garantee-text-hover_${id}` ).show(); 
  	        }, 
        function(){ 
            jQuery( `#garantee-text-hover_${id}` ).hide(); 
	     
        });
    }  
    
    const addtobtn = ( id ) => {
        jQuery( `#garantee_btn_${id}` ).on( 'click', function() {
         
        const dataProductID = jQuery(`#product-name__garantee_${id}`).attr("data-product_id");        

        transfer(dataProductID,1);

            jQuery( `#garantee-text_cancel_${id}` ).show(); 
            jQuery( `.garantee-text_${id}` ).hide(); 
        });
    }

    const cancelbtn = ( id ) => {
        jQuery( `#garantee-text_cancel_${id}` ).on( 'click', function() {

        const dataProductID = jQuery(`#product-name__garantee_${id}`).attr("data-product_id");        

        transfer(dataProductID,0);

            jQuery( `#garantee-text_cancel_${id}` ).hide(); 
            jQuery( `.garantee-text_${id}` ).show();
        });
    }

    const tooltip = ( id ) => {      
        jQuery('div.woocommerce').on( 'click', `#tooltip_btn_${id}`, function() { 
            productID = jQuery(`#product-name__tooltip_${id}`).attr("data-product_id");              

            let code_input = jQuery(`#tooltip_btn_${id}`).attr("data-index_value");                   
            let inner_code ='[name="' + code_input + '"]';
            let old_value = jQuery(inner_code).val(); 
            let new_value = parseInt(old_value) + 1;
            jQuery(inner_code).val(new_value);       

            jQuery.ajax({
                    url: '/wp-admin/admin-ajax.php',
                    type: 'POST',
                    data: {
                        action: 'transfer_tooltip',
                        product_id: productID                        
                    },success:function(){
                        setTimeout(jQuery(document.body).trigger('update_cart'),1000);                
                    } 
                });

        });
        
     }     
    
    const garantee_index = jQuery("input[name='garantee_index']").attr("data-index_full");    
    for ( let i = 1;i<=garantee_index;i++ ) {
        hovertext( i );
        addtobtn( i );
        cancelbtn ( i );       
        tooltip ( i );
      
    }      

    var $worked = jQuery("#worked");   

    function update() {
        var myTime = $worked.html();
        var ss = myTime.split(":");
        var dt = new Date();
        dt.setHours(0);
        dt.setMinutes(ss[0]);
        dt.setSeconds(ss[1]);

        var dt2 = new Date(dt.valueOf() - 1000);
        var temp = dt2.toTimeString().split(" ");
        var ts = temp[0].split(":");

        $worked.html(ts[1]+":"+ts[2]);
        let temper = setTimeout(update, 1000);        
        if ('00:00'===$worked.html()){
            clearTimeout(temper);
            jQuery(".checkout-timer").css("display", "none");
        } else {
            jQuery(".checkout-timer").css("display", "block"); 
        }
    }

    let globalTimer = setTimeout(update, 1000);
    if ('00:00'===$worked.html()){
        clearTimeout(globalTimer); 
    }  
    
});


function transfersurprise( productID, flag ) {
    jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: {
            action: 'transfer_surprise',
            product_id: productID,
            flag: flag
        },success:function(response){            
           jQuery("#wshresult").html(response);  
           setTimeout(jQuery(document.body).trigger('update_checkout'),1000);
        } 
    });
}		

jQuery(document).on("change", "input[name='surprise_checkbox']", function () {
    let flag;
    const dataProductID  = jQuery("input[name='surprise_checkbox']").attr('data-random_surprise');   
    if (this.checked) {       
        jQuery("#cart-surprise").show(100);
        flag = 1;
        transfersurprise( dataProductID, flag );      
    } else {
        jQuery("#cart-surprise").hide(100);
        flag = 0;
        transfersurprise( dataProductID, flag );       
    }
});



// in

function transferinsurance( productID, flag ) {
    jQuery.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: {
            action: 'transfer_insurance',
            product_id: productID,
            flag: flag
        },success:function(response){
            
            // jQuery("#wshresult").attr('data-random_surprise');  
        } 
    });
}		

jQuery(document).on("change", "input[name='insurance_checkbox']", function () {
    let flag;
    const dataProductID  = jQuery("input[name='surprise_checkbox']").attr('data-random_surprise');   
    if (this.checked) {
       
        jQuery("#insurance").show(100);
        flag = 1;
        transferinsurance( dataProductID, flag );
        setTimeout(jQuery(document.body).trigger('update_checkout'),2000);
    } else {
        jQuery("#insurance").hide(100);
        flag = 0;
        transferinsurance( dataProductID, flag );
        setTimeout(jQuery(document.body).trigger('update_checkout'),2000);
    }
});


   