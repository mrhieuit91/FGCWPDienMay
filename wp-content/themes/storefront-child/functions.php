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
<!--                    <script type="text/javascript">
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
 * CUSTOMIZE LOGIN PAGE
 */

function registration_form($username, $password, $email, $website, $first_name, $last_name, $nickname, $bio) {

    echo '
    <div class="register-form-container">
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
            <div>
                <label for="username">Tên Đăng Nhập <strong>*</strong></label>
                <input type="text" name="username" value="' . ( isset($_POST['username']) ? $username : null ) . '">
            </div>

            <div>
                <label for="password">Mật Khẩu <strong>*</strong></label>
                <input type="password" name="password" value="' . ( isset($_POST['password']) ? $password : null ) . '">
            </div>

            <div>
                <label for="email">Email <strong>*</strong></label>
                <input type="text" name="email" value="' . ( isset($_POST['email']) ? $email : null ) . '">
            </div>

            <div>
                <label for="website">Website</label>
                <input type="text" name="website" value="' . ( isset($_POST['website']) ? $website : null ) . '">
            </div>

            <div>
                <label for="firstname">Họ</label>
                <input type="text" name="fname" value="' . ( isset($_POST['fname']) ? $first_name : null ) . '">
            </div>

            <div>
                <label for="website">Tên</label>
                <input type="text" name="lname" value="' . ( isset($_POST['lname']) ? $last_name : null ) . '">
            </div>

            <div>
                <label for="nickname">Tên hiển thị</label>
                <input type="text" name="nickname" value="' . ( isset($_POST['nickname']) ? $nickname : null ) . '">
            </div>

            <div>
                <label for="bio">Đôi chút về bản thân</label>
                <textarea name="bio">' . ( isset($_POST['bio']) ? $bio : null ) . '</textarea>
            </div>
            <div id="reg-last-items">
                <input type="reset" name="reset" value="Nhập Lại"/>
                <input type="submit" name="submit" value="Đăng Ký"/>
            </div>
            
        </form>
    </div>
    ';
    ?>

    <!-- Mixins-->
    <!-- Pen Title-->
    <div class="pen-title">
        <h1>Hãy đăng nhập hoặc đăng ký</h1><span>Hoặc <i class='fa fa-code'></i><a href='#'>Quay lại trang chủ</a></span>
    </div>
    <div class="rerun"><a href="home">Quay lại</a></div>
    <div class="container">
        <div class="card"></div>
        <div class="card">
            <h1 class="title">Đăng nhập</h1>
            <?php
            if (isset($error))
                echo '<div class="alert alert-danger" role="alert">
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              <span class="sr-only">Error:</span>
              ' . $error . '
            </div>';
            elseif (isset($message))
                echo '<div class="alert alert-info" role="alert">
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              ' . $message . '
            </div>';
            if (isset($redirect))
                echo '<script>setTimeout(function(){window.location.replace("' . $redirect . '");}, 2000);</script>';
            ?>
            <form method="post" action="user/login" name="login">
                <input type="hidden" name="dologin" value="true"/>
                <div class="input-container">
                    <input name="email" type="text" id="email"/>
                    <label for="email">Email đăng nhập</label>
                    <div class="error" id="email_error"><?php echo form_error('email') ?></div>

                    <div class="bar"></div>
                </div>
                <div class="input-container">
                    <input name="password" type="password" id="password" />
                    <label for="password">Mật khẩu</label>
                    <div class="error" id="password_error"><?php echo form_error('password') ?></div>
                    <div class="bar"></div>
                </div>
                <div class="button-container">
                    <button name="login" type="submit"><span>Đăng nhập</span></button>
                </div>
                <div class="footer"><a href="login/facebook">Facebook</a> | <a href="login/google">Google</a> | <a href="user/forgot">Quên mật khẩu?</a></div>
            </form>
        </div>
        <div class="card alt">
            <div class="toggle"><a href=""></a></div>
            <h1 class="title">Đăng ký
                <div class="close"></div>
            </h1>
            <form method="post" action="<?php $_SERVER['REQUEST_URI']; ?>" name="register">
                <div class="input-container">
                    <input name="remail" type="text" id="email"/>
                    <label for="email">Email</label>
                    <div class="r_error"><?php echo form_error('remail'); ?></div>
                    <div class="bar"></div>
                </div>
                <div class="input-container">
                    <input name="rname" type="text" id="name"/>
                    <label for="name">Họ và tên</label>
                    <div class="r_error"><?php echo form_error('rname'); ?></div>
                    <div class="bar"></div>
                </div>
                <div class="input-container">
                    <input name="rpass" type="password" id="password"/>
                    <label for="password">Mật khẩu</label>
                    <div class="r_error"><?php echo form_error('rpass'); ?></div>
                    <div class="bar"></div>
                </div>
                <div class="input-container">
                    <input name="rrepass" type="password" id="re_password"/>
                    <label for="re_password">Nhập lại mật khẩu</label>
                    <div class="r_error"><?php echo form_error('rrepass'); ?></div>
                    <div class="bar"></div>
                </div>
                <div class="button-container">
                    <button><span>Đăng ký</span></button>
                </div>
            </form>
        </div>
    </div>
    <!-- Portfolio--><a id="portfolio" href="#" onclick="goBack()" title="View my portfolio!"><i class="fa fa-link"></i></a>
    <!-- CodePen--><a id="codepen" href="#" onclick="goBack()" title="Follow me!"><i class="fa fa-codepen"></i></a>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <script src='public/themes/js/jquery-1.7.2.min.js'></script>
    <script src="public/admin/js/index.js"></script>

    <?php
}

