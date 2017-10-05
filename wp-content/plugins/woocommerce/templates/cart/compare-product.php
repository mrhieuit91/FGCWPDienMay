<?php
	<style type="text/css">
    table {
  width: 100%;
  border-top: 1px solid #ccc;
  border-left: 1px solid #ccc;
  border-collapse: collapse;
  margin-bottom: 1em;
}
table th, table td {
  padding: 0.5em 1em;
  border-bottom: 1px solid #ccc;
  border-right: 1px solid #ccc;
}
table thead th,
table tbody td {
  text-align: center;
}
table thead {
  color: white;
  background: #0cf;
}
table td:first-child, table th:first-child{
    width: 92px;
}
table thead th {
  padding: 1em;
}
table[data-comparing="active"] tbody th {
  border-bottom: none;
  font-size: 0.75em;
  color: #767676;
  padding-bottom: 0;
}
</style>
    <div id="guide_compare">
        <i class="bg icon_large_compare"></i>
        <h1>So sánh sản phẩm</h1>
    </div>
    
      <?php 
      if(!empty($compare)) {
        ?>
    <table class="compare">
  <thead>
    <tr>
      <td></td>
        <?php 
        foreach ($compare['name'] as $id => $name) {
        echo '<th class="compare-name compare-product-'.$id.'">'.$name.' (<a href="javascript:deleteItem('.$id.')">Xóa</a>)</th>';
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
            $star = '';
            for($i=1;$i<=($rate);$i++) $star .= '<img src="public/themes/images/star-on.png" alt="1" title="good">';
        echo '<td class="compare-rate compare-product-'.$id.'">'.$star.'</td>';
        } ?>
    </tr>
  <tbody>
</table>
    <div class="clear space2"></div>

    <?php 
    } else {
        echo '<h1>Hãy chọn sản phẩm để so sánh</h1>';
        echo '<center><a href="sanpham" class="btn btn-primary">Mua sắm</a></center>';
    }
    ?>
    <div class="clear space2"></div>
<script type="text/javascript">
    //$(window).load(function () {});
    $('.compare-price').each(function(i, obj) {
        var price = $(this).text();
        $(this).text(format_curency(price));
    });
    function deleteItem(id) {
        $('.compare-product-'+id).hide();
        $.post('compare', {type:'deleteProduct',product_id:id}, function(data) {});
    }
</script>
?>