<?php
/**
 * Các đoạn code cần tùy biến của bạn vào bên dưới
 */
/*
 * Tạo shortcode hiển thị list tin tức
 */
/* * ***********************************HÀM LOAD TIN TỨC KHÔNG CÓ AJAX****************** */
if (!function_exists('load_all_news')) {

    function load_all_news() {
        global $post;
        $args = array('posts_per_page' => 5, 'offset' => 1, 'category' => 'tin-tuc');
        $myposts = get_posts($args);
        ?>

        <div class="col-xs-9">
            <div id="main_center" class="news-content">
                <ul style="list-style-type: none">
                    <?php foreach ($myposts as $post) : setup_postdata($post); ?>
                        <li>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php the_excerpt(); ?></p>
                            <a href="<?php the_permalink(); ?>">Read more..</a>
                            <hr>
                        </li>
                        <?php
                    endforeach;
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>
        </div>
        <?php
    }

}
add_shortcode('load_list_news', 'load_all_news');

/*
 * Kết thúc các hàm tạo shortcode hiển thị list tin tức
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
        ?><div class="header-right-box"><span class="fa fa-user"></span><?php
        if (!is_user_logged_in()) {
            ?> <a href="<?php echo wp_login_url(); ?>">Đăng nhập</a> / <a href="<?php echo wp_registration_url(); ?>">Đăng ký</a><?php
            } else {
                ?><span> Xin chào :</span> <span style="color: red"><?php echo $current_user->user_login ?> </span> / <a href="<?php echo wp_logout_url(get_permalink()); ?>">Đăng xuất</a><?php
            }
            ?>
            <div style="margin-top: 10px">
                <a id="minicart" href="<?php echo WC()->cart->get_cart_url(); ?>" class="cart icon red relative">

                    <span class="fa fa-cart-plus"></span> <?php echo sprintf('%d', WC()->cart->cart_contents_count); ?> <span>Sản phẩm</span>
                    <input type="button" value="Thanh toán" name="thanhtoan" style="padding: 0; margin: 0 ;width: 110px; height: 22px; line-height: 20px; background-color: #ff7c00; border: solid 1px orangered;  border-radius: 5px"/>
                </a>
            </div>
            <?php ?></div><?php
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

//        remove_filter( 'woocommerce_sale_flash', 'filter_woocommerce_sale_flash', 10, 3 );
//        add_action('storefront_header', 'add_search_form', 50);

        /**
         * Functions hooked into storefront_single_post add_action
         *
         * @hooked storefront_post_header          - 10
         * @hooked storefront_post_meta            - 20
         * @hooked storefront_post_content         - 30
         */
//        remove_action('storefront_single_post', 'storefront_post_header',10);
        remove_action('storefront_single_post', 'storefront_post_meta', 20);
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
        remove_action('woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10);
    }

    add_action('init', 'fgc_storefront_header_customizes');
}
remove_filter('the_content', 'wpautop');



