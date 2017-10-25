<?php /* Template Name: Compare */



get_header(); 
	$list_product_in_compare1 = !empty($_SESSION['compares']) ? $_SESSION['compares'] : [];

    if(empty($list_product_in_compare1)) { // neu bien session[compare] ko rong
    	echo '<h1>Hãy chọn sản phẩm để so sánh</h1>';
        echo '<center><a href="sanpham" class="btn btn-primary">Mua sắm</a></center>';
    } else{
?>
	    <div id="guide_compare">
	        <i class="bg icon_large_compare"></i>
	        <h1>So sánh sản phẩm</h1>
	    </div>
		<table class="compare">
<?php    	
	$products = array();
	foreach ($list_product_in_compare1 as $id) {
		$product = wc_get_product( $id );
		$products[$id] = $product;
	}
	$compare = array();
	foreach ($products as $id => $_product) {                
        $compare['name'][$id] = $_product->get_name();//
        $compare['image'][$id] = $_product->get_image();//
        $compare['price'][$id] = $_product->get_price();//xong
        $compare['description'][$id] = $_product->get_short_description();
        $compare['rate'][$id] = $_product->get_average_rating() ;
    }
            
?>
<table class="compare">
  <thead>
    <tr>
      <td></td>
        <?php 
        foreach ($compare['name'] as $id => $name) {
        echo '<th class="compare compare-name compare-product-'.$id.'">'.$name.' (<a href="javascript:deleteItem('.$id.')">Xóa</a>)</th>';
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
  <tbody>
</table>
	<div class=" xoahet">czxczxc</div>
    <div class="clear space2 ">czxczxc</div>
<?php } ?>
            	<script type="text/javascript">
            		var $urlbase = '<?php echo get_site_url();?>';


					// var url_website = location.href;
					
					// var productid = '<?php// echo get_the_ID(); ?>';// id sp
					
					// var num ='<?php //echo WC()->cart->get_cart_contents_count(); ?>' ;
					
					// var disable_yes = $('button.btn').hasClass(".disable");
					// var compare_yes = $('button.compare').hasClass('comparing');
		            function deleteItem(id) {
				       //$('.compare-product-'+id).hide();
				        $.post($urlbase+"/?fgcaction=deletecomparingProduct", {type:'POST',cache: false,dataType: 'html',product_id:id}, function(result) {$('.compare-product-'+id).hide();});
				    }
				    $('.xoahet').click(function() {
                                
                                $.post(
                                	$urlbase+"/?fgcaction=deleteall",
                                	//type: 'POST',
                                	
                                	function(result) {
                                    
                                        
                                        $('.xoahet').text('da xoa het');
                                        $('.xoahet').attr("onclick","window.location='compare'");

                                    
                                	}
                                );
                            });

		    //         	$('.deletecompare').bind("click", function() {

		            							    		
		    //         			$.ajax({
		    //         				url: $urlbase+"/?fgcaction=deletecomparingProduct",
			   //          //url: $urlbase+"/buy-product-for-cart.php",
		    //         				type: 'POST',
			   //          //cache: false,
		    //         				cache: false,
						// //contentType: ,
		    //         				dataType: 'html',
						// //processData: false,
		    //         				data: {products: $(this).attr('data-product-id')},
		    //         				success: function (result) {
			            	
		    //         					$(this).addClass("hide_com");
				  //   		//var numm = parseInt(num) +1;
				  //   		//$(".compare").html(result);
		    //         				}
		    //         			});	
		            		
		    //         	});
		            
		        </script>	
<?php
   	get_footer();