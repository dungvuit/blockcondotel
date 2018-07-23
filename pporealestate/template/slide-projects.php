<div class="content-right">
    <div class="project-hl">
        <div class="hl-title">
            <h3 class="title_vip">Dự án nổi bật</h3>
        </div>

        <div class="wr_project">
            <div class="wr_slide">
                <div class="slideproject">
                    <div id="sliderA" class="slider">
                        <?php
                        $args = array(
                            'post_type' => 'project',
                            'tag' => 'vip',
                            'posts_per_page' => 3
                        );
                        $projects = new WP_Query($args);
                        while ($projects->have_posts()) : $projects->the_post();
                        ?>
                            <div>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <img src="<?php the_post_thumbnail_url('347x232') ?>" alt="<?php the_title(); ?>" /></a>
                                <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
                                <p><?php echo get_post_meta(get_the_ID(), "khu_vuc", true); ?></p>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_query();
                        ?>

                    </div>
                </div>
            </div>
            <div class="thumbSlide">
                <div class="listproject">
                    <?php
                    $count = 0;
                    while ($projects->have_posts()) : $projects->the_post();
                    ?>
                        <div rel="<?php echo $count; ?>" class="item">
                            <a class="tt_project" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <img class="avatar" src="<?php the_post_thumbnail_url('104x69') ?>" alt="<?php the_title(); ?>" /></a>
                            <div class="info_project">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                <p><?php echo get_post_meta(get_the_ID(), "vi_tri", true); ?></p>
                            </div>
                        </div>
                        <?php
                        $count++;
                    endwhile;
                    wp_reset_query();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>