<?php

class Project_List_Widget extends WP_Widget {

    function Project_List_Widget() {
        $widget_ops = array('classname' => 'project-list-widget', 'description' => __('Display projects as list.'));
        $control_ops = array('id_base' => 'project_list_widget');
        parent::__construct('project_list_widget', 'PPO: Project List', $widget_ops, $control_ops);
    }

    /**
     * Displays projects widget on blog.
     *
     * @param array $instance current settings of widget .
     * @param array $args of widget area
     */
    function widget($args, $instance) {
        global $post;
        extract($args);

        $title = apply_filters('title', $instance['title']);
        $term_id = trim($instance["cat"]);
        if($term_id > 0){
            $category_info = get_category($term_id);
            // If not title, use the name of the category.
            if (!$instance['title']) {
                $title = $category_info->name;
            }
        }
        echo $before_widget;
        // Widget title
        echo $before_title;
        echo $title;
        echo $after_title;
        ?>
        <div class="widget-content">
            <?php
            $args = array(
                'post_type' => 'project',
                'showposts' => $instance["num"],
                'cat' => $term_id,
            );
            if($term_id > 0){
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'project_category',
                        'field'    => 'term_id',
                        'terms'    => $term_id,
                    ),
                );
            }
            $cat_posts = new WP_Query($args);
            while ($cat_posts->have_posts()) : $cat_posts->the_post();
                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), '170x115');
                $no_image_url = get_template_directory_uri() . "/assets/images/no_image.png";
                $khu_vuc = get_post_meta(get_the_ID(), "khu_vuc", true);
            ?>
            <div class="entry" itemscope="" itemtype="http://schema.org/Article">
                <div class="col-sm-3 pdl0 pdr0">
                    <a class="thumbnail" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" rel="bookmark" 
                       onclick="ga('send', 'event', 'Dự án', 'Xem dự án', '<?php the_title(); ?>');">
                        <img src="<?php echo $thumbnail_url ?>" alt="<?php the_title(); ?>" itemprop="image" 
                             onError="this.src=<?php echo $no_image_url ?>" />
                    </a>
                </div>
                <div class="col-sm-9">
                    <h3 class="entry-title" itemprop="name">
                        <a href="<?php the_permalink(); ?>" rel="bookmark" itemprop="url" 
                           onclick="ga('send', 'event', 'Dự án', 'Xem dự án', '<?php the_title(); ?>');"><?php the_title(); ?></a>
                    </h3>
                    <p class="location"><?php echo $khu_vuc ?></p>
                </div>
            </div>
            <?php
            endwhile;
            wp_reset_query();
            ?>
        </div>
        <?php
        echo $after_widget;
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
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Tiêu đề', SHORT_NAME) ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        <p>
            <label><?php _e('Danh mục', SHORT_NAME) ?></label><br />
            <?php 
            wp_dropdown_categories(array(
                'show_option_all' => __('Tất cả', SHORT_NAME),
                'taxonomy' => 'project_category',
                'name' => $this->get_field_name("cat"), 
                'hide_empty' => 0, 
                'selected' => $instance["cat"],
                'hierarchical' => true,
                'class' => 'widefat',
            ));
            ?>
        </p>
        <p>
            <label><?php _e('Số lượng', SHORT_NAME) ?></label><br />
            <input class="widefat" id="<?php echo $this->get_field_id("num"); ?>" name="<?php echo $this->get_field_name("num"); ?>" type="text" value="<?php echo intval($instance["num"]); ?>" />
        </p>
        <?php
    }

}

register_widget('Project_List_Widget');