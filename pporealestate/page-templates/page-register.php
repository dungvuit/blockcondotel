<?php
/*
  Template Name: Register
 */
if (is_user_logged_in()) {
    wp_redirect( home_url('/profile/') );
}
$msg = array(
    'warning' => array(),
    'success' => array()
);
if(getRequestMethod() == 'POST'){
    $sanitized_user_login = sanitize_user(getRequest('username') );
    $email = getRequest('email');
    $password = getRequest('pwd');
    $password2 = getRequest('repwd');
    
    if($sanitized_user_login == ""){
        array_push($msg['warning'], "<p>Vui lòng nhập tài khoản!</p>");
    }elseif(! validate_username( $sanitized_user_login )){
        array_push($msg['warning'], "<p>Tài khoản không hợp lệ, vui lòng nhập tài khoản khác!</p>");
    }elseif ( username_exists( $sanitized_user_login ) ) {
        array_push($msg['warning'], "<p>Tài khoản đã tồn tại, vui lòng nhập tài khoản khác!</p>");
    }elseif (!is_email( $email )) {
        array_push($msg['warning'], "<p>Địa chỉ email không hợp lệ!</p>");
    }elseif ( email_exists( $email ) ) {
        array_push($msg['warning'], "<p>Địa chỉ email này đã tồn tại!</p>");
    }elseif($password == ""){
        array_push($msg['warning'], "<p>Vui lòng nhập mật khẩu!</p>");
    }elseif($password2 != $password){
        array_push($msg['warning'], "<p>Xác nhận mật khẩu không chính xác!</p>");
    }else{
        $user_id = wp_create_user($sanitized_user_login, $password, $email);
        if (!$user_id || is_wp_error($user_id)) {
            array_push($msg['warning'], "Đăng ký lỗi. Vui lòng liên hệ <a href='mailto:" . get_option( 'admin_email' ) . "'>quản trị website</a>!");
        }else{
            array_push($msg['success'], "Đăng ký thành công!");
            //Set up the Password change nag.
            update_user_option( $user_id, 'default_password_nag', true, true ); 
            // notification for user
            wp_new_user_notification( $user_id, $password );
        }
    }
}
?>
<?php get_header(); ?>
<div class="container main_content">
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb30">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="row">
        <div class="left col-md-8 col-sm-8 col-xs-12 login">
            <div class="news-block">
                <div class="block-title"><h1><?php the_title(); ?></h1></div>
                <div class="line"></div>
                <div class="post">
                    <div id="message" class="<?php 
                    if(!empty($msg['warning'])){
                        echo 'warning';
                    }elseif(!empty($msg['success'])){
                        echo 'success';
                    }
                    ?>">
                    <?php 
                    if(!empty($msg['warning'])){
                        foreach ($msg['warning'] as $m) {
                            echo $m;
                        }
                    }
                    if(!empty($msg['success'])){
                        foreach ($msg['success'] as $m) {
                            echo $m;
                        }
                        header("location: " . get_page_link((SHORT_NAME . "_pagelogin")));
                        exit();
                    }
                    ?>
                    </div>
                    <?php while (have_posts()) : the_post();  ?>
                    <div class="post-content mt10"><?php the_content(); ?></div>
                    <?php endwhile;?>

                    <div class="account registerform">
                        <form action="" method="post" id="registerform" name="registerform">
                            <p>
                                <label for="user_login">Tài khoản *</label>
                                <input type="text" size="20" value="<?php echo getRequest('username'); ?>" class="input" id="user_login" name="username">
                            </p>
                            <p>
                                <label for="user_email">Email *</label>
                                <input type="text" size="20" value="<?php echo getRequest('email'); ?>" class="input" id="user_email" name="email">
                            </p>
                            <p>
                                <label for="user_pass">Mật khẩu *</label>
                                <input type="password" size="20" value="" class="input" id="user_pass" name="pwd">
                            </p>
                            <p>
                                <label for="user_pass2">Nhập lại mật khẩu *</label>
                                <input type="password" size="20" value="" class="input" id="user_pass2" name="repwd">
                            </p>
                            
                            <p>
                                <span class="fl">
                                    <a href="<?php echo get_page_link(get_option(SHORT_NAME . "_pagelogin")); ?>">Đăng nhập</a><br />
                                    <a href="<?php echo home_url('/lostpassword/'); ?>">Quên mật khẩu?</a>
                                </span>
                                
                                <input class="button-primary" type="submit" name="wp-submit" id="btnReg" value="Đăng ký" />
                                <input type="hidden" name="token" value="<?php echo random_string(); ?>" />
                                <input type="hidden" name="redirect_to" value="<?php echo (getRequest('redirect_to') != "") ? getRequest('redirect_to') : home_url(); ?>" />
                            </p>
                        </form>
                    </div>
                    <!--/.account-->
                </div>
            </div>
            <!--./news-block-->
        </div>
        <div class="right sidebar col-md-4 col-sm-4 col-xs-12"> 
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>