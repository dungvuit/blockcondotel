<?php

vc_map(array(
    'name' => esc_html__('PPO: Form Search', SHORT_NAME),
    'base' => 'ppo-form-search',
    'category' => esc_html__('PPO Shortcodes', SHORT_NAME),
    'description' => esc_html__('Display form search property', SHORT_NAME),
    'params' => array(
        array(
            'type' => 'textfield',
            'admin_label' => true,
            'heading' => esc_html__('Title', SHORT_NAME),
            'param_name' => 'title',
            'value' => '',
        ),
    )
));
