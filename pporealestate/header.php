<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <meta http-equiv="Cache-control" content="no-store; no-cache"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
    <title><?php wp_title('|', true, 'right'); ?></title>
    <meta name="author" content="PPO.VN" />
    <meta name="robots" content="index, follow" /> 
    <meta name="googlebot" content="index, follow" />
    <meta name="bingbot" content="index, follow" />
    <meta name="geo.region" content="VN" />
    <meta name="geo.position" content="14.058324;108.277199" />
    <meta name="ICBM" content="14.058324, 108.277199" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <?php if(is_home() or is_front_page()): ?>
    <meta name="keywords" content="<?php echo get_option('keywords_meta') ?>" />
    <?php endif; ?>
    <?php if(get_option(SHORT_NAME . "_fb_appid")): ?>
    <meta property="fb:app_id" content="<?php echo get_option(SHORT_NAME . "_fb_appid") ?>"/>
    <?php endif; ?>
    <link rel="publisher" href="https://plus.google.com/+PpoVnWebSoftAppsDesign"/>
    <link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />        
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <?php if (is_singular() && pings_open(get_queried_object_id())) : ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php endif; ?>

    <script>
        var siteUrl = "<?php bloginfo('siteurl'); ?>";
        var themeUrl = "<?php bloginfo('stylesheet_directory'); ?>";
        var no_image_src = themeUrl + "/images/no_image_available.jpg";
        var is_fixed_menu = <?php echo (get_option(SHORT_NAME . "_fixedMenu")) ? 'true' : 'false'; ?>;
        var show_popup = <?php echo (get_option(SHORT_NAME . "_showPopup")) ? 'true' : 'false'; ?>;
        var is_home = <?php echo is_home() ? 'true' : 'false'; ?>;
        var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
        var hotline = '<?php echo get_option(SHORT_NAME . "_hotline") ?>';
        var website = '<?php echo get_option(SHORT_NAME . "_website") ?>';
    </script>
    <?php wp_head(); ?>
    <style type="text/css">
        @media (max-width: 991px){html {margin-top:0!important}}
    </style>
</head>
<body <?php body_class(); ?>>
    <div id="ajax_loading" style="display: none;z-index: 9999999" class="ajax-loading-block-window">
        <div class="loading-image"></div>
    </div>
    <!--Alert Message-->
    <div id="nNote" class="nNote" style="display: none;"></div>
    <!--END: Alert Message-->
    
    <div id="header">
        <div class="container">
            <div class="row top_header">
                <div class="col-md-5 hidden-sm hidden-xs">
                    <div class="top-info">
                        Hotline: <a href="tel:<?php echo get_option(SHORT_NAME . "_hotline") ?>"><?php echo get_option(SHORT_NAME . "_hotline") ?></a> | 
                        Email: <a href="mailto:<?php echo get_option("info_email") ?>"><?php echo get_option("info_email") ?></a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="top_link">
                        <ul>
                            <li>
                                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> 
                                <a title="Đăng tin Bán/Cho thuê Nhà đất" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageposter")); ?>">Đăng tin</a>
                            </li>
                            <li>
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 
                                <a title="Yêu cầu Thuê/Mua" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pagesale")); ?>">Yêu cầu</a>
                            </li>
                            <li>
                                <span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span> 
                                <a title="Ký gửi nhà đất" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pagesign")); ?>">Ký gửi</a>
                            </li>
                            
                            <?php if (!is_user_logged_in()): ?>
                            <li>
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                                <a title="Đăng nhập" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pagelogin")); ?>">Đăng nhập</a>
                            </li> 
                            <li>
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                                <a title="Đăng ký" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageregister")); ?>">Đăng ký</a>
                            </li>
                            <?php else: ?>
                            <li>
                                <span class="glyphicon glyphicon-heart" aria-hidden="true"></span> 
                                <a title="Yêu thích" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageFavorites")); ?>">Yêu thích</a>
                            </li>
                            <li>
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                                <a title="Tài khoản" href="<?php echo get_page_link(get_option(SHORT_NAME . "_pageprofile")); ?>">Tài khoản</a>
                            </li>
                            <li>
                                <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 
                                <a title="Thoát" href="<?php echo wp_logout_url(); ?>">Thoát</a>
                            </li>
                            <?php endif; ?> 
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="head-mid">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div id="header_logo" itemtype="http://schema.org/Organization" itemscope="itemscope">
                            <a title="<?php bloginfo('sitename'); ?>" itemprop="url" href="<?php bloginfo('siteurl'); ?>">
                                <img alt="<?php bloginfo('sitename'); ?>" src="<?php echo get_option('sitelogo'); ?>" itemprop="logo" />
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6 hidden-xs">
                        <div class="header-hotline">
                            <a href="tel:<?php echo get_option(SHORT_NAME . "_hotline") ?>"><?php echo get_option(SHORT_NAME . "_hotline") ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ppo_menu">
            <div class="container" style="position: relative">
                <a id="menu">
                    <span class="menu-mobile-icon">&nbsp;</span>
                </a>
                <?php
                wp_nav_menu(array(
                    'container' => '',
                    'theme_location' => 'primary',
                    'menu_class' => 'main_menu',
                ));
                ?>
            </div>
            <!--MENU MOBILE-->
            <section class="menu-mobile">
                <div style="text-align: right">
                    <span class="btn-close-menu"></span>
                </div>
                <?php
                wp_nav_menu(array(
                    'container' => '',
                    'theme_location' => 'mobile',
                    'menu_class' => 'mnleft',
                ));
                ?> 
            </section>
        </div>
    </div>