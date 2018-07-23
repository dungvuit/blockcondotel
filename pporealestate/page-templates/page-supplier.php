<?php 
/*
  Template Name: Nhà cung cấp
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
                <h1 class="span-title">Nhà cung cấp</h1>
            </div>
        </div>
        <div class="supplier_list">
            <div class="row">
                <?php 
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array(
                    'post_type' => 'supplier',
                    'paged' => $paged,
                    'posts_per_page' => 12,
                );
                $query = new WP_Query($args);
                while ($query->have_posts()) : $query->the_post();
                    $title = get_the_title();
                    $permalink = get_permalink();
                    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    $no_image_url = get_template_directory_uri() . "/images/no_image.png";
                    echo <<<HTML
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="entry" itemscope="" itemtype="http://schema.org/Article">
                            <a class="thumbnail" href="{$permalink}" onclick="ga('send', 'event', 'Nhà cung cấp', 'Xem nhà cung cấp', '{$title}');">
                                <img src="{$thumbnail_url}" alt="{$title}" itemprop="image" onError="this.src={$no_image_url}" />
                            </a>
                            <h3 class="entry-title" itemprop="name">
                                <a href="{$permalink}" itemprop="url" onclick="ga('send', 'event', 'Nhà cung cấp', 'Xem nhà cung cấp', '{$title}');">{$title}</a>
                            </h3>
                        </div>
                    </div>
HTML;
                endwhile;
                wp_reset_query();
                getpagenavi(array('query' => $query));
                ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
