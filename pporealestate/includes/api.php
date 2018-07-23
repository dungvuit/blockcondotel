<?php

add_action('rest_api_init', function () {
//    register_rest_route('api/v1', '/author/(?P<id>\d+)', array(
//        'methods' => 'GET',
//        'callback' => 'api_get_product',
//        'args' => array(
//            'id' => array(
//                'validate_callback' => function($param, $request, $key) {
//                    return is_numeric($param);
//                }
//            ),
//        ),
//    ));
});

function api_get_product(WP_REST_Request $request) {
    // You can access parameters via direct array access on the object:
    $param = $request['some_param'];

    // Or via the helper method:
    $param = $request->get_param('some_param');

    // You can get the combined, merged set of parameters:
    $parameters = $request->get_params();

    // The individual sets of parameters are also available, if needed:
    $parameters = $request->get_url_params();
    $parameters = $request->get_query_params();
    $parameters = $request->get_body_params();
    $parameters = $request->get_json_params();
    $parameters = $request->get_default_params();

    // Uploads aren't merged in, but can be accessed separately:
    $parameters = $request->get_file_params();
    
    $parameters = $request->get_parameter_order();
}
