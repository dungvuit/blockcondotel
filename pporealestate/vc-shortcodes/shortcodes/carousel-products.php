<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display Products with carousel
 *
 * @param $atts
 *
 * @return string
 */
function ppo_shortcode_product_carousel($atts) {

    $instance = shortcode_atts(array(
        'title' => '',
        'product_type' => 'new',
    ), $atts);
    
    $args = array(
        'post_type' => 'product',
        'showposts' => 10,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'end_time',
                'value' => date('Y/m/d', strtotime("today")),
                'compare' => '>=',
                'type' => 'DATE'
            )
        )
    );
    if($instance['product_type'] == 'vip'){
        $args['meta_query'][] = array(
            'key' => 'not_in_vip',
            'value' => '1',
            'compare' => '='
        );
    } else {
        $args['meta_query'][] = array(
            'key' => 'not_in_vip',
            'value' => '1',
            'compare' => '!='
        );
    }
    $loop_query = new WP_Query($args);

    $html_output = '<div class="carousel-products-widget">';
    if (!empty($atts['title'])) {
        $html_output .= '<h3 class="widget-title">' . $instance['title'] . '</h3>';
    }
    $html_output .= '<div class="owl-carousel">';
    while ($loop_query->have_posts()) : $loop_query->the_post();
        ob_start();
        get_template_part('template', 'product_item2');
        $html_output .= ob_get_clean();
    endwhile;
    wp_reset_query();
    $html_output .= "</div>"; // end .owl-carousel
    $html_output .= "</div>"; // end .product-grid-widget

    return $html_output;
}

add_shortcode('ppo-product-carousel', 'ppo_shortcode_product_carousel');