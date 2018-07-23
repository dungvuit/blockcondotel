<?php get_header(); ?>
<div class="container main_content">
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="row">
        <div class="left col-md-8 col-sm-8 col-xs-12">
            <div class="archive_post">
                <h1 class="span-title"><?php single_cat_title(); ?></h1>
                <div class="list_post_archive">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="item_archive">
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                                        <img class="img" alt="<?php the_title(); ?>" src="<?php the_post_thumbnail_url('275x150') ?>"/>
                                    </a>
                                </div> <!-- col-xs-12 col-sm-4 col-md-3 -->
                                <div class="col-xs-12 col-sm-8 col-md-8">
                                    <div class="text-content-news">
                                        <h2><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                        <div class="entry-date">
                                            <p>
                                                <span class="glyphicon glyphicon-calendar"></span> <?php the_time('d-m-Y'); ?> 
                                            </p>
                                        </div>
                                        <p><?php echo get_short_content(get_the_excerpt(),120); ?></p>
                                        <a title="<?php the_title(); ?>" rel="bookmark" href="<?php the_permalink(); ?>" class="read-more"> Xem tiếp</a>
                                    </div><!--end text-content-news-->
                                </div> <!-- col-xs-12 col-sm-8 col-md-8 -->
                            </div><!--end row-->
                        </div><!--end .item_archive-->
                    <?php endwhile; ?>
                    <?php getpagenavi();?>
                </div>        
            </div>
        </div>
        <div class="right sidebar col-md-4 col-sm-4 col-xs-12">
            <?php if ( is_active_sidebar( 'sidebar_archive' ) ) { dynamic_sidebar( 'sidebar_archive' ); } ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>