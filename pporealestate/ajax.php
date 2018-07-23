<?php

/**
 * Get category childrens
 */
function get_category_childrens() {
    $term_id = getRequest('term_id');
    $html = "";
    $childrens = get_categories(array(
        'hide_empty' => 0, 
        'post_type' => 'product', 
        'taxonomy' => 'product_category', 
        'parent' => $term_id
    ));
    foreach ($childrens as $child) :
        $html .= "<option value=\"{$child->term_id}\">{$child->name}</option>";
    endforeach;
    Response($html);
    exit;
}

/* ----------------------------------------------------------------------------------- */
# Push product to SGD
/* ----------------------------------------------------------------------------------- */
function api_push_product() {
    $api_url = getRequest('api_url');
    $post_id = intval(getRequest('id'));
    $product = get_post($post_id);
    $pushed = get_post_meta($post_id, 'pushed', true);
    if($product and $pushed != 'yes'){
        $loai_tin = null;
        $category = null;
        $taxonomy = 'product_category';
        $terms = get_the_terms($post_id, $taxonomy);
        foreach ($terms as $term) {
            if($term->parent == 0){
                $loai_tin = get_term( $term, $taxonomy );
            } else {
                $category = get_term( $term, $taxonomy );
            }
        }
        $purpose_cat = array();
        $purposes = get_the_terms($post_id, 'product_purpose');
        foreach ($purposes as $purpose) {
            $purpose_cat[] = $purpose->term_id;
        }
        $product_price = array();
        $prices = get_the_terms($post_id, 'product_price');
        foreach ($prices as $price) {
            $product_price[] = $price->term_id;
        }
        $product_acreage = array();
        $acreages = get_the_terms($post_id, 'product_acreage');
        foreach ($acreages as $acreage) {
            $product_acreage[] = $acreage->term_id;
        }
        $special_cat = array();
        $specials = get_the_terms($post_id, 'product_special');
        foreach ($specials as $special) {
            $special_cat[] = $special->term_id;
        }
        
        $gallery = get_post_meta($post_id, 'gallery', true);
        $_gallery = array();
        if(is_array($gallery) and !empty($gallery)){
            foreach ($gallery as $__gallery) {
                $_gallery[] = wp_get_attachment_url( $__gallery );
            }
        }

        $args = array(
            'loai_tin' => $loai_tin->name,
            'category' => $category->name,
            'purpose_cat' => $purpose_cat,
            'product_price' => $product_price,
            'product_acreage' => $product_acreage,
            'special_cat' => $special_cat,
            'post_title' => $product->post_title,
            'post_content' => $product->post_content,
            'city' => get_post_meta($post_id, 'city', true),
            'district' => get_post_meta($post_id, 'district', true),
            'ward' => get_post_meta($post_id, 'ward', true),
            'street' => get_post_meta($post_id, 'street', true),
            'price' => get_post_meta($post_id, 'price', true),
            'currency' => get_post_meta($post_id, 'currency', true),
            'unitPrice' => get_post_meta($post_id, 'unitPrice', true),
            'com' => get_post_meta($post_id, 'com', true),
            'area' => get_post_meta($post_id, 'area', true),
            'vi_tri' => get_post_meta($post_id, 'vi_tri', true),
            'mat_tien' => get_post_meta($post_id, 'mat_tien', true),
            'duong_truoc_nha' => get_post_meta($post_id, 'duong_truoc_nha', true),
            'direction' => get_post_meta($post_id, 'direction', true),
            'so_tang' => get_post_meta($post_id, 'so_tang', true),
            'so_phong' => get_post_meta($post_id, 'so_phong', true),
            'toilet' => get_post_meta($post_id, 'toilet', true),
            'post_video' => get_post_meta($post_id, 'video', true),
            'post_maps' => get_post_meta($post_id, 'maps', true),
            'object_poster' => get_post_meta($post_id, 'object_poster', true),
            'product_permission' => get_post_meta($post_id, 'product_permission', true),
            'start_time' => get_post_meta($post_id, 'start_time', true),
            'end_time' => get_post_meta($post_id, 'end_time', true),
            'contact_name' => get_post_meta($post_id, 'contact_name', true),
            'contact_tel' => get_post_meta($post_id, 'contact_tel', true),
            'contact_email' => get_post_meta($post_id, 'contact_email', true),
            'thumbnail' => get_the_post_thumbnail_url($post_id, 'full'),
            'gallery' => $_gallery,
        );
        $data = http_build_query($args);
        $ch = curl_init($api_url . "/post_product");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'PPO/API');
        $returnValue = curl_exec($ch);
        curl_close($ch);

        echo $returnValue;
        $response = json_decode($returnValue);
        if($response->status == 'success'){
            update_post_meta($post_id, 'pushed', 'yes');
        }
    } else {
        Response(json_encode(array(
            'status' => 'error',
            'message' => 'Không hợp lệ!',
        )));
    }
    exit();
}

