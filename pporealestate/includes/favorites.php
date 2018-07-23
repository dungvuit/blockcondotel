<?php

add_action('after_setup_theme', 'favorites_install');

/* ----------------------------------------------------------------------------------- */
# Create table in database
/* ----------------------------------------------------------------------------------- */
if (!function_exists('favorites_install')) {
    function favorites_install() {
        global $wpdb;
        
        $favorites = $wpdb->prefix . 'favorites';

        $sql = "CREATE TABLE IF NOT EXISTS $favorites (
                ID int AUTO_INCREMENT PRIMARY KEY,
                user_id int NOT NULL,
                post_id int NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}