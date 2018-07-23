<?php

function project_list() {
    $result = array('' => '- Chọn dự án -');
    if(is_admin()){
        $projects = new WP_Query(array(
            'post_type' => 'project',
            'showposts' => -1,
            'post_status' => 'publish',
        ));
        while($projects->have_posts()): $projects->the_post();
            $result[get_the_ID()] = get_the_title();
        endwhile;
        wp_reset_query();
    }
    return $result;
}

/* ----------------------------------------------------------------------------------- */
# Create post_type
/* ----------------------------------------------------------------------------------- */
add_action('init', 'create_product_post_type');

function create_product_post_type() {
    register_post_type('product', array(
        'labels' => array(
            'name' => __('Nhà đất'),
            'singular_name' => __('Products'),
            'add_new' => __('Add new'),
            'add_new_item' => __('Add new Product'),
            'new_item' => __('New Product'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Product'),
            'view' => __('View Product'),
            'view_item' => __('View Product'),
            'search_items' => __('Search Products'),
            'not_found' => __('No Product found'),
            'not_found_in_trash' => __('No Product found in trash'),
        ),
        'public' => true,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => false,
        'menu_position' => 5,
        'hierarchical' => false,
        'query_var' => true,
        'supports' => array(
            'title', 'editor', 'author', 'thumbnail', 
            //'custom-fields', 'comments', 'excerpt',
        ),
        'rewrite' => array('slug' => 'nha-dat', 'with_front' => false),
        'can_export' => true,
        'description' => __('Product description here.'),
        'taxonomies' => array('post_tag'),
    ));
}

/* ----------------------------------------------------------------------------------- */
# Create taxonomy
/* ----------------------------------------------------------------------------------- */
add_action('init', 'create_product_taxonomies');

function create_product_taxonomies() {
    register_taxonomy('product_category', 'product', array(
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'query_var' => true,
        'labels' => array(
            'name' => __('Loại nhà đất'),
            'singular_name' => __('Product Categories'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add New Category'),
            'new_item' => __('New Category'),
            'search_items' => __('Search Categories'),
        ),
        'rewrite' => array('slug' => 'loai-nha-dat', 'with_front' => false),
    ));
    
    register_taxonomy('product_acreage', 'product', array(
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'query_var' => true,
        'labels' => array(
            'name' => __('Diện tích'),
            'singular_name' => __('Product Acreage'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add New Acreage'),
            'new_item' => __('New Acreages'),
            'search_items' => __('Search Real Acreages'),
        ),
        'rewrite' => array('slug' => 'dien-tich', 'with_front' => false),
    ));
    register_taxonomy('product_price', 'product', array(
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'query_var' => true,
        'labels' => array(
            'name' => __('Khoảng giá'),
            'singular_name' => __('Product Price'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add New Price'),
            'new_item' => __('New Prices'),
            'search_items' => __('Search Real Prices'),
        ),
        'rewrite' => array('slug' => 'khoang-gia', 'with_front' => false),
    ));
    
    register_taxonomy('product_purpose', 'product', array(
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'query_var' => true,
        'labels' => array(
            'name' => __('Mục đích'),
            'singular_name' => __('Product Purposes'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add New Purpose'),
            'new_item' => __('New Real Purposes'),
            'search_items' => __('Search Purposes'),
        ),
        'rewrite' => array('slug' => 'muc-dich', 'with_front' => false),
    ));
}

add_action('init', 'create_product_taxonomies');

/* ----------------------------------------------------------------------------------- */
# Meta box
/* ----------------------------------------------------------------------------------- */
$list_city = get_province();
$temp_city = array('' => '- Chọn Tỉnh/Thành phố -');
foreach ($list_city as $ct) {
    $temp_city[$ct->provinceid] = $ct->name;
}
$product_meta_box = array(
    'id' => 'product-meta-box',
    'title' => 'Vị trí',
    'page' => 'product',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Thành phố',
            'desc' => '',
            'id' => 'city',
            'type' => 'select',
            'std' => '',
            'options' =>$temp_city,
        ),
        array(
            'name' => 'Quận / Huyện',
            'desc' => '',
            'id' => 'district',
            'type' => 'select',
            'std' => '',
            'options' =>'',
        ),
        array(
            'name' => 'Phường/Xã',
            'desc' => '',
            'id' => 'ward',
            'type' => 'select',
            'std' => '',
            'options' =>'',
        ),
        array(
            'name' => 'Đường phố',
            'desc' => '',
            'id' => 'street',
            'type' => 'text',
            'std' => '',
        ),
    )
);
$product_meta_box2 = array(
    'id' => 'product-meta-box2',
    'title' => 'Thông tin chung',
    'page' => 'product',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Giá',
            'desc' => 'Ví dụ: 77000',
            'id' => 'price',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Đơn vị tiền tệ',
            'desc' => 'Ví dụ: tỷ',
            'id' => 'currency',
            'type' => 'select',
            'std' => '',
            'options' => unitCurrency_list(),
        ),
        array(
            'name' => 'Đơn vị giá',
            'desc' => 'Ví dụ: /m2',
            'id' => 'unitPrice',
            'type' => 'select',
            'std' => '',
            'options' => unitPrice_list(),
        ),
        array(
            'name' => 'Diện tích',
            'desc' => '',
            'id' => 'area',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Vị trí',
            'desc' => '',
            'id' => 'vi_tri',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Hướng',
            'desc' => '',
            'id' => 'direction',
            'type' => 'select',
            'std' => '',
            'options' => direction_list(),
        ),
        array(
            'name' => 'Mặt tiền (m)',
            'desc' => '',
            'id' => 'mat_tien',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Đường trước nhà',
            'desc' => '',
            'id' => 'duong_truoc_nha',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Số tầng',
            'desc' => '',
            'id' => 'so_tang',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Số phòng',
            'desc' => '',
            'id' => 'so_phong',
            'type' => 'select',
            'std' => '',
            'options' => room_list(),
        ),
        array(
            'name' => 'Số toilet',
            'desc' => '',
            'id' => 'toilet',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Thời gian hết hạn của tin',
            'desc' => 'ví dụ: 20/12/2015',
            'id' => 'end_time',
            'type' => 'text',
            'std' => '21/11/2019',
        ), 
        array(
            'name' => 'Nhà đất vip',
            'desc' => '',
            'id' => 'not_in_vip',
            'type' => 'radio',
            'std' => '',
            'options' => array(
                '1' => 'Yes',
                '0' => 'No'
            )
        ),
        array(
            'name' => 'Dự án',
            'desc' => '',
            'id' => 'project',
            'type' => 'select',
            'std' => '',
            'options' => project_list(),
        ),
    )
);
$product_meta_box3 = array(
    'id' => 'product-meta-box3',
    'title' => 'Thông tin liên hệ',
    'page' => 'product',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Họ và tên liên hệ',
            'desc' => '',
            'id' => 'contact_name',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Điện thoại liên hệ',
            'desc' => '',
            'id' => 'contact_tel',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Email liên hệ',
            'desc' => '',
            'id' => 'contact_email',
            'type' => 'text',
            'std' => '',
        ),
    )
);
//Add product meta box
if (is_admin()) {
    add_action('admin_menu', 'product_add_box');
    add_action('save_post', 'product_add_box');
    add_action('save_post', 'product_save_data');
}

