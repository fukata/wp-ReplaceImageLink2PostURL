<?php
/*
Plugin Name: ReplaceImageLink2PostURL 
Plugin URI: http://fukata.org/dev/wp-plugin/ReplaceImageLink2PostURL/
Description: Replace image link to post url in top page and search page etc.  
Version: 0.0.1
Author: Tatsuya Fukata
Author URI: http://fukata.org
*/

function ril_replace2post_url( $content='' ) {
}

function ril_filter_content_replace2post_url( $content ) {
    if ( is_single() ) return $content;

    return $content;
}

add_filter( 'the_content', 'ril_filter_content_replace2post_url' );

