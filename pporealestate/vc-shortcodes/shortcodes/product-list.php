<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display Product list
 *
 * @param $atts
 *
 * @return string
 */
function ppo_shortcode_product_list($atts) {

    $instance = shortcode_atts(array(
        'title' => '',
        'product_type' => 'new',
    ), $atts);

    $html_output = '<div class="product-list-widget">';
    ob_start();
    if($instance['product_type'] == 'vip'){
        get_template_part('template', 'vip');
    } else {
        get_template_part('template', 'new');
    }
    $html_output .= ob_get_clean();
    $html_output .= "</div>";

    return $html_output;
}

add_shortcode('ppo-product-list', 'ppo_shortcode_product_list');