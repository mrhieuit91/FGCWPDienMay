<?php
require(dirname(dirname(dirname(dirname(dirname(dirname( __FILE__ )))))) . '\wp-blog-header.php' );
add_filter('add_to_cart_redirect', 'custom_add_cart_redirect');
  
function custom_add_cart_redirect() {
     return wc_get_page_permalink( 'cart' ); // Replace with the url of your choosing
}
	
?>