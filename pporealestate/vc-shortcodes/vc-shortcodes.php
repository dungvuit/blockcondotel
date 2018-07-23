<?php
/*
Shortcodes Visual Composer for theme PPO Landing Page.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

define( 'THIM_SC_PATH', THEME_DIR . 'vc-shortcodes' );
define( 'THIM_SC_URL', plugin_dir_url( __FILE__ ) );

// Map shortcodes to Visual Composer
require_once( THEME_DIR . 'vc-shortcodes/vc-map.php' );

// Register new parameters for shortcodes
require_once( THEME_DIR . 'vc-shortcodes/vc-functions.php' );

// Register shortcodes
require_once( THEME_DIR . 'vc-shortcodes/shortcodes/carousel-projects.php' );
require_once( THEME_DIR . 'vc-shortcodes/shortcodes/carousel-products.php' );
require_once( THEME_DIR . 'vc-shortcodes/shortcodes/carousel-products2.php' );
require_once( THEME_DIR . 'vc-shortcodes/shortcodes/carousel-users.php' );
require_once( THEME_DIR . 'vc-shortcodes/shortcodes/carousel-suppliers.php' );
require_once( THEME_DIR . 'vc-shortcodes/shortcodes/carousel-posts.php' );
require_once( THEME_DIR . 'vc-shortcodes/shortcodes/featured-posts.php' );
require_once( THEME_DIR . 'vc-shortcodes/shortcodes/list-posts.php' );
require_once( THEME_DIR . 'vc-shortcodes/shortcodes/form-search.php' );
require_once( THEME_DIR . 'vc-shortcodes/shortcodes/popular-projects.php' );
require_once( THEME_DIR . 'vc-shortcodes/shortcodes/service-item.php' );
require_once( THEME_DIR . 'vc-shortcodes/shortcodes/product-list.php' );
require_once( THEME_DIR . 'vc-shortcodes/shortcodes/product-categories-list.php' );
require_once( THEME_DIR . 'vc-shortcodes/shortcodes/slide-projects.php' );
require_once( THEME_DIR . 'vc-shortcodes/shortcodes/project-list.php' );