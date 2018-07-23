<?php get_header(); ?>
<div class="container main_content">
    <?php while (have_posts()) : the_post(); ?>
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb10">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="row">
        <div class="left col-md-8 col-sm-8 col-xs-12">
            <div class="single_product">
                <h1 class="title_product"><?php the_title(); ?></h1>
                <div class="description">
                    <div class="main_des pdb30">
                        <?php the_content();?>
                    </div>
                    <?php endwhile; ?>
                    <div class="related_product">
                        <div class="title-pro">
                            <h3>
                                <span>Các dự án thuộc <?php the_title(); ?></span>
                            </h3>  
                        </div>
                        <div class="carousel-products-widget product-grid-container">
                            <div class="row">
                            <?php
                            $loop = new WP_Query(array(
                                'post_type' => 'project',
                                'posts_per_page' => -1,
                                'meta_query' => array(
                                    array(
                                        'key' => 'supplier',
                                        'value' => get_the_ID(),
                                    ),
                                ),
                            ));
                            while ($loop->have_posts()) : $loop->the_post();
                                echo '<div class="col-xs-6">';
                                get_template_part('template', 'project_item2');
                                echo '</div>';
                            endwhile;
                            wp_reset_query();
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="right sidebar col-md-4 col-sm-4 col-xs-12">
            <?php get_template_part('template', 'sidebarsearch'); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>