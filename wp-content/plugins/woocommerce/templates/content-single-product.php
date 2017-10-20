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
	<div id="product-<?php get_the_ID(); ?>" <?php post_class(); ?>>
		<div class="image" style="width: 100%;min-height: 630px; margin-bottom: 30px;">
			<div id="gallery_01" style="width: 10%; min-height:300px;float: left; clear: both;  ">
				<div class="list_img_products imager-thumbail" >	
					<?php 
					
					$product_id = get_the_ID();
					$product = new WC_product($product_id);
					$attachment_ids = $product->get_gallery_attachment_ids();
					
					foreach( $attachment_ids as $attachment_id ) 
					{
	          	// Display the image URL
						$Original_image_url = wp_get_attachment_url( $attachment_id );

	          	// Display Image instead of URL
					// echo '<a class="elevatezoom-gallery active " href="#" data-update="" data-image="" data-zoom-image="">'.wp_get_attachment_image($attachment_id, array( 190, 90)).'

	    //  		</a>';  
						echo '<a class="thumnail_pro elevatezoom-gallery active " href="#" data-update="" data-image="'. $Original_image_url.'" data-zoom-image="'.$Original_image_url.'">
						<img src="'.$Original_image_url .'" width="60%">
						</a>';         
					}
					?>
				</div> <!-- end list img -->
			</div><!-- end gallery -->
			<div class="image-product smallimage" style="width: 95%; min-height: 500px; margin: auto; ">
				<img id="zoom_03f"  width="65%" style="text-align: center; border:1px solid #e8e8e6;" src="<?php echo wp_get_attachment_url( $attachment_id ); ?>" data-zoom-image="<?php echo wp_get_attachment_url( $attachment_id ); ?>" >
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function ($) {
					$("#zoom_03f").elevateZoom({
						gallery:'gallery_01', 
						cursor: 'pointer', 
						easing : true,
						galleryActiveClass: "active"
					}); 
				});


			</script>
		</div> <!-- end image -->
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
			<div class="cart" style="text-align: center;">
				<?php 
					do_action( 'woocommerce_after_shop_loop_item' );
					do_action( 'woocommerce_add_to_cart_no_go' ); 					
				?>
				
				<button type="button" class="compare btn-compare" data-product-id="<?php get_the_ID();?>">Thêm vào danh sách so sánh</button>
				
				<script type="text/javascript">
					var url_website = location.href;
					var $urlbase = '<?php echo get_site_url();?>';
					var productid = '<?php echo get_the_ID(); ?>';// id sp
					//var compare_name = '<? echo $product->post->post_title; ?>';
					var num ='<?php echo WC()->cart->get_cart_contents_count(); ?>' ;
					
					var disable_yes = $('button.btn').hasClass(".disable");
					var compare_yes = $('button.compare').hasClass('comparing');
		            $(document).ready(function () {
		                $('button.btn.btn-success').bind("click", function() {
		                	
		                	//alert(cla);
					    	if (disable_yes != false) {
					    		window.location.replace($urlbase+"/cart");
					    	}else {					    		
					    		$.ajax({
			                        url: $urlbase+"/?fgcaction=addProduct",
			                        //url: $urlbase+"/buy-product-for-cart.php",
			                        type: 'POST',
						            //cache: false,
						            cache: false,
	        						//contentType: ,
	        						dataType: 'html',
	        						//processData: false,
						            data: {products: $('.btn-addtocart').data('product-id')},
			                        success: function (result) {
			                        	//alert("Test");
			                           
			                            $('button.btn').addClass("disable");
							    		$('button.btn').removeClass("btn-addtocart");
							    		$('button.btn').attr("onclick","window.location='cart'");
							    		//$(".btn").html("Đã có trong giỏ hàng");
							    		 $(".btn.btn-success").html("Đã có trong giỏ hàng");
							    		var numm = parseInt(num) +1;
							    		$(".number").html(numm);
			                        }
			                    });	
					    	}
        				});
        				$('button.compare').bind("click", function() {
        					
		                	if (compare_yes != false) {
					    		//window.location.replace($urlbase+"/cart");
					    	}else {					    		
					    		$.ajax({
			                        url: $urlbase+"/?fgcaction=compareProduct",
			                        //url: $urlbase+"/buy-product-for-cart.php",
			                        type: 'POST',
						            //cache: false,
						            cache: false,
	        						//contentType: ,
	        						dataType: 'html',
	        						//processData: false,
						            data: {products: $('.btn-addtocart').data('product-id')},
			                        success: function (result) {
			                        	//alert("Test");
			                            
			                            $('button.compare').addClass("comparing");
							    		$('button.compare').removeClass("btn-compare");
							    		$('button.compare').attr("onclick","window.location='cart'");
							    		//$("button.compare").html("Đã có trong giỏ hàng");
							    		var numm = parseInt(num) +1;
							    		$(".compare").html('So sánh ngay ('+numm+' sp)');
			                        }
			                    });	
					    	}
		                });

		                // $('.btn-compare').click(function () {
		                // 	//alert($urlbase)
		                //     $.ajax({
		                //         url: $urlbase+"/?action=compare",
				                        
		                //         success: function (result) {
		                //             $(".btn-compare").html(result);
		                //         }
		                //     });
		                // });

		                // $('.btn-compare').click(function() {
                  //               var param = {
                  //                   type: 'addtocompare',
                  //                   products: $('.btn-compare').data('product-id'),
                  //               };
                  //               $.post('compare', param, function(data) {
                  //                   if(data.status) {
                  //                       var number = data.number;
                  //                       $('.btn-compare').text('So sánh ngay ('+number+' sp)');
                  //                       $('.btn-compare').attr("onclick","window.location='compare'");
                  //                   }
                  //               });
                  //           });

		            });
		        </script>	
			</div> <!-- end cart -->
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
		</div> <!-- end product title -->
	</div> <!-- end product id -->
<?php do_action( 'woocommerce_after_single_product' ); ?>
