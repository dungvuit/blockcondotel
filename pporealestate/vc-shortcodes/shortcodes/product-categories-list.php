<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display product categories as list
 *
 * @param $atts
 *
 * @return string
 */
function ppo_shortcode_product_categories_list($atts) {

    $instance = shortcode_atts(array(
        'title' => '',
        'cat_id' => 'all',
    ), $atts);

    $html_output = '<div class="product-categories-list-widget">';
    if (!empty($atts['title'])) {
        $html_output .= '<h3 class="widget-title">' . $instance['title'] . '</h3>';
    }
    $args = array(
        'taxonomy' => 'product_category',
        'show_count' => 1,
        'hide_empty' => 0,
        'echo' => 0,
        'title_li' => '',
        'use_desc_for_title' => 0,
    );
    if(!empty($instance['cat_id']) and $instance['cat_id'] != 'all' and $instance['cat_id'] > 0){
        $args['child_of'] = $instance['cat_id'];
    }
    $html_output .= '<ul>' . wp_list_categories($args) . '</ul>';
    $html_output .= "</div>";

    return $html_output;
}

add_shortcode('ppo-product-categories-list', 'ppo_shortcode_product_categories_list');