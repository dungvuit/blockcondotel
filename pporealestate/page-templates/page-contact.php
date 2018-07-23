<?php
/*
  Template Name: Contact
 */
get_header(); ?>
<div class="container main_content contact">
    <?php while (have_posts()) : the_post(); ?>
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb10">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="row">
        <div class="col-md-5 col-sm-5 col-xs-12">
            <?php the_content(); ?>
        </div>
        <div class="col-md-7 col-sm-7 col-xs-12">
            <?php echo stripslashes(get_option(SHORT_NAME . "_gmaps")); ?>
        </div>
    </div>
</div>
<?php endwhile; ?>
<?php get_footer(); ?>