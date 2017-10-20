<?php
/**
 * Plugin Name:       WooCommerce compare product 
 * Plugin URI:        http://fgc.vn
 * Description:       Process compare product 
 * Version:           1.0
 * Author:            Nguyen Truonggg
 * Author URI:        http://fgcd.vn
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

function fgc_woocommercer_add_hook_compare_product(){

	$action = isset($_REQUEST['fgcaction'])?$_REQUEST['fgcaction']:'';
	session_start();
	switch($action){
		case 'compareProduct':
			//print_r($_REQUEST);
			//global $woocommerce;
			//echo  $_REQUEST['products'];
			//WC_AJAX::init();
			$post_id = isset($_REQUEST['products'])?$_REQUEST['products']:0;
			//$_POST['quantity'] = 1;
			// echo $_POST['product_id'] ;
			//global $woocommerce;
			//print_r($woocommerce->cart);
			//WC_AJAX::add_to_cart($_REQUEST['products']) ;
			//echo $_POST['product_id'];
			//WC()->cart->add_to_cart( $_POST['product_id'], 1 );
			//echo WC()->cart->get_cart_contents_count(); in ra số sản phẩm trong giỏ

			break;
		
	}
	if($action){
		die();
	}
	return true;
}
add_action('wp_loaded','fgc_woocommercer_add_hook_compare_product');

/*function get_info_product(){

}*/
