<?php
if (is_user_logged_in()) {
    wp_redirect( home_url('/profile/') );
}
/*
  Template Name: Login
 */
get_header();
?>
<div class="container main_content">
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb30">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="row">
        <div class="left col-md-8 col-sm-8 col-xs-12 login">
            <h1><?php the_title(); ?></h1>
            <?php
            $login = (isset($_GET['login']) ) ? $_GET['login'] : 0;
            if ($login === "failed") {
                echo '<p class="login-msg"><strong>ERROR:</strong> Sai Tên đăng nhập hoặc mật khẩu.</p>';
            } elseif ($login === "empty") {
                echo '<p class="login-msg"><strong>ERROR:</strong> Tên đăng nhập hoặc mật khẩu bị trống.</p>';
            } elseif ($login === "false") {
                echo '<p class="login-msg"><strong>ERROR:</strong> Bạn đã thoát đăng nhập.</p>';
            }
            
            if(isset($_REQUEST['checkemail']) and $_REQUEST['checkemail'] == 'confirm'){
                echo '<div class="description">' . __( 'Kiểm tra email của bạn và nhấp vào liên kết để đặt lại mật khẩu.', SHORT_NAME ) . '</div>';
            }
            
            if ( !is_user_logged_in() ) { // Display WordPress login form:
                $args = array(
                    'redirect' => admin_url(), 
                    'form_id' => 'loginform-custom',
                    'label_username' => __( 'Tên đăng nhập: ' ),
                    'label_password' => __( 'Mật khẩu: ' ),
                    'label_remember' => __( 'Ghi nhớ đăng nhập' ),
                    'label_log_in' => __( 'Đăng nhập' ),
                    'remember' => true
                );
                wp_login_form( $args );
            } else { // If logged in:
                wp_loginout( home_url() ); // Display "Log Out" link.
                echo " | ";
                wp_register('', ''); // Display "Site Admin" link.
            }
            ?>
            <div class="login-bottom">
                <a class="pull-left" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageregister")); ?>">Đăng ký</a>
                <a class="pull-right" href="<?php echo home_url('/lostpassword/'); ?>">Quên mật khẩu?</a>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="right sidebar col-md-4 col-sm-4 col-xs-12">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>