function product_add_box() {
    global $product_meta_box, $product_meta_box2, $product_meta_box3;
    add_meta_box($product_meta_box['id'], $product_meta_box['title'], 'product_show_box', $product_meta_box['page'], $product_meta_box['context'], $product_meta_box['priority']);
    add_meta_box($product_meta_box2['id'], $product_meta_box2['title'], 'product_show_box2', $product_meta_box2['page'], $product_meta_box2['context'], $product_meta_box2['priority']);
    add_meta_box($product_meta_box3['id'], $product_meta_box3['title'], 'product_show_box3', $product_meta_box3['page'], $product_meta_box3['context'], $product_meta_box3['priority']);
}

function product_show_box() {
    global $product_meta_box, $post;
    custom_output_meta_box($product_meta_box, $post);
}
function product_show_box2() {
    global $product_meta_box2, $post;
    custom_output_meta_box($product_meta_box2, $post);
}

function product_show_box3() {
    global $product_meta_box3, $post;
    custom_output_meta_box($product_meta_box3, $post);
}

function product_save_data($post_id) {
    global $product_meta_box, $product_meta_box2, $product_meta_box3;
    custom_save_meta_box($product_meta_box, $post_id);
    custom_save_meta_box($product_meta_box2, $post_id);
    custom_save_meta_box($product_meta_box3, $post_id);
    return $post_id;
}
