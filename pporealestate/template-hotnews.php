<?php
$args = array(
    'post_type' => 'post',
    'tag' => 'tin-hot',
    'posts_per_page' => 6
);
$query = new WP_Query($args);
$count = 1;
?>
<div class="news row">
    <?php 
        while ($query->have_posts()) : $query->the_post();
        if ($count == 1) { 
    ?>
    <div class="col-md-7 col-sm-7 col-xs-12">
        <div class="news-left">
        <a title="<?php the_title(); ?>" class="avatar" href="<?php the_permalink(); ?>">
            <img alt="<?php the_title(); ?>" src="<?php echo get_image_url(true, '400x250'); ?>"/></a>
        <h2><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </div>
    </div>
    <div class="col-md-5 col-sm-5 col-xs-12">
        <div class="news-right">
            <ul>
               <?php  }else {?>
                <li>
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