<?php

class Product_Categories_List_Widget extends WP_Widget {

    function Product_Categories_List_Widget() {
        $widget_ops = array('classname' => 'product-categories-list-widget', 'description' => __('Display product categories as list.'));
        $control_ops = array('id_base' => 'product_categories_list_widget');
        parent::__construct('product_categories_list_widget', 'PPO: Product Categories List', $widget_ops, $control_ops);
    }

    /**
     * Display product categories
     *
     * @param array $instance current settings of widget .
     * @param array $args of widget area
     */
    function widget($args, $instance) {
        global $post;
        extract($args);

        $title = apply_filters('title', $instance['title']);
        $term_id = trim($instance["cat"]);
        if($term_id > 0) {
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
                'taxonomy' => 'product_category',
                'show_count' => 1,
                'hide_empty' => 0,
                'echo' => 0,
                'title_li' => '',
                'use_desc_for_title' => 0,
            );
            if($term_id > 0) {
                $args['child_of'] = $term_id;
            }
            echo '<ul>' . wp_list_categories($args) . '</ul>';
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
                'taxonomy' => 'product_category',
                'name' => $this->get_field_name("cat"), 
                'hide_empty' => 0, 
                'selected' => $instance["cat"],
                'hierarchical' => true,
                'class' => 'widefat',
            ));
            ?>
        </p>
        <?php
    }

}

register_widget('Product_Categories_List_Widget');