<?php

vc_map(array(
    'name' => esc_html__('PPO: Carousel Suppliers', SHORT_NAME),
    'base' => 'ppo-carousel-suppliers',
    'category' => esc_html__('PPO Shortcodes', SHORT_NAME),
    'description' => esc_html__('Display carousel suppliers', SHORT_NAME),
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
