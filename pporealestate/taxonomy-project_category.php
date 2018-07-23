<?php 
$taxonomy = 'project_category';
$term = get_queried_object();
$term_id = $term->term_id;
$tax_meta = get_option("cat_{$term->term_id}");
get_header(); 
?>
<div class="container main_content">
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
                        <h1 class="span-title"><?php single_cat_title() ?></h1>
                    </div>
                </div>
                <div class="list_product">
                    <?php 
                    while (have_posts()) : the_post(); 
                        get_template_part('template', 'project_item');
                    endwhile;
                    getpagenavi();
                    ?>
                </div>
            </div>
        </div>
        <div class="right sidebar col-md-4 hidden-sm hidden-xs">
            <?php get_template_part('template', 'sidebarsearch'); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
