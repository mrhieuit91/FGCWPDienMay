jQuery(document).ready(function($) {

    $( ".attributes .fields" ).sortable({
        cursor: "move",
        scrollSensitivity: 10,
        tolerance: "pointer",
        axis: "y",
        stop: function(event, ui) {
            var list = ui.item.parents('.fields'),
                fields = new Array();
            $('input[type="checkbox"]', list).each(function(i){
                fields[i] = $(this).val();
            });

            list.next().val( fields.join(',') );
        }
    });

    // ############### TABLE PANEL ###################

    $( '#yith_woocompare_fields_attrs_product_info').on( 'woocompare-product-info-ready change', function(){
        if( ! $(this).is(':checked') ) {
            $( '[data-deps="yith_woocompare_fields_attrs_product_info"]' ).parents('tr').hide();
        }
        else {
            $( '[data-deps="yith_woocompare_fields_attrs_product_info"]' ).parents('tr').show();
        }
    }).trigger('woocompare-product-info-ready');

    $( '#yith_woocompare_fields_attrs_price' ).on( 'woocompare-product-price-ready change', function(){
        if( ! $(this).is(':checked') ) {
            $( '[data-deps="yith_woocompare_fields_attrs_price"]' ).parents('tr').hide();
        }
        else {
            $( '[data-deps="yith_woocompare_fields_attrs_price"]' ).parents('tr').show();
        }
    }).trigger('woocompare-product-price-ready');

    // ################ SHARE PANEL ####################

    $( '#yith-woocompare-enable-share' ).on( 'woocompare-share-ready change', function(){

        if( ! $(this).is(':checked') ) {
            $( '[data-deps="yith-woocompare-enable-share"]' ).parents('tr').hide();
        }
        else {
            $( '[data-deps="yith-woocompare-enable-share"]' ).parents('tr').show();
        }
    }).trigger('woocompare-share-ready');

    // select2 to select socials
    $(".yith-woocompare-chosen").select2({
        placeholder: "Select social..."
    });


    // ################ RELATED PANEL ####################

    $( '#yith-woocompare-show-related' ).on( 'woocompare-related-ready change', function(){

        if( ! $(this).is(':checked') ) {
            $( '[data-deps="yith-woocompare-show-related"]' ).parents('tr').hide();
        }
        else {
            $( '[data-deps="yith-woocompare-show-related"]' ).parents('tr').show();
        }
    }).trigger('woocompare-related-ready');


    // ##################### SHORTCODE PANEL ####################

    var sc_preview = $( '.shortcode-preview' );

    $('.yith-woocompare-shortcode-tab input').each( function(){

        $(this).on( 'change', function(){

            var value = ( this.type == 'checkbox' && ! $(this).is( ':checked' ) ) ? $(this).data('novalue') : $(this).val(),
                name  = this.name.replace( 'yith_', ''),
                shortcode = sc_preview.html(),
                attr;

            // remove old
            var reg = new RegExp( name + '="([a-zA-Z0-9-]*)"', 'g' );
            shortcode = shortcode.replace( reg, '' );

            if( ! value  ) {
                sc_preview.html( shortcode );
                return;
            }

            // else add attr
            shortcode = shortcode.replace(']', '');

            attr = name + '="' + value + '"';
            sc_preview.html( shortcode + ' ' + attr + ']' )

        });
    });

});