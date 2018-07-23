<?php get_header(); ?>
<div class="container main_content">
    <?php while (have_posts()) : the_post(); ?>
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb30">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="row">
        <div class="left col-md-8">
            <div class="products">
                <div class="section-header">
                    <div class="list-header">
                        <h1 class="page-title">
                            <?php the_title();?>
                        </h1>
                    </div>
                </div>
                <div class="content-page">
                    <?php the_content();?>
                </div>
                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) {
                    comments_template();
                }
                ?>
            </div>
        </div>
        <div class="right sidebar col-md-4 hidden-sm hidden-xs">
            <?php get_sidebar(); ?>
        </div>
    </div>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>
