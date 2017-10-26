<?php
/**
 * The template used for displaying page content in template-homepage.php
 *
 * @package storefront
 */
?>
<?php
$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="<?php storefront_homepage_content_styles(); ?>" data-featured-image="<?php echo $featured_image; ?>">
    <div class="col-full">
        <?php
        /**
         * Functions hooked in to storefront_page add_action
         *
         * @hooked storefront_homepage_header      - 10
         * @hooked storefront_page_content         - 20
         */
        
        $args = array(
            'post_type' => 'product',
            'meta_key' => 'total_sales',
            'orderby' => 'meta_value_num',
            'posts_per_page' => 1,
        );

        $loop = new WP_Query($args);
        while ($loop->have_posts()) : $loop->the_post();
            global $product;
            ?>

            <a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

                <?php
                if (has_post_thumbnail($loop->post->ID))
                    echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog');
                else
                    echo '<img src="' . woocommerce_placeholder_img_src() . '" alt="product placeholder Image" width="65px" height="115px" />';
                ?>
                <h3><?php the_title(); ?></h3>


            </a>


        </div>
<?php endwhile; ?>
<?php wp_reset_query(); ?>
    do_action( 'storefront_homepage' );
    ?>
</div>
</div><!-- #post-## -->
