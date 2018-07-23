<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display projects as slider
 *
 * @param $atts
 *
 * @return string
 */
function ppo_shortcode_slide_projects($atts) {

    $instance = shortcode_atts(array(
        'title' => '',
    ), $atts);

    $html_output = '<div class="slide-projects-widget">';
//    if (!empty($atts['title'])) {
//        $html_output .= '<h3 class="widget-title">' . $instance['title'] . '</h3>';
//    }
    ob_start();
    get_template_part('template/slide-projects');
    $html_output .= ob_get_clean();
    $html_output .= "</div>";

    return $html_output;
}

add_shortcode('ppo-slide-projects', 'ppo_shortcode_slide_projects');