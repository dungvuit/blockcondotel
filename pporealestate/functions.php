<?php

######## BLOCK CODE NAY LUON O TREN VA KHONG DUOC XOA ##########################
include 'includes/config.php';
include 'libs/HttpFoundation/Request.php';
include 'libs/HttpFoundation/Response.php';
include 'libs/HttpFoundation/Session.php';
include 'libs/custom.php';
include 'libs/common-scripts.php';
include 'libs/meta-box.php';
include 'libs/theme_functions.php';
include 'libs/theme_settings.php';
######## END: BLOCK CODE NAY LUON O TREN VA KHONG DUOC XOA ##########################
include 'includes/product.php';
include 'includes/project.php';
include 'includes/feedback.php';
include 'includes/question-answer.php';
include 'includes/supplier.php';
include 'includes/favorites.php';
include 'includes/widgets/ads.php';
include 'includes/widgets/category-post-list-widget.php';
include 'includes/widgets/category-posts-list.php';
include 'includes/widgets/product-categories-list.php';
include 'includes/widgets/project-list.php';
include 'includes/widgets/popular-users.php';
include 'includes/shortcodes.php';
include 'includes/custom-user.php';
include 'includes/api.php';
include 'ajax.php';

//Visual composer shortcodes
if ( class_exists( 'Vc_Manager' ) && ppo_plugin_active( 'js_composer/js_composer.php' ) ) {
    require THEME_DIR . 'vc-shortcodes/vc-shortcodes.php';
}

if (is_admin()) {
    $basename_excludes = array('plugins.php', 'plugin-install.php', 'plugin-editor.php', 'themes.php', 
        'theme-install.php', 'theme-editor.php', 'tools.php', 'import.php', 'export.php');
    if (in_array($basename, $basename_excludes)) {
//         wp_redirect(admin_url());
    }
    
    if (!current_user_can('administrator') and !current_user_can('editor')) {
        $page_viewed = basename($_SERVER['PHP_SELF']);
        if($page_viewed != "admin-ajax.php"){
            $page_profile = home_url('/profile/');
            wp_redirect($page_profile);
            exit;
        }
    }
    
    // Add filter
    add_filter('acf/settings/show_admin', '__return_false');
    add_filter('acf/settings/show_updates', '__return_false');

    // Add action
    add_action('admin_menu', 'custom_remove_menu_pages');
    add_action('admin_menu', 'remove_menu_editor', 102);
}

/**
 * Remove admin menu
 */
function custom_remove_menu_pages() {
    remove_menu_page('edit-comments.php');
    remove_menu_page('plugins.php');
    remove_menu_page('tools.php');
    remove_menu_page('wpseo_dashboard');
    remove_menu_page('vc-general');
    remove_menu_page('itsec');
}

function remove_menu_editor() {
    remove_submenu_page('themes.php', 'themes.php');
    remove_submenu_page('themes.php', 'theme-editor.php');
    remove_submenu_page('plugins.php', 'plugin-editor.php');
    remove_submenu_page('options-general.php', 'options-writing.php');
    remove_submenu_page('options-general.php', 'options-discussion.php');
    remove_submenu_page('options-general.php', 'options-media.php');
}

