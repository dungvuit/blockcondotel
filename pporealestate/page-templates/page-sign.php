<?php
/*
  Template Name: Ký gửi nhà đất
 */
$notify = "";
$email_admin = get_option('realestate_email');
if(isset($_POST['send'])){
    $loaitin = getRequest('loai_tin');
    $category = getRequest('category');
    $price = getRequest('price');
    $currency = getRequest('currency');
    $unitPrice = getRequest('unitPrice');
    $_price = "$price $currency/$unitPrice";
    if($currency == "Thỏa thuận"){
        $_price = "$currency/$unitPrice";
    }
    $com = getRequest('com');
    $area = getRequest('area');
    $vi_tri = getRequest('vi_tri');
    $mat_tien = getRequest('mat_tien');
    $duong_truoc_nha = getRequest('duong_truoc_nha');
    $direction = getRequest('direction');
    $so_tang = getRequest('so_tang');
    $so_phong = getRequest('so_phong');
    $toilet = getRequest('toilet');
    $project = getRequest('project');
    $purpose_cat = getRequest('purpose_cat');
    $special_cat = getRequest('special_cat');
    $post_title = getRequest('post_title');
    $post_content = getRequest('post_content');
    $post_video = getRequest('post_video');
    $post_maps = getRequest('post_maps');
    $object_poster = getRequest('object_poster');
    $product_permission = getRequest('product_permission');
    $tin_vip = getRequest('not_in_vip');
    $start_time = getRequest('start_time');
    $end_time = getRequest('end_time');
    $contact_name= getRequest('contact_name');
    $contact_tel = getRequest('contact_tel');
    $contact_email = getRequest('contact_email');
    
    $mucdich = "";
    foreach($purpose_cat as $purpose){
        $mucdich .= "- " . $purpose . "<br/>";
    }
    $dacdiem = "";
    foreach($special_cat as $special){
        $dacdiem .= "- " . $special . "<br/>";
    }
    
    // Upload images
    $attachments = array();
    $attachment_ids = array();
    for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
        $filename = $_FILES['images']['name'][$i];
        $file = file_get_contents($_FILES['images']['tmp_name'][$i]);
        $res = wp_upload_bits($filename, '', $file);
        $attach_id = insert_attachment($res['file'], $post_id);
        $attachments[] = $res['file'];
        $attachment_ids[] = $attach_id;
    }

    if($notify == ""){
    $subject = "Ký gửi nhà đất";
    $message = <<<HTML
<h1>THÔNG TIN KÝ GỬI NHÀ ĐẤT</h1>
<h2>Thông tin cơ bản</h2>
Loại tin: $loaitin<br/>
Dạng tin: $tin_vip<br/>
Lịch đăng: $start_time - $end_time<br/>
Giá: $_price<br/>
Hoa hồng: $com<br/>
Đối tượng đăng tin: $object_poster<br />
Quyền hạn đối với BĐS: $product_permission<br />
<h2>Thông tin chi tiết</h2> 
Tiêu đề: $post_title<br />
Nội dung: $post_content<br /> 
Video: $post_video<br />
<h2>Thông số Bất động sản</h2>
Loại BĐS: $category<br />
Dự án: $project<br />
Diện tích: {$area}m2<br />
Mặt tiền: {$mat_tien}m<br />
Đường vào: {$duong_truoc_nha}m<br />
Hướng: $direction<br />
Số tầng: $so_tang <br />
Số phòng ngủ: $so_phong <br />
Số nhà vệ sinh: $toilet <br />
<h2>Địa chỉ Bất động sản</h2> 
Địa chỉ: $vi_tri <br />
Bản đồ: $post_maps <br />
<h2>Bất động sản Phù hợp để</h2> 
$mucdich
<h2>Đặc điểm Bất động sản</h2> 
$dacdiem
<h2>Thông tin liên hệ</h2> 
Họ và tên: $contact_name<br />
Điện thoại: $contact_tel<br /> 
Email: $contact_email<br />
HTML;
    add_filter( 'wp_mail_content_type', 'set_html_content_type' );
        if(empty($attachments)){
            wp_mail($email_admin,$subject, $message);
        } else {
            wp_mail($email_admin,$subject, $message, "", $attachments);
            
            // Delete images
            foreach($attachment_ids as $attachmentid){
                wp_delete_attachment( $attachmentid );
            }
        }
        // reset content-type to avoid conflicts
        remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
        $notify = "Gửi yêu cầu thành công";
    }else{
        $notify = "Vui lòng kiểm tra thông tin ở những mục có dấu (*)";
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
    <div class="formsale postnews">
        <form name="formSign" id="formSign" method="post" action="" enctype="multipart/form-data">
            <div class="thongtincoban">
                <h1 class="title_postnews">Thông tin ký gửi nhà đất</h1>
            </div>
            <?php if(!empty($notify)): ?>
            <div class="alert alert-danger mt20" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Success:</span>
                <?php echo $notify; ?>
            </div>
            <?php endif; ?>
            <div class="thongtincoban">
                <h1 class="title_postnews">Thông tin cơ bản</h1>
                <div class="thongtin-content postnews-content">
                    <div class="item row">
                        <div class="col-sm-2">
                            <label class="text">Loại tin <span>(*)</span></label>
                        </div>
                        <div class="col-sm-4">
                            <input type="radio" id="loai_bds_ban" value="Bán" name="loai_tin" class="radio" checked />
                            <label for="loai_bds_ban" class="radio_type">BÁN</label>
                            <input type="radio" id="loai_bds_cho_thue" value="Cho thuê" name="loai_tin" class="radio" />
                            <label for="loai_bds_cho_thue" class="radio_type">CHO THUÊ</label>
                            <input type="radio" id="loai_bds_dau_tu" value="Đầu tư" name="loai_tin" class="radio" />
                            <label for="loai_bds_dau_tu" class="radio_type">ĐẦU TƯ</label>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="item row">
                        <div class="col-sm-2">
                            <label class="text">Lịch đăng <span>(*)</span></label>
                        </div>
                        <div class="col-sm-2">
                            <select name="not_in_vip" class="select" required>
                                <option value="Tin thường">Tin thường</option>
                                <option value="Tin VIP">Tin VIP</option>
                            </select>
                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <?php
                                $start_time = date('d/m/Y');
                                $end_time = date('d/m/Y', strtotime('+30 days'));
                                ?>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6 pdt5">
                                            <label class="text" for="start_time">Bắt đầu <span>(*)</span></label>
                                        </div>
                                        <div class="col-sm-6 date">
                                            <input type="text" value="<?php echo $start_time ?>" placeholder="<?php echo $start_time ?>" name="start_time" id="start_time" class="textbox" maxlength="10" required /> <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6 pdt5">
                                            <label class="text" for="end_time">Kết thúc <span>(*)</span></label>
                                        </div>
                                        <div class="col-sm-6 date">
                                            <input type="text" value="<?php echo $end_time ?>" placeholder="<?php echo $end_time ?>" name="end_time" id="end_time" class="textbox" maxlength="10" required /> <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item row">
                        <div class="col-sm-2">
                            <label class="text">Giá <span>(*)</span></label>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" value="0" name="price" min="0" id="price" class="number textbox" required/>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6 pdt5">
                                    <label class="text">Đơn vị tính <span>(*)</span></label>
                                </div>
                                <div class="col-sm-6">
                                    <select name="currency" id="currency" class="select" required>
                                        <?php
                                        foreach ($unitcurrencies as $key => $value) {
                                            echo '<option value="' . $value . '">' . $value . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6 pdt5">
                                    <label class="text">Giá tính <span>(*)</span></label>
                                </div>
                                <div class="col-sm-6">
                                    <select name="unitPrice" id="unitPrice" class="select" required>
                                        <?php
                                        foreach ($unitPrices as $key => $value) {
                                            echo '<option value="' . $value . '">' . $value . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item row">
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="text">Đối tượng đăng <span>(*)</span></label> 
                                </div>
                                <div class="col-sm-6">
                                    <select name="object_poster" class="select" required>
                                        <option value="">Chọn đối tượng</option>
                                        <?php
                                        foreach (get_object_posters() as $key => $value) {
                                            echo '<option value="' . $value . '">' . $value . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-6 pdt5">
                                                <label class="text">Quyền hạn BĐS <span>(*)</span></label> 
                                            </div>
                                            <div class="col-sm-6">
                                                <select name="product_permission" class="select" required>
                                                    <option value="">Chọn quyền hạn đối với Bất động sản</option>
                                                    <?php
                                                    foreach (get_product_permissions() as $key => $value) {
                                                        echo '<option value="' . $key . '">' . $value . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-6 pdt5">
                                                <label class="text">Hoa hồng</label> 
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" placeholder="Tính theo %" name="com" class="textbox" />
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end .thongtincoban-->
            <div class="motachitiet">
                <h1 class="title_postnews">Thông tin chi tiết</h1>
                <div class="mota-content postnews-content">
                    <div class="item row">
                        <div class="col-md-2 col-sm-3">
                            <label class="text">Tiêu đề tin <span>(*)</span></label> 
                        </div>
                        <div class="col-md-10 col-sm-9">
                            <input name="post_title" type="text" maxlength="70" value="" placeholder="Vui lòng gõ tiếng Việt có dấu để tin đăng được kiểm duyệt nhanh hơn" id="contact_name" class="form-control" required/>
                        </div>
                    </div>
                    <div class="item row">
                        <div class="col-md-2 col-sm-3">
                            <label class="text">Nội dung tin <span>(*)</span></label> 
                        </div>
                        <div class="col-md-10 col-sm-9">
                            <?php
                            wp_editor("", "post_content", array(
                                'textarea_name' => "post_content",
                                'textarea_rows' => 12,
                                'media_buttons' => false,
                                'teeny' => true,
                                'quicktags' => false,
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="item row">
                        <div class="col-sm-2">
                            <label class="text">Video</label>
                        </div>
                        <div class="col-sm-10">
                            <input name="post_video" type="text" class="form-control" />
                            <small>Link video Youtube hoặc Vimeo. Ví dụ: https://www.youtube.com/watch?v=yfJtGUZMnfE</small>
                        </div>
                    </div>
                    <div class="item row">
                        <div class="col-sm-2">
                            <label class="text">Hình ảnh</label>
                        </div>
                        <div class="col-sm-10">
                            <div class="product-images mb5">
                                <input type="file" name="images[]" accept="image/jpg,image/jpeg,image/x-png,image/gif" multiple />
                            </div>
                            <small>Tối đa 08 ảnh. Dung lượng mỗi ảnh không quá 1MB. Chấp nhận các định dạng: jpg, jpeg, png, gif.</small>
                        </div>
                    </div>
                </div>
            </div><!-- end .motachitiet-->
            <div class="thongtinkhac">
                <h1 class="title_postnews">Thông số Bất động sản</h1>
                <div class="thongtinkhac-content postnews-content">
                    <div class="item row">
                        <div class="col-sm-4 mb15">
                            <div class="row">
                                <div class="col-sm-5 pdr0">
                                    <label class="text">Loại BĐS <span>(*)</span></label>
                                </div>
                                <div class="col-sm-7">
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
                                            echo "<option value=\"{$category->name}\">{$category->name}</option>";
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mb15">
                            <div class="row">
                                <div class="col-sm-5 pdr0">
                                    <label class="text">Dự án</label>
                                </div>
                                <div class="col-sm-7">
                                    <select name="project" id="project" class="select">
                                        <option value="">- Chọn dự án -</option>
                                        <?php
                                        $projects = new WP_Query(array(
                                            'post_type' => 'project',
                                            'showposts' => -1,
                                            'post_status' => 'publish',
                                        ));
                                        while($projects->have_posts()): $projects->the_post();
                                            echo "<option value=\"".get_the_title()."\">".get_the_title()."</option>";
                                        endwhile;
                                        wp_reset_query();
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mb15">
                            <div class="row">
                                <div class="col-sm-5 pdr0">
                                    <label class="text">Diện tích (m<sup>2</sup>)</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" value="" name="area" id="area" class="number textbox" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mb15">
                            <div class="row">
                                <div class="col-sm-5 pdr0">
                                    <label class="text">Mặt tiền (m)</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" value="" name="mat_tien" id="mat_tien" class="number textbox" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mb15">
                            <div class="row">
                                <div class="col-sm-5 pdr0">
                                    <label class="text">Đường vào (m)</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" value="" name="duong_truoc_nha" id="duong_truoc_nha" class="number textbox" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mb15">
                            <div class="row">
                                <div class="col-sm-5 pdr0">
                                    <label class="text">Hướng BĐS</label>
                                </div>
                                <div class="col-sm-7">
                                    <select name="direction" id="direction" class="select">
                                        <?php
                                        foreach ($directions as $key => $value) {
                                            echo '<option value="' . $value . '">' . $value . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mb15">
                            <div class="row">
                                <div class="col-sm-5 pdr0">
                                    <label class="text">Số tầng</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" value="" name="so_tang" id="so_tang" class="number textbox" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mb15">
                            <div class="row">
                                <div class="col-sm-5 pdr0">
                                    <label class="text">Phòng ngủ</label>
                                </div>
                                <div class="col-sm-7">
                                    <select name="so_phong" id="so_phong" class="number select">
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
                        <div class="col-sm-4 mb15">
                            <div class="row">
                                <div class="col-sm-5 pdr0">
                                    <label class="text">Phòng vệ sinh</label>
                                </div>
                                <div class="col-sm-7">
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
                </div>
            </div><!-- .end thongtinkhac -->
            <div class="thongtincoban mt20">
                <h1 class="title_postnews">Địa chỉ Bất động sản</h1>
                <div class="thongtin-content postnews-content">
                    <div class="item row">
                        <div class="col-sm-2">
                            <label class="text">Địa chỉ <span>(*)</span></label> 
                        </div>
                        <div class="col-sm-10">
                            <input type="text" value="" name="vi_tri" id="vi_tri" class="textbox required" required/>
                        </div>
                    </div>
                    <div class="item row mb0">
                        <div class="col-sm-2">
                            <label class="text">Google Maps</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" value="" name="post_maps" id="post_maps" class="textbox" />
                            <small>Link bản đồ Google Maps. Ví dụ: https://www.google.com/maps/@21.068609,105.784993,17z?hl=vi</small>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="thongtinkhac">
                <h1 class="title_postnews">Bất động sản Phù hợp để</h1>
                <div class="thongtinkhac-content postnews-content">
                    <ul class="list-pu">
                        <?php
                        $purposes = get_categories(array(
                            'type' => 'product',
                            'taxonomy' => 'product_purpose',
                            'hide_empty' => 0,
                        ));
                        foreach ($purposes as $purpose) :
                            ?>
                            <li>
                                <input type="checkbox" name="purpose_cat[]" id="purpose_cat" value="<?php echo $purpose->name; ?>" />&nbsp;<?php echo $purpose->name; ?>
                            </li>
                        <?php endforeach; ?>           
                    </ul>
                </div>
            </div>
            <div class="thongtinkhac">
                <h1 class="title_postnews">Đặc điểm Bất động sản</h1>
                <div class="thongtinkhac-content postnews-content">
                    <ul class="list-pu">
                        <?php
                        $specials = get_categories(array(
                            'type' => 'product',
                            'taxonomy' => 'product_special',
                            'hide_empty' => 0,
                        ));
                        foreach ($specials as $special) :
                            ?>
                            <li>
                                <input type="checkbox" name="special_cat[]" id="special_cat" value="<?php echo $special->name; ?>" />&nbsp;<?php echo $special->name; ?>
                            </li>
                        <?php endforeach; ?>           
                    </ul>
                </div>
            </div>
            <div class="thongtinlienhe">
                <h1 class="title_postnews">Thông tin liên hệ</h1>
                <div class="thongtinlienhe-content postnews-content">
                    <div class="item row">
                        <div class="col-sm-2">
                            <label class="text">Họ tên <span>(*)</span></label>      
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="contact_name" id="contact_name" value="" maxlength="255" placeholder="Là Họ tên mà người dùng sẽ liên hệ với bạn" class="form-control" required />
                        </div>
                    </div>
                    <div class="item row">
                        <div class="col-sm-2">
                            <label class="text">Điện thoại <span>(*)</span></label>                          
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="contact_tel" id="contact_tel" maxlength="255" value="" placeholder="Là Số điện thoại mà người dùng sẽ gọi cho bạn" class="form-control" required />
                        </div>
                    </div>
                    <div class="item row">
                        <div class="col-sm-2">
                            <label class="text">Email</label>  
                        </div>
                        <div class="col-sm-6">
                            <input type="email" name="contact_email" id="contact_email" maxlength="255"  value="" placeholder="Là Email mà người dùng sẽ gửi cho bạn" class="form-control"/>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div><!-- end .thongtinlienhe-->
        
            <div class="dangtin">
                <div class="dangtin-content">
                    <div class="item">
                        <input type="submit" name="send" value="Gửi yêu cầu" class="button"/>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>   
    <?php endwhile;?>
</div>
<?php get_footer(); ?>