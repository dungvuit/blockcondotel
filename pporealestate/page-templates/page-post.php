<?php
/*
  Template Name: Đăng tin mua bán nhà đất
 */
if(!is_user_logged_in()){
    $login_url = get_page_link(get_option(SHORT_NAME . "_pagelogin"));
    wp_redirect($login_url);
    exit;
}
if (isset($_POST['bntSave'])) {
    global $current_user;
    get_currentuserinfo();
    
    $loaitin = intval(getRequest('loai_tin'));
    $category = intval(getRequest('category'));
    $city = getRequest('city');
    $district = getRequest('district');
    $ward = getRequest('ward');
    $street = getRequest('street');
    $price = getRequest('price');
    $currency = getRequest('currency');
    $unitPrice = getRequest('unitPrice');
    $area = getRequest('area');
    $vi_tri = getRequest('vi_tri');
    $mat_tien = getRequest('mat_tien');
    $duong_truoc_nha = getRequest('duong_truoc_nha');
    $direction = getRequest('direction');
    $so_tang = getRequest('so_tang');
    $so_phong = getRequest('so_phong');
    $toilet = getRequest('toilet');
    $purpose_cat = getRequest('purpose_cat');
    $post_title = getRequest('post_title');
    $post_content = getRequest('post_content');
    $end_time = getRequest('end_time');
    $contact_name = getRequest('contact_name');
    $contact_tel = getRequest('contact_tel');
    $contact_email = getRequest('contact_email');

    $my_post = array(
        'post_type' => 'product',
        'post_title' => $post_title,
        'post_content' => $post_content,
        'post_status' => 'draft',
        'post_author' => $current_user->ID,
        'tax_input' => array(
            'product_category' => array($loaitin, $category),
            'product_purpose' => $purpose_cat
        ),
    );
    $post_id = wp_insert_post($my_post);
    if ($post_id > 0) {
        $notify = "Bạn đã đăng dự án thành công!";
        update_post_meta($post_id, 'city', $city);
        update_post_meta($post_id, 'district', $district);
        update_post_meta($post_id, 'ward', $ward);
        update_post_meta($post_id, 'street', $street);
        update_post_meta($post_id, 'price', $price);
        update_post_meta($post_id, 'currency', $currency);
        update_post_meta($post_id, 'unitPrice', $unitPrice);
        update_post_meta($post_id, 'area', $area);
        update_post_meta($post_id, 'vi_tri', $vi_tri);
        update_post_meta($post_id, 'direction', $direction);
        update_post_meta($post_id, 'mat_tien', $mat_tien);
        update_post_meta($post_id, 'duong_truoc_nha', $duong_truoc_nha);
        update_post_meta($post_id, 'so_tang', $so_tang);
        update_post_meta($post_id, 'so_phong', $so_phong);
        update_post_meta($post_id, 'toilet', $toilet);
        update_post_meta($post_id, 'end_time', $end_time);
        update_post_meta($post_id, 'contact_name', $contact_name);
        update_post_meta($post_id, 'contact_tel', $contact_tel);
        update_post_meta($post_id, 'contact_email', $contact_email);
    } else {
        $contact_page = get_page_link(get_option(SHORT_NAME . "_pagecontact"));
        $notify1 = 'Có lỗi xảy ra, bạn hãy thử lại hoặc <a href="'.$contact_page.'" target="_blank">liên hệ</a> với chúng tôi để được trợ giúp.';
    }
}

$directions = direction_list();
$unitcurrencies = unitCurrency_list();
$unitPrices = unitPrice_list();
$categories = get_categories(array('hide_empty' => 0, 'post_type' => 'product', 'taxonomy' => 'product_category', 'parent' => 0));

