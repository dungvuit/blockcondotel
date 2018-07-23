<?php

/**
 * Get recent feedback with carousel
 * 
 * @param array $atts Attributes
 * @param string $content
 * @return string
 */
function shortcode_recent_feedback_carousel($atts, $content = null) {
    $atts = shortcode_atts(array(
        'number' => 6
    ), $atts, 'recent_feedback_carousel');
    $args = array(
        'post_type' => 'feedback',
        'showposts' => $atts['number'],
    );
    $loop = new WP_Query($args);
    $html = '<div class="recent-feedback-carousel-widget">';
    $html .= '<div class="owl-carousel">';
    while($loop->have_posts()) : $loop->the_post();
        $permalink = get_permalink();
        $title = get_the_title();
        $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
        $content = get_the_content();
        $html .= <<<HTML
<div class="entry">
    <a class="thumbnail" href="{$permalink}">
        <img alt="{$title}" src="{$thumb_url}" itemprop="image" onError="this.src=no_image_url" />
    </a>
    <h3 class="entry-title"><a href="{$permalink}">{$title}</a></h3>
    <div class="entry-content">{$content}</div>
</div>
HTML;
    endwhile;
    wp_reset_query();
    $html .= '</div></div>';
    
    return $html;
}