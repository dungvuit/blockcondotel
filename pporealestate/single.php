<?php 
get_header(); ?>
<div class="container main_content">
    <?php while (have_posts()) : the_post(); ?>
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    
    <div class="row">
        <div class="left col-md-8 col-sm-8 col-xs-12">
            <div class="single_post">
                <h1 class="title_post"><?php the_title(); ?></h1>
                <div class="post_description">
                    <div class="entry-meta">
                        <span class="date"><i class="fa fa-calendar"></i> Ngày đăng: <?php the_time('d/m/Y'); ?> </span> 
                        <span class="post-views-icon dashicons  dashicons-chart-bar"></span>
                        <span class="post-views-label">Lượt xem: </span>
                        <span class="post-views-count">
                            <?php 
                            if(function_exists('pvc_get_post_views')):
                                echo pvc_get_post_views(get_the_ID());
                            endif;
                            ?>
                        </span>
                    </div>
                    <?php the_content();?>
                </div>
                <div class="post-tags">
                    <?php the_tags( '<span class="glyphicon glyphicon-tags"></span> Tags: ', ', ' ); ?>
                </div> 
                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) {
                    comments_template();
                }
                ?>
            </div>
            <?php endwhile; ?>
            <div class="related">
                <h3>Bạn nên đọc</h3>
                <ul class="pdl0">
                    <?php
                    $loop = new WP_Query(array(
                        'post_type' => 'post',
                        'orderby' => 'rand',
                        'post__not_in' => array(get_the_ID()),
                    ));
                    while ($loop->have_posts()) : $loop->the_post();
                        ?>
                        <li>
                            <a title="<?php the_title(); ?>" rel="bookmark" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </li>
                        <?php
                    endwhile;
                    wp_reset_query();
                    ?>
                </ul>
            </div> 
        </div>
        <div class="right sidebar col-md-4 col-sm-4 col-xs-12">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>