//THANH PHO - QUAN HUYEN - PHUONG XA

function get_ddlcity() {
    $data = list_city();
    foreach ($data as $tp) {
        $opt .= '<option value="' . $tp->CityId . '">' . $tp->CityName . '</option>';
    }
    $response = array(
        'data' => $opt
    );
    Response(json_encode($response));
    exit();
}

function get_ddldistrict() {
    $city_ID = getRequest('city_id');
    $data = get_district($city_ID);
    $opt = "";
    foreach ($data as $d) {
        $opt .='<option value="' . $d->districtid . '">' . $d->name . '</option>';
    }
    $response = array(
        'data' => $opt
    );
    Response(json_encode($response));
    exit();
}

function get_ddlward() {
    $district_ID = getRequest('district_id');
    $data = get_ward($district_ID);
    $opt = "";
    foreach ($data as $d) {
        $opt .='<option value="' . $d->wardid . '">' . $d->name . '</option>';
    }
    $response = array(
        'data' => $opt
    );
    Response(json_encode($response));
    exit();
}

/**
 * Change user profile
 */
function change_user_profile(){
    $author = wp_get_current_user();
    $user_id = getRequest('user_id');
    $first_name = getRequest('first_name');
    $last_name = getRequest('last_name');
    $phone = getRequest('phone');
    $url = getRequest('url');
    $googleplus = getRequest('googleplus');
    $twitter = getRequest('twitter');
    $facebook = getRequest('facebook');
    $description = getRequest('description');
    
    if (!is_user_logged_in()) {
        Response(json_encode(array(
            'status' => 'error',
            'message' => __('Phiên làm việc đã hết hạn, bạn cần đăng nhập lại để thực hiện tác vụ này.', SHORT_NAME),
        )));
    } else if($user_id != $author->ID){
        Response(json_encode(array(
            'status' => 'error',
            'message' => __('Xảy ra lỗi, vui lòng thử lại.', SHORT_NAME),
        )));
    } else if(!empty($phone) and ! is_valid_phone_number($phone)){
        Response(json_encode(array(
            'status' => 'error',
            'message' => __('Vui lòng nhập một số điện thoại hợp lệ.', SHORT_NAME),
        )));
    } else {
        $user_fields = array(
            'ID' => $user_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'user_url' => $url,
//            'googleplus' => $googleplus,
//            'twitter' => $twitter,
//            'facebook' => $facebook,
            'description' => $description,
        );

        wp_update_user($user_fields);
        update_user_meta( $user_id, 'phone', $phone );
        update_user_meta( $user_id, 'googleplus', $googleplus );
        update_user_meta( $user_id, 'twitter', $twitter );
        update_user_meta( $user_id, 'facebook', $facebook );

        Response(json_encode(array(
            'status' => 'success',
            'message' => __('Lưu thay đổi thành công.', SHORT_NAME),
        )));
    }
    
    exit;
}

/**
 * Save post to Favorites
 */
