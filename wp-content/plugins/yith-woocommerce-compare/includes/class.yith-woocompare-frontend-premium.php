<?php
/**
 * Frontend class premium
 *
 * @author Yithemes
 * @package YITH Woocommerce Compare Premium
 * @version 1.1.4
 */

if ( ! defined( 'YITH_WOOCOMPARE' ) ) {
	exit;
} // Exit if accessed directly

if( ! class_exists( 'YITH_Woocompare_Frontend_Premium' ) ) {
    /**
     * YITH Custom Login Frontend
     *
     * @since 1.0.0
     */
    class YITH_Woocompare_Frontend_Premium extends YITH_Woocompare_Frontend {
        /**
         * Plugin version
         *
         * @var string
         * @since 1.0.0
         */
        public $version = YITH_WOOCOMPARE_VERSION;

	    /**
	     * The list of current cat inside the comparison table
	     *
	     * @var array
	     * @since 1.0.0
	     */
	    public $current_cat = array();

	    /**
	     * The name of categories cookie name
	     *
	     * @var string
	     * @since 1.0.0
	     */
	    public $cat_cookie = 'yith_woocompare_current_cat';

	    /**
	     * The action used to view the comparison table
	     *
	     * @var string
	     * @since 1.0.0
	     */
	    public $action_filter = 'yith_woocompare_filter_by_cat';

	    /**
	     * The compare page id
	     *
	     * @var int
	     * @since 2.1.0
	     */
	    public $page_id = 0;

        /**
         * Constructor
         *
         * @since 1.0.0
         */
        public function __construct() {

	        parent::__construct();

	        $this->init_variables();

	        // populate the list of current categories
	        add_action( 'init', array( $this, 'update_cat_cookie' ), 10 );
	        // list action
	        add_action( 'yith_woocompare_after_add_product', array( $this, 'update_cat_cookie_after_add' ), 10, 1 );
	        add_action( 'yith_woocompare_after_remove_product', array( $this, 'update_cat_cookie_after_remove' ), 10, 1 );

	        // before table
	        add_action( 'yith_woocompare_before_main_table', array( $this, 'add_logo_to_compare' ), 10 );
	        add_action( 'yith_woocompare_before_main_table', array( $this, 'print_filter_by_cat' ), 20 );
	        add_action( 'yith_woocompare_before_main_table', array( $this, 'wc_bundle_compatibility' ) );

	        // after table
	        add_action( 'yith_woocompare_after_main_table', array( $this, 'social_share' ), 10 );
	        add_action( 'yith_woocompare_after_main_table', array( $this, 'related_product' ), 20 );

	        add_filter( 'yith_woocompare_exclude_products_from_list', array( $this, 'exclude_product_from_list' ), 10, 1 );
	        add_filter( 'yith_woocompare_view_table_url', array( $this, 'filter_table_url' ), 10, 2 );

	        // filter comnpare link
	        add_filter( 'yith_woocompare_remove_compare_link_by_cat', array( $this, 'exclude_compare_by_cat' ), 10, 2 );

	        // enqueue scripts styles premium
	        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_premium_scripts' ), 20 );

	        // add the shortcode
	        add_shortcode( 'yith_woocompare_table', array( $this, 'compare_table_sc' ) );

	        if( version_compare( WC()->version, '2.4', '>=' ) ){
		        add_action( 'wc_ajax_' . $this->action_filter, array( $this, $this->action_filter . '_ajax' ) );
	        }
	        else {
		        add_action( 'wp_ajax_' . $this->action_filter, array( $this, $this->action_filter . '_ajax' ) );
		        add_action( 'wp_ajax_nopriv' . $this->action_filter, array( $this, $this->action_filter . '_ajax' ) );
	        }

	        // filter remove response
	        add_action( 'yith_woocompare_remove_product_action_ajax', array( $this, 'remove_product_ajax_premium' ) );
	        // filter added response
	        add_action( 'yith_woocompare_add_product_action_ajax', array( $this, 'added_related_to_compare' ) );

			add_filter( 'yith_woocompare_get_different_fields_value', array( $this, 'add_different_class' ), 99, 1 );

			add_action( 'yith_woocompare_popup_head', array( $this, 'add_styles_themes_and_custom') );
        }

	    /**
	     * Init class variables
	     *
	     * @since 2.1.0
	     * @author Francesco Licandro
	     */
	    public function init_variables(){
		    // Page
		    $this->page_id = get_option( 'yith-woocompare-page-id' );
		    if( function_exists( 'wpml_object_id_filter' ) && $this->page_id ) {
			    $this->page_id = wpml_object_id_filter( $this->page_id, 'page', true );
		    }
	    }

	    /**
	     * Update current categories cookie
	     *
	     * @since 2.0.0
	     * @author Francesco Licandro
	     * @param mixed $categories
	     */
	    public function update_cat_cookie( $categories = array() ){

		    if( isset( $_REQUEST['yith_compare_prod'] ) ) {

				$products = explode( ',', base64_decode( $_REQUEST['yith_compare_prod'] ) );
			    $this->set_variables_prod_cat( $products );
		    }
		    elseif( isset( $_REQUEST['yith_compare_cat'] ) ) {
			    $this->current_cat = array( intval( $_REQUEST['yith_compare_cat'] ) );
		    }
		    elseif( ! empty( $categories ) ) {
			    $this->current_cat = $categories;
		    }
		    elseif( ! empty( $this->products_list ) ) {
			    $products = $this->products_list;
			    $product = array_shift( $products );
				$categories = array_keys( $this->get_product_categories( $product ) );

			    $this->current_cat = $categories;
		    }
			else {
				$this->current_cat = $categories;
			}
	    }

		/**
		 * Set products_list and current_cat variables if $_REQUEST['yith_compare_prod'] is set
		 *
		 * @param array $products
		 * @since 2.0.0
		 * @author Francesco Licandro
		 */
		public function set_variables_prod_cat( $products ) {

			// set products list
			$this->products_list = $products;
			// get first for get active cat
			$product = array_shift( $products );
			if( ! isset( $_REQUEST['yith_compare_cat'] ) )
				$categories = array_keys( $this->get_product_categories( $product ) );
			else
				$categories = array( intval( $_REQUEST['yith_compare_cat'] ) );

			$this->current_cat = $categories;
		}

	    /**
	     * Update cookie after add to compare table
	     *
	     * @since 2.0.0
	     * @author Francesco Licandro
	     * @param $id
	     */
	    public function update_cat_cookie_after_add( $id ) {
		    $categories = array_keys( $this->get_product_categories( $id ) );

		    if( ! empty( $categories ) ){
			    $this->update_cat_cookie( $categories );
	        }
	    }

	    /**
	     * Update cookie after remove product from compare table
	     *
	     * @since 2.0.0
	     * @author Francesco Licandro
	     * @param $id
	     */
	    public function update_cat_cookie_after_remove( $id ) {
		    // get categories
		    $categories = $this->get_product_categories( $id );
			$exist      = array();

		    if( ! empty( $categories ) ) {
				foreach( $this->products_list as $product ) {
					$cat    = $this->get_product_categories( $product );
					foreach( $cat as $id => $name ) {
						if( array_key_exists( $id, $categories ) && ! in_array( $id, $exist ) ){
							$exist[] = $id;
						}
					}
				}
	        }

		    //remove old cookie
		    if( isset( $_COOKIE[ $this->cat_cookie ] ) )
			    unset( $_COOKIE[ $this->cat_cookie ] );

		    $this->update_cat_cookie( $exist );
	    }

	    /**
	     * Enqueue premium scripts and styles
	     *
	     * @since 2.0.0
	     * @author Francesco Licandro <francesco.licandro@yithemes.com>
	     */
	    public function enqueue_premium_scripts(){

		    global $sitepress;

		    wp_register_style( 'yith_woocompare_page', $this->stylesheet_url(), array(), false, 'all' );
		    wp_register_script( 'yith_woocompare_owl', YITH_WOOCOMPARE_ASSETS_URL . '/js/owl.carousel.min.js', array( 'jquery' ), '2.0.0', true );
		    wp_register_style( 'yith_woocompare_owl_style', YITH_WOOCOMPARE_ASSETS_URL . '/css/owl.carousel.css', array(), false, 'all' );

		    // dataTables
		    wp_register_script( 'jquery-fixedheadertable', YITH_WOOCOMPARE_ASSETS_URL . '/js/jquery.dataTables.min.js', array('jquery'), '1.10.7', true );
		    wp_register_style( 'jquery-fixedheadertable-style', YITH_WOOCOMPARE_ASSETS_URL . '/css/jquery.dataTables.css', array(), false, 'all' );
		    wp_register_script( 'jquery-fixedcolumns', YITH_WOOCOMPARE_ASSETS_URL . '/js/FixedColumns.min.js', array('jquery', 'jquery-fixedheadertable' ), '3.0.4', true );
		    wp_register_script( 'jquery-imagesloaded', YITH_WOOCOMPARE_ASSETS_URL . '/js/imagesloaded.pkgd.min.js', array('jquery'), '3.1.8', true );


		    // get custom style
		    $inline_css = $this->custom_user_style();
			wp_add_inline_style( 'yith_woocompare_page', $inline_css );

			wp_enqueue_style( 'yith_woocompare_page' );
			wp_enqueue_style( 'jquery-fixedheadertable-style' );

			if( is_page( $this->page_id ) ) {

			    wp_enqueue_script( 'jquery-fixedheadertable' );
			    wp_enqueue_script( 'jquery-fixedcolumns' );
			    wp_enqueue_script( 'jquery-imagesloaded' );

			    if( ! empty( $this->products_list ) || get_option( 'yith-woocompare-show-related' ) == 'yes' || ! isset( $_REQUEST['yith_compare_prod'] ) ) {
				    wp_enqueue_script( 'yith_woocompare_owl' );
				    wp_enqueue_style( 'yith_woocompare_owl_style' );
			    }
		    }

		    wp_localize_script( 'yith-woocompare-main', 'yith_woocompare_premium', array(
			    'is_page' => $this->page_or_popup == 'page',
			    'page_url' => $this->get_compare_page_url(),
			    'im_in_page' => is_page( $this->page_id ),
			    'view_label'    => get_option( 'yith_woocompare_button_text_added', __( 'View Compare', 'yith-woocommerce-compare' ) ),
			    'actionfilter' => $this->action_filter,
			    'num_related'   => get_option( 'yith-woocompare-related-visible-num' ),
			    'autoplay_related'  => get_option( 'yith-woocompare-related-autoplay' ) == 'yes',
				'loader'    => YITH_WOOCOMPARE_ASSETS_URL . '/images/loader.gif',
				'button_text'	=> get_option( 'yith_woocompare_button_text'),
				'fixedcolumns'	=> get_option( 'yith_woocompare_num_fixedcolumns', 1 )
		    ));


	    }

		/**
		 * Add scripts for shortcodes
		 *
		 * @since 2.0.3
		 * @author Francesco Licandro
		 */
		public function add_scripts() {
			wp_enqueue_script( 'jquery-fixedheadertable' );
			wp_enqueue_script( 'jquery-fixedcolumns' );
			wp_enqueue_script( 'jquery-imagesloaded' );
		}

	    /**
	     * Set custom style based on user options
	     *
	     * @since 2.0.0
	     * @author Francesco Licandro
	     * @return string
	     */
	    public function custom_user_style() {
			return yith_woocompare_user_style();
	    }

	    /**
	     * Add logo/image to compare table
	     *
	     * @since 2.0.0
		 * @param array $products_list
	     * @author Francesco Licandro <francesco.licandro@yithemes.com>
	     */
	    public function add_logo_to_compare( $products_list = array() ){

		    $image    = get_option( 'yith-woocompare-table-image' );
		    $in_page  = get_option( 'yith-woocompare-table-image-in-page' ) == 'yes';
		    $in_popup = get_option( 'yith-woocompare-table-image-in-popup' ) == 'yes';

		    if( ! $image || ( is_page( $this->page_id ) && ! $in_page ) || ( isset( $_REQUEST['iframe'] ) && ! $in_popup ) ) {
			    return;
		    }

		    ob_start();
		    ?>
				<div class="yith_woocompare_table_image">
					<img src="<?php echo esc_url( $image ) ?>" />
				</div>
			<?php

		    echo ob_get_clean();
	    }

	    /**
	     * Get product categories
	     *
	     * @param $product_id
	     * @return mixed
	     * @author Francesco Licandro <francesco.licandro@yithemes.com>
	     */
	    public function get_product_categories( $product_id ) {

		    $cat = $categories = array();

		    if( ! is_array( $product_id ) ) {
			    $categories = get_the_terms( $product_id, 'product_cat' );
		    }
		    else {
			    foreach( $product_id as $id ) {

				    $single_cat = get_the_terms( $id, 'product_cat' );

				    if( empty( $single_cat ) ) {
					    continue;
				    }
				    // get values
				    $single_values = array_values( $single_cat );

				    $categories = array_merge( $categories, $single_values );
			    }
		    }

		    if( empty( $categories ) ) {
			    return $cat;
		    }

		    foreach( $categories as $category ) {
			    $cat[$category->term_id] = $category->name;
		    }

		    return $cat;
	    }

	    /**
	     * Filter vars for compare table
	     *
	     * @since 2.0.0
		 * @param mixed $products
	     * @return mixed
	     * @author Francesco Licandro <francesco.licandro@yithemes.com>
	     */
	    public function exclude_product_from_list( $products ) {

		    // exit if less then 2 products
		    if( count( $products ) < 2 ) {
			    return $products;
		    }

		    $new_products = array();
		    $excluded_cat = array_filter( explode( ',', get_option( 'yith_woocompare_excluded_category' ) ) );
		    $inverse      = get_option( 'yith_woocompare_excluded_category_inverse' ) == 'yes';

		    foreach( $products as $product ) {
			    $product_cat = array_keys( $this->get_product_categories( $product ) );

			    // first check for excluded cat
			    if ( ! empty( $excluded_cat ) ) {
				    $intersect = array_intersect( $product_cat, $excluded_cat );

				    if( ! $inverse && ! empty( $intersect ) ) {
					    continue;
				    }
				    elseif( $inverse && empty( $intersect ) ) {
					    continue;
				    }
			    }
			    // now check for same cat
			    if ( get_option( 'yith_woocompare_use_category' ) == 'yes' ) {

				    if ( ! empty( $this->current_cat ) ) {
					    // else intersect array to find same cat
					    $intersect = array_intersect( $product_cat, $this->current_cat );
					    // cat is different
					    if ( empty( $intersect ) ) {
						    continue;
					    }
				    }
			    }

			    $new_products[] = $product;
		    }

		    return $new_products;
	    }

	    /**
	     * Filter view table link
	     *
	     * @param $link
	     * @param $product_id
	     *
	     * @return string
	     * @author Francesco Licandro <francesco.licandro@yithemes.com>
	     */
	    public function filter_table_url( $link, $product_id ) {

		    if( $this->page_or_popup != 'page' ) {
			    return $link;
		    }

		    $page = $this->get_compare_page_url();

		    if( ! $page ) {
			    return $link;
		    }

		    return $page;
	    }


	    /**
	     * Get page url
	     *
	     * @since 2.0.6
	     * @author Francesco Licandro
	     * @return string
	     */
	    public function get_compare_page_url(){
		    return get_permalink( $this->page_id );
	    }

	    /**
	     * Filter compare link
	     *
	     * @since 2.0.0
	     * @param $default
	     * @param $product_id
	     * @return bool
	     * @author Francesco Licandro <francesco.licandro@yithemes.com>
	     */
	    public function exclude_compare_by_cat( $default, $product_id ) {

		    $excluded_cat = array_filter( explode( ',', get_option( 'yith_woocompare_excluded_category', '' ) ) );

		    if( empty( $excluded_cat ) )
			    return false;

		    $product_cat = array_keys( $this->get_product_categories( $product_id ) );
		    $intersect = array_intersect( $product_cat, $excluded_cat );

		    $inverse = get_option( 'yith_woocompare_excluded_category_inverse' ) == 'yes';

		    if( ! $inverse && ! empty( $intersect ) ) {
			    return true;
		    }
		    elseif( $inverse && empty( $intersect ) ) {
			    return true;
		    }

		    return false;
	    }

	    /**
	     * Shortcode to show the compare table
	     *
	     * @since 2.0.0
	     * @author Francesco Licandro <francesco.licandro@yithemes.com>
	     */
	    public function compare_table_sc( $atts, $content = null ) {

		    $atts = shortcode_atts(array(
			    'products' => false
		    ), $atts );

			$products = array();

		    // get product id from shortcode atts
		    if ( ! empty( $atts['products'] ) ) {

			    global $wpdb;

			    foreach( explode( ',', $atts['products'] ) as $product ) {
				    $products[] = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE ID = %d OR post_name LIKE %s OR post_title LIKE %s LIMIT 1", $product, '%' . $product . '%', '%' . $product . '%' ) );
			    }
		    }

			if( ! empty( $products ) ) {
				$products = array_unique( $products );
				$_REQUEST['yith_compare_prod'] = base64_encode( implode( ',', $products ) );
				// then set correct products list and current cat
				$this->set_variables_prod_cat( $products );

				// add scripts
				add_action( 'wp_footer', array( $this, 'add_scripts' ) );
			}

		    // get args
		    $args = $this->_vars( $products );
		    // change args
		    $args['share']    = isset( $_REQUEST['yith_compare_prod'] );


		    wc_get_template( 'yith-compare-table.php', $args, '', YITH_WOOCOMPARE_TEMPLATE_PATH . '/' );
	    }

	    /**
	     * Share compare table
	     *
	     * @since 2.0.0
	     * @author Francesco Licandro <francesco.licandro@yithemes.com>
	     */
	    public function social_share() {

		    $enable = get_option( 'yith-woocompare-enable-share' ) == 'yes';
			$social = get_option( 'yith-woocompare-share-socials' );

		    if( ! $enable || empty( $social ) || empty( $this->products_list ) || isset( $_REQUEST['yith_compare_prod'] ) )
			    return;

		    // check for page/popup
		    $in_page  = get_option( 'yith-woocompare-share-in-page' ) == 'yes';
		    $in_popup = get_option( 'yith-woocompare-share-in-popup' ) == 'yes';

		    if( ( is_page( $this->page_id ) && ! $in_page ) || ( isset( $_REQUEST['iframe'] ) && ! $in_popup ) ) {
			    return;
		    }

		    $products = implode(',', $this->products_list );
		    $products_base64 = base64_encode( $products );

		    // get facebook image
		    $facebook_image = get_option( 'yith_woocompare_facebook_image', '' );

		    $args = array(
			    'socials'   => $social,
			    'share_title' => get_option( 'yith-woocompare-share-title', __( 'Share on:', 'yith-woocommerce-compare' ) ),
		        'share_link_url' => esc_url_raw( add_query_arg( 'yith_compare_prod', $products_base64, $this->get_compare_page_url() ) ),
		        'share_link_title' => urlencode( get_option( 'yith_woocompare_socials_title' ) ),
		        'share_summary' => urlencode( str_replace( '%compare_url%', '', get_option( 'yith_woocompare_socials_text' ) ) ),
			    'facebook_appid' => get_option( 'yith_woocompare_facebook_appid', '' ),
			    'facebook_image' => $facebook_image
		    );

		    wc_get_template( 'yith-compare-share.php', $args, '', YITH_WOOCOMPARE_TEMPLATE_PATH . '/' );
	    }

	    /**
	     * Add category filter for compare page
	     *
	     * @since 2.0.0
	     * @author Francesco Licandro
	     */
	    public function print_filter_by_cat() {

		    if( get_option( 'yith_woocompare_use_category' ) != 'yes' ) {
		        return;
		    }

		    // get all categories
		    $all_cat = $this->get_product_categories( $this->products_list );

		    if( empty( $all_cat ) ) {
			    return;
		    }

		    // set data for compare share
		    $data = isset( $_REQUEST['yith_compare_prod'] ) ? 'data-product_ids="' . $_REQUEST['yith_compare_prod'] . '"' : '';
		    $data .= isset( $_REQUEST['iframe'] ) ? ' data-iframe="1"' : '';

		    ?>

		    <div id="yith-woocompare-cat-nav">
			    <h3><?php echo get_option( 'yith-woocompare-categories-filter-title', __( 'Category Filter', 'yith-woocommerce-compare' ) ) ?></h3>

		        <ul class="yith-woocompare-nav-list" <?php echo $data ?>>

		        <?php
		        foreach( $all_cat as $cat_id => $cat_name ) :
		            $active = in_array( $cat_id, (array) $this->current_cat ) ? true : false;
		        ?>
			        <li>
			        <?php if( $active ) : ?>
				        <span class="active"><?php echo $cat_name ?></span>
			        <?php else : ?>
				        <a href="<?php echo esc_url_raw( add_query_arg( 'yith_compare_cat', $cat_id ) ) ?>" data-cat_id="<?php echo $cat_id ?>"><?php echo $cat_name ?></a>
			        <?php endif; ?>
			        </li>

		        <?php endforeach; ?>

		        </ul>
		    </div>

			<?php
	    }

	    /**
	     * Ajax compare table filter for category
	     *
	     * @since 2.0.0
	     * @author Francesco Licandro
	     */
	    public function yith_woocompare_filter_by_cat_ajax() {

		    if( ! isset( $_REQUEST['yith_compare_cat'] ) )
			    die();


		    if( isset( $_REQUEST['iframe'] ) ){
			    header('Content-Type: text/html; charset=utf-8');
			    $this->compare_table_html();
		    }
		    else {
		        echo do_shortcode( '[yith_woocompare_table]' );
	        }

		    die();
	    }

	    /**
	     * Add related product in compare table
	     *
	     * @since 2.0.0
	     * @author Francesco Licandro
	     */
        public function related_product() {

	        if( empty( $this->products_list ) || get_option( 'yith-woocompare-show-related' ) != 'yes' || isset( $_REQUEST['yith_compare_prod'] ) )
		        return;

	        // check for page/popup
	        $in_page  = get_option( 'yith-woocompare-related-in-page' ) == 'yes';
	        $in_popup = get_option( 'yith-woocompare-related-in-popup' ) == 'yes';

	        if( ( is_page( $this->page_id ) && ! $in_page ) || ( isset( $_REQUEST['iframe'] ) && ! $in_popup ) ) {
		        return;
	        }

	        // filter product
	        $products = $this->exclude_product_from_list( $this->products_list );
	        $related = array();

			foreach( $products as $product_id ) {
				if( function_exists( 'wpml_object_id_filter' ) ) {
					$product_id = wpml_object_id_filter( $product_id, 'product', false );
					if( ! $product_id ) {
						continue;
					}
				}

				$product = wc_get_product( $product_id );

				if( ! $product )
					continue;

				$related = array_merge( $product->get_related(), $related );
			}
	        // remove duplicate
	        $related = array_unique( $related );
	        // remove products already in compare
	        $related = array_diff( $related, $this->products_list );

	        // exit if related is empty
	        if( empty( $related ) )
		        return;

	        // set args
	        $args = array(
		        'iframe'        => isset( $_REQUEST['iframe'] ),
		        'products'      => $related,
		        'related_title' => get_option( 'yith-woocompare-related-title' )
	        );

	        // the template
	        wc_get_template( 'yith-compare-related.php', $args, '', YITH_WOOCOMPARE_TEMPLATE_PATH . '/' );
        }

	    /**
	     * Filter remove action for compare page
	     *
	     * @since 2.0.0
	     * @author Francesco Licandro
	     */
	    public function remove_product_ajax_premium() {

		    if( ! isset( $_REQUEST['iframe'] ) && ! ( isset( $_REQUEST['responseType'] ) && $_REQUEST['responseType'] == 'product_list' ) ){

			    echo do_shortcode( '[yith_woocompare_table]' );

			    die();
		    }
	    }

	    /**
	     * Added related product to compare
	     *
	     * @since 2.0.0
	     * @author Francesco Licandro
	     */
        public function added_related_to_compare(){

	        if( isset( $_REQUEST['is_related'] ) && $_REQUEST['is_related'] != 'false' ){

		        if( isset( $_REQUEST['iframe'] ) && $_REQUEST['iframe'] != 'false' ) {
			        header('Content-Type: text/html; charset=utf-8');
		            $this->compare_table_html();
			    }
		        else {
			        echo do_shortcode( '[yith_woocompare_table]' );
		        }

		        die();
	        }
        }

		/**
		 * Add different class to let's compare products attributes
		 *
		 * @access public
		 * @since 2.0.3
		 * @param array $products_list
		 * @return array
		 * @author Francesco Licandro
		 */
		public function add_different_class( $products_list ) {

			if( get_option('yith_woocompare_highlights_different') != 'yes' || empty( $products_list ) || count( $products_list ) < 2 ) {
				return array();
			}

			$prev_value = array();
			$different_value = array();


			foreach( $products_list as $key => $product ) {

				$value = $product->fields;

				// remove unused fields
				unset(
					$value['description'],
					$value['stock']
				);

				$new_value = array();
				foreach( $value as $name => $val ) {

					if( $name == 'price' ) {
						$new_value[$name] = $val;
						continue;
					}

					$val = strtolower( $val );
					$val = explode(',', $val );
					foreach( $val as $index => $elem ){
						$val[ $index ] = trim( $elem );
					}
					natsort( $val );
					$val = implode(',', $val );

					$new_value[$name] = $val;
				}

				// if prev value is not empty compare with current and save difference
				if( ! empty( $prev_value ) ) {
					$diff = array_diff( $prev_value, $new_value );
					$different_value = array_merge( $different_value, $diff );
				}

				// save current value
				$prev_value = $new_value;
			}

			// if no difference return list
			if( empty( $different_value ) ){
				return array();
			}

			return array_keys( $different_value );
		}

		/**
		 * Add style for YITH Themes Compatibility
		 *
		 * @since 2.0.4
		 * @author Francesco Licandro
		 */
		public function add_styles_themes_and_custom(){

			echo '<style>' . $this->custom_user_style() . '</style>';

			// get theme and woocommerce assets
			$assets_yit = class_exists( 'YIT_Asset' ) ? YIT_Asset()->get() : array();
			$assets_yit = isset( $assets_yit['style'] ) ? $assets_yit['style'] : array();
			$assets_wc = class_exists( 'WC_Frontend_Scripts' ) ? WC_Frontend_Scripts::get_styles() : array();
			! is_array( $assets_wc ) && $assets_wc = array();
			$assets = array_merge( $assets_yit, $assets_wc );
			$to_include = apply_filters( 'yith_woocompare_popup_assets', array(
					"google-fonts",
					"font-awesome",
					"theme-stylesheet",
					"woocommerce-general",
					"yit-layout",
					"cache-dynamics",
					"custom"
			) );

			// first if is child include parent css
			if( is_child_theme() && function_exists( 'yit_enqueue_parent_theme_style' ) ) {
				yit_enqueue_parent_theme_style();
			}

			foreach( $to_include as $css ) {
				if( ! isset( $assets[$css]["src"] ) ){
					continue;
				}
				echo "<link rel=\"stylesheet\" href=" . $assets[$css]["src"] . " type=\"text/css\" media=\"all\">";
			}

		}

	    /**
	     * WooCommerce Product Bundle Compatibility
	     *
	     * @since 2.0.6
	     * @author Francesco Licandro
	     */
	    public function wc_bundle_compatibility(){
		    // remove description from bundled items
		    remove_action( 'wc_bundles_bundled_item_details', 'wc_bundles_bundled_item_description', 20 );
		    remove_action( 'wc_bundles_bundled_item_details', 'wc_bundles_bundled_item_product_details', 25 );
		    add_action( 'wc_bundles_bundled_item_details', array( $this, 'print_bundled_item_price' ), 25, 2 );
	    }

	    /**
	     * Print bundled single item price
	     *
	     * @since 2.0.6
	     * @param object $bundled_item
	     * @param object $product
	     * @author Francesco Licandro
	     */
	    public function print_bundled_item_price( $bundled_item, $product ) {

		    if( ! function_exists( 'WC_PB' ) ) {
			    return;
		    }

		    wc_get_template( 'single-product/bundled-item-price.php', array(
				    'bundled_item' => $bundled_item
		    ), false, WC_PB()->woo_bundles_plugin_path() . '/templates/' );
	    }
    }
}