/* ----------------------------------------------------------------------------------- */
# Setup Theme
/* ----------------------------------------------------------------------------------- */
if (!function_exists("ppo_theme_setup")) {

    function ppo_theme_setup() {
        ## Enable Links Manager (WP 3.5 or higher)
//        add_filter('pre_option_link_manager_enabled', '__return_true');
        
        // This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 
            'assets/css/editor-style.css',
            'assets/css/wp-default.css',
            'assets/genericons/genericons.css', 
            'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'
        ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
        
        /*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );
        
        ## Post Thumbnails
        if (function_exists('add_theme_support')) {
            add_theme_support('post-thumbnails');
        }

        if (function_exists('add_image_size')) {
            add_image_size('400x250', 400, 250, true);
            add_image_size('170x115', 170, 115, true);
            add_image_size('318x204', 318, 204, true);
            add_image_size('347x232', 347, 232, true);
            add_image_size('104x69', 104, 69, true);
            add_image_size('275x150', 275, 150, true);
        }

        ## Register menu location
        register_nav_menus(array(
            'primary' => 'Primary Location',
            'mobile' => 'Mobile Menu',
            'footermenu' => 'Footer Location',
        ));
        
        ## Remove admin bar
        if (current_user_can('administrator') || current_user_can('editor')) {
            show_admin_bar(true);
        } else {
            show_admin_bar(false);
        }
        
        // Remove WP Generator Meta Tag
        remove_action('wp_head', 'wp_generator');
    }

}

add_action('after_setup_theme', 'ppo_theme_setup');

/* ----------------------------------------------------------------------------------- */
# Widgets init
/* ----------------------------------------------------------------------------------- */
if (!function_exists("ppo_widgets_init")) {

    // Register Sidebar
    function ppo_widgets_init() {
        register_sidebar(array(
            'id' => __('sidebar'),
            'name' => __('Sidebar'),
            'before_widget' => '<div id="%1$s" class="widget-container widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'id' => 'sidebar_qna',
            'name' => __('Sidebar Q&A', SHORT_NAME),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'id' => 'sidebar_archive',
            'name' => __('Sidebar Archive', SHORT_NAME),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'id' => 'sidebar_product',
            'name' => __('Sidebar Product', SHORT_NAME),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'id' => 'sidebar_user',
            'name' => __('Sidebar User', SHORT_NAME),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'id' => 'posthomesidebar',
            'name' => __('Post Home Sidebar'),
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '',
            'after_title' => '',
        ));
        register_sidebar(array(
            'id' => 'homerightsidebar',
            'name' => __('Home Right Sidebar'),
            'before_widget' => '<div id="%1$s" class="widget-container widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="widget-title">',
            'after_title' => '</div>',
        ));
        register_sidebar(array(
            'id' => 'footer1',
            'name' => __('Footer 1', SHORT_NAME),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'id' => 'footer2',
            'name' => __('Footer 2', SHORT_NAME),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'id' => 'footer3',
            'name' => __('Footer 3', SHORT_NAME),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }
}

add_action('widgets_init', 'ppo_widgets_init');

/* ----------------------------------------------------------------------------------- */
# Enqueue scripts and styles for the front end.
/* ----------------------------------------------------------------------------------- */
function ppo_enqueue_scripts() {
    // Common stylesheet
    wp_enqueue_style( SHORT_NAME . '-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '3.3.7' );
    wp_enqueue_style( SHORT_NAME . '-font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.7.0' );
    wp_enqueue_style( SHORT_NAME . '-excoloSlider', get_template_directory_uri() . '/assets/css/jquery.excoloSlider.css', array(), '1.1.0' );
//    wp_enqueue_style( SHORT_NAME . '-jquery-ui', '//code.jquery.com/ui/1.11.1/themes/start/jquery-ui.css', array(), '1.11.1' );
    wp_enqueue_style( SHORT_NAME . '-wp-default', get_template_directory_uri() . '/assets/css/wp-default.css', array(), THEME_VER );
    wp_enqueue_style( SHORT_NAME . '-owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), THEME_VER );
    wp_enqueue_style( SHORT_NAME . '-toastr', get_template_directory_uri() . '/assets/css/toastr.min.css', array(), '2.1.3' );
    wp_enqueue_style( SHORT_NAME . '-common', get_template_directory_uri() . '/assets/css/common.css', array(), THEME_VER );

    // Visual Composer element stylesheet
    wp_enqueue_style( SHORT_NAME . '-vc-carousel-projects', get_template_directory_uri() . '/vc-shortcodes/css/carousel-projects.css', array(), THEME_VER );
    wp_enqueue_style( SHORT_NAME . '-vc-carousel-products', get_template_directory_uri() . '/vc-shortcodes/css/carousel-products.css', array(), THEME_VER );
    wp_enqueue_style( SHORT_NAME . '-vc-carousel-products2', get_template_directory_uri() . '/vc-shortcodes/css/carousel-products2.css', array(), THEME_VER );
    wp_enqueue_style( SHORT_NAME . '-vc-carousel-users', get_template_directory_uri() . '/vc-shortcodes/css/carousel-users.css', array(), THEME_VER );
    wp_enqueue_style( SHORT_NAME . '-vc-carousel-suppliers', get_template_directory_uri() . '/vc-shortcodes/css/carousel-suppliers.css', array(), THEME_VER );
    wp_enqueue_style( SHORT_NAME . '-vc-carousel-posts', get_template_directory_uri() . '/vc-shortcodes/css/carousel-posts.min.css', array(), THEME_VER );
    wp_enqueue_style( SHORT_NAME . '-vc-featured-posts', get_template_directory_uri() . '/vc-shortcodes/css/featured-posts.css', array(), THEME_VER );
    wp_enqueue_style( SHORT_NAME . '-vc-list-posts', get_template_directory_uri() . '/vc-shortcodes/css/list-posts.min.css', array(), THEME_VER );
    wp_enqueue_style( SHORT_NAME . '-vc-popular-projects', get_template_directory_uri() . '/vc-shortcodes/css/popular-projects.css', array(), THEME_VER );
    wp_enqueue_style( SHORT_NAME . '-vc-product-categories-list', get_template_directory_uri() . '/vc-shortcodes/css/product-categories-list.css', array(), THEME_VER );
    wp_enqueue_style( SHORT_NAME . '-vc-project-list', get_template_directory_uri() . '/vc-shortcodes/css/project-list.css', array(), THEME_VER );
    wp_enqueue_style( SHORT_NAME . '-vc-service-item', get_template_directory_uri() . '/vc-shortcodes/css/service-item.css', array(), THEME_VER );
    
    // Load our main stylesheet.
    wp_enqueue_style( SHORT_NAME . '-style', get_stylesheet_uri() );

    // Load the Internet Explorer specific stylesheet.
    wp_enqueue_style( SHORT_NAME . '-ie', get_template_directory_uri() . '/assets/css/ie.css', array( SHORT_NAME . '-style' ), THEME_VER );
    wp_style_add_data( SHORT_NAME . '-ie', 'conditional', 'lt IE 9' );

    if ( is_singular() && comments_open() ) {
        $comment_type = get_option(SHORT_NAME . "_coment_type");
        if(!in_array($comment_type, array('fb', 'disqus'))){
            
            // Add Genericons font, used in the main stylesheet.
            wp_enqueue_style( SHORT_NAME . '-genericons', get_template_directory_uri() . '/assets/genericons/genericons.css', array(), '3.4.1' );

            // Add comment stylesheet
            wp_enqueue_style( SHORT_NAME . '-comment', get_template_directory_uri() . '/assets/css/comment.css', array(), THEME_VER );

            // Add comment script
            wp_enqueue_script( 'comment-reply' );
        }
    }

    // Add script references
    wp_deregister_script( 'wp-embed' );
    wp_enqueue_script( 'jquery-ui-accordion' );
//    wp_enqueue_script( SHORT_NAME . '-jquery-ui', get_template_directory_uri() . '/assets/js/jquery-ui.js', array( ), '1.11.1', true );
    wp_enqueue_script( SHORT_NAME . '-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( ), '3.3.7', true );
    wp_enqueue_script( SHORT_NAME . '-excoloSlider', get_template_directory_uri() . '/assets/js/excoloSlider.js', array( ), '1.1.0', true );
    wp_enqueue_script( SHORT_NAME . '-responsive-tabs', get_template_directory_uri() . '/assets/js/responsive-tabs.js', array( ), THEME_VER, true );
    wp_enqueue_script( SHORT_NAME . '-simplesidebar', get_template_directory_uri() . '/assets/js/jquery.simplesidebar.js', array( ), THEME_VER, true );
    wp_enqueue_script( SHORT_NAME . '-scrolltofixed', get_template_directory_uri() . '/assets/js/jquery-scrolltofixed-min.js', array( ), THEME_VER, true );
    wp_enqueue_script( SHORT_NAME . '-owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( ), THEME_VER, true );
    wp_enqueue_script( SHORT_NAME . '-toastr', get_template_directory_uri() . '/assets/js/toastr.min.js', array( ), '2.1.3', true );
    wp_enqueue_script( SHORT_NAME . '-custom', get_template_directory_uri() . '/assets/js/custom.js', array( ), THEME_VER, true );
    wp_enqueue_script( SHORT_NAME . '-ajax', get_template_directory_uri() . '/assets/js/ajax.min.js', array( ), THEME_VER, true );
    wp_enqueue_script( SHORT_NAME . '-app', get_template_directory_uri() . '/assets/js/app.min.js', array( ), THEME_VER, true );
}

add_action( 'wp_enqueue_scripts', 'ppo_enqueue_scripts' );

function ppo_script_add_data() {
    echo <<<HTML
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
HTML;
}

add_action('wp_head', 'ppo_script_add_data');

/* ----------------------------------------------------------------------------------- */
# User login
/* ----------------------------------------------------------------------------------- */
add_filter('login_redirect', 'admin_default_page');
add_action('init', 'redirect_after_logout');
add_action('init', 'redirect_login_page');
add_action('wp_login_failed', 'login_failed');
add_action( 'login_form_lostpassword', 'redirect_to_custom_lostpassword' );
add_action( 'login_form_lostpassword', 'custom_do_password_lost' );
add_shortcode( 'custom-lost-password-form', 'ppo_render_password_lost_form' );

function admin_default_page() {
    $profile_page = get_page_link(get_option(SHORT_NAME . "_pageprofile"));
    return $profile_page;
}

function redirect_after_logout() {
    if (preg_match('#(wp-login.php)?(loggedout=true)#', $_SERVER['REQUEST_URI'])){
        wp_redirect(get_option('siteurl'));
    }
}

function redirect_login_page() {
    $login_page = home_url('/login/');
    $page_viewed = basename($_SERVER['REQUEST_URI']);

    if ($page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
        wp_redirect($login_page);
        exit;
    }
}

function login_failed() {
    $login_page = home_url('/login/');
    wp_redirect($login_page . '?login=failed');
    exit;
}

function verify_username_password($user, $username, $password) {
    $login_page = home_url('/login/');
    if ($username == "" || $password == "") {
        wp_redirect($login_page . "?login=empty");
        exit;
    }
}
/**
 * Redirects the user to the custom "Forgot your password?" page instead of
 * wp-login.php?action=lostpassword.
 */
function redirect_to_custom_lostpassword() {
    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
        if ( is_user_logged_in() ) {
            wp_redirect( home_url('/profile/') );
            exit;
        }
 
        wp_redirect( home_url( 'lostpassword' ) );
        exit;
    }
}
/**
 * A shortcode for rendering the form used to initiate the password reset.
 * [custom-lost-password-form]
 *
 * @param  array   $attributes  Shortcode attributes.
 * @param  string  $content     The text content for shortcode. Not used.
 *
 * @return string  The shortcode output
 */
function ppo_render_password_lost_form( $attributes, $content = null ) {
    // Parse shortcode attributes
    $default_attributes = array( 'show_title' => true );
    $attributes = shortcode_atts( $default_attributes, $attributes );

    return get_template_html( 'password_lost_form', $attributes );
}
/**
 * Initiates password reset.
 */
function custom_do_password_lost() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        $errors = retrieve_password();
        if ( is_wp_error( $errors ) ) {
            // Errors found
            $redirect_url = home_url( '/lostpassword/' );
            $redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
        } else {
            // Email sent
            $redirect_url = home_url( '/login/' );
            $redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
        }
 
        wp_redirect( $redirect_url );
        exit;
    }
}

/**
* Render the contents of the given template to a string and returns it.
* @param    string  $template_name  The name of the template to render (without .php)
* @param    array   $attributes     The PHP variables for the template
*
* @return   string                  The contents of the template.
*/
function get_template_html($template_name, $attributes = null) {
    if (!$attributes) {
        $attributes = array();
    }
    
    ob_start();
    do_action('personalize_div_before_' . $template_name);
    require( $template_name . '.php' );
    do_action('personalize_div_before_' . $template_name);
    $html = ob_get_contents();
    ob_end_clean();

    return $html;
}

## Add custom script to Admin Footer

function admin_add_custom_js() {
    ?>
    <script type="text/javascript">/* <![CDATA[ */
        jQuery(function ($) {
            var area = new Array();

            $.each(area, function (index, id) {
                //tinyMCE.execCommand('mceAddControl', false, id);
                tinyMCE.init({
                    selector: "textarea#" + id,
                    height: 400
                });
                $("#newmeta-submit").click(function () {
                    tinyMCE.triggerSave();
                });
            });

            $(".submit input[type='submit']").click(function () {
                if (typeof tinyMCE != 'undefined') {
                    tinyMCE.triggerSave();
                }
            });

        });
        /* ]]> */
    </script>
    <?php

}

add_action('admin_print_footer_scripts', 'admin_add_custom_js', 99);

/* ----------------------------------------------------------------------------------- */
# Custom search
/* ----------------------------------------------------------------------------------- */
add_action('pre_get_posts', 'custom_search_filter');

function custom_search_filter($query) {
    // where in backend
    if(is_admin() and getRequest('post_type') == 'product'){
        $object_poster = getRequest('object_poster');
        $product_permission = getRequest('product_permission');
        $meta_query = array(
            'relation' => 'AND',
        );
        if(!empty($object_poster)){
            $meta_query[] = array(
                'key' => 'object_poster',
                'value' => $object_poster,
                'compare' => '='
            );
        }
        if(!empty($product_permission)){
            $meta_query[] = array(
                'key' => 'product_permission',
                'value' => $product_permission,
                'compare' => '='
            );
        }
        $query->set('meta_query', $meta_query);
    }
    // where in frontend
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_search) {
            $category = getRequest('category');
            $price = getRequest('price');
            $city = getRequest('city');
            $district = getRequest('district');
            $ward = getRequest('ward');
            $street = getRequest('street');
            $room = getRequest('room');
            $direction = getRequest('direction');
            $purpose = getRequest('purpose');
            $special = getRequest('special');
            $area = getRequest('area');
            $project = getRequest('project');
            $products_per_page = intval(get_option(SHORT_NAME . "_product_pager"));
            $tax_query = array('relation' => 'AND');
            $meta_query = array(
                'relation' => 'AND',
                array(
                    'key' => 'end_time',
                    'value' => date('Y/m/d', strtotime("today")),
                    'compare' => '>=',
                    'type' => 'DATE'
                )
            );
            if(!empty($category) and $category > 0){
                $tax_query[] = array(
                    'taxonomy' => 'product_category',
                    'field'    => 'term_id',
                    'terms'    => array( $category ),
		);
            }
            if(!empty($price) and $price > 0){
                $tax_query[] = array(
                    'taxonomy' => 'product_price',
                    'field'    => 'term_id',
                    'terms'    => array( $price ),
		);
            }
            if(!empty($purpose) and $purpose > 0){
                $tax_query[] = array(
                    'taxonomy' => 'product_purpose',
                    'field'    => 'term_id',
                    'terms'    => array( $purpose ),
		);
            }
            if(!empty($special) and $special > 0){
                $tax_query[] = array(
                    'taxonomy' => 'product_special',
                    'field'    => 'term_id',
                    'terms'    => array( $special ),
		);
            }
            if(!empty($area) and $area > 0){
                $tax_query[] = array(
                    'taxonomy' => 'product_acreage',
                    'field'    => 'term_id',
                    'terms'    => array( $area ),
		);
            }
            if(!empty($city)){
                $meta_query[] = array(
                    'key'     => 'city',
                    'value'   => $city,
		);
            }
            if(!empty($room)){
                $meta_query[] = array(
                    'key'     => 'so_phong',
                    'value'   => $room,
		);
            }
            if(!empty($district)){
                $meta_query[] = array(
                    'key'     => 'district',
                    'value'   => $district,
		);
            }
            if(!empty($direction)){
                $meta_query[] = array(
                    'key'     => 'direction',
                    'value'   => $direction,
		);
            }
            if(!empty($ward)){
                $meta_query[] = array(
                    'key'     => 'ward',
                    'value'   => $ward,
		);
            }
            if(!empty($street)){
                $meta_query[] = array(
                    'key'     => 'street',
                    'value'   => $street,
		);
            }
            if(!empty($project) and $project > 0){
                $meta_query[] = array(
                    'key'     => 'project',
                    'value'   => $project,
		);
            }
            
            $query->set('post_type', 'product');
            $query->set('orderby', array('not_in_vip' => 'DESC', 'product_permission' => 'DESC', 'post_date' => 'DESC'));
//            $query->set('orderby', array('meta_value_num', 'post_date'));
            $query->set('meta_key', 'not_in_vip');
//            $query->set('order', 'DESC');
            $query->set('posts_per_page', $products_per_page);
            $query->set('tax_query', $tax_query);
            $query->set('meta_query', $meta_query);
        } else if ($query->is_tax and ( is_tax('product_category') || is_tax('project_category'))) {
            $products_per_page = intval(get_option(SHORT_NAME . "_product_pager"));
            $query->set('posts_per_page', $products_per_page);
        }
        if ($query->is_tax and is_tax('product_category')) {
            $meta_query = array(
                array(
                    'key' => 'end_time',
                    'value' => date('Y/m/d', strtotime("today")),
                    'compare' => '>=',
                    'type' => 'DATE'
                )
            );
            
            $query->set('orderby', array('meta_value_num', 'post_date'));
            $query->set('meta_key', 'not_in_vip');
            $query->set('order', 'DESC');
            $query->set('meta_query', $meta_query);
        }
        if ($query->is_author) {
            $query->set('post_type', 'product');
            $query->set('orderby', array('meta_value_num', 'post_date'));
            $query->set('meta_key', 'not_in_vip');
            $query->set('order', 'DESC');
            $query->set('posts_per_page', $products_per_page);
        }
    }
    return $query;
}

/**
 * Add admin bar items
 */
if(!is_admin()){
    add_action('admin_bar_menu', 'add_toolbar_items', 100);
}

function add_toolbar_items($admin_bar) {
    $admin_bar->remove_menu('wp-logo');
//    $admin_bar->remove_menu('site-name');
    $admin_bar->remove_menu('customize');
    $admin_bar->remove_menu('updates');
//    $admin_bar->remove_menu('comments');
    $admin_bar->remove_menu('autoptimize');
    $admin_bar->remove_menu('wpseo-menu');
    $admin_bar->remove_menu('ubermenu');
    $admin_bar->remove_menu('itsec_admin_bar_menu');
}

/**
 * Danh sách Phương hướng
 */
function direction_list() {
    return array(
        'dong' => 'Đông',
        'dong_nam' => 'Đông Nam',
        'dong_bac' => 'Đông Bắc',
        'nam' => 'Nam',
        'bac' => 'Bắc',
        'tay' => 'Tây',
        'tay_nam' => 'Tây Nam',
        'tay_bac' => 'Tây Bắc',
    );
}

/**
 * Lấy giá trị của một Hướng theo key
 */
function get_direction($key) {
    $array = direction_list();
    return $array[$key];
}

/**
 * Danh sách Phòng ngủ
 */
function room_list() {
    return array(
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
    );
}

/**
 * Lấy giá trị của một phòng ngủ theo key
 */
function get_room($key) {
    $array = room_list();
    return $array[$key];
}

/**
 * Danh sách Đơn vị tiền tệ
 */
function unitCurrency_list() {
    return array(
        'default' => 'Thỏa thuận',
        'vnd' => 'VND',
        'usd' => 'USD',
        'trieu' => 'Triệu',
        'ty' => 'Tỷ',
        'vang' => 'Lượng vàng',
    );
}

/**
 * Lấy giá trị của một đơn vị tiền tệ theo key
 */
function get_unitCurrency($key) {
    $array = unitCurrency_list();
    return $array[$key];
}

/**
 * Danh sách Đơn vị giá
 */
function unitPrice_list() {
    return array(
        'm' => '/m2',
        'mmonth' => '/m2/tháng',
        'total' => '/tổng',
        'month' => '/tháng',
        'room' => '/phòng',
    );
}

/**
 * Lấy giá trị của một đơn vị theo key
 */
function get_unitPrice($key) {
    $array = unitPrice_list();
    return $array[$key];
}

/**
 * Danh sách Đối tượng đăng tin
 */
function get_object_posters(){
    return array(
        'san_bds' => 'Sàn BĐS',
        'investor' => 'Chủ đầu tư',
        'chu_nha' => 'Chủ nhà',
        'broker' => 'Nhà môi giới tự do',
        'adv' => 'Nhà quảng cáo',
    );
}

function get_object_poster($poster){
    $array = get_object_posters();
    return $array[$poster];
}

/**
 * Danh sách Quyền hạn đối với BĐS
 */
function get_product_permissions(){
    return array(
        '4' => 'Độc quyền',
        '3' => 'Chính chủ',
        '2' => 'Ủy quyền',
        '1' => 'Giới thiệu',
        '0' => 'Không xác định',
    );
}

function get_product_permission($permission){
    $array = get_product_permissions();
    return $array[$permission];
}