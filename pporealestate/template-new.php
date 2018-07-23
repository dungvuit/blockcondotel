<?php
$sell_cat = intval(get_option(SHORT_NAME . "_cat_sell"));
$rent_cat = intval(get_option(SHORT_NAME . "_cat_rent"));
$args = array(
    'post_type' => 'product',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'not_in_vip',
            'value' => '1',
            'compare' => '!='
        ),
        array(
            'key' => 'end_time',
            'value' => date('Y/m/d', strtotime("today")),
            'compare' => '>=',
            'type' => 'DATE'
        )
    ),
    'posts_per_page' => 5
);
$query = new WP_Query($args);
?>
<div class="title-pro">
    <h3>
        <span>Bất động sản mới cập nhật</span>
    </h3>
</div>
<div class="clearfix"></div>
<div class="list_product">
    <?php
    while ($query->have_posts()) : $query->the_post();
        get_template_part('template', 'product_item');
    endwhile;
    wp_reset_query();
    ?>
    <div>
        <a title="Nhà đất bán" href="<?php echo get_term_link($sell_cat, 'product_category') ?>"><span class="fl more">Xem tất cả Nhà đất cần  bán »</span> </a> 
        <a title="Nhà đất cho thuê" href="<?php echo get_term_link($rent_cat, 'product_category') ?>"><span class="fr more">Xem tất cả Nhà đất cho thuê »</span> </a>
        <div class="clearfix"></div>
    </div>
</div>