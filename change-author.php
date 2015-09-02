<?php
/**
Plugin Name: Change Author Alias
Plugin URI: https://github.com/baffo/ca-alias
Description: Change Author Alias to a custom alias name when publishing a post. Allows you to specify a custom author name for each post.
Version: 1.0
Author: Primož Bevk
Author URI: http://timerecursion.com
License: GPL3
*/
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Admin Author Alias Box */
add_action('add_meta_boxes', 'ca_add_alias_box');
function ca_add_alias_box() {
    $screens = array('post');
    foreach ($screens as $screen) {
        add_meta_box(
            'ca_box_id',
            'Author Alias',    
            'ca_alias_meta_box',
            $screen,
			'side',
			'high'
        );
    }
}

function ca_alias_meta_box($post) {
?>
   <label for="ca_author_alias">Set the Display name of Post author</label>
   <input type="text" name="ca_author_alias" id="ca_author_alias" class="postbox" placeholder="John Doe" />
<?php
}

/* Save Author Alias data */
add_action('save_post', 'ca_save_author_meta');
function ca_save_author_meta($post_id) {
	if (array_key_exists('ca_author_alias', $_POST) ) {
        update_post_meta( $post_id,
           'ca_author_alias',
            sanitize_text_field($_POST['ca_author_alias'])
        );
    }
}

/* Display Author Alias */
add_filter('the_author', 'ca_author_filter' );
function ca_author_filter($name) {
	global $post;
	$author = get_post_meta($post->ID, 'ca_author_alias', true);
	if ($author != '')
		$name = $author;

	return $name;
}
?>