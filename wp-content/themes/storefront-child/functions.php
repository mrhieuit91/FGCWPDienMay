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
                    <span class="number"><?php echo sprintf('%d', WC()->cart->cart_contents_count); ?> </span>
                    <span>Sản phẩm</span>
                    <input type="button" value="Thanh toán" name="thanhtoan" style="padding: 0; margin: 0 ;width: 110px; height: 22px; line-height: 20px; background-color: #ff7c00; border: solid 1px orangered;  border-radius: 5px"/>
                </a>
            </div>
            <?php
            ?></div><?php
    }

}
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
// ko chạy àh ò nó không tự thêm vào sau luôn anh thử mà xem,
// trang chủ mô? code layout?


//******************************************************************************

add_filter('woocommerce_breadcrumb_defaults', 'fgc_change_breadcrumb_home_text');

function fgc_change_breadcrumb_home_text($defaults) {
    // Change the breadcrumb home text from 'Home' to 'Trang Chủ'
    $defaults['home'] = 'Trang Chủ';
    return $defaults;
}

show_admin_bar(false);
