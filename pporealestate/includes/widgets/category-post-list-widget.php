<?php

class Category_Post_List_widget extends WP_Widget {

    function Category_Post_List_widget() {
        $widget_ops = array('classname' => 'category-post-list-widget', 'description' => 'Display post under particular category.');
        $control_ops = array('id_base' => 'category_post_list_widget');
        parent::__construct($control_ops['id_base'], 'PPO: Category Post List', $widget_ops, $control_ops);
    }

    /**
     * Displays category posts widget on blog.
     *
     * @param array $instance current settings of widget .
     * @param array $args of widget area
     */
    function widget($args, $instance) {
        global $post;
        $post_old = $post; // Save the post object.
        extract($args);

        $term_id = trim($instance["cat"]);
        $icon = $instance["icon"];
        $layout = $instance["layout"];
        $order = $instance["order"];
        $category_info = get_category($term_id);
        // If not title, use the name of the category.
        if (!$instance["widget_title"]) {
            $instance["widget_title"] = $category_info->name;
        }
        //1 cot
        if($layout == "1column"){
            if($order == "1"){
            echo "<div class='one_column row mt10'>";
            }
        ?>		
            <div class="col-md-6 col-md-6 col-xs-12">
                <div class="box">
                    <?php
                    // Widget title
                    echo $before_title;
                    echo "<div class='box-title'><h3><span class='glyphicon ".$icon."' aria-hidden='true'></span> <a href='".$category_info->slug."'>".$instance["widget_title"]."</a></h3></div>";
                    echo $after_title;
                    ?>
                    <div class="box_news">
                        <?php
                            $cat_posts = new WP_Query(array(
                                'showposts' => 6,
                                'cat' => $term_id,
                            ));
                            $count = 1;
                            while ($cat_posts->have_posts()) : $cat_posts->the_post();
                            if ($count == 1) { 
                        ?>
                        <div class="box-hot">
                        <a title="<?php the_title(); ?>" class="avatar" href="<?php the_permalink(); ?>">
                            <img alt="<?php the_title(); ?>" src="<?php echo get_image_url(true, '318x204'); ?>"/></a>
                        <h3><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        </div>
                        <div class="clearfix"></div>
                        <div class="list_box">
                            <ul>
                               <?php  }else {?>
                                <li >
                                    <h3><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                </li>
                                <?php 
                                }
                                $count++;
                                endwhile;
                                wp_reset_query();
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>  
        <?php 
            if($order == "2"){
            echo "</div>";
            }
        }else {     
        ?>
        <div class="two_column mt10">
            <?php
                // Widget title
            echo $before_title;
            echo "<div class='title-column'><h3><span class='glyphicon ".$icon."' aria-hidden='true'></span> <a href='".$category_info->slug."'>".$instance["widget_title"]."</a></h3></div>";
            echo $after_title;
            ?>
            <div class="list_news row">
                <?php
                $cat_posts = new WP_Query(array(
                    'showposts' => 6,
                    'cat' => $term_id,
                ));
                $count = 1;
                while ($cat_posts->have_posts()) : $cat_posts->the_post();
                if ($count == 1) { 
                ?>
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <div class="news-hot">
                    <a title="<?php the_title(); ?>" class="avatar" href="<?php the_permalink(); ?>">
                        <img alt="<?php the_title(); ?>" src="<?php echo get_image_url(true, '318x204'); ?>"/></a>
                    <h4><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    </div>
                </div>

                <div class="col-md-5 col-sm-5 col-xs-12">
                    <div class="list_top">
                        <ul>
                           <?php  }else {?>
                            <li >
                                <h3><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            </li>
                            <?php 
                            }
                            $count++;
                            endwhile;
                            wp_reset_query();
                            ?>
                        </ul>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <?php
        } 
        $post = $post_old; // Restore the post object.
    }

    /**
     * Form processing...
     *
     * @param array $new_instance of widget .
     * @param array $old_instance of widget .
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['widget_title'] = $new_instance['widget_title'];
        $instance['cat'] = $new_instance['cat'];
        $instance['icon'] = $new_instance['icon'];
        $instance['layout'] = $new_instance['layout'];
        $instance['order'] = $new_instance['order'];
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
            <label for="<?php echo $this->get_field_id("widget_title"); ?>">Tiêu đề</label>
            <input class="widefat" id="<?php echo $this->get_field_id("widget_title"); ?>" name="<?php echo $this->get_field_name("widget_title"); ?>" type="text" value="<?php echo esc_attr($instance["widget_title"]); ?>" />
        </p>
        <p>
            <label>Chuyên mục</label><br />
            <?php wp_dropdown_categories(array('name' => $this->get_field_name("cat"), 'show_option_all' => 'All', 'hide_empty' => 0, 'selected' => $instance["cat"])); ?>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("icon"); ?>">Icon</label>
            <input class="widefat" id="<?php echo $this->get_field_id("icon"); ?>" name="<?php echo $this->get_field_name("icon"); ?>" type="text" value="<?php echo esc_attr($instance["icon"]); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("layout"); ?>">Layout</label>
            <?php
            $array_styles = array(
                '1column' => '1 cột',
                '2column' => '2 cột '
            );
            ?>
            <select name="<?php echo $this->get_field_name("layout"); ?>">
                <?php
                foreach ($array_styles as $key => $value) {
                    if ($instance["layout"] == $key)
                        echo '<option value="' . $key . '" selected>' . $value . '</option>';
                    else
                        echo '<option value="' . $key . '">' . $value . '</option>';
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("order"); ?>">Với layout 1 cột có 2 giá trị để ghi vào ô là 1 hoặc 2</label>
            <input class="widefat" id="<?php echo $this->get_field_id("order"); ?>" name="<?php echo $this->get_field_name("order"); ?>" type="text" value="<?php echo esc_attr($instance["order"]); ?>" />
        </p>
        <?php
    }

}

register_widget('Category_Post_List_widget');