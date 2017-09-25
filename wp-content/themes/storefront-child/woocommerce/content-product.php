<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}
?>
<style type="text/css">
    /*style 4 sản phẩm trên một dòng*/

    .cutom-woocommerce-product-item-title-and-price h2 a {
        font-weight: normal;
        font-size: 14px;
        clear: both;
        text-align: center;
    }
    .cutom-woocommerce-product-item {
        width: 23.5%;
        float: left;
        margin-right: 2%;
        background: #fff;
        text-align: center;
        min-height: 290px;
        margin-bottom: 40px;
    }
    .cutom-woocommerce-product-item:nth-of-type(4n+4) {
        margin-right: 0;
    }

    span.amount {
        text-decoration: none;
    }

    .cutom-woocommerce-product-item-title-and-price ins {
        text-decoration: none !important;
        font-weight: 700 !important;
        color: #F91111 !important;
    }
    .cutom-woocommerce-product-item-title-and-price h2 a {
        font-weight: normal;
        font-size: 14px;
        clear: both;
        text-align: center;
    }
    .cutom-woocommerce-product-item {
        width: 100%;
        float: left;
        margin-right: 2%;
        background: #fff;
        text-align: center;
        min-height: 290px;
        margin-bottom: 40px;
        border: solid #333 1px;
        border-radius: 4px;
    }
    .cutom-woocommerce-product-item:nth-of-type(4n+4) {
        margin-right: 0;
    }

    span.amount {
        text-decoration: none;
    }

    .cutom-woocommerce-product-item-title-and-price ins {
        text-decoration: none !important;
        font-weight: 700 !important;
        color: #F91111 !important;
    }
    #product-contents {
        display: block;
        width: 32%;
        height: 30%;
        margin: 4px !important;
        float: left;
    }
    .product-hover {
        display: none;

    }
    #product-contents:hover .product-hover {
        color: #fff !important;
        display: block;
        /*opacity: 0.7;*/
        background-color: #6f6969;
        position: absolute;
        width: 100%;
        z-index: 1;
        margin-right: 2%;
        /*text-align: center;*/
        min-height: 290px;
        margin-bottom: 40px;
        border: solid #333 1px;
        border-radius: 4px;
        top: 0px;
        transition: height 1s;
    }
    #cart-container button {
        background: #f09627;
        /*width: 120px;*/
        /*height: 18px;*/
    }
</style>
<li <?php post_class(); ?> id="product-contents">
    <div class="cutom-woocommerce-product-item col-xs-4">
        <div class="cutom-woocommerce-product-item-featured-image">
            <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <?php echo get_the_post_thumbnail(get_the_ID(), 'thumbnail', array('class' => 'product-image')); ?>

            </a>
        </div>    
        <div class="cutom-woocommerce-product-item-title-and-price">

            <p><?php do_action('woocommerce_after_shop_loop_item_title'); ?></p>
        </div>
        <div class=" col-xs-4 product-hover">
            <div class="cutom-woocommerce-product-item-featured-image">
                <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
            </div>    
            <div>

            </div>
            <div id="cart-container">
                <button type="button" class="btn btn-default btn-sm pull-left btn-shopping-cart" >
                    <span class="glyphicon glyphicon-shopping-cart"></span> Thêm vào giỏ hàng
                </button>
                <button type="button" class="btn btn-default btn-sm pull-right btn-details" >
                    <a href="<?php the_permalink(); ?>"><span class="glyphicon glyphicon-list-alt"></span> Chi tiết</a>
                </button>
            </div>

        </div>
    </div>

</li>
