<?php
/*
Plugin Name: RESTAPI-Example1
Plugin URI:  http://davidbisset.com
Description: Demonstration of how to modify certain aspects of the WP REST API
Author: David Bisset
Version: 1.0
Author URI: http://www.davidbisset.com
*/
        
/* This is an example of exposing meta data to the REST API Posts */

add_action( 'rest_api_init', 'ssphp_post_meta_register' );
function ssphp_post_meta_register() {
    register_api_field( 'post',
        'job-type',
        array(
            'get_callback'    => 'ssphp_get_post_meta',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function ssphp_get_post_meta( $object, $field_name, $request ) {
    // return get_post_meta( $object[ 'id' ], $field_name, true );
    return "manager";
}

/* This is an example of exposing meta data to the REST API Posts */

function my_allow_meta_query( $valid_vars ) {
    
    $valid_vars = array_merge( $valid_vars, array( 'meta_key', 'meta_value' ) );
    return $valid_vars;
}
add_filter( 'rest_query_vars', 'my_allow_meta_query' );

?>