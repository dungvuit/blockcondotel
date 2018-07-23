<?php
/*
  Template Name: Favorites
 */
if (!is_user_logged_in()) {
    wp_redirect( home_url('/login/') );
}
get_header(); 

global $wpdb, $current_user;
get_currentuserinfo();
$favorites = $wpdb->prefix . 'favorites';
$user_id = $current_user->ID;
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
            <div class="products">
                <div class="section-header">
                    <div class="list-header">
                        <h1 class="span-title">
                            <?php _e('Danh sách yêu thích của bạn', SHORT_NAME) ?>
                        </h1>
                    </div>
                </div>
                <div class="list_product">
                    <?php
                    $result = $wpdb->get_results($wpdb->prepare( "SELECT * FROM $favorites WHERE user_id=%d", $user_id ));
                    if(!empty($result)){
                        foreach ($result as $value) :
                            $post_id = $value->post_id;
                            include THEME_DIR . '/template/favorite_item.php';
                        endforeach;
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="cat-sidebar sidebar col-md-4 col-sm-6">
            <?php get_template_part('template', 'sidebarsearch'); ?>
            <?php if ( is_active_sidebar( 'sidebar_archive' ) ) { dynamic_sidebar( 'sidebar_archive' ); } ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
