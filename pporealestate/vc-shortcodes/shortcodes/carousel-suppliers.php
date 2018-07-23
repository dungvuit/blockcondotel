<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display carousel suppliers
 *
 * @param $atts
 *
 * @return string
 */
function ppo_shortcode_carousel_suppliers($atts) {

    $instance = shortcode_atts(array(
        'title' => '',
    ), $atts);

    $args = array(
        'post_type' => 'supplier',
        'showposts' => 10,
    );
    $loop_query = new WP_Query($args);
    
    $html_output = '<div class="carousel-suppliers-widget">';
    if (!empty($atts['title'])) {
        $html_output .= '<h3 class="widget-title">' . $instance['title'] . '</h3>';
    }
    $html_output .= '<div class="owl-carousel">';
    while ($loop_query->have_posts()) : $loop_query->the_post();
        $title = get_the_title();
        $permalink = get_permalink();
        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $no_image_url = get_template_directory_uri() . "/images/no_image.png";
        $html_output .= <<<HTML
        <div class="entry" itemscope="" itemtype="http://schema.org/Article">
            <a class="thumbnail" href="{$permalink}" onclick="ga('send', 'event', 'Nhà cung cấp', 'Xem nhà cung cấp', '{$title}');">
                <img src="{$thumbnail_url}" alt="{$title}" itemprop="image" onError="this.src={$no_image_url}" />
            </a>
            <h3 class="entry-title" itemprop="name">
                <a href="{$permalink}" itemprop="url" onclick="ga('send', 'event', 'Nhà cung cấp', 'Xem nhà cung cấp', '{$title}');">{$title}</a>
            </h3>
        </div>
HTML;
    endwhile;
    wp_reset_query();
    $html_output .= "</div></div>";

    return $html_output;
}

add_shortcode('ppo-carousel-suppliers', 'ppo_shortcode_carousel_suppliers');


