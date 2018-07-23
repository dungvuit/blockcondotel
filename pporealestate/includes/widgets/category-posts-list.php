<?php

class Category_Posts_List_Widget extends WP_Widget {

    function Category_Posts_List_Widget() {
        $widget_ops = array('classname' => 'cat-posts-list-widget', 'description' => __('Show posts by category.'));
        $control_ops = array('id_base' => 'cat_posts_list_widget');
        parent::__construct('cat_posts_list_widget', 'PPO: Category Posts List', $widget_ops, $control_ops);
    }

    /**
     * Displays category posts widget on blog.
     *
     * @param array $instance current settings of widget .
     * @param array $args of widget area
     */
    function widget($args, $instance) {
        global $post;
        extract($args);

        $title = apply_filters('title', $instance['title']);
        $term_id = trim($instance["cat"]);
        if($term_id > 0):
            $category_info = get_category($term_id);
            // If not title, use the name of the category.
            if (!$instance['title']) {
                $title = $category_info->name;
            }

            echo $before_widget;
            // Widget title
            echo $before_title;
            echo $title;
            echo $after_title;
            ?>
            <div class="widget-content">
                <?php
                $date_format = get_option( 'date_format' );
                $time_format = get_option( 'time_format' );
                $cat_posts = new WP_Query(array(
                    'post_type' => 'post',
                    'showposts' => $instance["num"],
                    'cat' => $term_id,
                ));
                while ($cat_posts->have_posts()) : $cat_posts->the_post();
                ?>
                <div class="item">
                    <div class="thumbnail col-sm-3">
                        <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" rel="bookmark">
                            <?php the_post_thumbnail('thumbnail'); ?>
                        </a>
                    </div>
                    <div class="col-sm-9">
                        <h4><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                        <div class="entry-meta">
                            <span><?php the_time($time_format); ?></span> | 
                            <span itemprop="datePublished"><?php echo date($date_format, strtotime($post->post_date)); //the_date($date_format); ?></span>
                        </div>
                    </div>
                </div>
                <?php
                endwhile;
                wp_reset_query();
                ?>
            </div>
            <?php
            echo $after_widget;
        endif;
    }

    /**
     * Form processing...
     *
     * @param array $new_instance of widget .
     * @param array $old_instance of widget .
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['cat'] = $new_instance['cat'];
        $instance['num'] = $new_instance['num'];
        return $instance;
    }

    /**
     * The configuration form.
     *
     * @param array $instance of widget to display already stored value .
     * 
     */
    function form($instance) {
        ?>		
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', SHORT_NAME) ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        <p>
            <label><?php _e('Category', SHORT_NAME) ?></label><br />
            <?php 
            wp_dropdown_categories(array(
                'name' => $this->get_field_name("cat"), 
                'hide_empty' => 0, 
                'selected' => $instance["cat"],
                'hierarchical' => true,
                'class' => 'widefat',
            ));
            ?>
        </p>
        <p>
            <label><?php _e('Number', SHORT_NAME) ?></label><br />
            <input class="widefat" id="<?php echo $this->get_field_id("num"); ?>" name="<?php echo $this->get_field_name("num"); ?>" type="text" value="<?php echo intval($instance["num"]); ?>" />
        </p>
        <?php
    }

}

register_widget('Category_Posts_List_Widget');