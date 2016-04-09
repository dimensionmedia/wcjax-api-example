<?php
/*
Plugin Name: RESTAPI-Example1
Plugin URI:  http://davidbisset.com
Description: Demonstration of how to modify certain aspects of the WP REST API
Author: David Bisset
Version: 1.0
Author URI: http://www.davidbisset.com
*/
		
/* This is an example of adding meta data to the REST API Posts */

add_action( 'rest_api_init', 'ssphp_post_meta_register' );
function ssphp_post_meta_register() {
    register_api_field( 'post',
        'test_meta',
        array(
            'get_callback'    => 'ssphp_get_post_meta',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function ssphp_get_post_meta( $object, $field_name, $request ) {
    // return get_post_meta( $object[ 'id' ], $field_name, true );
    return "oh yeah!";
}

/* This is an example of filtering posts by post meta */

add_action( 'rest_api_init', 'ssphp_add_meta' );
functoin ssphp_add_meta() {
	add_filter( 'rest_query_vars', 'ssphp_allow_api_meta' );
	add_filter( 'rest_post_query', 'ssphp_allowed_api_meta' );
}

function ssphp_allowed_api_meta( $valid_vars ) {

	$allowed = array('test_meta');

	if ( ! in_array( $args['meta_key'], $allowed_meta_keys ) ) {
	        unset( $args['meta_key'] );
	        unset( $args['meta_value'] );
	}

	return $args;
}


function ssphp_allow_api_meta( $valid_vars ) { // remember we have a mix of possible private/public metavalue
        $valid_vars = array_merge( $valid_vars, array( 'meta_key', 'meta_value' ) );
        return $valid_vars;
}

?>