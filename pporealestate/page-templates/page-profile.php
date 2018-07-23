<?php
/*
  Template Name: Profile
 */
if (!is_user_logged_in()) {
    wp_redirect( home_url('/login/') );
}
get_header(); 

$author = wp_get_current_user();
$display_name = $author->user_lastname . ' ' . $author->user_firstname;
if(empty($display_name)){
    $display_name = $author->display_name;
}
$phone = get_the_author_meta( 'phone', $author->ID );
if(empty($phone)) $phone = get_option(SHORT_NAME . "_hotline");

$website = get_the_author_meta( 'url', $author->ID );
if(empty($website)) $website = "#";

$fbURL = get_the_author_meta( 'facebook', $author->ID );
if(empty($fbURL)) $fbURL = get_option(SHORT_NAME . "_fbURL");

$googlePlusURL = get_the_author_meta( 'googleplus', $author->ID );
if(empty($googlePlusURL)) $googlePlusURL = get_option(SHORT_NAME . "_googlePlusURL");

$twitterURL = get_the_author_meta( 'twitter', $author->ID );
if(empty($twitterURL)) $twitterURL = get_option(SHORT_NAME . "_twitterURL");
?>
<div class="container main_content">
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb30">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="row">
        <div class="left col-md-8 col-sm-12">
            <div class="user-info">
                <div class="row">
                    <div class="col-md-2 col-sm-3">
                        <div class="avatar">
                            <?php echo get_avatar($author->ID, 108); ?>
                        </div>
                    </div>
                    <div class="col-md-10 col-sm-9">
                        <div class="info">
                            <h1 class="name"><?php echo $display_name; ?></h1>
                            <h3 class="login"><?php echo $author->user_login ?></h3>
                            <div class="social_footer">
                                <ul>
                                    <li class="facebook"><a target="_self" href="<?php echo $fbURL; ?>"><i class="fa fa-facebook"></i></a></li>
                                    <li class="gplus"><a target="_self" href="<?php echo $googlePlusURL; ?>"><i class="fa fa-google-plus"></i></a></li>
                                    <li class="twitter"><a target="_self" href="<?php echo $twitterURL; ?>"><i class="fa fa-twitter"></i></a></li>
                                    <li class="website"><a href="<?php echo $website; ?>" target="_blank"><i class="fa fa-link"></i></a></li>
                                    <li class="email"><a href="mailto:<?php echo $author->user_email; ?>"><i class="fa fa-envelope"></i></a></li>
                                    <li class="phone"><a href="tel:<?php echo $phone; ?>"><i class="fa fa-phone"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-10">
                    <h3 class="user-block-title">Thông tin cá nhân</h3>
                    <p class="description">- Bạn có thể thay ảnh đại diện tại <a href="https://en.gravatar.com/" target="_blank">Gravatar</a>.</p>
                    <p class="description">- Thay đổi địa chỉ Email cần liên hệ <a href="<?php echo get_page_link(get_option(SHORT_NAME . "_pagecontact")); ?>" target="_blank">Administrator</a>.</p>
                    <p class="description">- Thay đổi mật khẩu <a href="<?php echo get_page_link(get_option(SHORT_NAME . "_pagelostpassword")); ?>" target="_blank">tại đây</a>.</p>
                    <form action="" method="post" class="form" id="frmChangeProfile">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="first_name">Tên</label>
                                    <input type="text" id="first_name" name="first_name" value="<?php echo $author->user_firstname ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="last_name">Họ và đệm</label>
                                    <input type="text" id="last_name" name="last_name" value="<?php echo $author->user_lastname ?>" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="url">Website</label>
                                    <input type="text" id="url" name="url" value="<?php echo $website; ?>" class="form-control" placeholder="http://domain.com" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="googleplus">Google+ URL</label>
                            <input type="text" id="googleplus" name="googleplus" value="<?php echo $googlePlusURL; ?>" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="twitter">Twitter username (Không bao gồm @)</label>
                            <input type="text" id="twitter" name="twitter" value="<?php echo $twitterURL; ?>" class="form-control" placeholder="username" />
                        </div>
                        <div class="form-group">
                            <label for="facebook">Facebook profile URL</label>
                            <input type="text" id="facebook" name="facebook" value="<?php echo $fbURL; ?>" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="description">Giới thiệu</label>
                            <textarea id="description" name="description" class="form-control" rows="5"><?php echo $author->description; ?></textarea>
                        </div>
                        <input type="button" class="btnSubmit" value="Lưu thay đổi" />
                        <input type="hidden" name="action" value="change_user_profile" />
                        <input type="hidden" name="user_id" value="<?php echo $author->ID ?>" />
                    </form>
                </div>
            </div>
        </div>
    
        <div class="cat-sidebar sidebar col-md-4 col-sm-6">
            <?php get_sidebar('user') ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
