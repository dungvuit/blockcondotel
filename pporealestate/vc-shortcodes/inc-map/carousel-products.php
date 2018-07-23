<?php

vc_map(array(
    'name' => esc_html__('PPO: Carousel Products', SHORT_NAME),
    'base' => 'ppo-product-carousel',
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
