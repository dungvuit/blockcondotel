<?php

class PopularUsers_Widget extends WP_Widget {

    function PopularUsers_Widget() {
        $widget_ops = array('classname' => 'popular-users-widget', 'description' => 'Thành viên nổi bật.');
        $control_ops = array('id_base' => 'popular_users_widget');
        parent::__construct($control_ops['id_base'], 'PPO: Popular Users', $widget_ops, $control_ops);
    }

    function form($instance) {
        $defaults = array('title' => __('Thành viên nổi bật', SHORT_NAME), 'number' => 10);
        $instance = wp_parse_args((array) $instance, $defaults);

        $display = '<p><label for="' . $this->get_field_id('title') . '">Title:</label>
			<input id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" value="' . $instance['title'] . '" class="widefat" />
		</p><p>
			<label for="' . $this->get_field_id('number') . '">Number:</label>
		</p><p>	
			<input id="' . $this->get_field_id('number') . '" name="' . $this->get_field_name('number') . '" value="' . $instance['number'] . '" class="widefat" />
		</p>';
        print $display;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = $new_instance['number'];
        return $instance;
    }

    function widget($args, $instance) {
        extract($args);

        $title = apply_filters('widget_title', $instance['title']);
        $number = $instance['number'];

        print $before_widget;
        if ($title) {
            print $before_title . $title . $after_title;
        }

        $count_users = count_users();
        $total_users = $count_users['avail_roles']['contributor'];
        $paged = get_query_var('paged');
        $args = array(
            'role'         => 'contributor',
            'orderby'      => 'post_count',
            'order'        => 'DESC',
            'number'       => $number,
            'fields'       => 'all',
            'offset'       => $paged ? ($paged - 1) * $number : 0,
        );
        $users = get_users( $args );
        echo '<div class="widget-content">';
        foreach($users as $user):
            $permalink = get_author_posts_url( $user->ID );
            $display_name = $user->user_lastname . ' ' . $user->user_firstname;
            if(empty($display_name)){
                $display_name = $user->display_name;
            }
            $phone = get_the_author_meta( 'phone', $user->ID );
            if(empty($phone)) $phone = get_option(SHORT_NAME . "_hotline");

            $website = get_the_author_meta( 'url', $user->ID );
            if(empty($website)) $website = "#";

            $fbURL = get_the_author_meta( 'facebook', $user->ID );
            if(empty($fbURL)) $fbURL = get_option(SHORT_NAME . "_fbURL");

            $googlePlusURL = get_the_author_meta( 'googleplus', $user->ID );
            if(empty($googlePlusURL)) $googlePlusURL = get_option(SHORT_NAME . "_googlePlusURL");

            $twitterURL = get_the_author_meta( 'twitter', $user->ID );
            if(empty($twitterURL)) $twitterURL = get_option(SHORT_NAME . "_twitterURL");
            
            $md5 = md5($user->user_email);
            $avatar = "<img alt=\"{$display_name}\" src=\"http://2.gravatar.com/avatar/{$md5}?s=100&amp;d=mm&amp;r=g\" 
                        srcset=\"http://2.gravatar.com/avatar/{$md5}?s=192&amp;d=mm&amp;r=g 2x\" itemprop=\"image\" />";
            if(!validate_gravatar($user->user_email)){
                $first_char = mb_substr($display_name, 0, 2);
                $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                $color = $rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
                $avatar = '<span class="avatar-bg" style="background:#'.$color.'"><span class="avatar-first-char">'. strtoupper($first_char).'</span></span>';
            }
            echo <<<HTML
            <div class="item" itemscope="" itemtype="http://schema.org/Person">
                <div class="row">
                    <div class="col-sm-4">
                        <a class="avatar" href="{$permalink}" onclick="ga('send', 'event', 'Thành viên', 'Xem thành viên', '{$display_name}');">
                            {$avatar}
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <h3 itemprop="name">{$display_name}</h3>
                        <ul class="socials">
                            <li class="facebook"><a target="_self" href="{$fbURL}"><i class="fa fa-facebook"></i></a></li>
                            <li class="gplus"><a target="_self" href="{$googlePlusURL}"><i class="fa fa-google-plus"></i></a></li>
                            <li class="twitter"><a target="_self" href="{$twitterURL}"><i class="fa fa-twitter"></i></a></li>
                            <li class="website"><a href="{$website}" target="_blank"><i class="fa fa-link"></i></a></li>
                            <li class="email"><a href="mailto:{$user->user_email}"><i class="fa fa-envelope"></i></a></li>
                            <li class="phone"><a href="tel:{$phone}"><i class="fa fa-phone"></i></a></li>
                        </ul>
                        <a href="{$permalink}" class="xem-them">Xem thêm</a>
                    </div>
                </div>
            </div>
HTML;
        endforeach;
        echo '</div>';
        print $after_widget;
    }

}

register_widget('PopularUsers_Widget');