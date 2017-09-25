<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row">
    <div class="product_list col-xs-12">
        <div class="product-slide">
            <?php echo do_shortcode('[wcps id="74"]'); ?>
            
        </div>
        
    </div>
    <div class="product_list col-xs-12">
        <div class="box-center">
            <h3>Sản phẩm mới nhất</h3>
        </div>
        <div class="content_product col-xs-12">
            <?php echo do_shortcode('[recent_products per_page="6" columns="3" orderby="date" order="desc"]'); ?>
        </div>
    </div>
</div>
