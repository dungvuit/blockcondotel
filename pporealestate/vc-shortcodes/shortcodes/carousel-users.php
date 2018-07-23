<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Carousel Users
 *
 * @param $atts
 *
 * @return string
 */
function ppo_shortcode_carousel_users($atts) {

    $instance = shortcode_atts(array(
        'title' => '',
    ), $atts);

    $html_output = '<div class="carousel-users-widget">';
    if (!empty($atts['title'])) {
        $html_output .= '<h3 class="widget-title">' . $instance['title'] . '</h3>';
    }
    $html_output .= '<div class="owl-carousel">';
    $args = array(
//	'blog_id'      => $GLOBALS['blog_id'],
	'role'         => 'contributor',
//	'role__in'     => array(),
//	'role__not_in' => array(),
//	'meta_key'     => '',
//	'meta_value'   => '',
//	'meta_compare' => '',
//	'meta_query'   => array(),
//	'date_query'   => array(),
//	'include'      => array(),
//	'exclude'      => array(),
	'orderby'      => 'post_count',
	'order'        => 'DESC',
	'number'       => 10,
	'fields'       => 'all',
//	'offset'       => '',
//	'search'       => '',
//	'count_total'  => false,
//	'who'          => '',
    );
    $users = get_users( $args );
    foreach($users as $user):
        $permalink = get_author_posts_url( $user->ID );
        $display_name = $user->user_lastname . ' ' . $user->user_firstname;
        if(empty($display_name)){
            $display_name = $user->display_name;
        }
        $phone = get_the_author_meta( 'phone', $user->ID );
        if(empty($phone)) $phone = __('Đang cập nhật', SHORT_NAME);
        $website = get_the_author_meta( 'url', $user->ID );
        if(empty($website)) $website = __('Đang cập nhật', SHORT_NAME);
        $md5 = md5($user->user_email);
        $avatar = "<img alt=\"{$display_name}\" src=\"http://2.gravatar.com/avatar/{$md5}?s=150&amp;d=mm&amp;r=g\" 
                    srcset=\"http://2.gravatar.com/avatar/{$md5}?s=192&amp;d=mm&amp;r=g 2x\" itemprop=\"image\" />";
        if(!validate_gravatar($user->user_email)){
            $first_char = mb_substr($display_name, 0, 2);
//            $color = dechex(rand(0x000000, 0xFFFFFF));
//            while ($color === "ffffff") {
//                $color = dechex(rand(0x000000, 0xFFFFFF));
//            }
            $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
            $color = $rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
            $avatar = '<span class="avatar-bg" style="background:#'.$color.'"><span class="avatar-first-char">'. strtoupper($first_char).'</span></span>';
        }
        $html_output .= <<<HTML
        <div class="item" itemscope="" itemtype="http://schema.org/Person">
            <a class="avatar" href="{$permalink}" onclick="ga('send', 'event', 'Thành viên', 'Xem thành viên', '{$display_name}');">
                {$avatar}
            </a>
            <h3 itemprop="name">{$display_name}</h3>
            <p><strong>M: </strong>{$phone}</p>
            <p><strong>E: </strong>{$user->user_email}</p>
            <p><strong>W: </strong>{$website}</p>
            <a href="{$permalink}" class="xem-them">Xem thêm</a>
        </div>
HTML;
    endforeach;
    $html_output .= "</div></div>";

    return $html_output;
}

add_shortcode('ppo-carousel-users', 'ppo_shortcode_carousel_users');


