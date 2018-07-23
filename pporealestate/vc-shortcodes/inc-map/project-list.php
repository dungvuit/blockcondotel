<?php

vc_map(array(
    'name' => esc_html__('PPO: Project List', SHORT_NAME),
    'base' => 'ppo-project-list',
    'category' => esc_html__('PPO Shortcodes', SHORT_NAME),
    'description' => esc_html__('Display projects as list', SHORT_NAME),
    'params' => array(
        array(
            'type' => 'textfield',
            'admin_label' => true,
            'heading' => esc_html__('Title', SHORT_NAME),
            'param_name' => 'title',
            'value' => '',
        ),
        array(
            'type' => 'ppo_project_category',
            'heading' => esc_html__('Select Category', SHORT_NAME),
            'param_name' => 'cat_id',
            'std' => 'all',
        ),
        array(
            'type' => 'textfield',
            'admin_label' => true,
            'heading' => esc_html__('Number posts', SHORT_NAME),
            'param_name' => 'number_posts',
            'std' => '5',
            'value' => '',
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
    )
));