get_header();
?>
<div class="container main_content">
    <?php while (have_posts()) : the_post(); ?>
        <div class="ppo_breadcrumb">
            <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
        </div>
        <div class="banner_logo mt10 mb10">
            <?php get_template_part('template', 'logo_banner'); ?>
        </div>
        <form name="formPost" id="formPost" method="post" action="">
            <div class="formsale postnews">
                <?php //the_content();?>
                <?php if (!empty($notify)): ?>
                    <div class="alert alert-success mt20" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="bold">Chúc mừng:</span>
                        <?php echo $notify; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($notify1)): ?>
                    <div class="alert alert-danger mt20" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="bold">Rất tiếc:</span>
                        <?php echo $notify1; ?>
                    </div>
                <?php endif; ?>
                <div class="thongtincoban">
                    <h1 class="title_postnews">Thông tin cơ bản</h1>
                    <div class="thongtin-content postnews-content">
                        <div class="item row">
                            <div class="col-sm-2">
                                <label class="text">Loại tin</label>
                            </div>
                            <div class="col-sm-4">
                                <?php
                                $count = 0;
                                foreach ($categories as $category) : ?>
                                    <input <?php echo ($count==0)?'checked':''; ?> type="radio" id="loai_bds_<?php echo $category->term_id; ?>" onclick="ShowType(<?php echo $category->term_id; ?>);" value="<?php echo $category->term_id; ?>" name="loai_tin" class="radio" />
                                    <label for="loai_bds_<?php echo $category->term_id; ?>" class="radio_type"><?php echo $category->name; ?></label>
                                <?php
                                    $count++;
                                endforeach;
                                ?>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="col-sm-2">
                                <label class="text">Loại nhà đất <span>(*)</span></label>
                            </div>
                            <div class="col-sm-3">
                                <select name="category" id="category" class="required select" required>
                                    <?php
                                    $term_id = 0;
                                    if(!empty($categories)){
                                        $term_id = $categories[0]->term_id;
                                    }
                                    $categories = get_categories(array(
                                        'hide_empty' => 0,
                                        'post_type' => 'product',
                                        'taxonomy' => 'product_category',
                                        'parent' => $term_id,
                                    ));
                                    foreach ($categories as $category) :
                                        echo "<option value=\"{$category->term_id}\">{$category->name}</option>";
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="item row">
                            <div class="col-sm-2">
                                <label class="text">Vị trí <span>(*)</span></label>
                            </div>
                            <div class="col-sm-2">
                                <select name="city" id="ddlCity" class="select" required>
                                    <option value="">- Tỉnh/Thành phố -</option>
                                    <?php
                                    $list_city = get_province();
                                    foreach ($list_city as $c) {
                                        echo '<option value="' . $c->provinceid . '">' . $c->name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select name="district" id="ddlDistrict" class="select" required>
                                    <option value="">-- Quận/Huyện --</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select name="ward" id="ddlWard" class="select" required>
                                    <option value="">-- Phường/Xã --</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" value="" name="street" id="street" class="textbox" placeholder="Đường phố" />
                            </div>
                        </div>
                        <div class="item row"> 
                            <div class="col-sm-2">
                                <label class="text">Giá <span>(*)</span></label>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" value="0" name="price" min="0" id="price" class="number textbox" required/>
                            </div>
                            <div class="col-sm-2">
                                <select name="currency" id="currency" class="select" required>
                                    <?php
                                    foreach ($unitcurrencies as $key => $value) {
                                        echo '<option value="' . $key . '">' . $value . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select name="unitPrice" id="unitPrice" class="select" required>
                                    <?php
                                    foreach ($unitPrices as $key => $value) {
                                        echo '<option value="' . $key . '">' . $value . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="text">Diện tích</label>
                                <input type="text" value="" name="area" id="area" class="number textbox" style="width: 60%"/> m2
                            </div>
                        </div>
                        <div class="item row">
                            <div class="col-sm-2">
                                <label class="text">Địa điểm <span>(*)</span></label> 
                            </div>
                            <div class="col-sm-10">
                                <input type="text" value="" name="vi_tri" id="vi_tri" class="textbox required" required/>
                            </div>
                        </div>
                    </div>
                </div><!-- end .thongtincoban-->
                <div class="thongtinkhac">
                    <h1 class="title_postnews">Thông tin khác</h1>
                    <div class="thongtinkhac-content postnews-content">
                        <div class="item row">
                            <div class="col-sm-3">
                                <div class="row">
                                    <label class="text col-lg-4">Mặt tiền</label>
                                    <div class="col-lg-8">
                                        <input type="text" value="" name="mat_tien" id="mat_tien" class="number textbox" style="width: 70%" /> m
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <label class="text col-lg-4">Đường trước nhà</label>
                                    <div class="col-lg-8">
                                        <input type="text" value="" name="duong_truoc_nha" id="duong_truoc_nha" class="textbox" style="width: 100%" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <label class="text col-lg-4">Hướng BĐS</label>
                                    <div class="col-lg-8">
                                        <select name="direction" id="direction" class="select">
                                            <?php
                                            foreach ($directions as $key => $value) {
                                                echo '<option value="' . $key . '">' . $value . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="col-sm-3">
                                <div class="row">
                                    <label class="text col-lg-4">Số tầng</label>
                                    <div class="col-lg-8">
                                        <input type="text" value="" name="so_tang" id="so_tang" class="number textbox" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <label class="text col-lg-4">Số phòng</label>
                                    <div class="col-lg-8">
                                        <select name="so_phong" id="so_phong" class="select">
                                            <?php
                                            $rooms = room_list();
                                            foreach ($rooms as $key => $value) {
                                                echo '<option value="' . $key . '">' . $value . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="row">
                                    <label class="text col-lg-4">Số toilet</label>
                                    <div class="col-lg-8">
                                        <select name="toilet" id="toilet" class="number select">
                                            <?php
                                            foreach (range(1, 9) as $key => $value) {
                                                echo '<option value="' . $key . '">' . $value . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="col-sm-2">
                                <label class="text">BĐS Phù hợp</label>
                            </div>
                            <div class="col-sm-10">
                                <ul class="list-pu">
                                    <?php
                                    $purposes = get_categories(array(
                                        'type' => 'product',
                                        'taxonomy' => 'product_purpose',
                                    ));
                                    foreach ($purposes as $purpose) :
                                        ?>
                                        <li>
                                            <input type="checkbox" name="purpose_cat[]" id="purpose_cat" value="<?php echo $purpose->term_id; ?>" />&nbsp;<?php echo $purpose->name; ?>
                                        </li>
                                    <?php endforeach; ?>           
                                </ul>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div><!-- .end thongtinkhac -->
                <div class="motachitiet">
                    <h1 class="title_postnews">Mô tả chi tiết</h1>
                    <div class="mota-content postnews-content">
                        <div class="item row">
                            <div class="col-md-2 col-sm-3">
                                <label class="text">Tiêu đề <span>(*)</span></label> 
                            </div>
                            <div class="col-md-10 col-sm-9">
                                <input name="post_title" type="text" maxlength="70" value="" placeholder="Vui lòng gõ tiếng Việt có dấu để tin đăng được kiểm duyệt nhanh hơn" minlength="5" maxlength="150" id="contact_name" class="form-control" required/>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="col-md-2 col-sm-3">
                                <label class="text">Nội dung mô tả <span>(*)</span></label> 
                            </div>
                            <div class="col-md-10 col-sm-9">
                                <!--<textarea rows="5" name="post_content" minlength="100" maxlength="3000" id="post_content" cols="60" class="form-control" required></textarea>-->
                                <?php
                                wp_editor("", "post_content", array(
                                    'textarea_name' => "post_content",
                                    'textarea_rows' => 12,
                                    'media_buttons' => false,
                                    'teeny' => true,
                                    'quicktags' => false,
                                ));
                                ?>
                                <small>Hình ảnh hãy upload lên <a href="https://drive.google.com/" rel="nofollow" target="_blank">Google Drive</a> của bạn, 
                                    rồi để link download vào cuối bài viết. Ban biên tập của chúng tôi sẽ đưa vào bài viết khi phê duyệt.</small>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="col-md-2 col-sm-3">
                                <label class="text">Thời gian đăng <span>(*)</span></label>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <?php $end_time = date('d/m/Y', strtotime('+30 days')); ?>
                                <input type="text" value="<?php echo $end_time ?>" name="end_time" id="end_time" class="textbox" required> <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div><!-- end .motachitiet-->
                <div class="thongtinlienhe">
                    <h1 class="title_postnews">Thông tin liên hệ</h1>
                    <div class="thongtinlienhe-content postnews-content">
                        <div class="item row">
                            <div class="col-md-2 col-sm-3">
                                <label class="text">Họ tên <span>(*)</span></label>      
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" name="contact_name" id="contact_name" value="" maxlength="100" placeholder="Là Họ tên mà khách hàng sẽ liên hệ với bạn" class="form-control" required/>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="col-md-2 col-sm-3">
                                <label class="text">Điện thoại <span>(*)</span></label>                          
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" name="contact_tel" id="contact_tel" maxlength="20" value="" placeholder="Là Số điện thoại mà khách hàng sẽ gọi cho bạn" class="form-control" required/>
                            </div>
                        </div>
                        <div class="item row">
                            <div class="col-md-2 col-sm-3">
                                <label class="text">Email</label>  
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <input type="email" name="contact_email" id="contact_email" maxlength="100"  value="" placeholder="Là Email mà khách hàng sẽ gửi cho bạn" class="form-control"/>
                            </div>
                        </div>
                    </div>
                </div><!-- end .thongtinlienhe-->
                <div class="dangtin">
                    <div class="dangtin-content">
                        <div class="item">
                            <input type="submit" name="bntSave" value="Đăng tin" id="bntSave" class="button">
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>  
        </form>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>