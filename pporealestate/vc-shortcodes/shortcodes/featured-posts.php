<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Shortcode Heading
 *
 * @param $atts
 *
 * @return string
 */
function ppo_shortcode_featured_posts($atts) {

    $instance = shortcode_atts(array(
        'title' => '',
        'cat_id' => '',
//        'layout'          => 'base',
        'number_posts' => '4', // 3 or 4 or 6
        'show_description' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
    ), $atts);

    $date_format = get_option( 'date_format' );
    $time_format = get_option( 'time_format' );
    $args = array(
        'post_type' => 'post',
        'showposts' => $instance['number_posts'],
        'featured' => 'yes',
        'orderby' => $instance['orderby'],
        'order' => $instance['order'],
    );
    if(!empty($instance['cat_id']) and $instance['cat_id'] > 0){
        $args['cat'] = $instance['cat_id'];
    }
    $FeaturedPost_query = new WP_Query($args);
    
    $html_output = '<div class="featured-posts-widget">';
    if (!empty($atts['title'])) {
        $html_output .= '<h3 class="widget-title">' . $instance['title'] . '</h3>';
    }
    $html_output .= '<div class="row">';
    while ($FeaturedPost_query->have_posts()) : $FeaturedPost_query->the_post();
        $post = get_post();
        $title = get_the_title();
        $permalink = get_permalink();
        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), '275x150');
        $no_image_url = get_template_directory_uri() . "/images/no_image.png";
        $date = date($date_format, strtotime($post->post_date));
        $excerpt = "";
        if($instance['show_description'] == 1){
            $excerpt = '<div class="description">' . get_short_content(get_the_excerpt(), 156) . '</div>';
        }
        if($instance['number_posts'] == 3 or $instance['number_posts'] == 6){
            $html_output .= '<div class="col-sm-4 col-xs-6">';
        } else if($instance['number_posts'] == 4){
            $html_output .= '<div class="col-md-3 col-sm-6 col-xs-6">';
        }
        $html_output .= <<<HTML
            <div class="entry" itemscope="" itemtype="http://schema.org/Article">
                <a class="thumbnail" href="{$permalink}" onclick="ga('send', 'event', 'Xem tin', 'Xem tin', '{$title}');">
                    <img src="{$thumbnail_url}" alt="{$title}" itemprop="image" onError="this.src={$no_image_url}" />
                </a>
                <div class="entry-meta">
                    <i class="fa fa-calendar"></i> 
                    <span itemprop="datePublished">{$date}</span>
                </div>
                <h3 class="entry-title" itemprop="name">
                    <a href="{$permalink}" itemprop="url" onclick="ga('send', 'event', 'Xem tin', 'Xem tin', '{$title}');">{$title}</a>
                </h3>
                {$excerpt}
            </div>
        </div>
HTML;
    endwhile;
    wp_reset_query();
    $html_output .= "</div></div>";

    return $html_output;
}

add_shortcode('ppo-featured-posts', 'ppo_shortcode_featured_posts');


