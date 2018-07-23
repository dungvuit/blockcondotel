<?php

vc_map(array(
    'name' => esc_html__('PPO: Product List', SHORT_NAME),
    'base' => 'ppo-product-list',
    'category' => esc_html__('PPO Shortcodes', SHORT_NAME),
    'description' => esc_html__('Display products', SHORT_NAME),
    'params' => array(
        array(
            'type' => 'textfield',
            'admin_label' => true,
            'heading' => esc_html__('Title', SHORT_NAME),
            'param_name' => 'title',
            'value' => '',
        ),
        array(
            'type' => 'dropdown',
            'admin_label' => true,
            'heading' => esc_html__('Type', SHORT_NAME),
            'param_name' => 'product_type',
            'std' => 'new',
            'value' => array(
                'New' => 'new',
                'VIP' => 'vip',
            ),
        ),
    )
));
