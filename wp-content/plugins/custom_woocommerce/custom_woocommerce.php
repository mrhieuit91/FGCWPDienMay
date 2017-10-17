<?php
/**
 * Plugin Name:       Custome WooCommerce
 * Plugin URI:        http://wpbean.com/plugins/
 * Description:       Highly customizable product image zoom plugin for Woocommerce Store. 
 * Version:           1.02.4
 * Author:            Nguyen Truong
 * Author URI:        http://wpbean.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-image-zoom
 * Domain Path:       /languages
 */

$action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
switch($action){
case 'addProduct':
//print_r($_REQUEST);
//global $woocommerce;
WC()->cart->add_to_cart( $_REQUEST['productid2']);
break;

}
if($action){
	exit();
}
?>