<?php

vc_map(array(
    'name' => esc_html__('PPO: Service Item', SHORT_NAME),
    'base' => 'ppo-service-item',
    'category' => esc_html__('PPO Shortcodes', SHORT_NAME),
    'description' => esc_html__('Display Service Item', SHORT_NAME),
    'params' => array(
        array(
            'type' => 'textfield',
            'admin_label' => true,
            'heading' => esc_html__('Title', SHORT_NAME),
            'param_name' => 'title',
            'value' => '',
        ),
        array(
            'type' => 'textarea',
            'admin_label' => true,
            'heading' => esc_html__('Description', SHORT_NAME),
            'param_name' => 'description',
            'value' => '',
        ),
        array(
            'type' => 'vc_link',
            'admin_label' => true,
            'heading' => esc_html__('URL', SHORT_NAME),
            'param_name' => 'url',
            'value' => '',
        ),
        array(
            'type' => 'attach_image',
            'admin_label' => true,
            'heading' => esc_html__('Image', SHORT_NAME),
            'param_name' => 'image',
        ),
    )
));
