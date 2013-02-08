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
    global $post;

    $urls = array(
        'flickr.com',
    );
    $post_url = get_permalink($post->ID);

    foreach ( $urls as $url ) {
        $pattern = '/(<a\shref=")[^"]*' . $url . '[^"]*("[^>]*><img\ssrc="[^"]+"[^\/]*\/><\/a>)/i';
        $match_count = 0;
        $content = preg_replace( $pattern, '${1}' . $post_url . '${2}', $content, -1, &$match_count );
        if ( $match_count > 0 ) break;
    }

    return $content;
}

function ril_filter_content_replace2post_url( $content ) {
    if ( is_single() ) {
        return $content;
    } else {
        return ril_replace2post_url( $content );
    }
}

add_filter( 'the_content', 'ril_filter_content_replace2post_url' );

