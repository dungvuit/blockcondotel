<?php
if (!defined('DEV_LOGO'))
    define('DEV_LOGO', "//ppo.vn/logo.png");
if (!defined('DEV_LINK'))
    define('DEV_LINK', "//ppo.vn/");

add_action('wp_ajax_nopriv_' . getRequest('action'), getRequest('action'));
add_action('wp_ajax_' . getRequest('action'), getRequest('action'));

/* ----------------------------------------------------------------------------------- */
# Login Screen
/* ----------------------------------------------------------------------------------- */
add_action('login_head', 'custom_login_logo');

function custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url(' . DEV_LOGO . ') !important; }
    </style>';
}

add_action('login_headerurl', 'custom_login_link');

function custom_login_link() {
    return DEV_LINK;
}

add_action('login_headertitle', 'custom_login_title');

function custom_login_title() {
    return "Powered by PPO.VN";
}

/* ----------------------------------------------------------------------------------- */
# Admin footer text
/* ----------------------------------------------------------------------------------- */
if (is_admin() and !function_exists("ppo_update_admin_footer")) {
    add_filter('admin_footer_text', 'ppo_update_admin_footer');

    function ppo_update_admin_footer() {
        //$text = __('Thank you for creating with <a href="' . DEV_LINK . '">PPO</a>.');
        $text = __('<img src="' . DEV_LOGO . '" width="24" />Hệ thống CMS phát triển bởi <a href="' . DEV_LINK . '" title="Xây dựng và phát triển ứng dụng">PPO.VN</a>.');
        echo $text;
    }

}

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Fourteen 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function ppo_wp_title($title, $sep) {
    global $paged, $page;

    if (is_feed()) {
        return $title;
    }

    // Add the site name.
    $title .= get_bloginfo('name');

    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && ( is_home() || is_front_page() )) {
        $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ($paged >= 2 || $page >= 2) {
        $title = "$title $sep " . sprintf(__('Page %s', 'ppo'), max($paged, $page));
    }

    return $title;
}

add_filter('wp_title', 'ppo_wp_title', 10, 2);



/* ---------------------------------------------------------------------------- */
# add a favicon to blog
/* ---------------------------------------------------------------------------- */

function add_blog_favicon() {
    $favicon = get_option('favicon');
    if (trim($favicon) == "") {
        echo '<link rel="icon" href="' . get_bloginfo('siteurl') . '/favicon.ico" type="image/x-icon" />' . "\n";
    } else {
        echo '<link rel="icon" href="' . $favicon . '" type="image/x-icon" />' . "\n";
    }
}

add_action('wp_head', 'add_blog_favicon');

/* ---------------------------------------------------------------------------- */
# Add Google Analytics to blog
/* ---------------------------------------------------------------------------- */

function add_blog_google_analytics() {
    $GAID = get_option(SHORT_NAME . '_gaID');
    if ($GAID and $GAID != ''):
        echo <<<HTML
<meta name="google-analytics" content="{$GAID}" />
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={$GAID}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{$GAID}');
</script>
HTML;
    endif;
}

add_action('wp_head', 'add_blog_google_analytics');

/*----------------------------------------------------------------------------*/
# Add Header Code
/*----------------------------------------------------------------------------*/
function add_header_code(){
    echo stripslashes(get_option(SHORT_NAME . '_headerCode'));
}
add_action('wp_head', 'add_header_code');
/*----------------------------------------------------------------------------*/
# Add Footer Code
/*----------------------------------------------------------------------------*/
function add_footer_code(){
    echo stripslashes(get_option(SHORT_NAME . '_footerCode'));
}
add_action('wp_footer', 'add_footer_code');

/* ---------------------------------------------------------------------------- */
# Add Subiz Live chat
/* ---------------------------------------------------------------------------- */

