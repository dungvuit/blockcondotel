<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display Form search
 *
 * @param $atts
 *
 * @return string
 */
function ppo_shortcode_form_search($atts) {

    $instance = shortcode_atts(array(
        'title' => '',
    ), $atts);

    $html_output = '<div class="form-search-widget">';
//    if (!empty($atts['title'])) {
//        $html_output .= '<h3 class="widget-title">' . $instance['title'] . '</h3>';
//    }
    ob_start();
    get_template_part('template', 'search');
    $html_output .= ob_get_clean();
    $html_output .= "</div>";

    return $html_output;
}

add_shortcode('ppo-form-search', 'ppo_shortcode_form_search');