<?php get_header(); ?>
<div class="container main_content">
    <?php while (have_posts()) : the_post(); ?>
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb30">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="row">
        <div class="left col-md-8 col-sm-8 col-xs-12">
            <div class="single_product">
                <h1 class="title_product"><?php the_title(); ?></h1> 
                <div class="short_info">
                    <div class="mb5">
                        <span class="bold-red">Khu vực:</span> <?php echo get_post_meta(get_the_ID(), "vi_tri", true); ?>
                    </div>
                    <span class="bold-red">Giá: </span>
                    <?php echo get_post_meta(get_the_ID(), "price", true); ?> <?php echo get_unitCurrency(get_post_meta(get_the_ID(), "currency", true));?><?php echo get_unitPrice(get_post_meta(get_the_ID(), "unitPrice", true));?>
                    <span class="bold-red" style="margin-left: 10px;">Diện tích: </span>
                    <?php echo get_post_meta(get_the_ID(), "dt", true); ?> m2
                    <span class="bold-red" style="margin-left: 10px;">Hướng: </span>
                    <?php
                    $direction = get_post_meta(get_the_ID(), 'direction', true);
                    echo get_direction($direction);
                    ?>
                    <span class="bold-red" style="margin-left: 10px;">Người đăng: </span>
                    <?php
                    printf( '<span class="byline"><span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span></span>',
                        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                        get_the_author()
                    );
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
<!--                        <div class="images_des">
                            <img alt="<?php // the_title(); ?>" src="<?php // echo get_image_url(); ?>"/>
                        </div>-->
                        <div class="table_des">
                            <table id="tbl1">
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="col1 bold-blue">THÔNG TIN KHÁC</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 120px" class="col1">Mã số tin rao</td>
                                        <td> <?php the_ID(); ?></td>
                                        <td style="width: 150px" class="col1">Mặt tiền</td>
                                        <td>
                                            <?php
                                            $mat_tien = get_post_meta(get_the_ID(), "mat_tien", true);
                                            if(!empty($mat_tien)){
                                                echo $mat_tien . ' m';
                                            }
                                            ?>
                                        </td>
                                        <td style="width: 150px" class="col1">Số phòng ngủ</td>
                                        <td><?php echo get_post_meta(get_the_ID(), "so_phong", true) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col1">Ngày đăng tin</td>
                                        <td><?php the_time('d-m-Y'); ?> </td>
                                        <td class="col1">Đường vào</td>
                                        <td>
                                            <?php
                                            $duong_truoc_nha = get_post_meta(get_the_ID(), "duong_truoc_nha", true);
                                            if(!empty($duong_truoc_nha)){
                                                echo $duong_truoc_nha . ' m';
                                            }
                                            ?>
                                        </td>
                                        <td class="col1">Số phòng tắm</td>
                                        <td><?php echo get_post_meta(get_the_ID(), "toilet", true) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col1">Ngày hết hạn</td>
                                        <td><?php echo get_post_meta(get_the_ID(), "end_time", true); ?></td>
                                        <td class="col1">Số tầng</td>
                                        <td><?php echo get_post_meta(get_the_ID(), "so_tang", true) ?></td>
                                        <td class="col1">Dự án</td>
                                        <td>
                                            <?php
                                            $project_id = get_post_meta(get_the_ID(), "project", true);
                                            if($project_id){
                                                echo '<a href="' . get_permalink($project_id) . '" target="_blank">' . get_the_title($project_id) . '</a>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="col1 bold-blue">BĐS PHÙ HỢP ĐỂ</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="col1">
                                            <ul class="purpose-list normal">
                                            <?php
                                            $purposes = get_the_terms(get_the_ID(), 'product_purpose');
                                            foreach($purposes as $purpose){
                                                echo '<li>- '.$purpose->name.'</li>';
                                            }
                                            ?>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="col1 bold-blue">ĐẶC ĐIỂM CỦA BĐS</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="col1">
                                            <ul class="special-list normal">
                                            <?php
                                            $specials = get_the_terms(get_the_ID(), 'product_special');
                                            foreach($specials as $special){
                                                echo '<li>- '.$special->name.'</li>';
                                            }
                                            ?>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="col1 bold-blue">LIÊN HỆ</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 120px" class="col1">Tên liên hệ</td>
                                        <td colspan="5"><?php
                                        $not_in_vip = get_post_meta(get_the_ID(), 'not_in_vip', TRUE);
                                        $contact_name = get_post_meta(get_the_ID(), 'contact_name', TRUE);
                                        $contact_tel = get_post_meta(get_the_ID(), 'contact_tel', TRUE);
                                        $contact_email = get_post_meta(get_the_ID(), 'contact_email', TRUE);
                                        if($not_in_vip == 1 or empty($contact_name)){
                                            echo get_option('unit_owner');
                                        } else {
                                            echo $contact_name;
                                        }
                                        ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col1">Địa chỉ</td>
                                        <td colspan="5"><?php echo get_option('info_address') ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col1">Điện thoại</td>
                                        <td colspan="5"><?php
                                        if($not_in_vip == 1 or empty($contact_tel)){
                                            echo get_option('info_tel');
                                        } else {
                                            echo $contact_tel;
                                        }
                                        ?></td>
                                    </tr>
                                    <tr>
                                        <td class="col1">Email</td>
                                        <td colspan="5"><?php
                                        if($not_in_vip == 1 or empty($contact_email)){
                                            echo get_option('info_tel');
                                        } else {
                                            echo $contact_email;
                                        }
                                        ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php if( get_field('maps') ) : ?>
                        <div class="post-maps">
                            <?php the_field('maps') ?>
                        </div>
                        <?php endif; ?>
                        <?php show_share_socials(); ?>
                        <?php the_tags( '<div class="post-tags"><span class="glyphicon glyphicon-tags"></span> Tags: ', ', ', '</div>'); ?>
                    </div>
                </div>
                <div class="related_product">
                    <div class="title-pro">
                        <h3>
                            <span>Có thể bạn quan tâm</span>
                        </h3>  
                    </div>
                    <div class="carousel-products-widget product-grid-container">
                        <div class="row">
                        <?php
                            $taxonomy = 'product_category';
                            $terms = get_the_terms(get_the_ID(), $taxonomy);
                            $terms_id = array();
                            $term_id = 0;
                            foreach ($terms as $term) {
                                array_push($terms_id, $term->term_id);
                                if($term->parent == 0){
                                    $term_id = $term->term_id;
                                }
                            }
                            $loop = new WP_Query(array(
                                'post_type' => 'product',
                                'posts_per_page' => 6,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => $taxonomy,
                                        'field' => 'term_id',
                                        'terms' => $terms_id,
                                    )
                                ),
                                'order' => 'DESC',
                                'orderby' => array('rand', 'meta_value_num', 'post_date'),
                                'meta_key' => 'not_in_vip',
                                'post__not_in' => array(get_the_ID()),
                                'meta_query' => array(
                                    array(
                                        'key' => 'end_time',
                                        'value' => date('Y/m/d', strtotime("today")),
                                        'compare' => '>=',
                                        'type' => 'DATE'
                                    )
                                )
                            ));
                            while ($loop->have_posts()) : $loop->the_post();
                                echo '<div class="col-xs-6">';
                                get_template_part('template', 'product_item2');
                                echo '</div>';
                            endwhile;
                            wp_reset_query();
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="right sidebar col-md-4 col-sm-4 col-xs-12">
            <?php get_template_part('template', 'sidebarsearch'); ?>
            <div class="widget child_category">
                <?php
                $ancestors = get_ancestors($term_id, $taxonomy); // Get a list of ancestors
                $ancestors = array_reverse($ancestors); //Reverse the array to put the top level ancestor first
                $ancestors[0] ? $top_term_id = $ancestors[0] : $top_term_id = $term_id; //Check if there is an ancestor, else use id of current term

                $term = get_term($top_term_id, $taxonomy); //Get the term
                $parent = $term->term_id; // id of top level ancestor
                $args = array(
                    'child_of' => $parent,
                    'taxonomy' => 'product_category',
                    'hide_empty' => 0,
                );
                $terms = get_terms($taxonomy, $args);
                ?>
                <h3 class="widget-title"><?php echo $term->name ?></h3>
                <div class="child_content">
                    <ul class="child">
                    <?php 
                    foreach ($terms as $term) {
                        echo '<li><a href="' . get_term_link($term) . '">' . $term->name . '</a></li>';
                    }
                    ?>
                    </ul>
                </div>
            </div>
            <?php if ( is_active_sidebar( 'sidebar_product' ) ) { dynamic_sidebar( 'sidebar_product' ); } ?>
        </div>
    </div>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>