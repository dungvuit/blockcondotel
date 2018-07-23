<?php

/**
 * Get partner with carousel
 * 
 * @param array $atts Attributes
 * @param string $content
 * @return string
 */
function shortcode_partner_carousel($atts, $content = null) {
    $atts = shortcode_atts(array(
        'number' => 6
    ), $atts, 'partner_carousel');
    $args = array(
        'post_type' => 'partner',
        'showposts' => $atts['number'],
    );
    $loop = new WP_Query($args);
    $html = '<div class="partner-carousel-widget">';
    $html .= '<div class="owl-carousel">';
    while($loop->have_posts()) : $loop->the_post();
        $permalink = get_permalink();
        $title = get_the_title();
        $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $content = get_the_content();
        $html .= <<<HTML
<a class="thumbnail" href="{$permalink}">
    <img alt="{$title}" src="{$thumb_url}" itemprop="image" onError="this.src=no_image_url" />
</a>
HTML;
    endwhile;
    wp_reset_query();
    $html .= '</div></div>';
    
    return $html;
}