<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */
?>

</div><!-- .col-full -->
</div><!-- #content -->

<?php do_action('storefront_before_footer'); ?>

<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="col-full" id="footer_social">

        <?php
        /**
         * Functions hooked in to storefront_footer action
         *
         * @hooked storefront_footer_widgets - 10
         * @hooked storefront_credit         - 20
         */
        ///do_action( 'storefront_footer' );
        echo '<h3>Học lớp lập trình onlines miễn phí.</h3><br/>Hướng dẫn xây dựng website bán hàng và thanh toán trực tuyến.<br/>Website :<br/>Fanpage :<br/>';
        echo '<a href="https://vi-vn.facebook.com/"><img src="'. get_template_directory_uri().'/images/goog.png"></a> <a href="https://twitter.com/"> <img  src="'. get_template_directory_uri().'/images/quadat.png"></a> <a href="https://www.google.com.vn/?gfe_rd=cr&ei=XUYRWcizLoLj8we4haSICw/"><img src="'. get_template_directory_uri().'/images/facebook.png"></a>';
        ?>

    </div><!-- .col-full -->
</footer><!-- #colophon -->

<?php do_action('storefront_after_footer'); ?>

</div><!-- #page -->

<?php //wp_footer();  ?>
<!-- Scroll back to top -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<div id="backtotop"> 
    <a href="javascript:void(0)" class="backtotop"></a> 
</div>                 
<script type="text/javascript">
    $(function () {
        $("#backtotop").hide();
        $(window).scroll(function () {
            if ($(this).scrollTop() > 500) {
                $('#backtotop').fadeIn();
            } else {
                $('#backtotop').fadeOut();
            }
        });
    });
    jQuery('.backtotop').click(function () {
        jQuery('html, body').animate({
            scrollTop: 0
        }, 'slow');
    });
</script>
<!-- End of Scroll back to top --> 

</body>
</html>
