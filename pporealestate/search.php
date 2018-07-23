<?php
get_header();
?>

<div class="container main_content">
    <div class="banner_logo mt10 mb30">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="row">
        <div class="left col-md-8">
            <div class="products">
                <div class="section-header">
                    <div class="list-header">
                        <h2 class="span-title">KẾT QUẢ TÌM KIẾM</h2>
                    </div>
                </div>
                <div class="list_product">
                    <?php 
                    while (have_posts()) : the_post(); 
                        get_template_part('template', 'product_item');
                    endwhile;
                    getpagenavi();
                    ?>
                </div>
            </div>
        </div>
        <!--END COLUMN MAIN-->

        <div class="right sidebar col-md-4 hidden-sm hidden-xs">
            <?php get_template_part('template', 'sidebarsearch'); ?>
            <?php if ( is_active_sidebar( 'sidebar_archive' ) ) { dynamic_sidebar( 'sidebar_archive' ); } ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>