<?php get_header(); ?>
<div class="top_search">
    <div class="search">
        <div class="container">
            <?php get_template_part('template', 'search'); ?>
        </div>
    </div>
</div>
<div class="container main_content">
    <div class="banner_logo mb10">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="row">
        <div class="left col-md-8 col-sm-8">
            <?php get_template_part('template', 'hotnews'); ?>
            <div class="products mt10">
                <?php get_template_part('template', 'vip'); ?>
            </div>
            <div class="products">
                <?php get_template_part('template', 'new'); ?>
            </div>
            <div class="clearfix"></div>
            <?php if ( is_active_sidebar( 'posthomesidebar' ) ) { dynamic_sidebar( 'posthomesidebar' ); } ?>
        </div>
        <div class="right sidebar col-md-4 col-sm-4 hidden-xs">
            <?php
            get_template_part('template', 'right');
            
            if ( is_active_sidebar( 'homerightsidebar' ) ) { dynamic_sidebar( 'homerightsidebar' ); }
            ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