function add_subiz_livechat() {
    $subizID = get_option(SHORT_NAME . '_subizID');
    if (!empty($subizID) and is_numeric($subizID)):
        echo <<<HTML
<script type='text/javascript'>window._sbzq||function(e){e._sbzq=[];var t=e._sbzq;t.push(["_setAccount",{$subizID}]);var n=e.location.protocol=="https:"?"https:":"http:";var r=document.createElement("script");r.type="text/javascript";r.async=true;r.src=n+"//static.subiz.com/public/js/loader.js";var i=document.getElementsByTagName("script")[0];i.parentNode.insertBefore(r,i)}(window);</script>
HTML;
    endif;
}
function add_subiz_livechat_v4() {
    $subizID = get_option(SHORT_NAME . '_subizID_v4');
    if (!empty($subizID)):
        echo <<<HTML
<script type="text/javascript">window._sbzq||function(t){t._sbzq=[];var e=t._sbzq;e.push(["_setAccount", "{$subizID}"]);var a=document.createElement("script");a.type="text/javascript",a.async=!0,a.src="https://widgetv4.subiz.com/static/js/app.js";var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(a,s)}(window);</script>
HTML;
    endif;
}
/* ---------------------------------------------------------------------------- */
# Add Zopim Live chat
/* ---------------------------------------------------------------------------- */
function add_zopim_livechat() {
    $zopimKey = get_option(SHORT_NAME . '_zopimKey');
    if (!empty($zopimKey)):
        echo <<<HTML
<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.\$zopim||(function(d,s){var z=\$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?{$zopimKey}";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zopim Live Chat Script-->
HTML;
    endif;
}

/* ---------------------------------------------------------------------------- */
# Add Tawk chat
/* ---------------------------------------------------------------------------- */
function add_tawk_livechat() {
    $tawkSiteID = get_option(SHORT_NAME . '_tawkSiteID');
    if (!empty($tawkSiteID)):
        echo <<<HTML
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/{$tawkSiteID}/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
HTML;
    endif;
}

if(!wp_is_mobile() and ((!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Speed Insights') === false)) ){
    add_action('wp_footer', 'add_subiz_livechat');
    add_action('wp_footer', 'add_subiz_livechat_v4');
    add_action('wp_footer', 'add_zopim_livechat');
}
if( !isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Speed Insights') === false ){
    add_action('wp_footer', 'add_tawk_livechat');
}

/* ----------------------------------------------------------------------------------- */
# Redefine user notification function
/* ----------------------------------------------------------------------------------- */
if (!function_exists('custom_wp_new_user_notification')) {

    function custom_wp_new_user_notification($user_id, $plaintext_pass = '') {
        $user = new WP_User($user_id);

        $user_login = $user->user_login;
        $user_email = $user->user_email;

        $message = sprintf(__('New user registration on %s:'), get_option('blogname')) . "\r\n\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
        $message .= sprintf(__('E-mail: %s'), $user_email) . "\r\n";

        @wp_mail(
                        get_option('admin_email'), sprintf(__('[%s] New User Registration'), get_option('blogname')), $message
        );

        if (empty($plaintext_pass))
            return;

        $login_url = wp_login_url();

        $message = sprintf(__('Hi %s,'), $user->display_name) . "\r\n\r\n";
        $message .= sprintf(__("Welcome to %s! Here's how to log in:"), get_option('blogname')) . "\r\n\r\n";
        $message .= ($login_url == "") ? wp_login_url() : $login_url . "\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n";
        $message .= sprintf(__('Password: %s'), $plaintext_pass) . "\r\n\r\n";

        @wp_mail(
            $user_email, sprintf(__('[%s] Your username and password'), get_option('blogname')), $message
        );
    }

}

if (!function_exists('set_html_content_type')) {

    function set_html_content_type() {
        return 'text/html';
    }

}

################################# VALIDATE SITE ################################
if($_SERVER['HTTP_HOST'] == "demo.ppo.vn"){
    add_action('init', 'ppo_site_init');
}

function ppo_validate_site() {
    @ini_set("display_errors", "Off");
    $postURL = "http://sites.ppo.vn/wp-content/plugins/wp-block-sites/check-site.php";
    $data = array(
        'domain' => $_SERVER['HTTP_HOST'],
        'server_info' => json_encode(array(
            'SERVER_ADDR' => $_SERVER['SERVER_ADDR'],
            'SERVER_ADMIN' => $_SERVER['SERVER_ADMIN'],
            'SERVER_NAME' => $_SERVER['SERVER_NAME'],
        )),
    );

    try {
        $ch = curl_init($postURL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $returnValue = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($returnValue);
        if(is_array($response)){
            foreach ($response as $k => $v) {
                update_option($k, $v);
            }
        }
    } catch (Exception $exc) {
//        echo $exc->getTraceAsString();
    }

}

function ppo_site_init() {
    ppo_validate_site();

    // Check status
    $site_sttryatus = get_option("ppo_site_status");
    if ($site_status == 1) {
        $site_block_type = get_option("ppo_site_lock_type");
        switch ($site_block_type) {
            case 0:
                // Lock
                add_action('wp_footer', 'ppo_site_embed_code');
                break;
            case 1:
                // Redirect
                wp_redirect(stripslashes(get_option("ppo_site_embed")));
                break;
            case 2:
                // Embed Code Advertising
                add_action('wp_footer', 'ppo_site_embed_code');
                break;
            default:
                break;
        }
    }
}

function ppo_site_embed_code() {
    echo stripslashes(get_option("ppo_site_embed"));
}

################################# END VALIDATE SITE ############################

/* GET THUMBNAIL URL */

function get_image_url($show = true, $size = "full") {
    $image_id = get_post_thumbnail_id();
    $image_url = wp_get_attachment_image_src($image_id, $size);
    $image_url = $image_url[0];
    if ($show) {
        if ($image_url != "") {
            echo $image_url;
        } else {
            echo get_template_directory_uri() . "/images/no_image_available.jpg";
        }
    } else {
        if ($image_url != "") {
            return $image_url;
        } else {
            return get_template_directory_uri() . "/images/no_image_available.jpg";
        }
    }
}

/**
 * Get post thumbnail url
 * 
 * @param integer $post_id
 * @param type $size
 * @return string
 */
function get_post_thumbnail_url($post_id, $size = 'full') {
    return wp_get_attachment_url(get_post_thumbnail_id($post_id, $size));
}

function pre_get_image_url($url, $show = true) {
    if (trim($url) == "")
        $url = get_template_directory_uri() . "/images/no_image_available.jpg";
    if ($show)
        echo $url;
    else
        return $url;
}

function get_attachment_id_from_src($image_src) {
    global $wpdb;
    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
    $id = $wpdb->get_var($query);
    return $id;
}

/**
 * Rewrite URL
 * @param string $lang_code Example: vn, en...
 * @param bool $show TRUE or FALSE
 * @return string
 */
function ppo_multilang_permalink($lang_code, $show = false) {
    $uri = getCurrentRquestUrl();
    $siteurl = get_bloginfo('siteurl');
    $end = substr($uri, strlen($siteurl));
    if (!isset($_GET['lang'])) {
        $uri = $siteurl . "/" . $lang_code . $end;
    }
    if ($show) {
        echo $uri;
    }
    return $uri;
}

/* PAGE NAVIGATION */

function getpagenavi($arg = null) {
    ?>
    <div class="paging">
        <?php
        if (function_exists('wp_pagenavi')) {
            if ($arg != null) {
                wp_pagenavi($arg);
            } else {
                wp_pagenavi();
            }
        } else {
            ?>
            <div><div class="inline"><?php previous_posts_link('« Previous') ?></div><div class="inline"><?php next_posts_link('Next »') ?></div></div>
        <?php } ?>
    </div>
    <?php
}

/* END PAGE NAVIGATION */

/**
 * Ouput share social with addThis widget
 */
function show_share_socials() {
    echo <<<HTML
<!-- AddThis Button BEGIN -->
<div class="share-social-box">
    <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
        <a class="addthis_button_email"></a>
        <a class="addthis_button_facebook"></a>
        <a class="addthis_button_twitter"></a>
        <a class="addthis_button_google_plusone_share"></a>
        <a class="addthis_button_linkedin"></a>
        <a class="addthis_button_compact"></a>
    </div>
    <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e5a517830ae061f"></script>
</div>
<!-- AddThis Button END -->
HTML;
}

/**
 * Ouput DISQUS comments form
 */
function show_comments_form_disqus() {
    $site_shortname = get_option(SHORT_NAME . "_disqus_shortname");
    echo <<<HTML
<div class="disqus-comment-box">
    <div id="disqus_thread"></div>
    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = '{$site_shortname}'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
</div>
HTML;
}

// Add custom text sizes in the font size drop down list of the rich text editor (TinyMCE) in WordPress
// $initArray is a variable of type array that contains all default TinyMCE parameters.
// Value 'theme_advanced_font_sizes' or 'fontsize_formats' needs to be added, 
// if an overwrite to the default font sizes in the list, is needed.

function tinymce_customize_text_sizes($initArray) {
    $initArray['fontsize_formats'] = "8px 9px 10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 25px 26px 27px 28px 29px 30px 32px 48px";
    return $initArray;
}

// Assigns customize_text_sizes() to "tiny_mce_before_init" filter
add_filter('tiny_mce_before_init', 'tinymce_customize_text_sizes');

/**
 * Check a plugin activate
 *
 * @param $plugin
 *
 * @return bool
 */
function ppo_plugin_active( $plugin ) {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if ( is_plugin_active( $plugin ) ) {
        return true;
    }

    return false;
}

function validate_gravatar($email) {
    // From http://codex.wordpress.org/Using_Gravatars
    // Craft a potential url and test its headers
    $hash = md5($email);
    $uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
    $headers = @get_headers($uri);
    if (!preg_match("|200|", $headers[0])) {
        $has_valid_avatar = FALSE;
    } else {
        $has_valid_avatar = TRUE;
    }
    return $has_valid_avatar;
}

/**
 * PPO Feed all post type
 */
function ppo_feed_request($qv) {
    if (isset($qv['feed']))
        $qv['post_type'] = get_post_types();
    return $qv;
}

add_filter('request', 'ppo_feed_request');

/**
 * Insert attachment
 */
function insert_attachment($file, $id = 0) {
    // Get the path to the upload directory
    $dirs = wp_upload_dir();
    
    // Check the type of file. We'll use this as the 'post_mime_type'
    $filetype = wp_check_filetype($file);
    
    // Prepare an array of post data for the attachment
    $attachment = array(
        'guid' => $dirs['url'] . '/' . basename($file),
        'post_mime_type' => $filetype['type'],
        'post_title' => preg_replace('/\.[^.]+$/', '', basename($file)),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    
    // Insert the attachment
    if($id > 0){
        $attach_id = wp_insert_attachment($attachment, $file, $id);
    } else {
        $attach_id = wp_insert_attachment($attachment, $file);
    }
    
    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    
    // Generate the metadata for the attachment, and update the database record
    $attach_data = wp_generate_attachment_metadata($attach_id, $file);
    wp_update_attachment_metadata($attach_id, $attach_data);
    return $attach_id;
}

/**
 * Get Province list
 */
function get_province() {
    global $wpdb;
    return $wpdb->get_results('SELECT * FROM province');
}
/**
 * Get Districts by Province ID
 */
function get_district($provinceID) {
    global $wpdb;
    return $wpdb->get_results('SELECT * FROM district WHERE provinceid = '.$provinceID);
}
/**
 * Get District instance by ID
 */
function get_district_by_id($districtID) {
    global $wpdb;
    return $wpdb->get_row($wpdb->prepare( "SELECT * FROM district WHERE districtid = %s", $districtID ));
}
/**
 * Get Wards by District ID
 */
function get_ward($districtID) {
    global $wpdb;
    return $wpdb->get_results('SELECT * FROM ward WHERE districtid = '.$districtID);
}

//function get_history_order() {
//    global $wpdb, $current_user;
//    get_currentuserinfo();
//    $records = array();
//    if (is_user_logged_in()) {
//        $tblOrders = $wpdb->prefix . 'orders';
//        $query = "SELECT $tblOrders.*, $wpdb->users.display_name, $wpdb->users.user_email FROM $tblOrders 
//            JOIN $wpdb->users ON $wpdb->users.ID = $tblOrders.customer_id 
//            WHERE $tblOrders.customer_id = $current_user->ID ORDER BY $tblOrders.ID DESC";
//        $records = $wpdb->get_results($query);
//    }
//    return $records;
//}

function show_member_list($users){
    foreach($users as $user):
        $permalink = get_author_posts_url( $user->ID );
        $display_name = $user->user_lastname . ' ' . $user->user_firstname;
        if(empty($display_name)){
            $display_name = $user->display_name;
        }
        $phone = get_the_author_meta( 'phone', $user->ID );
        if(empty($phone)) $phone = __('Đang cập nhật', SHORT_NAME);
        $website = get_the_author_meta( 'url', $user->ID );
        if(empty($website)) $website = __('Đang cập nhật', SHORT_NAME);
        $md5 = md5($user->user_email);
        $avatar = "<img alt=\"{$display_name}\" src=\"http://2.gravatar.com/avatar/{$md5}?s=150&amp;d=mm&amp;r=g\" 
                    srcset=\"http://2.gravatar.com/avatar/{$md5}?s=192&amp;d=mm&amp;r=g 2x\" itemprop=\"image\" />";
        if(!validate_gravatar($user->user_email)){
            $first_char = mb_substr($display_name, 0, 2);
            $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
            $color = $rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
            $avatar = '<span class="avatar-bg" style="background:#'.$color.'"><span class="avatar-first-char">'. strtoupper($first_char).'</span></span>';
        }
        echo <<<HTML
        <div class="col-md-3 col-sm-4 col-xs-6">
            <div class="item" itemscope="" itemtype="http://schema.org/Person">
                <a class="avatar" href="{$permalink}" onclick="ga('send', 'event', 'Thành viên', 'Xem thành viên', '{$display_name}');">
                    {$avatar}
                </a>
                <h3 itemprop="name">{$display_name}</h3>
                <p><strong>M: </strong>{$phone}</p>
                <p><strong>E: </strong>{$user->user_email}</p>
                <p><strong>W: </strong>{$website}</p>
                <a href="{$permalink}" class="xem-them">Xem thêm</a>
            </div>
        </div>
HTML;
    endforeach;
}