function add_to_favorites(){
    global $wpdb;
    $favorites = $wpdb->prefix . 'favorites';
    $user_id = 0;
    $post_id = getRequest('post_id');
    $msg = "";
    
    if(!is_user_logged_in()){
        $msg = __('Bạn cần đăng nhập mới sử dụng được tính năng này!', SHORT_NAME);
    } else if($post_id <= 0) {
        $msg = __('Xảy ra lỗi, xin vui lòng thử lại!', SHORT_NAME);
    } else {
        global $current_user;
        get_currentuserinfo();
        $user_id = $current_user->ID;
    }
    
    if(empty($msg)){
        $result = $wpdb->get_row($wpdb->prepare( "SELECT ID FROM $favorites WHERE user_id=%d AND post_id=%d", $user_id, $post_id ));
        if($result){
            Response(json_encode(array(
                'status' => 'success',
                'message' => __('Đã thêm vào danh sách yêu thích của bạn!'),
            )));
        } else {
            $result = $wpdb->insert($favorites, array(
                    'user_id' => $user_id,
                    'post_id' => $post_id
                ), array(
                    '%d',
                    '%d'
                )
            );
            if(!$result){
                Response(json_encode(array(
                    'status' => 'error',
                    'message' => __('Xảy ra lỗi, xin vui lòng thử lại!', SHORT_NAME),
                )));
            } else {
                Response(json_encode(array(
                    'status' => 'success',
                    'message' => __('Đã thêm vào danh sách yêu thích của bạn!'),
                )));
            }
        }
        
    } else {
        Response(json_encode(array(
            'status' => 'error',
            'message' => $msg,
        )));
    }
    
    exit;
}

/**
 * Remove post to Favorites
 */
function remove_from_favorites(){
    global $wpdb;
    $favorites = $wpdb->prefix . 'favorites';
    $user_id = 0;
    $post_id = getRequest('post_id');
    $msg = "";
    
    if(!is_user_logged_in()){
        $msg = __('Bạn cần đăng nhập lại mới sử dụng được tính năng này!', SHORT_NAME);
    } else if($post_id <= 0) {
        $msg = __('Xảy ra lỗi, xin vui lòng thử lại!', SHORT_NAME);
    } else {
        global $current_user;
        get_currentuserinfo();
        $user_id = $current_user->ID;
    }
    
    if(empty($msg)){
        $result = $wpdb->delete($favorites, array(
                'user_id' => $user_id,
                'post_id' => $post_id
            ), array(
                '%d',
                '%d'
            )
        );
        if(!$result){
            Response(json_encode(array(
                'status' => 'error',
                'message' => __('Xảy ra lỗi, xin vui lòng thử lại!', SHORT_NAME),
            )));
        } else {
            Response(json_encode(array(
                'status' => 'success',
                'message' => __('Đã xóa một mục khỏi danh sách yêu thích của bạn!'),
            )));
        }
        
    } else {
        Response(json_encode(array(
            'status' => 'error',
            'message' => $msg,
        )));
    }
    
    exit;
}

/**
 * Add post to compare
 */
function add_to_compare(){
    $post_id = getRequest('post_id');
    if(isset($_SESSION['compare']) and !empty($_SESSION['compare'])){
        $compare = $_SESSION['compare'];
        if(!in_array($post_id, $compare)){
            array_push($compare, $post_id);
            $_SESSION['compare'] = $compare;
        }
    }else{
        $compare = array();
        array_push($compare, $post_id);
        $_SESSION['compare'] = $compare;
    }

    $compare = $_SESSION['compare'];
    if(count($compare) > 0){
        Response(json_encode(array(
            'redirect_url' => get_page_link(get_option(SHORT_NAME . "_pageCompare")),
            'message' => "",
        )));
    } else {
        Response(json_encode(array(
            'redirect_url' => get_page_link(get_option(SHORT_NAME . "_pageCompare")),
            'message' => __('Đã thêm vào mục so sánh. Bạn hãy chọn thêm một bất động sản khác để tiến hành so sánh.'),
        )));
    }
    
    exit;
}