<div class="two_column mt10">
    <?php
    $args = array(
        'post_type' => 'post',
        'tag' => 'tin-hot',
        'posts_per_page' => 10
    );
    $query = new WP_Query($args);
    $count = 1;
    ?>
    <div class="title-column title-phongthuy">
        <h3>
            <a title="Phong thủy" href="#">Phong thủy</a>
        </h3>
    </div>
    <div class="list_news row">
        <?php 
            while ($query->have_posts()) : $query->the_post();
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
<div class="clearfix"></div>
<div class="two_column mt10">
    <?php
    $args = array(
        'post_type' => 'post',
        'tag' => 'tin-hot',
        'posts_per_page' => 10
    );
    $query = new WP_Query($args);
    $count = 1;
    ?>
    <div class="title-column title-life">
        <h3>
            <a title="Phong thủy" href="#">Không gian sống</a>
        </h3>
    </div>
    <div class="list_news row">
        <?php 
            while ($query->have_posts()) : $query->the_post();
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


