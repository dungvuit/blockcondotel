<div class="one_column row mt10">
    <div class="col-md-6 col-md-6 col-xs-12">
        <div class="box">
            <?php
            $args = array(
                'post_type' => 'post',
                'tag' => 'tin-hot',
                'posts_per_page' => 10
            );
            $query = new WP_Query($args);
            $count = 1;
            ?>
            <div class="box-title title-tuvanluat">
                <h3>
                    <a title="Phong thủy" href="#">Tư vấn luật</a>
                </h3>
            </div>
            <div class="box_news">
                <?php 
                    while ($query->have_posts()) : $query->the_post();
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
    <div class="col-md-6 col-md-6 col-xs-12">
        <div class="box">
            <?php
            $args = array(
                'post_type' => 'post',
                'tag' => 'tin-hot',
                'posts_per_page' => 10
            );
            $query = new WP_Query($args);
            $count = 1;
            ?>
            <div class="box-title title-thietkekientruc">
                <h3>
                    <a title="Phong thủy" href="#">Không gian sống</a>
                </h3>
            </div>
            <div class="box_news">
                <?php 
                    while ($query->have_posts()) : $query->the_post();
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
</div>


