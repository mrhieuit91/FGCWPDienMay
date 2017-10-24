<?php /* Template Name: Compare */



get_header(); 
$list_product_in_compare1 = !empty($_SESSION['compares']) ? $_SESSION['compares'] : [];

    if(!empty($list_product_in_compare1)) { // neu bien session[compare] ko rong
    	?>
		    <div id="guide_compare">
		        <i class="bg icon_large_compare"></i>
		        <h1>So sánh sản phẩm</h1>
		    </div>
    		<table class="compare">
	<?php
    	
    	$products = [];
    	foreach ($list_product_in_compare1 as $id) {
    		$product = wc_get_product( $id );
    		$products[$id] = $product;

				// echo $ids;
				// echo $_product->get_price(); // giá
				// echo $_product->get_name(); // tên
				// echo $_product->get_image(); // ảnh
				// echo $_product->get_short_description(); // thông số tóm tắt
				// echo $_product->get_average_rating() *2; // thông số tóm tắt

					//var_dump($product);

                // echo $compare['name'][$id]  = $_product->get_name(); // tên
                // echo $compare['image'][$id]  = $_product->get_image(); // ảnh
                // echo $compare['price'][$id]  = $_product->get_price(); // giá
                // //$compare['buys'] = $product['buys'];
                // echo $compare['description'][$id]  = $_product->get_short_description(); // thông số tóm tắt
                // echo $compare['rate'][$id]  = $_product->get_average_rating() *2; // đánh gái trung bình
    	}

    	$compare = array();
    	foreach ($products as $id => $_product) {
                //$id = $product->id;
                $compare['name'][$id] = $_product->get_name();//
                $compare['image'][$id] = $_product->get_image();//
                $compare['price'][$id] = $_product->get_price();//xong
                //$compare['buys'][$id] = $product['buys'];
                $compare['description'][$id] = $_product->get_short_description();
                $compare['rate'][$id] = $_product->get_average_rating() *2;
            }
            
            ?>
            <table class="compare">
            	<thead>
            		<tr>
            			<td></td>
            			<?php 
            			foreach ($compare['name'] as $id => $name) {
            				echo '<th class="blue compare-name compare-product-'.$id.'">'.$name.' (<p class="deletecompare" data-product-id="'.$id.'">Xóa</p>)</th>';
            			} ?>
            		</tr>
            	</thead>
            	<tbody>
            		<tr>
            			<th>Ảnh</th>
            			<?php 
            			foreach ($compare['image'] as $id => $image) {
            				echo '<td class="compare-image compare-product-'.$id.'"><img src="'.$image.'" width="80px" height="80px" /></td>';
            			} ?>
            		</tr>
            		<tr>
            			<th>Giá</th>
            			<?php 
            			foreach ($compare['price'] as $id => $price) {
            				echo '<td class="compare-price compare-product-'.$id.'">'.$price.'</td>';
            			} ?>
            		</tr>
            		<tr>
            			<th>Thông số</th>
            			<?php 
            			foreach ($compare['description'] as $id => $description) {
            				echo '<td class="compare-description compare-product-'.$id.'">'.nl2br($description).'</td>';
            			} ?>
            		</tr>
            		<tr>
            			<th>Đánh giá</th>
            			<?php 
            			foreach ($compare['rate'] as $id => $rate) {
            				echo '<td class="compare-rate compare-product-'.$id.'">'.$rate.'</td>';
            			} ?>
            		</tr>
            		<tr>
            			<th>Xóa khỏi danh sách so sánh</th>
            			<?php 
            			foreach ($compare['rate'] as $id => $rate) {
            				echo '<td class="compare-rate compare-product-'.$id.'">xóa sản phẩm có id là '.$id.'</td>';
            			} ?>
            		</tr>
            		<tbody>
            		</table>
            		<?php


            	}
            	?>
            	<script type="text/javascript">
            	var $urlbase = '<?php echo get_site_url();?>';
            	$('.deletecompare').bind("click", function() {

            							    		
            			$.ajax({
            				url: $urlbase+"/?fgcaction=deletecomparingProduct",
	            //url: $urlbase+"/buy-product-for-cart.php",
            				type: 'POST',
	            //cache: false,
            				cache: false,
				//contentType: ,
            				dataType: 'html',
				//processData: false,
            				data: {products: $(this).attr('data-product-id')},
            				success: function (result) {
	            	
            					$('deletecompare').addClass("hide_com");
		    		//var numm = parseInt(num) +1;
		    		//$(".compare").html(result);
            				}
            			});	
            		
            	});
            	</script>	
<?php





//do_action( 'storefront_sidebar' );
            	get_footer();