function registration_validation($username, $password, $email, $website, $first_name, $last_name, $nickname, $bio) {
    global $reg_errors;
    $reg_errors = new WP_Error;

    // Kiểm tra các trường bắt buộc có dữ liệu Username, Password và Email
    if (empty($username) || empty($password) || empty($email)) {
        $reg_errors->add('field', 'Không được bỏ trống các trường Username, Password và Email');
    }
    // Yêu cầu số ký tự để đăng ký Username phải nhiều hơn 4 ký tự
    if (4 > strlen($username)) {
        $reg_errors->add('username_length', 'Username quá ngắn. Tên đăng nhập phải có ít nhất 4 ks tự');
    }
    // Kiểm tra xem Username đã tồn tại hay chưa
    if (username_exists($username)) {
        $reg_errors->add('user_name', 'Xin lỗi! Username này đã tồn tại!');
    }
    // Sử dụng hàm validate_username trong WordPress để đảm bảo rằng username là hợp lệ.
    if (!validate_username($username)) {
        $reg_errors->add('username_invalid', 'Xin lỗi! Username bạn nhập không hợp lệ');
    }
    // Yêu cầu số ký tự của Password phải  nhiều hơn 5 ký tự
    if (5 > strlen($password)) {
        $reg_errors->add('password', 'Độ dài của mật khẩu phải nhiều hơn 5 ký tự');
    }
    // Kiểm tra tính hợp lệ của email
    if (!is_email($email)) {
        $reg_errors->add('email_invalid', 'Email của bạn không hợp lệ');
    }
    // Kiểm tra xem email đã được đăng ký hay chưa
    if (email_exists($email)) {
        $reg_errors->add('email', 'Email đã được đăng ký bởi người dùng khác');
    }
    //Nếu trường website đã được điền, kiểm tra xem nó có hợp lệ hay không
    if (!empty($website)) {
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $reg_errors->add('website', 'Website không hợp lệ');
        }
    }
    // lặp qua các lỗi trong đối tượng WP_Error và hiển thị từng lỗi.
    if (is_wp_error($reg_errors)) {

        foreach ($reg_errors->get_error_messages() as $error) {

            echo '<div class="reg-errors">';
            echo '<strong style="color: red !important; font-weight: bold !important;">OOP..!</strong>:';
            echo '<span style="color: red !important;">' . $error . '</span> <br/>';
            echo '</div>';
        }
    }
}

