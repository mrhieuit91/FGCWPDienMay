<?php
require(dirname(dirname(dirname(dirname(dirname(dirname( __FILE__ )))))) . '\wp-blog-header.php' );
$product_id= get_the_ID();
//$cart = new WC_Cart();
//@WC_AJAX::add_to_cart();
WC()->cart->add_to_cart( $product_id, 1 );
//do_action( 'woocommerce_add_product_to_cart_item' );
//echo "đã có trong giỏ hàng";
?>