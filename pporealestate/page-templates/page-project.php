<?php 
/*
  Template Name: Project
 */
get_header(); 
?>
<div class="container main_content">
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb30">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="products">
        <div class="section-header">
            <div class="list-header">
                <h1 class="span-title">Dự án bất động sản</h1>
            </div>
        </div>
        <div class="carousel-products-widget product-grid-container">
            <div class="row">
            <?php 
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $products_per_page = intval(get_option(SHORT_NAME . "_product_pager"));
            $args = array(
                'post_type' => 'project',
                'paged' => $paged,
                'posts_per_page' => $products_per_page,
            );
            $query = new WP_Query($args);
            while ($query->have_posts()) : $query->the_post();
                echo '<div class="col-sm-4 col-xs-6">';
                get_template_part('template', 'project_item2');
                echo '</div>';
            endwhile;
            wp_reset_query();
            getpagenavi(array('query' => $query));
            ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
