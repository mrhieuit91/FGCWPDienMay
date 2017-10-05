<?php
/**
 * Woocommerce Compare page
 *
 * @author Your Inspiration Themes
 * @package YITH Woocommerce Compare
 * @version 1.1.4
 */

global $product, $yith_woocompare;

$is_iframe = isset( $_REQUEST['iframe'] ) && $_REQUEST['iframe'];

?>

<div id="yith-woocompare" class="woocommerce">

	<?php
        if ( empty( $products ) ) {
            echo '<p>' . apply_filters( 'yith_woocompare_empry_compare_message', __( 'Không có sản phẩm nào được đưa vào trong bảng so sánh.', 'yith-woocommerce-compare' ) ) . '</p>';
            return;
        }
    ?>

    <?php do_action( 'yith_woocompare_before_main_table' ); ?>

	<table id="yith-woocompare-table" class="compare-list <?php if( empty( $products ) ) echo 'empty-list' ?>">
		<thead>
		<tr>
			<th>&nbsp;</th>
			<?php foreach( $products as $i => $product ) : ?>
				<td></td>
			<?php endforeach; ?>
			<?php if( $is_iframe ) : ?>
				<td class="last-column"></td>
			<?php endif; ?>
		</tr>
		</thead>
		<tfoot>
		<tr>
			<th>&nbsp;</th>
			<?php foreach( $products as $i => $product ) : ?>
				<td></td>
			<?php endforeach; ?>
			<?php if( $is_iframe ) : ?>
				<td class="last-column"></td>
			<?php endif; ?>
		</tr>
		</tfoot>

		<tbody>

            <?php if( ! isset( $fields['product_info'] ) && ! $share ) : ?>
            <tr class="remove">
                <th>&nbsp;</th>
                <?php foreach( $products as $i => $product ) : $product_class = ( $i % 2 == 0 ? 'odd' : 'even' ) . ' product_' . $product->id ?>
                    <td class="<?php echo $product_class; ?>">
                        <a href="<?php echo $yith_woocompare->obj->remove_product_url( $product->id ) ?>" data-is_page="1" data-product_id="<?php echo $product->id; ?>"><span class="remove">x</span><?php _e( 'Xóa', 'yith-woocommerce-compare' ) ?></a>
                    </td>
                <?php endforeach; ?>
	            <?php if( $is_iframe ) : ?>
		            <td class="last-column"></td>
	            <?php endif; ?>
            </tr>
            <?php endif; ?>

            <?php foreach ( $fields as $field => $name ) : ?>

                <tr class="<?php echo ! in_array( $field, $different ) ? $field : $field . ' different' ?>">

                    <th>
                        <?php echo $name ?>
                        <?php if ( $field == 'product_info' ) echo '<div class="fixed-th"></div>'; ?>
                    </th>

                    <?php foreach( $products as $i => $product ) :
                        // set td class
                        $product_class = ( $i % 2 == 0 ? 'odd' : 'even' ) . ' product_' . $product->id;
                        if( $field == 'stock' ) {
                            $availability = $product->get_availability();
                            $product_class .= ' ' . (  empty( $availability['class'] ) ? 'in-stock' : $availability['class'] );
                        }
                        ?>

                        <td class="<?php echo $product_class; ?>"><?php
                            switch( $field ) {

                                case 'product_info':

                                    if( ! $share )
                                        echo '<div class="remove"><a href="'. $yith_woocompare->obj->remove_product_url( $product->id ) . '" data-is_page="1" data-product_id="'. $product->id . '"><span class="remove">x</span>' .  __( 'Xóa', 'yith-woocommerce-compare' ) . '</a></div>';

                                    if( $show_image || $show_title ) {
	                                    echo '<a href="' . get_permalink( $product->id ) .'">';
                                        if( $show_image )
	                                        echo '<div class="image-wrap">' . $product->get_image( 'yith-woocompare-image' ) . '</div>';
	                                    if( $show_title )
		                                    echo '<h4 class="product_title">' . $product->get_title() . '</h4>';
	                                    echo '</a>';
                                    }

                                    if( $product->product_type == 'bundle' ) {
                                        $bundled_items = $product->get_bundled_items();

                                        if( ! empty( $bundled_items ) ) {

                                            echo '<div class="bundled_product_list">';

                                            foreach ( $bundled_items as $bundled_item ) {
                                                /**
                                                 * wc_bundles_bundled_item_details hook
                                                 */
                                                do_action( 'wc_bundles_bundled_item_details', $bundled_item, $product );
                                            }

                                            echo '</div>';
                                        }
                                    }

                                    if( $show_add_cart ) {
                                        woocommerce_template_loop_add_to_cart();
                                    }
                                    break;

                                case 'rating':
                                    $rating = $product->get_rating_html();
                                    echo $rating != '' ? '<div class="woocommerce-product-rating">' . $rating . '</div>' : '-';
                                    break;

                                default:
                                    echo empty( $product->fields[$field] ) ? '-' : $product->fields[$field];
                                    break;
                            }
                            ?>
                        </td>
                    <?php endforeach ?>
	                <?php if( $is_iframe ) : ?>
		                <td class="last-column"></td>
	                <?php endif; ?>
                </tr>
            <?php endforeach; ?>

            <?php if ( $repeat_price == 'yes' && isset( $fields['price'] )  ) : ?>
                <tr class="price repeated">
                    <th><?php echo $fields['price'] ?></th>

                    <?php foreach( $products as $i => $product ) : $product_class = ( $i % 2 == 0 ? 'odd' : 'even' ) . ' product_' . $product->id ?>
                        <td class="<?php echo $product_class ?>"><?php echo $product->fields['price'] ?></td>
                    <?php endforeach; ?>
	                <?php if( $is_iframe ) : ?>
		                <td class="last-column"></td>
	                <?php endif; ?>
                </tr>
            <?php endif; ?>

            <?php if ( $repeat_add_to_cart == 'yes'  ) : ?>
                <tr class="add-to-cart repeated">
                    <th>&nbsp;</th>

                    <?php foreach( $products as $i => $product ) : $product_class = ( $i % 2 == 0 ? 'odd' : 'even' ) . ' product_' . $product->id ?>
                        <td class="<?php echo $product_class ?>">
                            <?php woocommerce_template_loop_add_to_cart(); ?>
                        </td>
                    <?php endforeach; ?>

	                <?php if( $is_iframe ) : ?>
		                <td class="last-column"></td>
	                <?php endif; ?>

                </tr>
            <?php endif; ?>

		</tbody>
	</table>

	

</div>