<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display Service Item
 *
 * @param $atts
 *
 * @return string
 */
function ppo_shortcode_service_item($atts) {

    $instance = shortcode_atts(array(
        'title' => '',
        'description' => '',
        'url' => '',
        'image' => '',
    ), $atts);

    $url = vc_build_link($instance['url']);
    $url_text = (!empty($url['title'])) ? $url['title'] : "Xem thêm";
    $url_link = $url['url'];
    $url_target = (!empty($url['target'])) ? 'target="' . $url['target'] . '"' : "";
    $url_rel = (!empty($url['rel'])) ? 'rel="' . $url['rel'] . '"' : "";
    $image = wp_get_attachment_image($instance['image']);
    $html_output = <<<HTML
    <div class="service-item-widget">
        {$image}
        <h3 class="service-title">{$instance['title']}</h3>
        <div class="service-description">{$instance['description']}</div>
        <a href="{$url_link}" {$url_rel} {$url_target} class="btn">{$url_text}</a>
    </div>
HTML;

    return $html_output;
}

add_shortcode('ppo-service-item', 'ppo_shortcode_service_item');