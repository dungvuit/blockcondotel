<?php
/* ----------------------------------------------------------------------------------- */
# Create post_type
/* ----------------------------------------------------------------------------------- */
add_action('init', 'create_qna_post_type');

function create_qna_post_type(){
    register_post_type('qna', array(
        'labels' => array(
            'name' => __('Hỏi đáp', SHORT_NAME),
            'singular_name' => __('Hỏi đáp', SHORT_NAME),
            'add_new' => __('Add new', SHORT_NAME),
            'add_new_item' => __('Add new Q&A', SHORT_NAME),
            'new_item' => __('New Q&A', SHORT_NAME),
            'edit' => __('Edit', SHORT_NAME),
            'edit_item' => __('Edit Q&A', SHORT_NAME),
            'view' => __('View Q&A', SHORT_NAME),
            'view_item' => __('View Q&A', SHORT_NAME),
            'search_items' => __('Search Questions & Answers', SHORT_NAME),
            'not_found' => __('No Q&A found', SHORT_NAME),
            'not_found_in_trash' => __('No Q&A found in trash', SHORT_NAME),
        ),
        'public' => false,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => false,
        'menu_position' => 20,
        'hierarchical' => false,
        'query_var' => true,
        'supports' => array(
            'title', 'editor', 
            //'custom-fields', 'excerpt', 'author', 'thumbnail', 'comments', 
        ),
        'rewrite' => array('slug' => 'qna', 'with_front' => false),
        'can_export' => true,
        'description' => __('Q&A description here.', SHORT_NAME),
    ));
}