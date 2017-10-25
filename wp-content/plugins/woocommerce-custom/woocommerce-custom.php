<?php
/**
 * Plugin Name:       WooCommerce Custome
 * Plugin URI:        http://fgc.vn
 * Description:       Process ajax add to cart
 * Version:           1.0
 * Author:            Nguyen Truong
 * Author URI:        http://fgc.vn
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */
function fgc_woocommecer_add_hook_custom(){

	$action = isset($_REQUEST['fgcaction'])?$_REQUEST['fgcaction']:'';
	switch($action){
		case 'addProduct':
			//print_r($_REQUEST);
			//global $woocommerce;
			//echo  $_REQUEST['products'];
			//WC_AJAX::init();
			$post_id = isset($_REQUEST['products'])? $_REQUEST['products']:0;
			//$_POST['quantity'] = 1;
			//global $woocommerce;
			//print_r($woocommerce->cart);
			//WC_AJAX::add_to_cart($_REQUEST['products']) ;
			//echo $_POST['product_id'];
			WC()->cart->add_to_cart( $post_id, 1 );
			//echo WC()->cart->get_cart_contents_count(); in ra số sản phẩm trong giỏ
			break;
		
	}
	if($action){
		exit();
	}
	return true;
}
add_action('wp_loaded','fgc_woocommecer_add_hook_custom');
