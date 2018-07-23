<?php

/**
 * Feedbacks Menu Page
 */

# Custom feedback post type
add_action('init', 'create_feedback_post_type');

function create_feedback_post_type(){
    register_post_type('feedback', array(
        'labels' => array(
            'name' => __('Cảm nhận'),
            'singular_name' => __('Cảm nhận'),
            'add_new' => __('Add new'),
            'add_new_item' => __('Add new Feedback'),
            'new_item' => __('New Feedback'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Feedback'),
            'view' => __('View Feedback'),
            'view_item' => __('View Feedback'),
            'search_items' => __('Search Feedbacks'),
            'not_found' => __('No Feedback found'),
            'not_found_in_trash' => __('No Feedback found in trash'),
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
            //'custom-fields', 'comments', 'author','excerpt',
        ),
        'rewrite' => array('slug' => 'feedback', 'with_front' => false),
        'can_export' => true,
        'has_archive' => true,
        'description' => __('Feedback description here.')
    ));
}

# Custom feedback taxonomies
//add_action('init', 'create_feedback_taxonomies');
//
//function create_feedback_taxonomies(){
//    register_taxonomy('feedback_category', 'feedback', array(
//        'hierarchical' => true,
//        'labels' => array(
//            'name' => __('Feedback Categories'),
//            'singular_name' => __('Feedback Categories'),
//            'add_new' => __('Add New'),
//            'add_new_item' => __('Add New Category'),
//            'new_item' => __('New Category'),
//            'search_items' => __('Search Categories'),
//        ),
//    ));
//}