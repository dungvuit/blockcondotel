<?php get_header(); ?>
<div class="container main_content">
    <?php while (have_posts()) : the_post(); ?>
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb10">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="row">
        <div class="left col-md-8 col-sm-8 col-xs-12">
            <div class="single_product">
                <h1 class="title_product"><?php the_title(); ?></h1> 
                <div class="short_info">
                    <span class="bold-red">Giá: </span><?php echo get_post_meta(get_the_ID(), "project_price", true); ?>
                    <span class="bold-red" style="margin-left: 10px;">Địa chỉ: </span>
                    <?php echo get_post_meta(get_the_ID(), "khu_vuc", true); ?>
                    <span class="bold-red" style="margin-left: 10px;">Nhà cung cấp: </span>
                    <?php
                    $supplier_id = get_post_meta(get_the_ID(), "supplier", true);
                    if($supplier_id){
                        echo '<a href="' . get_permalink($supplier_id) . '" target="_blank">' . get_the_title($supplier_id) . '</a>';
                    }
                    ?>
                </div>
                <?php if( get_field('gallery') ) : ?>
                <div class="product-gallery">
                    <div class="owl-carousel">
                        <?php
                        $gallery = get_field('gallery');
                        foreach ($gallery as $_gallery) :
                        ?>
                        <img src="<?php echo $_gallery['url']; ?>" alt="<?php echo $_gallery['title']; ?>" />
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                <div class="description">
                    <?php if( get_field('video') ) : ?>
                    <div class="post-video">
                        <?php the_field('video') ?>
                    </div>
                    <?php endif; ?>
                    <h3 class="title_head">Mô tả chi tiết</h3>
                    <div class="main_des">
                        <?php the_content();?>
                        
                        <?php if( get_field('maps') ) : ?>
                        <div class="post-maps">
                            <?php the_field('maps') ?>
                        </div>
                        <?php endif; ?>
                        <?php show_share_socials(); ?>
                        <?php the_tags( '<div class="post-tags"><span class="glyphicon glyphicon-tags"></span> Tags: ', ', ', '</div>'); ?>
                    </div>
                    <?php
                    $products = new WP_Query(array(
                        'post_type' => 'product',
                        'posts_per_page' => 10,
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'project',
                                'value' => get_the_ID(),
                            ),
                            array(
                                'key' => 'end_time',
                                'value' => date('Y/m/d', strtotime("today")),
                                'compare' => '>=',
                                'type' => 'DATE'
                            )
                        ),
                    ));
                    if($products->post_count > 0):
                    ?>
                    <div class="related_product mb30">
                        <div class="title-pro">
                            <h3>
                                <span>Bất động sản thuộc <?php the_title(); ?></span>
                            </h3>
                        </div>
                        <div class="list_product">
                        <?php
                        while ($products->have_posts()) : $products->the_post();
                            get_template_part('template', 'product_item');
                        endwhile;
                        wp_reset_query();
                        ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="related_product">
                        <div class="title-pro">
                            <h3>
                                <span>Dự án khác</span>
                            </h3>  
                        </div>
                        <div class="carousel-products-widget product-grid-container">
                            <div class="row">
                            <?php
                                $taxonomy = 'project_category';
                                $terms = get_the_terms(get_the_ID(), $taxonomy);
                                $terms_id = array();
                                foreach ($terms as $term) {
                                    array_push($terms_id, $term->term_id);
                                }
                                $loop = new WP_Query(array(
                                    'post_type' => 'project',
                                    'posts_per_page' => 6,
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => $taxonomy,
                                            'field' => 'term_id',
                                            'terms' => $terms_id,
                                        )
                                    ),
                                    'orderby' => 'rand',
                                    'post__not_in' => array(get_the_ID()),
                                ));
                                while ($loop->have_posts()) : $loop->the_post();
                                    echo '<div class="col-xs-6">';
                                    get_template_part('template', 'project_item2');
                                    echo '</div>';
                                endwhile;
                                wp_reset_query();
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="right sidebar col-md-4 col-sm-4 col-xs-12">
            <?php get_template_part('template', 'sidebarsearch'); ?>
        </div>
    </div>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>