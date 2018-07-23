<?php

vc_map(array(
    'name' => esc_html__('PPO: Product Categories List', SHORT_NAME),
    'base' => 'ppo-product-categories-list',
    'category' => esc_html__('PPO Shortcodes', SHORT_NAME),
    'description' => esc_html__('Display product categories as list', SHORT_NAME),
    'params' => array(
        array(
            'type' => 'textfield',
            'admin_label' => true,
            'heading' => esc_html__('Title', SHORT_NAME),
            'param_name' => 'title',
            'value' => '',
        ),
        array(
            'type' => 'ppo_product_category',
            'heading' => esc_html__('Select Category', SHORT_NAME),
            'param_name' => 'cat_id',
            'std' => 'all',
        ),
    )
));
