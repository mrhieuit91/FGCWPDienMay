<?php
define('WP_USE_THEMES', true);
/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
 	//$product_id= "44";
	//$product_id= get_the_ID();
	
	$product_id= $_REQUEST['products'];
	//echo $product_id;
	WC()->cart->add_to_cart( $product_id, 1 );

 	//echo "Đã có trong giỏ hàng";
// add_filter('add_to_cart_redirect', 'custom_add_cart_redirect');
  
//function custom_add_cart_redirect() {
	//$product_id = $_REQUEST['products'];
	//echo "Ten toi la {$_REQUEST['products']}  ";
    //$woocommerce->cart->add_to_cart( $product_id ); $_POST['product_id'];
 	//PRINT_R($_REQUEST);
//}

?>