<?php
/*
Plugin Name: RESTAPI-Example1
Plugin URI:  http://davidbisset.com
Description: Demonstration of how to modify certain aspects of the WP REST API
Author: David Bisset
Version: 1.0
Author URI: http://www.davidbisset.com

NOTE: This requries the WordPress 4.4+ and you should be running the latest version of the REST API plugin 2.0

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
    return get_post_meta( $object[ 'id' ], $field_name, true );
}

/*  This is an example of using rest_query_vars filter to be able to query by meta_key/meta_value
 *  Example: yoururl.com/wp-json/wp/v2/posts?filter[meta_key]=job-type&filter[meta_value]=manager
 */

function my_allow_meta_query( $valid_vars ) {
    
    $valid_vars = array_merge( $valid_vars, array( 'meta_key', 'meta_value' ) );
    return $valid_vars;
}
add_filter( 'rest_query_vars', 'my_allow_meta_query' );

?>