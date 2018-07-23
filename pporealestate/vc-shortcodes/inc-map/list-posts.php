<?php

vc_map(array(
    'name' => esc_html__('PPO: List Posts', SHORT_NAME),
    'base' => 'ppo-list-posts',
    'category' => esc_html__('PPO Shortcodes', SHORT_NAME),
    'description' => esc_html__('Display list posts', SHORT_NAME),
    'params' => array(
        array(
            'type' => 'textfield',
            'admin_label' => true,
            'heading' => esc_html__('Title', SHORT_NAME),
            'param_name' => 'title',
            'value' => '',
        ),
        array(
            'type' => 'textfield',
            'admin_label' => true,
            'heading' => esc_html__('Number posts', SHORT_NAME),
            'param_name' => 'number_posts',
            'std' => '4',
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Select Category', SHORT_NAME),
            'param_name' => 'cat_id',
            'value' => ppo_sc_get_categories(),
        ),
        array(
            'type' => 'dropdown',
            'admin_label' => true,
            'heading' => esc_html__('Order by', SHORT_NAME),
            'param_name' => 'orderby',
            'std' => 'date',
            'value' => array(
                esc_html__('Select', SHORT_NAME) => '',
//                esc_html__('Popular', SHORT_NAME) => 'popular',
                esc_html__('Recent', SHORT_NAME) => 'date',
                esc_html__('Title', SHORT_NAME) => 'title',
                esc_html__('Random', SHORT_NAME) => 'rand',
            ),
        ),
        array(
            'type' => 'dropdown',
            'admin_label' => true,
            'heading' => esc_html__('Order', SHORT_NAME),
            'param_name' => 'order',
            'std' => 'desc',
            'value' => array(
                esc_html__('Select', SHORT_NAME) => '',
                esc_html__('ASC', SHORT_NAME) => 'asc',
                esc_html__('DESC', SHORT_NAME) => 'desc',
            ),
        ),
        array(
            'type' => 'dropdown',
            'admin_label' => true,
            'heading' => esc_html__('Layout', SHORT_NAME),
            'param_name' => 'layout',
            'value' => array(
                esc_html__('Default', SHORT_NAME) => 'list',
                esc_html__('List without Thumbnail', SHORT_NAME) => 'list_without_thumb',
                esc_html__('Grid', SHORT_NAME) => 'grid',
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Select Image Size', SHORT_NAME),
            'param_name' => 'image_size',
            'value' => ppo_sc_get_list_image_size(),
        ),
    )
));