//Customize Main Content
if (!function_exists('fgc_storefont_homepage_custom')) {

    function fgc_storefont_homepage_custom() {
        /**
         * Functions hooked in to storefront_page add_action
         *
         * @hooked storefront_homepage_header      - 10
         * @hooked storefront_page_content         - 20
         */
        //remove_action('storefront_page', 'storefront_page_content', 20);
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

add_theme_support('menus');
register_nav_menus(
        array(
            'categories-nav' => 'Categories Menu',
//            'footer-nav' => 'Footer menu'
        )
);
//********************************CREATE WIDGETS**********************************************
//CATEGORIES WIDGET

/*
 * Đăng ký widget mới
 */
add_action('widgets_init', 'fgc_create_categories_widget');

function fgc_create_categories_widget() {
    register_widget('FGC_Categories_Widget');
}

class FGC_Categories_Widget extends WP_Widget {
    /*
     * Thiết lập cơ bản
     */

    public function __construct() {
        parent::__construct(
                'fgc_create_categories_widget', 'Danh Mục Sản Phẩm', array(
            'description' => 'Danh mục sản phẩm' // mô tả
                )
        );
    }

    /*
     * Tạo form option cho widget
     */

    function form($instance) {
        parent::form($instance);

        //Biến tạo các giá trị mặc định trong form
        $default = array(
            'title' => 'Tiêu đề widget'
        );

        //Gộp các giá trị trong mảng $default vào biến $instance để nó trở thành các giá trị mặc định
        $instance = wp_parse_args((array) $instance, $default);

        //Tạo biến riêng cho giá trị mặc định trong mảng $default
        $title = esc_attr($instance['title']);

        //Hiển thị form trong option của widget       
        echo 'Nhập tiêu đề <input class="widefat" type="text" name="' . $this->get_field_name('title') . '"value="' . $title . '"/>';
    }

    /*
     * Lưu widget form
     */

    function update($new_instance, $old_instance) {
        parent::update($new_instance, $old_instance);

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /*
     * Hiển thị widget
     */

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        echo $before_widget;

        //In tiêu đề widget
        echo $before_title . $title . $after_title;

        // Nội dung trong widget
//        global $wpdb;
//        $fgc_table = $wpdb->predix . '';
        ?>
        <style>
            .contact-boder-menu{font-weight: bold;}
            .contact-boder-menu .product-catogory-widget ul {
                margin-left: 15px;
                margin-right: 10px;
                color: #000;
            }
            .contact-boder-menu>.product-catogory-widget>.product-categories>.cat-parent a{
                height: 30px;
                color: #000 !important;
                font-weight: bold !important;
            }
            .contact-boder-menu ul li a{
                text-decoration: none;
            }
            .contact-boder-menu ul li a :hover{
                text-decoration: underline;        
            }
            .contact-boder-menu ul {
                margin-left: 0px;
            }
            .menu-item ul {
                /*display: none;*/
            }
            .product-categories-hidden {
                display: none;
            }
            .parent-product-categories {
                border-bottom: #2E4453 dashed 1px;
            }
            .parent-product-categories:last-child {
                border-bottom: none;
            }
            .parent-product-categories .product-categories-name {
                display: block;
                margin-top: 2em;
                transform: translateY(-50%);
            }
            .parent-product-categories:hover {
                cursor: pointer;
            }
            .parent-product-categories:hover .product-categories-hidden{
                display: block;
            }
        </style>
        <div class="contact-boder-menu" style="border: dashed 1px">          

            <?php
            echo '<nav class="product-catogory-widget col-2" aria-label="' . esc_html__('Product Categories', 'storefront') . '">';
            the_widget('WC_Widget_Product_Categories', array(
                'count' => 1,
            ));

            echo '</nav>';
            ?>

                <!--            <script type="text/javascript">
                                
                                jQuery(".cat-parent").hover(function () {
                                    jQuery("li.cat-parent").show("2000", function () {
                                        jQuery(".children").css({"display": "block"});
                                    });
                                });
                                
                                jQuery(".cat-parent").mouseleave(function () {
                                    jQuery(".children").hide();
                                    
                                });
                            </script>-->


        </div>
        <!--        <script type="text/javascript">
            $('.menu-item').hover(function () {
                $('.sub-menu').css("display", "block");
                $(this).children('.sub-menu').stop().slideToggle(400);
            });
        </script>-->
        <?php
        // Kết thúc nội dung trong widget

        echo $after_widget;
    }

}

/* ----------------------------------------------------------------------------- */
//CONTACT WIDGET

/*
 * Đăng ký widget mới
 */
add_action('widgets_init', 'fgc_create_contact_widget');

function fgc_create_contact_widget() {
    register_widget('Fgc_Contact_Widget');
}

class FGC_Contact_Widget extends WP_Widget {
    /*
     * Thiết lập cơ bản
     */

    public function __construct() {
        parent::__construct(
                'fgc_contact_widget', 'Hỗ Trợ Trực Tuyến', array(
            'description' => 'Widget chứa thông tin liên hệ của công ty !' // mô tả
                )
        );
    }

    /*
     * Tạo form option cho widget
     */

    function form($instance) {
        parent::form($instance);

        //Biến tạo các giá trị mặc định trong form
        $default = array(
            'title' => 'Tiêu đề widget'
        );

        //Gộp các giá trị trong mảng $default vào biến $instance để nó trở thành các giá trị mặc định
        $instance = wp_parse_args((array) $instance, $default);

        //Tạo biến riêng cho giá trị mặc định trong mảng $default
        $title = esc_attr($instance['title']);

        //Hiển thị form trong option của widget       
        echo 'Nhập tiêu đề <input class="widefat" type="text" name="' . $this->get_field_name('title') . '"value="' . $title . '"/>';
    }

    /*
     * Lưu widget form
     */

    function update($new_instance, $old_instance) {
        parent::update($new_instance, $old_instance);

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /*
     * Hiển thị widget
     */

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        echo $before_widget;

        //In tiêu đề widget
        echo $before_title . $title . $after_title;

        // Nội dung trong widget
        ?>
        <style>
            .contact-boder-menu{font-weight: bold;}
            .contact-boder-menu ul {
                margin-left: 15px;        
            }
            .contact-boder-menu ul li a{
                text-decoration: none;        
            }
            .contact-boder-menu ul li a :hover{
                text-decoration: underline;        
            }
        </style>
        <div class="contact-boder-menu" style="border: dashed 1px">
            <h4 style="color: red; padding-left: 10px; ">FGC TECHLUTION</h4>
            <ul>
                <li><span class="fa fa-phone"></span> SĐT: 0989.675.411</li>
                <li><span class="fa fa-envelope"></span> Email:<a href="#">support@fgc.net</a></li>
                <li><span class="fa fa-skype"></span> Skype:<a title="Mở skype để liên hệ bây giờ" href="skype:khanhhuyna?chat" style="color: orangered"> Click để liên hệ</a>      </li>
            </ul>
        </div>
        <?php
        // Kết thúc nội dung trong widget

        echo $after_widget;
    }

}

//COMMENT WIDGET

/*
 * Đăng ký widget mới
 */
add_action('widgets_init', 'fgc_create_comment_widget');

function fgc_create_comment_widget() {
    register_widget('Fgc_Comment_Widget');
}

class FGC_Comment_Widget extends WP_Widget {
    /*
     * Thiết lập cơ bản
     */

    public function __construct() {
        parent::__construct(
                'fgc_comment_widget', 'Các đánh giá mới nhất', array(
            'description' => 'Widget chứa các comments mới nhất !' // mô tả
                )
        );
    }

    /*
     * Tạo form option cho widget
     */

    function form($instance) {
        parent::form($instance);

        //Biến tạo các giá trị mặc định trong form
        $default = array(
            'title' => 'Tiêu đề widget'
        );

        //Gộp các giá trị trong mảng $default vào biến $instance để nó trở thành các giá trị mặc định
        $instance = wp_parse_args((array) $instance, $default);

        //Tạo biến riêng cho giá trị mặc định trong mảng $default
        $title = esc_attr($instance['title']);

        //Hiển thị form trong option của widget       
        echo 'Nhập tiêu đề <input class="widefat" type="text" name="' . $this->get_field_name('title') . '"value="' . $title . '"/>';
    }

    /*
     * Lưu widget form
     */

    function update($new_instance, $old_instance) {
        parent::update($new_instance, $old_instance);

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /*
     * Hiển thị widget
     */

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        echo $before_widget;

        //In tiêu đề widget
        echo $before_title . $title . $after_title;

        // Nội dung trong widget
        ?>
        <style>
            .contact-boder-menu{font-weight: bold;}
            .contact-boder-menu ul {
                margin-left: 15px;        
            }
            .contact-boder-menu ul li a{
                text-decoration: none;        
            }
            .contact-boder-menu ul li a :hover{
                text-decoration: underline;        
            }
        </style>
        <div class="contact-boder-menu" style="border: dashed 1px">

            <marquee align="center" direction="up" height="422" scrollamount="4" width="100%" onmouseover="this.stop()" onmouseout="this.start()" >
                <?php
                $comments = get_comments();
                foreach ($comments as $comment) {
                    echo '<div class="user-com"><a href="index.php/sanpham/">
                    <img src="" alt="" width="100%"/>
                    <div class="by-user"><span><b>Khách hàng:</b></span>' . $comment->comment_author . '</div>
                    <p>' . $comment->comment_content . '</p>
                  </a></div>';
                }
                ?> 
            </marquee>

        </div>
        <?php
        // Kết thúc nội dung trong widget

        echo $after_widget;
    }

}

/* ------------------------------------------------------------------------------------------------------- */

/**
 *  RECENT POST WIDGET
 */
add_action('widgets_init', 'fgc_create_recent_news_widget');

function fgc_create_recent_news_widget() {
    register_widget('FGC_Recent_News_Posts');
}

class FGC_Recent_News_Posts extends WP_Widget {

    /**
     * Sets up a new Recent Posts widget instance.
     *
     * @since 2.8.0
     * @access public
     */
    public function __construct() {
        $widget_ops = array(
            'fgc_recent_news_post', 'Các đánh giá mới nhất',
            'classname' => 'widget_recent_news_entries',
            'description' => __('Các tin tức mới '),
            'customize_selective_refresh' => true,
        );
        parent::__construct('recent-news_posts', __('Tin Tức mới'), $widget_ops);
        $this->alt_option_name = 'widget_recent_news_entries';
    }

    public function widget($args, $instance) {
        if (!isset($args['widget_id'])) {
            $args['widget_id'] = $this->id;
        }

        $title = (!empty($instance['title']) ) ? $instance['title'] : __('Tin Tức mới');

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);

        $number = (!empty($instance['number']) ) ? absint($instance['number']) : 5;
        if (!$number)
            $number = 5;
        $show_date = isset($instance['show_date']) ? $instance['show_date'] : false;


        $r = new WP_Query(apply_filters('widget_posts_args', array(
                    'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true
        )));

        if ($r->have_posts()) :
            ?>
            <?php echo $args['before_widget']; ?>
            <?php
            if ($title) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
            ?>
            <style>
                .contact-boder-menu{font-weight: bold;}
                .contact-boder-menu ul {
                    margin-left: 15px;

                }
                .contact-boder-menu ul li a{
                    text-decoration: none !important; 
                }
                .contact-boder-menu ul li a:hover {
                    text-decoration: underline !important;        
                }
            </style>
            <div class="contact-boder-menu" style="border: dashed 1px">
                <ul style="list-style-type: circle; color: #000 !important;">
                    <?php while ($r->have_posts()) : $r->the_post(); ?>
                        <li>
                            <a href="<?php the_permalink(); ?>" style="color: #000 !important"><?php get_the_title() ? the_title() : the_ID(); ?></a>
                            <?php if ($show_date) : ?>
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <?php echo $args['after_widget']; ?>
            <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

        endif;
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = isset($new_instance['show_date']) ? (bool) $new_instance['show_date'] : false;
        return $instance;
    }

    public function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $show_date = isset($instance['show_date']) ? (bool) $instance['show_date'] : false;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox"<?php checked($show_date); ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" />
            <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Display post date?'); ?></label></p>
        <?php
    }

}

/*
 * Đổi text cho button thêm vào giỏ hàng
 */
add_filter('woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text');    // 2.1 +

function woo_custom_cart_button_text() {

    return __('Thêm vào giỏ hàng', 'woocommerce');
}

add_filter('add_to_cart_text', 'woo_custom_cart_button_text');    // &amp;lt; 2.1
add_filter('woocommerce_product_add_to_cart_text', 'woo_custom_cart_button_text');


//remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);


/*
 * COMPARE PRODUCTS MODULE
 */
