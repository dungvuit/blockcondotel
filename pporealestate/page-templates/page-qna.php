<?php 
/*
  Template Name: Hỏi đáp
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
    <div class="row">
        <div class="left col-md-8">
            <?php get_template_part('template/qna'); ?>
        </div>
        <div class="right sidebar col-md-4 hidden-sm hidden-xs">
            <?php if ( is_active_sidebar( 'sidebar_qna' ) ) { dynamic_sidebar( 'sidebar_qna' ); } ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>