// Hàm để xử lý đăng ký người dùng
function complete_registration() {
    global $reg_errors, $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
    if (1 > count($reg_errors->get_error_messages())) {
        $userdata = array(
            'user_login' => $username,
            'user_email' => $email,
            'user_pass' => $password,
            'user_url' => $website,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'nickname' => $nickname,
            'description' => $bio,
        );
        $user = wp_insert_user($userdata);
        echo 'Đăng ký thành công. Đi đến <a href="' . get_site_url() . '/wp-login.php">trang đăng nhập</a>.';
    }
}

function custom_registration_function() {
    // Xác định xem form đã được submit hay chưa bằng cách kiểm tra $_POST['submit'] có được thiết lập hay chưa
    if (isset($_POST['submit'])) {
        // Nếu form đã được submit, chúng ta gọi hàm registration_validation để xác nhận form.
        registration_validation(
                $_POST['username'], $_POST['password'], $_POST['email'], $_POST['website'], $_POST['fname'], $_POST['lname'], $_POST['nickname'], $_POST['bio']
        );

        // Sàng lọc thông tin user nhập vào
        global $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
        $username = sanitize_user($_POST['username']);
        $password = esc_attr($_POST['password']);
        $email = sanitize_email($_POST['email']);
        $website = esc_url($_POST['website']);
        $first_name = sanitize_text_field($_POST['fname']);
        $last_name = sanitize_text_field($_POST['lname']);
        $nickname = sanitize_text_field($_POST['nickname']);
        $bio = esc_textarea($_POST['bio']);

        // Gọi hàm complete_registration để tạo user chỉ khi không có lỗi WP_error được tìm thấy
        complete_registration(
                $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio
        );
    }

    registration_form(
            $username = "", $password = "", $email = "", $website = "", $first_name = "", $last_name = "", $nickname = "", $bio = ""
    );
}

function user_infomation_details() {
    $current_user = wp_get_current_user();
    ?>
    <h1> Thông tin tài khoản</h1>
    <p>Welcome:  <span style="color: red !important; font-weight: bold !important;"><?php echo $current_user->display_name; ?></span></p> 
    <p>ID:  <span style="color: red !important; font-weight: bold !important;"><?php echo $current_user->ID; ?></span></p>
    <p>Email:  <span style="color: red !important; font-weight: bold !important;"><?php echo $current_user->user_email; ?></span></p>
    <p><a href="<?php home_url('/FGCClass_WordPress/') ?>">Quay về trang chủ</a></p>
    <?php
}

// Tạo mới 1 shortcode [fgc_custom_registration]
add_shortcode('fgc_custom_registration', 'custom_registration_shortcode');

// Hàm gọi
function custom_registration_shortcode() {
    ob_start();
    if (!is_user_logged_in()) {
        custom_registration_function();
    } else {
        user_infomation_details();
//        remove_action(custom_registration_function());
    }
    return ob_get_clean();
}

// CUSTOM LOGIN PAGE INTERFACE

