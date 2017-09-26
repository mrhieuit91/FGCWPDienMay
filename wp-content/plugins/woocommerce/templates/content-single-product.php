<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
<div class="woocommerce-products-header page-title"> 
	<?php	do_action( 'woocommerce_shop_loop_item_title' ); ?> 
</div>
<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	  
	<div class="image">
	<?php

		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		//do_action( 'woocommerce_before_single_product_summary' );
	?>
	</div>
	<div class="product-title-price-cart">
		
		
		<div class="product-title-price">
			<?php
			/**
			 * truong Product Summary Box.
			 * 
			 * @see woocommerce_template_single_excerpt()
			 * @see woocommerce_template_single_price()
			 */
			do_action( 'truong_single_product_summary' );
			 ?>
		</div>
						<?php   global $woocommerce;
    $items = $woocommerce->cart->get_cart();
       ?>

		<div class="cart" style="text-align: center;">

 
                <button type="button" class="btn-buy" data-product-id="<?=$product->id?>">Mua ngay</button> 
                <!-- <button type="button" class="btn-addtocart" data-product-id="'.$product->id.'">Thêm vào giỏ hàng</button> 
                <button type="button" class="btn-compare" data-product-id="'.$product->id.'">Thêm vào danh sách so sánh</button>
 -->
                			<button type="button" class="btn btn-primary btn-buy" data-product-id="<?=$product->id?>">Mua ngay</button> 
                            <?php 
                            //var_dump($this->session->userdata("cart"));exit;
                            //var_dump($this->session->userdata("compare"));exit;
                            if(is_array($woocommerce->cart->get_cart();) && array_key_exists($product->id,$woocommerce->cart->get_cart();))
                                echo '<button type="button" class="btn btn-success disable" data-product-id="'.$product->id.'" onclick="window.location=\'cart\'">Đã có trong giỏ hàng</button> ';
                            else echo '<button type="button" class="btn btn-success btn-addtocart" data-product-id="'.$product->id.'">Thêm vào giỏ hàng</button> ';

                            if(is_array($this->session->userdata("compare")) && in_array($product->id,$this->session->userdata("compare")))
                                echo '<button type="button" class="btn btn-info btn-compare" data-product-id="'.$product->id.'" onclick="window.location=\'compare\'">Đã có trong danh sách so sánh</button> ';
                            else echo '<button type="button" class="btn btn-info btn-compare" data-product-id="'.$product->id.'">Thêm vào danh sách so sánh</button> ';?>


        </div>
                        <!-- <script type="text/javascript">
                            var price = $('.product-price').text().trim();
                            $('.product-price').text(format_curency(price));

                            $('.btn-compare').click(function() {
                                var param = {
                                    type: 'addtocompare',
                                    products: $('.btn-compare').data('product-id'),
                                };
                                $.post('compare', param, function(data) {
                                    if(data.status) {
                                        var number = data.number;
                                        $('.btn-compare').text('So sánh ngay ('+number+' sp)');
                                        $('.btn-compare').attr("onclick","window.location='compare'");
                                    }
                                });
                            });

                            $('.btn-buy').click(function() {
                                $.post('cart', {
                                    type: 'addtocart',
                                    products: $('.btn-buy').data('product-id'),
                                }, function(data) {
                                    if(data.status) {
                                        location.href = 'cart/';
                                    }
                                });
                            });
                            $('.btn-addtocart').click(function() {
                                var param = {
                                    type: 'addtocart',
                                    products: $('.btn-addtocart').data('product-id'),
                                };
                                $.post('cart', param, function(data) {
                                    if(data.status) {
                                        $('.btn-addtocart').text('Đã thêm vào giỏ hàng');//.prop('disabled', true);
                                        $('.btn-addtocart').attr("onclick","window.location='cart'");
                                        var number = parseInt($('span#count_shopping_cart_store').text())+1;
                                        if(data.number) number = data.number;
                                        $('span#count_shopping_cart_store').text(number);
                                        $('#img-cart').show();
                                    }
                                });
                            });

                        </script> -->

		
		
		
		
	</div>
	<div class="product-description">
	<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'truong_woocommerce_after_single_product_summary' );
	?>
		

	</div><!-- .summary -->

	

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
