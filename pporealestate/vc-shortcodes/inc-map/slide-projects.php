<?php

vc_map(array(
    'name' => esc_html__('PPO: Slide Projects', SHORT_NAME),
    'base' => 'ppo-slide-projects',
    'category' => esc_html__('PPO Shortcodes', SHORT_NAME),
    'description' => esc_html__('Display projects as slider', SHORT_NAME),
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
