<?php
/*
  Template Name: Lost Password
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
        <div class="left col-md-8 col-sm-8 col-xs-12 login">
            <h1><?php the_title(); ?></h1>
            <?php echo do_shortcode("[custom-lost-password-form]"); ?>
            <?php if (!is_user_logged_in()): ?>
            <div class="login-bottom">
                <a class="pull-left" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageregister")); ?>">Đăng ký</a>
                <a class="pull-right" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pagelogin")); ?>">Đăng nhập</a>
                <div class="clearfix"></div>
            </div>
            <?php endif; ?>
        </div>
        <div class="right sidebar col-md-4 col-sm-4 col-xs-12">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>