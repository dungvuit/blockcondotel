<?php
/*
  Template Name: Thuê mua BĐS
 */
$notify = "";
$email_admin = get_option('realestate_email');
if(isset($_POST['send'])){
    $vi_tri = getRequest('vi_tri');
    $description = getRequest('description');
    $area = getRequest('area');
    $price = getRequest('price');
    $purpose = getRequest('purpose');
    $contact_name= getRequest('contact_name');
    $contact_tel = getRequest('contact_tel');
    $contact_email = getRequest('contact_email');
    
    if($notify == ""){
    $subject = "Yêu cầu Thuê/Mua bất động sản";
    $message = <<<HTML
    <h1>Yêu cầu thuê/ mua bất động sản</h1>
    <h2>Mô tả chi tiết</h2>
    Vị trí/ Khu vực: $vi_tri<br />
    Mô tả: $description<br />
    <h2>Thông tin thêm</h2> 
    Diện tích: $area m2<br />
    Giá: $price triệu<br /> 
    Mục đích: $purpose<br />
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

get_header(); ?>
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
            
            <div class="motachitiet">
                <h1 class="title_postnews">Mô tả chi tiết</h1>
                <div class="mota-content postnews-content">
                    <div class="item row">
                        <div class="col-sm-3">
                            <label class="text">Vị trí/ Khu vực <span>(*)</span></label> 
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id="vi_tri" name="vi_tri" value="" placeholder="Vị trí/ khu vực bạn cần thuê mua" minlength="5" maxlength="150" class="form-control" required />
                        </div>
                    </div>
                    <div class="item row">
                        <div class="col-sm-3">
                            <label class="text">Mô tả <span>(*)</span></label>
                        </div>
                        <div class="col-sm-9">
                            <textarea id="description" name="description" rows="2" placeholder="Hãy mô tả chi tiết yêu cầu của bạn, chúng tôi sẽ giúp bạn tìm được bất động sản phù hợp nhất "  minlength="50" maxlength="3000"  cols="20" class="form-control" required></textarea>
                        </div>
                    </div>                            
                </div>
            </div><!-- end .motachitiet-->
            <div class="thongtinkhac">
                <h1 class="title_postnews">Thông tin thêm</h1>
                <div class="thongtinkhac-content postnews-content">
                    <div class="item row">
                        <div class="col-sm-4">
                            <div class="row">
                                <label class="text col-lg-4">Diện tích <span>(*)</span></label>
                                <div class="col-lg-8">
                                    <input type="text" value="" name="area" id="area" class="textbox" required/> m2
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <label class="text col-lg-4">Giá <span>(*)</span></label>
                                <div class="col-lg-8">
                                    <input type="text" value="" name="price" min="0" id="price" class="number textbox" required/> Triệu
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <label class="text col-lg-4">Mục đích <span>(*)</span></label>
                                <div class="col-lg-8">
                                    <select name="purpose" id="purpose" class="textbox" required>
                                    <?php
                                    $purposes = get_categories(array(
                                        'type' => 'product',
                                        'taxonomy' => 'product_purpose',
                                    ));
                                    foreach ($purposes as $purpose) :
                                        echo "<option value=\"{$purpose->name}\">{$purpose->name}</option>";
                                    endforeach;
                                    ?>
                                </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end .thong tin khac -->
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