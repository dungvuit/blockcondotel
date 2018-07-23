<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display popular projects
 *
 * @param $atts
 *
 * @return string
 */
function ppo_shortcode_popular_projects($atts) {

    $instance = shortcode_atts(array(
        'title' => '',
        'cat_id' => '',
        'number_posts' => '4',
        'show_description' => 0,
        'orderby' => 'date',
        'order' => 'DESC',
    ), $atts);

    $args = array(
        'post_type' => 'project',
        'showposts' => $instance['number_posts'],
        'orderby' => $instance['orderby'],
        'order' => $instance['order'],
    );
    if(!empty($instance['cat_id']) and $instance['cat_id'] > 0){
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'project_category',
                'field'    => 'term_id',
                'terms'    => $instance['cat_id'],
            ),
	);
    }
    $loop_query = new WP_Query($args);
    
    $html_output = '<div class="popular-projects-widget">';
    if (!empty($atts['title'])) {
        $html_output .= '<h3 class="widget-title">' . $instance['title'] . '</h3>';
    }
    $html_output .= '<div class="row">';
    while ($loop_query->have_posts()) : $loop_query->the_post();
        $title = get_the_title();
        $permalink = get_permalink();
        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), '347x232');
        $no_image_url = get_template_directory_uri() . "/assets/images/no_image.png";
        $khu_vuc = get_post_meta(get_the_ID(), "khu_vuc", true);
        $excerpt = "";
        if($instance['show_description'] == 1){
            $excerpt = '<div class="description">' . get_short_content(get_the_excerpt(), 156) . '</div>';
        }
        $html_output .= <<<HTML
<div class="col-md-3 col-sm-6 col-xs-6">
    <div class="entry" itemscope="" itemtype="http://schema.org/Article">
        <a class="thumbnail" href="{$permalink}" onclick="ga('send', 'event', 'Dự án', 'Xem dự án', '{$title}');">
            <img src="{$thumbnail_url}" alt="{$title}" itemprop="image" onError="this.src={$no_image_url}" />
        </a>
        <h3 class="entry-title" itemprop="name">
            <a href="{$permalink}" itemprop="url" onclick="ga('send', 'event', 'Dự án', 'Xem dự án', '{$title}');">{$title}</a>
        </h3>
        <p class="location">{$khu_vuc}</p>
        {$excerpt}
    </div>
</div>
HTML;
    endwhile;
    wp_reset_query();
    $html_output .= "</div></div>";

    return $html_output;
}

add_shortcode('ppo-popular-projects', 'ppo_shortcode_popular_projects');


