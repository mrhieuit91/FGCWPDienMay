<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version' => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce = require 'inc/woocommerce/class-storefront-woocommerce.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';

	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
		require 'inc/nux/class-storefront-nux-starter-content.php';
	}
}

function custom_style (){
    wp_enqueue_style('fgc_customs_style',get_template_directory_uri() . '/fgc-customs/fgc-style.css', array(), null);
}
add_action('wp_enqueue_scripts', 'custom_style');


function elevatezoom_master_scripts() {
	//wp_enqueue_script('jquery'); /* không cần thiết vì bên dưới file ntuts.js đã phụ thuộc vào jquery */
	wp_enqueue_script('elevatezoom_master', get_template_directory_uri() .'/assets/js/elevatezoom-master/jquery.elevateZoom-3.0.8.min.js', array('jquery'),'v1.38',true );
}   
add_action('init', 'elevatezoom_master_scripts');


/**

 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */

// remove default sorting dropdown in StoreFront Theme
 
add_action('init','delay_remove');
 
function delay_remove() {
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
}


// add_filter('add_to_cart_redirect', 'custom_add_to_cart_redirect');
  
// function custom_add_to_cart_redirect() {
//      return wc_get_page_permalink( 'cart' ); // Replace with the url of your choosing
// }
// apply_filters( 'woocommerce_add_to_cart_redirect', wc_get_cart_url() );
// // add_filter('add_to_cart_redirect', 'custom_add_to_cart_redirect');
  
// // function custom_add_to_cart_redirect() {
// //     global $woocommerce;
// //     $count=WC()->cart->cart_contents_count;
// //     $amount = floatval( preg_replace( '#[^\d.]#', '', $woocommerce->cart->get_cart_total() ) );
     
// //     if($count>=5 && $amount>=100)
// //      return get_permalink(get_option('woocommerce_catalog_ordering')); // Replace with the url of your choosing
// // }

add_filter( 'add_to_cart_text', 'woo_custom_cart_button_text' );                                // < 2.1
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +
add_filter( 'add_to_cart_text', 'woo_custom_cart_button_text' );                        // < 2.1
add_filter( 'woocommerce_product_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +
function woo_custom_cart_button_text() {
  
        return __( 'Mua Ngay', 'woocommerce' );
  
}

add_filter('add_to_cart_redirect', 'custom_add_to_cart_redirect');
function custom_add_to_cart_redirect() {
	     /**
	      * Replace with the url of your choosing
	      */
	     return wc_get_page_permalink( 'cart' );
}

// function add_woocommerce_loop_add_to_cart_link($value,$product){

// 	return "ADD to cart new". $value;
// }

// add_filter( 'woocommerce_loop_add_to_cart_link', 'add_woocommerce_loop_add_to_cart_link',2,2); 