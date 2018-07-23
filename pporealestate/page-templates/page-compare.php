<?php
/*
  Template Name: Compare
 */
if(!isset($_SESSION['compare']) or empty($_SESSION['compare'])){
    wp_redirect( home_url() );
}

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
                <h1 class="span-title">
                    <?php _e('So sánh bất động sản', SHORT_NAME) ?>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-1"></div>
            <div class="col-xs-10">
                <div class="compare-products">
                    <div class="owl-carousel">
                    <?php
                    $compare = $_SESSION['compare'];
                    $loop = new WP_Query(array(
                        'post_type' => 'product',
                        'post__in' => $compare,
                        'showposts' => -1,
                        'post_status' => 'publish',
                    ));
                    while ($loop->have_posts()) : $loop->the_post();
                        $direction = get_post_meta(get_the_ID(), 'direction', true);
                        $currency = get_post_meta(get_the_ID(), "currency", true);
                        $price = get_post_meta(get_the_ID(), "unitPrice", true);
                    ?>
                        <div class="item">
                            <a class="thumbnail" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" target="_blank">
                                <img alt="<?php the_title(); ?>" src="<?php the_post_thumbnail_url('400x250'); ?>" />
                            </a>
                            <h4><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a></h4>
                            <p><i class="fa fa-map-marker" aria-hidden="true"></i> Vị trí: <?php echo get_post_meta(get_the_ID(), "vi_tri", true) ?></p>
                            <p><i class="fa fa-bed" aria-hidden="true"></i> P.Ngủ: <?php echo get_post_meta(get_the_ID(), "so_phong", true) ?></p>
                            <p><i class="fa fa-bath" aria-hidden="true"></i> P.Tắm: <?php echo get_post_meta(get_the_ID(), "toilet", true) ?></p>
                            <p><i class="fa fa-flag" aria-hidden="true"></i> Diện tích: <?php echo get_post_meta(get_the_ID(), "dt", true) ?> m²</p>
                            <p><i class="fa fa-arrow-up" aria-hidden="true"></i> Hướng: <?php echo get_direction($direction) ?></p>
                            <p><i class="fa fa-tag" aria-hidden="true"></i> Đơn giá: 
                                <span class="price">
                                    <?php echo get_post_meta(get_the_ID(), "price", true); ?> 
                                    <?php echo get_unitCurrency($currency);?>
                                    <?php echo get_unitPrice($price);?>
                                </span>
                            </p>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_query();
                    ?>
                        <div class="item-plus">
                            <a href="javascript:history.back()"><span class="glyphicon glyphicon-plus-sign"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-1"></div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
