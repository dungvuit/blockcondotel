<?php
$args = array(
    'post_type' => 'product',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'not_in_vip',
            'value' => '1',
            'compare' => '='
        ),
        array(
            'key' => 'end_time',
            'value' => date('Y/m/d', strtotime("today")),
            'compare' => '>=',
            'type' => 'DATE'
        )
    ),
    'posts_per_page' => -1,
);
$query = new WP_Query($args);
?>
<div class="title-pro">
    <h3>
        <span>Bất động sản VIP</span>
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
</div>