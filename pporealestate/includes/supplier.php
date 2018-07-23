<?php

/**
 * Suppliers Menu Page
 */

# Custom supplier post type
add_action('init', 'create_supplier_post_type');

function create_supplier_post_type(){
    register_post_type('supplier', array(
        'labels' => array(
            'name' => __('Nhà cung cấp', SHORT_NAME),
            'singular_name' => __('Nhà cung cấp', SHORT_NAME),
            'add_new' => __('Add new', SHORT_NAME),
            'add_new_item' => __('Add new Supplier', SHORT_NAME),
            'new_item' => __('New Supplier', SHORT_NAME),
            'edit' => __('Edit', SHORT_NAME),
            'edit_item' => __('Edit Supplier', SHORT_NAME),
            'view' => __('View Supplier', SHORT_NAME),
            'view_item' => __('View Supplier', SHORT_NAME),
            'search_items' => __('Search Suppliers', SHORT_NAME),
            'not_found' => __('No Supplier found', SHORT_NAME),
            'not_found_in_trash' => __('No Supplier found in trash', SHORT_NAME),
        ),
        'public' => true,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => true,
        'menu_position' => 5,
        'hierarchical' => false,
        'query_var' => true,
        'supports' => array(
            'title', 'editor', 'thumbnail', 
            //'custom-fields', 'author', 'excerpt', 'comments', 
        ),
        'rewrite' => array('slug' => 'supplier', 'with_front' => false),
        'can_export' => true,
//        'has_archive' => true,
        'description' => __('Supplier description here.')
    ));
}