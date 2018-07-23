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
function ppo_shortcode_product_carousel2($atts) {

    $instance = shortcode_atts(array(
        'title' => '',
        'cat_id' => '',
        'number_posts' => '10',
    ), $atts);
    
    $args = array(
        'post_type' => 'product',
        'showposts' => $instance['number_posts'],
        'orderby' => array('meta_value_num', 'post_date'),
        'meta_key' => 'not_in_vip',
        'order' => 'DESC',
        'meta_query' => array(
            array(
                'key' => 'end_time',
                'value' => date('Y/m/d', strtotime("today")),
                'compare' => '>=',
                'type' => 'DATE'
            )
        )
    );
    if(!empty($instance['cat_id']) and $instance['cat_id'] > 0){
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_category',
                'field'    => 'term_id',
                'terms'    => $instance['cat_id'],
            ),
	);
    }
    $loop_query = new WP_Query($args);

    $html_output = '<div class="carousel-products-widget-2">';
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

add_shortcode('ppo-product-carousel2', 'ppo_shortcode_product_carousel2');