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
if ( ! function_exists( 'woocommerce_compare_product' ) ) {

	/**
	 * print button compare
	 *
	 * @subpackage    Loop
	 *
	 * @param array $args
	 */

	function woocommerce_compare_product() {
		//session_start();
	        //$action = isset($_REQUEST['fgcaction'])?$_REQUEST['fgcaction']:'';
		if(!session_id()){
			session_start();				
		}

		
		$list_product_in_compare = !empty($_SESSION['compares']) ? $_SESSION['compares'] : [];

        $found = false;
        $comparing_id = get_the_ID();
	  
			if ( is_array($list_product_in_compare) && in_array($comparing_id,$list_product_in_compare)) {
	                    $found = true;
	        }
	        if($found != false) {
	        
	        	$html  = '<button type="button" class="compare comparing" data-product-id="'.get_the_ID().'" onclick="window.location=\'?page_id=266\'">Đã có trong danh sách so sánh ( '.count($list_product_in_compare).' )</button> ';
			} else {
				$html = '<button type="button" class="compare btn-compare" data-product-id="'.get_the_ID().'">Thêm vào danh sách so sánh</button>';
			}
		echo $html;
	}
}
add_action( 'woocommerce_compare_product_to_view', 'woocommerce_compare_product', 10 );




if ( ! function_exists( 'fgc_woocommercer_add_hook_compare_product' ) ) {
	/**
	 * action add comppareproduct, delete compare product
	 *
	 * @subpackage    Loop
	 *
	 * @param array $args
	 */
	function fgc_woocommercer_add_hook_compare_product(){
		include 'woocommerce-admin-compare.php';
		$action = isset($_REQUEST['fgcaction'])?$_REQUEST['fgcaction']:'';
		if(!session_id()){
			session_start();

		}
		switch($action){
			case 'addProduct':
	 			//print_r($_REQUEST);
	 			//global $woocommerce;
	 			//echo  $_REQUEST['products'];
	 			//WC_AJAX::init();
	 			$post_id = isset($_REQUEST['product_id'])? $_REQUEST['product_id']:[];
	 			//$_POST['quantity'] = 1;
	 			//global $woocommerce;
	 			//print_r($woocommerce->cart);
	 			//WC_AJAX::add_to_cart($_REQUEST['products']) ;
	 			//echo $_POST['product_id'];
//	 			var_dump( $post_id);
	 			WC()->cart->add_to_cart( $post_id, 1 );
	 			echo WC()->cart->get_cart_contents_count();
	 			//echo WC()->cart->get_cart_contents_count(); in ra số sản phẩm trong giỏ
	 			break;
			case 'addcompareProduct':
				//print_r($_REQUEST);
				//global $woocommerce;
				//echo  $_REQUEST['products'];
				//WC_AJAX::init();
				$product_compare_id = isset($_REQUEST['product_id'])?$_REQUEST['product_id'] : 0;
				//var_dump( $_SESSION['compares']);
				// 	echo '<pre>';
				// print_r($_SESSION['compares']);
				// echo '</pre>';
				$list_product_in_compare = !empty($_SESSION['compares']) ? $_SESSION['compares'] : array();

				if ( !in_array($product_compare_id,$list_product_in_compare ) ){
					$list_product_in_compare[] = $product_compare_id;
					$_SESSION['compares'] = $list_product_in_compare;
				}
				$num = count($_SESSION['compares']);
				echo $num;
				
				//$_POST['quantity'] = 1;
				// echo $_POST['product_id'] ;
				//global $woocommerce;
				//print_r($woocommerce->cart);
				//WC_AJAX::add_to_cart($_REQUEST['products']) ;
				//echo $_POST['product_id'];
				//WC()->cart->add_to_cart( $_POST['product_id'], 1 );
				//echo WC()->cart->get_cart_contents_count(); in ra số sản phẩm trong giỏ
				break;
				
			case 'deletecomparingProduct':

				$product_compare_id = isset($_REQUEST['product_id'])?$_REQUEST['product_id']:[""];
				
				foreach($_SESSION['compares']  as $key=>$value_id)
				{

				    if($value_id == $product_compare_id)
				    {
				        unset($_SESSION['compares'][$key]);
				        
				    }

					
				}

			
				

			// 	echo '<pre>';
			// 	print_r($_SESSION);
			// 	echo '</pre>';
				//print_r($_REQUEST);
				//global $woocommerce;
				//echo  $_REQUEST['products'];
				//WC_AJAX::init();
				//////////////////////////////$post_id = isset($_REQUEST['products'])?$_REQUEST['products']:0;
				//$_POST['quantity'] = 1;
				// echo $_POST['product_id'] ;
				//global $woocommerce;
				//print_r($woocommerce->cart);
				//WC_AJAX::add_to_cart($_REQUEST['products']) ;
				//echo $_POST['product_id'];
				//WC()->cart->add_to_cart( $_POST['product_id'], 1 );
				//echo WC()->cart->get_cart_contents_count(); in ra số sản phẩm trong giỏ

				break;

			case 'deleteall':
				
				unset($_SESSION['compares']);

			

				break;
			
			
		}
		if($action){
			die();
		}
		return true;
	}
}
add_action('wp_loaded','fgc_woocommercer_add_hook_compare_product');


