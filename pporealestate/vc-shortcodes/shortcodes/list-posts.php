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
function ppo_shortcode_list_posts($atts) {

    $instance = shortcode_atts(array(
        'title' => '',
        'number_posts' => '4',
        'cat_id' => '',
        'orderby' => 'date',
        'order' => 'DESC',
        'image_size' => 'none',
        'layout' => 'list', // 'list', 'list_without_thumb', 'grid'
    ), $atts);
    
    $date_format = get_option( 'date_format' );
    $time_format = get_option( 'time_format' );
        
    $args = array(
        'post_type' => 'post',
        'showposts' => $instance['number_posts'],
        'orderby' => $instance['orderby'],
        'order' => $instance['order'],
    );
    if(!empty($instance['cat_id']) and $instance['cat_id'] > 0){
        $args['cat'] = $instance['cat_id'];
    }
    $Posts_query = new WP_Query($args);

    $html_output = '<div class="' . $instance['layout'] . '-posts-widget">';
    if (!empty($atts['title'])) {
        $html_output .= '<h3 class="widget-title">' . $instance['title'] . '</h3>';
    }
    $html_output .= '<div class="widget-content">';
    $count = 0;
    while ($Posts_query->have_posts()) : $Posts_query->the_post();
        $post = get_post();
        $title = get_the_title();
        $permalink = get_permalink();
        $large_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), '450x267');
        if($instance['image_size'] == 'none'){
            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), $instance['image_size']);
        }
        $no_image_url = get_template_directory_uri() . "/images/no_image.png";
        $date = date($date_format, strtotime($post->post_date));
        $time = get_the_time($time_format);
        $description = get_short_content(get_the_excerpt(), 300);
        if($count == 0){
            if($instance['layout'] == 'grid'){
                $html_output .= <<<HTML
                <div class="entry first" itemscope="" itemtype="http://schema.org/Article">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <a class="thumbnail" href="{$permalink}" onclick="ga('send', 'event', 'Xem tin', 'Xem tin', '{$title}');">
                                <img src="{$large_url}" alt="{$title}" itemprop="image" onError="this.src={$no_image_url}" />
                            </a>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <h3 class="entry-title" itemprop="name">
                                <a href="{$permalink}" itemprop="url" onclick="ga('send', 'event', 'Xem tin', 'Xem tin', '{$title}');">{$title}</a>
                            </h3>
                            <div class="entry-meta">
                                <i class="fa fa-calendar"></i> 
                                <span>{$time}</span> | <span itemprop="datePublished">{$date}</span>
                            </div>
                            <div class="description" itemprop="description">{$description}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
HTML;
            } else {
                $html_output .= <<<HTML
                <div class="row">
                    <div class="col-md-6">
                        <div class="entry first" itemscope="" itemtype="http://schema.org/Article">
                            <a class="thumbnail" href="{$permalink}" onclick="ga('send', 'event', 'Xem tin', 'Xem tin', '{$title}');">
                                <img src="{$large_url}" alt="{$title}" itemprop="image" onError="this.src={$no_image_url}" />
                            </a>
                            <h3 class="entry-title" itemprop="name">
                                <a href="{$permalink}" itemprop="url" onclick="ga('send', 'event', 'Xem tin', 'Xem tin', '{$title}');">{$title}</a>
                            </h3>
                            <div class="entry-meta">
                                <i class="fa fa-calendar"></i> 
                                <span>{$time}</span> | <span itemprop="datePublished">{$date}</span>
                            </div>
                            <div class="description" itemprop="description">{$description}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
HTML;
            }
        } else {
            if($instance['layout'] == 'grid'){
                $html_output .= <<<HTML
                <div class="col-xs-6 col-sm-4 col-md-4">
                    <div class="entry" itemscope="" itemtype="http://schema.org/Article">
                        <a class="thumbnail" href="{$permalink}" onclick="ga('send', 'event', 'Xem tin', 'Xem tin', '{$title}');">
                            <img src="{$thumbnail_url}" alt="{$title}" itemprop="image" onError="this.src={$no_image_url}" />
                        </a>
                        <div class="entry-meta">
                            <i class="fa fa-calendar"></i> 
                            <span>{$time}</span> | <span itemprop="datePublished">{$date}</span>
                        </div>
                        <h3 class="entry-title" itemprop="name">
                            <a href="{$permalink}" itemprop="url" onclick="ga('send', 'event', 'Xem tin', 'Xem tin', '{$title}');">{$title}</a>
                        </h3>
                    </div>
                </div>
HTML;
            } else if($instance['layout'] == 'list'){
                $html_output .= <<<HTML
                <div class="row entry" itemscope="" itemtype="http://schema.org/Article">
                    <div class="col-sm-4">
                        <a class="thumbnail" href="{$permalink}" onclick="ga('send', 'event', 'Xem tin', 'Xem tin', '{$title}');">
                            <img src="{$thumbnail_url}" alt="{$title}" itemprop="image" onError="this.src={$no_image_url}" />
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <h3 class="entry-title" itemprop="name">
                            <a href="{$permalink}" itemprop="url" onclick="ga('send', 'event', 'Xem tin', 'Xem tin', '{$title}');">{$title}</a>
                        </h3>
                        <div class="entry-meta">
                            <i class="fa fa-calendar"></i> 
                            <span>{$time}</span> | <span itemprop="datePublished">{$date}</span>
                        </div>
                    </div>
                </div>
HTML;
            } else {
                $html_output .= <<<HTML
                <div class="entry" itemscope="" itemtype="http://schema.org/Article">
                    <h3 class="entry-title" itemprop="name">
                        <a href="{$permalink}" itemprop="url" onclick="ga('send', 'event', 'Xem tin', 'Xem tin', '{$title}');">{$title}</a>
                    </h3>
                    <div class="entry-meta">
                        <i class="fa fa-calendar"></i> 
                        <span>{$time}</span> | <span itemprop="datePublished">{$date}</span>
                    </div>
                </div>
HTML;
            }
        }
        $count++;
    endwhile;
    if($Posts_query->post_count > 0){
        if($instance['layout'] == 'grid'){
            $html_output .= '</div>';
        } else {
            $html_output .= "</div></div>";
        }
    }
    wp_reset_query();
    $html_output .= "</div></div>";

    return $html_output;
}

add_shortcode('ppo-list-posts', 'ppo_shortcode_list_posts');


