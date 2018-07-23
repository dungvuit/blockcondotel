<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PPO_DIR_SHORTCODES_MAP', THEME_DIR . 'vc-shortcodes/inc-map/' );

/**
 * Mapping shortcodes
 */
function ts_map_vc_shortcodes() {

	include_once( PPO_DIR_SHORTCODES_MAP . 'carousel-projects.php' );
	include_once( PPO_DIR_SHORTCODES_MAP . 'carousel-products.php' );
	include_once( PPO_DIR_SHORTCODES_MAP . 'carousel-products2.php' );
	include_once( PPO_DIR_SHORTCODES_MAP . 'carousel-users.php' );
	include_once( PPO_DIR_SHORTCODES_MAP . 'carousel-suppliers.php' );
	include_once( PPO_DIR_SHORTCODES_MAP . 'carousel-posts.php' );
	include_once( PPO_DIR_SHORTCODES_MAP . 'featured-posts.php' );
	include_once( PPO_DIR_SHORTCODES_MAP . 'list-posts.php' );
	include_once( PPO_DIR_SHORTCODES_MAP . 'form-search.php' );
	include_once( PPO_DIR_SHORTCODES_MAP . 'popular-projects.php' );
	include_once( PPO_DIR_SHORTCODES_MAP . 'service-item.php' );
	include_once( PPO_DIR_SHORTCODES_MAP . 'product-list.php' );
	include_once( PPO_DIR_SHORTCODES_MAP . 'product-categories-list.php' );
	include_once( PPO_DIR_SHORTCODES_MAP . 'slide-projects.php' );
	include_once( PPO_DIR_SHORTCODES_MAP . 'project-list.php' );
}

add_action( 'vc_before_init', 'ts_map_vc_shortcodes' );
