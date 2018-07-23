<?php

vc_map(array(
    'name' => esc_html__('PPO: Carousel Products 2', SHORT_NAME),
    'base' => 'ppo-product-carousel2',
    'category' => esc_html__('PPO Shortcodes', SHORT_NAME),
    'description' => esc_html__('Display products with carousel', SHORT_NAME),
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
        array(
            'type' => 'textfield',
            'admin_label' => true,
            'heading' => esc_html__('Number posts', SHORT_NAME),
            'param_name' => 'number_posts',
            'std' => '10',
            'value' => '',
        ),
    )
));
