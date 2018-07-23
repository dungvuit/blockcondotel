<?php 
get_header(); 

$author = get_queried_object();
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
                <div class="biographical_info">
                    <?php echo $author->description; ?>
                </div>
            </div>
            <div class="products">
                <div class="section-header">
                    <div class="list-header">
                        <h1 class="span-title">
                            <?php single_cat_title(); ?>
                        </h1>
                    </div>
                </div>
                <div class="list_product">
                    <?php 
                    while (have_posts()) : the_post(); 
                        get_template_part('template', 'product_item');
                    endwhile;
                    getpagenavi();
                    ?>
                </div>
            </div>
        </div>
        <div class="cat-sidebar sidebar col-md-4 col-sm-6">
            <?php get_template_part('template', 'sidebarsearch'); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
