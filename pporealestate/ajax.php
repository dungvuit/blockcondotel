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
# Add new post
/* ----------------------------------------------------------------------------------- */

function add_new_post() {
    $request = getRequestAll();

    $error = false;
    $brand_id = 0;
    if (strtolower($request['exists_brand']) == "no") {
        // Create new brand
        $new_brand = array(
            'post_type' => 'brand',
            'post_title' => $request['brand']['title'],
            'post_content' => "Logo: " . $request['brand']['logo'],
            'post_status' => 'publish',
            'post_author' => 1,
        );
        $brand_id = wp_insert_post($new_brand);
        wp_set_post_terms($brand_id, array(intval($request['brand']['category'])), 'brand_category');
        update_post_meta($brand_id, "address", $request['brand']['address']);
        update_post_meta($brand_id, "city", $request['brand']['city']);
        update_post_meta($brand_id, "tel", $request['brand']['tel']);
        update_post_meta($brand_id, "mobile", $request['brand']['mobile']);
        update_post_meta($brand_id, "email", $request['brand']['email']);
        update_post_meta($brand_id, "website", $request['brand']['website']);
        update_post_meta($brand_id, "certificate", "no");
    } else {
        $brand_id = intval($request['brand']['id']);
    }

    if ($brand_id > 0) {
        // Create new post
        $new_post = array(
            'post_type' => 'post',
            'post_title' => $request['post']['title'],
            'post_content' => $request['post']['post_content'],
            'post_status' => 'draft',
            'post_category' => array(intval($request['post']['category'])),
            'post_author' => 1,
        );
        $post_id = wp_insert_post($new_post);
        update_post_meta($post_id, "brand_published", $brand_id);
        update_post_meta($post_id, "premium", $request['post']['premium']);
        update_post_meta($post_id, "certificate", "no");
        update_post_meta($post_id, "tmp_thumb", $request['post']['thumbnail']);
    } else {
        $error = true;
    }

    if ($error) {
        $response = array(
            'status' => "error",
            'message' => "Xảy ra lỗi!"
        );
        Response(json_encode($response));
    } else {
        $response = array(
            'status' => "success",
            'message' => "Đăng thành công!"
        );
        Response(json_encode($response));
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