function custom_login_interface() {
    ?>
    <style type="text/css">
        
        body {
            background-color: #ffffff !important;
        }
        .login-main-container {
            padding: 0;
            margin: 0 auto;
            position: relative;
        }
        #login h1 a {
            background-image: none;
            width: 300px;
            height: 100px;
            background-size: 300px 100px;            
        }
        #dangnhap {
            border-radius: 5px;
        }
        .login-container #backtoblog a, .login #nav a {
            color: #1674d2 !important;
        }
        .login-container div#login form#dangnhap p.submit input#wp-submit {
            outline: 0;
            cursor: pointer;
            position: relative;
            display: inline-block;
            background: 0;
            width: 240px;
            border: 2px solid #e3e3e3;
            padding: 20px 0;
            font-size: 24px;
            font-weight: 600;
            line-height: 1;
            text-transform: uppercase;
            overflow: hidden;
            -webkit-transition: .3s ease;
            transition: .3s ease;
            text-shadow:none;
            box-shadow: none;
            color: #e3e3e3;
        }
        .login-container div#login form#dangnhap p.submit input#wp-submit:hover {
            border-color: #ed2553;
            color: #ed2553;
        }
        /* Pen Title */
        .pen-title {
            padding: 50px 0 !important;
            text-align: center;
            letter-spacing: 2px;
            font-weight: bold !important;
        }
        .pen-title h1 {
            margin: 0 0 20px;
            font-size: 48px;
            font-weight: 300;
        }
        .pen-title span {
            font-size: 12px;
        }
        .pen-title span .fa {
            color: #ed2553;
        }
        .pen-title span a {
            color: #ed2553;
            font-weight: 600;
            text-decoration: none;
        }

        /* Rerun */
        .rerun {
            margin: 0 0 30px;
            text-align: center;
        }
        .rerun a {
            cursor: pointer;
            display: inline-block;
            background: #ed2553;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            padding: 10px 20px;
            color: #ffffff;
            text-decoration: none;
            -webkit-transition: 0.3s ease;
            transition: 0.3s ease;
        }
        .rerun a:hover {
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        }
        .card:first-child {
            background: #fafafa;
            height: 10px;
            border-radius: 5px 5px 0 0;
            margin: 0 10px;
            padding: 0;
        }
        .card {
            position: relative;
            background: #ffffff;
            border-radius: 5px;
            padding: 60px 0 40px 0;
            box-sizing: border-box;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            -webkit-transition: .3s ease;
            transition: .3s ease;
        }

    </style>
    <div class="login-main-container">
        <div class="pen-title">
            <h1>Hãy đăng nhập hoặc đăng ký</h1><span>Hoặc <i class='fa fa-code'></i><a href="<?php echo home_url(); ?>">Quay lại trang chủ</a></span>
        </div>
        <div class="rerun"><a href="<?php echo home_url(); ?>">Quay lại</a></div>

        <div class="login-container">
            <div class="card"></div>
            <div class="card">
                <h1 class="title">Đăng nhập</h1>
                <?php
                if (isset($error))
                    echo '<div class="alert alert-danger" role="alert">
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              <span class="sr-only">Error:</span>
              ' . $error . '
            </div>';
                elseif (isset($message))
                    echo '<div class="alert alert-info" role="alert">
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              ' . $message . '
            </div>';
                if (isset($redirect))
                    echo '<script>setTimeout(function(){window.location.replace("' . $redirect . '");}, 2000);</script>';
                ?>

                <?php
                $arrgs = array(
                    'redirect' => site_url($_SERVER['REQUEST_URI']),
                    'form_id' => 'dangnhap', //Để dành viết CSS
                    'label_username' => __('Tài khoản'),
                    'label_password' => __('Mật khẩu'),
                    'label_remember' => __('Ghi nhớ'),
                    'label_log_in' => __('Đăng nhập'),
                );
                wp_login_form($arrgs);
                ?>
            </div>
        </div>
    </div>

    <?php
}

//add_action('login_enqueue_scripts', 'custom_login_interface');
//THAY THẾ CHỮ SALE BẰNG PHẦN TRĂM GIẢM GIÁ

add_filter('woocommerce_sale_flash', 'fgc_woocommerce_sale_flash', 10, 2);
function fgc_woocommerce_sale_flash($post, $product){
    global $product;
    $sale_price = $product->get_sale_price();
    $regular_price = $product->get_regular_price();
    $tmp = ($sale_price * 100)/$regular_price;
    return '<span class="onsale">-'.(int)number_format(100-$tmp,2).'%</span>';
}