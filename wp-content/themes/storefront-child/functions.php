<?php
/**
 * Đặt các đoạn code cần tùy biến của bạn vào bên dưới
 */
if (!function_exists('fgc_custom_style')) {

    function fgc_custom_style() {
        wp_register_style('main-style', get_template_directory_uri() . '/style.css', 'all');
        wp_enqueue_style('main-style');
    }

    add_action('wp_enqueue_scripts', 'fgc_custom_style');
}

add_theme_support('menus');
register_nav_menus(
        array(
            'main-nav' => 'Menu chính',
            'footer-nav' => 'Footer menu'
        )
);

//Customize menu
if (!function_exists('show_custom_menu')) {

    function show_custom_menu() {

        wp_nav_menu(array(
            'theme_location' => 'main-nav', // tên location cần hiển thị
            'container' => 'nav', // thẻ container của menu
            'container_class' => 'main-nav', //class của container
            'menu_class' => 'menu clearfix' // class của menu bên trong
        ));
        echo '<div class="fgc-search-form"> ';
        echo get_search_form();
        echo '</div>';
    }

}
//Customize Search box

if (!function_exists('fgc_custom_search_box')) {

    function fgc_custom_search_box() {
        get_search_form();
    }

}
if (!function_exists('fgc_custom_header_right_box')) {

    function fgc_custom_header_right_box() {
        $current_user = wp_get_current_user();
        ?><div class="header-right-box"><span class="glyphicon glyphicon-user"></span><?php
        if (!is_user_logged_in()) {
            ?> <a href="<?php echo wp_login_url(); ?>">Đăng nhập</a> / <a href="<?php echo wp_registration_url(); ?>">Đăng ký</a><?php
            } else {
                ?><span>Xin chào :</span> <span style="color: red"><?php echo $current_user->user_login ?> </span> / <a href="<?php echo wp_logout_url(get_permalink()); ?>">Đăng xuất</a><?php
            }
            ?>
            <div style="margin-top: 10px">
                <a id="minicart" href="<?php echo WC()->cart->get_cart_url(); ?>" class="cart icon red relative">

                    <?php echo sprintf('%d', WC()->cart->cart_contents_count); ?> <span>Sản phẩm</span>
                    <input type="button" value="Thanh toán" name="thanhtoan" style="padding: 0; margin: 0 ;width: 110px; height: 22px; line-height: 20px; background-color: #ff7c00; border: solid 1px orangered;  border-radius: 5px"/>
                </a>
            </div>
            <?php
            ?></div><?php
    }

}

// Function customizes Page Header
if (!function_exists('fgc_storefront_header_customizes')) {

    function fgc_storefront_header_customizes() {
        /**
         * Functions hooked into storefront_header action
         *
         * @hooked storefront_skip_links                       - 0
         * @hooked storefront_social_icons                     - 10
         * @hooked storefront_site_branding                    - 20
         * @hooked storefront_secondary_navigation             - 30
         * @hooked storefront_product_search                   - 40
         * @hooked storefront_primary_navigation_wrapper       - 42
         * @hooked storefront_primary_navigation               - 50
         * @hooked storefront_header_cart                      - 60
         * @hooked storefront_primary_navigation_wrapper_close - 68
         */
        
        remove_action('storefront_header', 'storefront_product_search', 40);
        remove_action('storefront_header', 'storefront_header_cart', 60);
//        remove_action('storefront_header', 'storefront_primary_navigation_wrapper', 42);
        remove_action('storefront_header', 'storefront_primary_navigation', 50);

//        add_action('storefront_header', 'storefront_header_cart', 40);
        add_action('storefront_header', 'fgc_custom_header_right_box', 40);
        add_action('storefront_header', 'show_custom_menu', 42);
//        add_action('storefront_header', 'add_search_form', 50);
    }

    add_action('init', 'fgc_storefront_header_customizes');
}
//Customize Main Content
if (!function_exists('fgc_storefont_homepage_custom')) {

    function fgc_storefont_homepage_custom() {
        /**
         * Functions hooked in to storefront_page add_action
         *
         * @hooked storefront_homepage_header      - 10
         * @hooked storefront_page_content         - 20
         */
        remove_action('storefront_page', 'storefront_page_content', 20);
    }

    add_action('init', 'fgc_storefont_homepage_custom');
}

function add_search_form($items, $args) {
    if ($args->theme_location == 'main-nav') {
        $items .= '<li class="menu-item">'
                . '<form role="search" method="get" class="search-form" action="' . home_url('/') . '">'
                . '<label>'
                . '<span class="screen-reader-text">' . _x('Search for:', 'label') . '</span>'
                . '<input type="search" class="search-field" placeholder="' . esc_attr_x('Tìm kiếm …', 'placeholder') . '" value="' . get_search_query() . '" name="s" title="' . esc_attr_x('Tìm kiếm:', 'label') . '" />'
                . '</label>'
                . '<input type="submit" class="search-submit" value="' . esc_attr_x('Tìm kiếm', 'submit button') . '" />'
                . '</form>'
                . '</li>';
    }
    return $items;
}

