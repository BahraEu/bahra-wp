<?php

add_action(
    'rest_api_init',
    function () {
        remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );

        add_filter(
            'rest_pre_serve_request',
            function ( $value ) {
                header( 'Access-Control-Allow-Origin: ' . get_frontend_origin() );
                header( 'Access-Control-Allow-Methods: GET' );
                header( 'Access-Control-Allow-Credentials: true' );
                header( 'Access-Control-Allow-Methods: GET,PUT,POST,DELETE,PATCH,OPTIONS' );
                header( 'Access-Control-Allow-Headers: Access-Control-Allow-Headers, Authorization, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers' );

                return $value;
            }
        );
    },
    15
);
