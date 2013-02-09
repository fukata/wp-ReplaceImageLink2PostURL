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

    $replace_urls = explode( "\n", get_option('ril_replace_urls') );
    $post_url = get_permalink($post->ID);

    foreach ( $replace_urls as $url ) {
        $url = trim( $url );
        if ( strlen( $url ) === 0 ) continue;

        $pattern = '/<a\shref="([^"]*[^"]*)"[^>]*>(<img\ssrc="[^"]+"[^\/]*\/>)<\/a>/i';
        if ( preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER) ) {
            foreach ( $matches as $match ) {
                if ( strpos( $match[1], $url ) === false ) continue;

                $replace_tag = '<a href="' . $post_url . '">' . $match[2] . '</a>';
                $content = str_replace( $match[0], $replace_tag, $content );
            }
        }
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

function ril_action_admin_menu() {
    add_options_page( 'ReplaceImageLink2PostURL Options', 'ReplaceImageLink2PostURL', 'manage_options', __FILE__, 'ril_generate_option_form' );
}

function ril_generate_option_form() {
?>
<div class="wrap">
	<h2>ReplaceImageLink2PostURL</h2>
	<form method="post" action="options.php">
        <?php wp_nonce_field('update-options'); ?>
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="ril_replace_urls" />

		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<p>Replace URLs</p>
				</th>
				<td>
                    <textarea name="ril_replace_urls" rows="10" cols="70"><?php echo get_option('ril_replace_urls'); ?></textarea>
                    <p class="description">Please specify separated by newline characters to be included in the link that you want to replace.</p>
                </td>
            </tr>
        </table>
		<p class="submit">
			<input type="submit" class="button-primary" value="Update" />
		</p>
    </form>
</div>
<?php
}

add_filter( 'the_content', 'ril_filter_content_replace2post_url' );
add_action( 'admin_menu',  'ril_action_admin_menu');

