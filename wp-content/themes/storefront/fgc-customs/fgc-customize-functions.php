<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

add_filter('woocommerce_breadcrumb_defaults', 'fgc_change_breadcrumb_home_text');

function fgc_change_breadcrumb_home_text($defaults) {
    // Change the breadcrumb home text from 'Home' to 'Trang Chủ'
    $defaults['home'] = 'Trang Chủ';
    return $defaults;
}

add_action('init', 'fgc_remove_woo_breadcrumbs');

function fgc_remove_woo_breadcrumbs() {
    remove_action('woo_main_before', 'woo_display_breadcrumbs', 10);
}