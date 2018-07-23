<div class="most-read">
    <div class="title">
        <h3>Tin xem nhiều </h3>
    </div>
    <ul>
        <?php
        $args = array(
            'post_type' => 'post',
            'orderby' => 'post_views',
            'order' => 'ASC',
            'posts_per_page' => 10
        );
        $query = new WP_Query($args);
        while ($query->have_posts()) : $query->the_post();
            ?>
            <li>
                <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
            </li>
            <?php
        endwhile;
        wp_reset_query();
        ?>     
    </ul>
</div>

<?php get_template_part('template/slide-projects'); ?>