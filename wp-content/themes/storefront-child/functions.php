<?php

/**
 * Xóa đi các thành phần không sử dụng trong homepage
 * @hook after_setup_theme
 * 
 * template-homepage.php
 * @hook homepage
 * @hooked storefront_homepage_content - 10
 * @hooked storefront_product_categories - 20
 * @hooked storefront_recent_products - 30
 * @hooked storefront_featured_products - 60
 * @hooked storefront_popular_products - 50
 * @hooked storefront_on_sale_products - 70
 * @hooked storefront_best_selling_products - 40
 */
function tp_homepage_blocks() {
 /*
 * Sử dụng: remove_action( 'homepage', 'tên_hàm_cần_xóa', số thứ tự mặc định );
 */
 //remove_action( 'homepage', 'storefront_featured_products', 70 );
 //remove_action( 'homepage', 'storefront_homepage_content', 10 );
 remove_action( 'homepage', 'storefront_product_categories', 20 );
 //remove_action( 'homepage', 'storefront_recent_products', 30 );
 //remove_action( 'homepage', 'storefront_popular_products', 50 );
 //remove_action( 'homepage', 'storefront_on_sale_products', 60 );
 //remove_action( 'homepage', 'storefront_best_selling_products', 40 );
}
add_action( 'after_setup_theme', 'tp_homepage_blocks', 10 );

/**
 * Tùy biến Product by Category
 * @hook storefront_product_categories_args
 * 
 */
function tp_homepage_blocks_custom() {
 
 
 // /* Shop by Category */
 // add_filter( 'storefront_product_categories_args', function($args) {
 // $args = array(
 // 'limit' => 6,
 // 'title' => __( 'Danh mục sản phẩm', 'thachpham' )
 // );
 
 // return $args; 
 // } );
 
 /* New In */
 add_filter( 'storefront_recent_products_args', function($args) {
 $args = array(
 'limit' => 6,
 'title' => __( 'Sản phẩm mới', 'thachpham' )
 );
 return $args;
 } );
  
 /* Nhiều người yêu thích */
 add_filter( 'storefront_popular_products_args', function($args) {
 $args = array(
 'limit' => 6,
 'title' => __( 'Nhiều người yêu thích', 'thachpham' )
 );
 return $args;
 } );
 
 /* Nhiều người yêu thích */
 add_filter( 'storefront_best_selling_products_args', function($args) {
 $args = array(
 'limit' => 6,
 'title' => __( 'Sản phẩm bán chạy nhất', 'thachpham' )
 );
 return $args;
 } );


 
}
add_action( 'after_setup_theme', 'tp_homepage_blocks_custom' );