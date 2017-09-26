<?php
/**
 * Select category type
 *
 * @package    YITH Woocommerce Compare Premium
 * @author     Francesco Licandro <francesco.licandro@yithemes.com>
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
?>

<tr valign="top">
	<th scope="row" class="image_upload">
		<label for="<?php echo $id ?>"><?php echo $name ?></label>
	</th>
	<td class="forminp forminp-color plugin-option">

		<div id="<?php echo $id ?>-container" class="yit_options rm_option rm_input rm_text rm_upload" <?php if ( isset( $option['deps'] ) ): ?>data-field="<?php echo $id ?>" data-dep="<?php echo $this->get_id_field( $option['deps']['ids'] ) ?>" data-value="<?php echo $option['deps']['values'] ?>" <?php endif ?>>
			<div class="option">
				<input type="hidden" class="wc-product-search" style="width: 50%;" id="<?php echo $id ?>" name="<?php echo $id ?>" data-placeholder="<?php _e( 'Search for a category&hellip;', 'ywbt' ); ?>" data-multiple="true" data-action="yith_woocompare_search_product_cat" data-selected="<?php
				$categories = explode( ',', $value );
				$json_ids    = array();

				foreach ( $categories as $category ) {
					$term_obj = get_term_by( 'id', $category, 'product_cat' );
					if ( $term_obj ) {
						$json_ids[ $category ] = wp_kses_post( $term_obj->name );
					}
				}

				echo esc_attr( json_encode( $json_ids ) );
				?>" value="<?php echo implode( ',', array_keys( $json_ids ) ); ?>" />
			</div>
		</div>


	</td>
</tr>