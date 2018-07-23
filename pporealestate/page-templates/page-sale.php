<?php
/*
  Template Name: Thuê mua BĐS
 */
$notify = "";
$email_admin = "ngothangit@gmail.com";
//$email_admin = get_option('realestate_email');
if(isset($_POST['send'])){
    $loaitin = getRequest('loai_tin');
    $category = getRequest('category');
    $price = number_format(floatval(getRequest('price')), 0, ",", ".");
    $max_price = number_format(floatval(getRequest('max_price')), 0, ",", ".");
    $area = getRequest('area');
    $max_area = getRequest('max_area');
    $city = getRequest('city');
    $district = getRequest('district');
    $direction = getRequest('direction');
    $so_phong = getRequest('so_phong');
    $toilet = getRequest('toilet');
    $purpose_cat = getRequest('purpose_cat');
    $contact_name= getRequest('contact_name');
    $contact_tel = getRequest('contact_tel');
    $contact_email = getRequest('contact_email');
    
    $mucdich = "";
    foreach($purpose_cat as $purpose){
        $mucdich .= "- " . $purpose . "<br/>";
    }
    
    if($notify == ""){
    $subject = "Yêu cầu Thuê/Mua bất động sản";
    $message = <<<HTML
<h1>YÊU CẦU THUÊ/MUA NHÀ ĐẤT</h1>
<h2>Thông tin cơ bản</h2>
Loại tin: $loaitin<br/>
Giá tối thiểu: $price VNĐ<br/>
Giá tối đa: $max_price VNĐ<br/>
<h2>Thông số Bất động sản</h2>
Loại BĐS: $category<br />
Diện tích tối thiểu: {$area}m2<br />
Diện tích tối đa: {$max_area}m2<br />
Hướng: $direction<br />
Số phòng ngủ: $so_phong <br />
Số nhà vệ sinh: $toilet <br />
<h2>Địa chỉ Bất động sản</h2> 
Tỉnh/TP: $city <br />
Quận/Huyện: $district <br />
<h2>Bất động sản Phù hợp để</h2> 
$mucdich
<h2>Thông tin liên hệ</h2> 
Họ và tên: $contact_name<br />
Điện thoại: $contact_tel<br /> 
Email: $contact_email<br />
HTML;
    add_filter( 'wp_mail_content_type', 'set_html_content_type' );
        wp_mail($email_admin,$subject, $message);
        // reset content-type to avoid conflicts
        remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
        $notify = "Gửi Yêu cầu Thuê/Mua thành công!";
    }else{
        $notify = "Vui lòng điền đầy đủ thông tin ở những mục có dấu (*)";
    }
    
}

$directions = direction_list();
$categories = get_categories(array('hide_empty' => 0, 'post_type' => 'product', 'taxonomy' => 'product_category', 'parent' => 0));

get_header();
?>
<div class="container main_content">
    <?php while (have_posts()) : the_post(); ?>
    <!--BREADCRUMBS-->
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    
    <!--BANNER-->
    <div class="banner_logo mt10 mb10">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    
    <!--BEGIN: FORM GUI YEU CAU-->
    <div class="formsale postnews">
        <form name="formSales" id="formSales" method="post" action="">
            <input name="act" value="sales" type="hidden" />
            <div class="thongtincoban">
                <h1 class="title_postnews">Gửi yêu cầu thuê/ mua bất động sản</h1>
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
                        <div class="col-sm-3">
                            <label class="text">Nhu cầu <span>(*)</span></label>
                        </div>
                        <div class="col-sm-4">
                            <input type="radio" id="loai_bds_mua" value="Mua" name="loai_tin" class="radio" checked />
                            <label for="loai_bds_mua" class="radio_type">MUA</label>
                            <input type="radio" id="loai_bds_thue" value="Thuê" name="loai_tin" class="radio" />
                            <label for="loai_bds_thue" class="radio_type">THUÊ</label>
                            <input type="radio" id="loai_bds_dau_tu" value="Đầu tư" name="loai_tin" class="radio" />
                            <label for="loai_bds_dau_tu" class="radio_type">ĐẦU TƯ</label>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="item row">
                        <div class="col-sm-3">
                            <label class="text">Giá tối thiểu (VNĐ) <span>(*)</span></label>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" value="0" name="price" min="0" id="price" class="number textbox" required/>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-6 pdt5">
                                    <label class="text">Giá tối đa (VNĐ) <span>(*)</span></label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" value="0" name="max_price" min="0" id="max_price" class="number textbox" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end .thongtincoban-->
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
                                    <label class="text">D.T tối thiểu (m<sup>2</sup>)</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" value="" name="area" id="area" class="number textbox" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mb15">
                            <div class="row">
                                <div class="col-sm-5 pdr0">
                                    <label class="text">D.T tối đa (m<sup>2</sup>)</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text" value="" name="max_area" id="max_area" class="number textbox" />
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
                        <div class="col-sm-3 pdr0">
                            <label class="text">Vị trí <span>(*)</span></label>
                        </div>
                        <div class="col-sm-3">
                            <select name="city" class="select" required>
                                <option value="">- Tỉnh/Thành phố -</option>
                                <?php
                                $list_city = vn_city_list();
                                foreach ($list_city as $c) {
                                    echo '<option value="' . $c . '">' . $c . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-3 pdr0">
                            <label class="text">Quận/Huyện</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" value="" name="district" class="textbox" />
                        </div>
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
    <!--END: FORM GUI YEU CAU-->
    
    <?php endwhile;?>
</div>
<?php get_footer(); ?>