//add_filter('wp_nav_menu_items', 'add_search_form', 10, 2);
//******************************************************************************

add_filter('woocommerce_breadcrumb_defaults', 'fgc_change_breadcrumb_home_text');

function fgc_change_breadcrumb_home_text($defaults) {
    // Change the breadcrumb home text from 'Home' to 'Trang Chủ'
    $defaults['home'] = 'Trang Chủ';
    return $defaults;
}

show_admin_bar(false);

//CUSTOM SINGLE PRODUCT PAGE
function fgc_single_product() {
    ?>
    <div class="col-xs-9">
        <div id="main-center">
            <div class="row">
                <div class="col-xs-12">
                    <div class="title-box">
                        <img src="">
                        <h3><a href="#"><?php add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title'); ?></a></h3>
                    </div> <!-- End title -->

                    <div class="conten_product col-xs-12" style="width:500px;float:left;">
                        <div id="gallery_01" class="col-xs-2">
                            <div class="list_img_products">
                                <?php
                                foreach ($product->image as $image) {
                                    echo '<a class="elevatezoom-gallery active " href="#" data-update="" data-image="' . $image["url"] . '" data-zoom-image="' . $image["url"] . '">
                            <img src="' . $image['url'] . '" width="80%">
                        </a>';
                                }
                                ?>

                            </div>
                        </div>
                        <div class="col-xs-10 col-xs-push-1 smallimage">
                            <img id="zoom_03f"  width="100%" style="text-align: center; border:1px solid #e8e8e6;" src="<?php echo @$product->image[0]['url'] ?>" data-zoom-image="<?php echo @$product->image[0]['url'] ?>" >
                        </div>
                        <script type="text/javascript">
                            jQuery(document).ready(function ($) {
                                $("#zoom_03f").elevateZoom({
                                    gallery: 'gallery_01',
                                    cursor: 'zoom-in',
                                    easing: true,
                                    galleryActiveClass: "active"
                                });
                            });
                        </script>

                        <div class="col-xs-12 ">                                        
                            <p style="text-align: center; font-weight: bold; font-size: 24px;padding-top: 11px;
                               margin-bottom: -3px; color: #ea28ff;"><?php echo $title; ?></p>
                            <div class="product-price col-xs-4 col-xs-push-4" style = "height: auto;padding: 2px;margin: 2px; text-align: center; font-weight: bold; font-size: 29px; color: red; ">
                                <?php
                                echo($product->price);
                                ?>
                            </div>
                            <div class="clearfix"></div>
                            <div style="text-align: center;">
                                <button type="button" class="btn btn-primary btn-buy" data-product-id="<?= $product->id ?>">Mua ngay</button> 
                                <?php
                                //var_dump($this->session->userdata("cart"));exit;
                                //var_dump($this->session->userdata("compare"));exit;
                                if (is_array($this->session->userdata("cart")) && array_key_exists($product->id, $this->session->userdata("cart")))
                                    echo '<button type="button" class="btn btn-success disable" data-product-id="' . $product->id . '" onclick="window.location=\'cart\'">Đã có trong giỏ hàng</button> ';
                                else
                                    echo '<button type="button" class="btn btn-success btn-addtocart" data-product-id="' . $product->id . '">Thêm vào giỏ hàng</button> ';

                                if (is_array($this->session->userdata("compare")) && in_array($product->id, $this->session->userdata("compare")))
                                    echo '<button type="button" class="btn btn-info btn-compare" data-product-id="' . $product->id . '" onclick="window.location=\'compare\'">Đã có trong danh sách so sánh</button> ';
                                else
                                    echo '<button type="button" class="btn btn-info btn-compare" data-product-id="' . $product->id . '">Thêm vào danh sách so sánh</button> ';
                                ?>

                            </div>
                            <br /><br />
                            <div class="col-xs-12 ">
                                <span>
                                    <?= nl2br($product->description) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

if (!function_exists('fgc_customize_single_product_page')) {

    function fgc_customize_single_product_page() {
        /**
         * woocommerce_single_product_summary hook.
         *
         * @hooked woocommerce_template_single_title - 5
         * @hooked woocommerce_template_single_rating - 10
         * @hooked woocommerce_template_single_price - 10
         * @hooked woocommerce_template_single_excerpt - 20
         * @hooked woocommerce_template_single_add_to_cart - 30
         * @hooked woocommerce_template_single_meta - 40
         * @hooked woocommerce_template_single_sharing - 50
         * @hooked WC_Structured_Data::generate_product_data() - 60
         */
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    }

}