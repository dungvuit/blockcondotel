<?php

add_action('rest_api_init', function () {
    register_rest_route('api/v1', '/post_product', array(
        'methods' => 'POST',
        'callback' => 'api_post_product',
    ));
});

//add_action('rest_api_init', function () {
//    register_rest_route('api/v1', '/get_product/(?P<id>\d+)', array(
//        'methods' => 'GET',
//        'callback' => 'api_get_product',
//        'args' => array(
//            'id' => array(
//                'validate_callback' => function($param, $request, $key) {
//                    return is_numeric($param);
//                }
//            ),
//        ),
//    ));
//});

function api_post_product(WP_REST_Request $request) {
    @ini_set('user_agent', 'PPO/API');

    // You can get the combined, merged set of parameters:
//    $parameters = $request->get_params();

    // The individual sets of parameters are also available, if needed:
//    $parameters = $request->get_url_params();
//    $parameters = $request->get_query_params();
//    $parameters = $request->get_body_params();
//    $parameters = $request->get_json_params();
//    $parameters = $request->get_default_params();

    // Uploads aren't merged in, but can be accessed separately:
//    $parameters = $request->get_file_params();
    
//    $parameters = $request->get_parameter_order();
    
    $status = "error";
    $message = 'Có lỗi xảy ra, bạn hãy thử lại!';
    
    // Get request params
    $product_category = array();
    $loaitin = $request->get_param('loai_tin');
    $loaitin = get_term_by('name', $loaitin, 'product_category');
    $loaitin = ($loaitin) ? $loaitin->term_id : 0;
    if($loaitin > 0) $product_category[] = $loaitin;
    $category = $request->get_param('category');
    $category = get_term_by('name', $category, 'product_category');
    $category = ($category) ? $category->term_id : 0;
    if($category > 0) $product_category[] = $category;
    $purpose_cat = $request->get_param('purpose_cat');
    $purpose_cat = ($purpose_cat == null) ? array() : $purpose_cat;
    $product_price = $request->get_param('product_price');
    $product_price = ($product_price == null) ? array() : $product_price;
    $product_acreage = $request->get_param('product_acreage');
    $product_acreage = ($product_acreage == null) ? array() : $product_acreage;
    $special_cat = $request->get_param('special_cat');
    $special_cat = ($special_cat == null) ? array() : $special_cat;
    $post_title = $request->get_param('post_title');
    $post_content = $request->get_param('post_content');
    $city = $request->get_param('city');
    $district = $request->get_param('district');
    $ward = $request->get_param('ward');
    $street = $request->get_param('street');
    $price = $request->get_param('price');
    $currency = $request->get_param('currency');
    $unitPrice = $request->get_param('unitPrice');
    $com = $request->get_param('com');
    $area = $request->get_param('area');
    $vi_tri = $request->get_param('vi_tri');
    $mat_tien = $request->get_param('mat_tien');
    $duong_truoc_nha = $request->get_param('duong_truoc_nha');
    $direction = $request->get_param('direction');
    $so_tang = $request->get_param('so_tang');
    $so_phong = $request->get_param('so_phong');
    $toilet = $request->get_param('toilet');
    $post_video = $request->get_param('post_video');
    $post_maps = $request->get_param('post_maps');
    $object_poster = $request->get_param('object_poster');
    $product_permission = $request->get_param('product_permission');
    $start_time = $request->get_param('start_time');
    $end_time = $request->get_param('end_time');
    $contact_name = $request->get_param('contact_name');
    $contact_tel = $request->get_param('contact_tel');
    $contact_email = $request->get_param('contact_email');
    $thumbnail = $request->get_param('thumbnail');
    $gallery = $request->get_param('gallery');
    
    $check_exist = get_page_by_title($post_title, OBJECT, 'product');
    if(!$check_exist){
        // Get first administrator
        $users = get_users( array(
            'role'         => 'administrator',
            'orderby'      => 'ID',
            'number'       => 1,
            'fields'       => 'all',
        ) );

        $my_post = array(
            'post_type' => 'product',
            'post_title' => $post_title,
            'post_content' => $post_content,
            'post_status' => 'draft',
            'post_author' => $users[0]->ID,
        );
        $post_id = wp_insert_post($my_post);
        if ($post_id > 0) {
            $status = "success";
            $message = "Bạn đã đăng dự án thành công!";

            // update terms
            wp_set_object_terms($post_id, $product_category, 'product_category');
            wp_set_object_terms($post_id, $purpose_cat, 'product_purpose');
            wp_set_object_terms($post_id, $product_price, 'product_price');
            wp_set_object_terms($post_id, $product_acreage, 'product_acreage');
            wp_set_object_terms($post_id, $special_cat, 'product_special');

            // update meta data
            update_post_meta($post_id, 'city', $city);
            update_post_meta($post_id, 'district', $district);
            update_post_meta($post_id, 'ward', $ward);
            update_post_meta($post_id, 'street', $street);
            update_post_meta($post_id, 'price', $price);
            update_post_meta($post_id, 'currency', $currency);
            update_post_meta($post_id, 'unitPrice', $unitPrice);
            update_post_meta($post_id, 'com', $com);
            update_post_meta($post_id, 'area', $area);
            update_post_meta($post_id, 'vi_tri', $vi_tri);
            update_post_meta($post_id, 'mat_tien', $mat_tien);
            update_post_meta($post_id, 'duong_truoc_nha', $duong_truoc_nha);
            update_post_meta($post_id, 'direction', $direction);
            update_post_meta($post_id, 'so_tang', $so_tang);
            update_post_meta($post_id, 'so_phong', $so_phong);
            update_post_meta($post_id, 'toilet', $toilet);
            update_post_meta($post_id, 'video', $post_video);
            update_post_meta($post_id, 'maps', $post_maps);
            update_post_meta($post_id, 'object_poster', $object_poster);
            update_post_meta($post_id, 'product_permission', $product_permission);
            update_post_meta($post_id, 'start_time', $start_time);
            update_post_meta($post_id, 'end_time', $end_time);
            update_post_meta($post_id, 'contact_name', $contact_name);
            update_post_meta($post_id, 'contact_tel', $contact_tel);
            update_post_meta($post_id, 'contact_email', $contact_email);

            // update thumbnail
            if(!empty($thumbnail)){
                $file = file_get_contents($thumbnail);
                $filename = basename($thumbnail);
                $res = wp_upload_bits($filename, '', $file);
                $attach_id = insert_attachment($res['file'], $post_id);
                set_post_thumbnail($post_id, $attach_id);
            }

            // update gallery
            if(!empty($gallery) and function_exists('update_field')){
                $gallery_ids = array();
                foreach ($gallery as $image_url) {
                    if (empty($image_url))
                        continue;

                    $file = file_get_contents($image_url);
                    $filename = basename($image_url);
                    $res = wp_upload_bits($filename, '', $file);
                    $attach_id = insert_attachment($res['file'], $post_id);
                    $gallery_ids[] = $attach_id;
                }
                if(!empty($gallery_ids)){
                    update_field('gallery', $gallery_ids, $post_id);
                }
            }
        }
    } else {
        $message = "Bài viết đã tồn tại!";
    }
    
    // response json string
    return rest_ensure_response(array(
        'status' => $status,
        'message' => $message,
    ));
}
