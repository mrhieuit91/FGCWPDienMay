<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package storefront
 */
get_header();
?><h1>So sánh sản phẩm</h1><?php
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
echo do_shortcode('[yith_woocompare_table]');

get_footer();
