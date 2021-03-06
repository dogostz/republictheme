<?php
include_once(dirname(__FILE__) . '/twitter/TwitterHelper.php');
include_once(dirname(__FILE__) . '/user-functions.php');
include_once(dirname(__FILE__) . '/video.php');

/**
 * Truncates a string to a certain word count.
 * @param  string  $input Text to be shortalized. Any HTML will be stripped.
 * @param  integer $words_limit number of words to return
 * @param  string $end the suffix of the shortalized text
 * @return string
 */
function crb_shortalize($input, $words_limit=15, $end='...') {
	$input = strip_tags($input);
	$words_limit = abs(intval($words_limit));

	if ($words_limit == 0) {
		return $input;
	}

	$words = str_word_count($input, 2, '0123456789');
	if (count($words) <= $words_limit + 1) {
		return $input;
	}
	
	$loop_counter = 0;
	foreach ($words as $word_position => $word) {
		$loop_counter++;
		if ($loop_counter==$words_limit + 1) {
			return substr($input, 0, $word_position) . $end;
		}
	}
}

/**
 * Crawls the taxonomy tree up to top level taxonomy ancestor and returns
 * that taxonomy as object. 
 * @param  int $term_id
 * @param  string $taxonomy Taxonomy slug
 * @return mixed object with the ancestor or false if the term or taxonomy don't exist
 */
function crb_taxonomy_ancestor($term_id, $taxonomy) {
	$term_obj = get_term_by('id', $term_id, $taxonomy);
	while ($term_obj->parent!=0) {
		$term_obj = get_term_by('id', $term_obj->parent, $taxonomy);
	}
	return get_term_by('id', $term_obj->term_id, $taxonomy);
}

/**
 * Shortcut for get_post_meta. 
 * @param  string $key 
 * @param  integer $id required if the function is not called in loop context
 * @return string custom field if it exist
 */
function crb_get_meta($key, $id=null) {
	if (!isset($id)) {
		global $post;
		if (empty($post->ID)) {
			return null;
		}
		$id = $post->ID;
	}
	return get_post_meta($id, $key, true);
}

/**
 * Gets all pages / posts which have the specified custom field. Does not check
 * whether it has any value - just for existence. 
 * @param  string $meta_key
 * @return array
 */
function crb_get_content_by_meta_key($meta_key) {
	global $wpdb;
	$result = $wpdb->get_col('
		SELECT DISTINCT(post_id)
		FROM ' . $wpdb->postmeta . '
		WHERE meta_key = "' . $meta_key . '"
	');
	if(empty($result)) {
		return array();
	}
	return $result;
}

/** 
 * For Blog Section ( "Posts page", "Archive", "Search" or "Single post" )
 * returns the ID of the "Page for Posts" or 0 if it's not setup
 * 
 * For single page or the front page, returns the ID of the page.
 * 
 * In all other cases(404, single pages on CPT), returns false.
 * 
 * @return int|bool The ID of the current page context, 0 or false.
 */
function crb_get_page_context() {
	$page_ID = false;

	if (is_page()) {
		$page_ID = get_the_ID();
	} elseif ( is_home() || is_archive() || is_search() || ( is_single() && get_post_type() == 'post' ) ) {
		$page_ID = get_option('page_for_posts');
	}

	return apply_filters('crb_get_page_context', $page_ID);
}

/**
 * Removes leading protocol from a URL address
 *
 * @param string $url URL (http://example.com)
 * @return string The URL without protocol(//example.com)
 */
function crb_strip_url_protocol($url) {
	return preg_replace('~^https?:~i', '', $url);
}

/**
 * Checks whether a URL address is from the current site
 *
 * @param string $src [required] The URL address that will be checked.
 * @param string $home_url [required] The URL address to the homepage of the site.
 * @return bool
 */
function crb_is_external_url($src, $home_url) {
	$separator = '~';
	$regex_quoted_home_url = preg_quote($home_url, $separator);
	$internal_url_reg = $separator . '^' . $regex_quoted_home_url . $separator . 'i';

	return !preg_match($internal_url_reg, $src);
}

/**
 * Generates a version for the given file.
 *
 * Checks if the given file actually exists and returns its
 * last modified time. Otherwise, returns false.
 *
 * @see crb_strip_url_protocol()
 * @see crb_is_external_url()
 *
 * @param string [required] $src The URL to the file, which version should be returned.
 * @return int|bool The last modified time of the given file or false.
 */
function crb_generate_file_version($src) {
	# Normalize both URLs in order to avoid problems with http, https
	# and protocol-less cases
	$src = crb_strip_url_protocol($src);
	$home_url = crb_strip_url_protocol( home_url('/') );

	# Default version
	$version = false;

	if ( !crb_is_external_url($src, $home_url) ) {
		# Generate the absolute path to the file
		$file_path = str_replace(
			array($home_url, '/'),
			array(ABSPATH, DIRECTORY_SEPARATOR),
			$src
		);

		# Check if the given file really exists
		if ( file_exists($file_path) ) {
			# Use the last modified time of the file as a version
			$version = filemtime($file_path);
		}
	}

	# Return version
	return $version;
}

/**
 * Enqueues a single JS file
 *
 * @see crb_generate_file_version()
 *
 * @param string $handle [required] Name used as a handle for the JS file
 * @param string $src    [required] The URL to the JS file, which should be enqueued
 * @param array  $dependencies [optional] An array of files' handle names that this file depends on
 * @param bool $in_footer [optional] Whether to enqueue in footer or not. Defaults to false
 */
function crb_enqueue_script($handle, $src, $dependencies=array(), $in_footer=false) {
	wp_enqueue_script($handle, $src, $dependencies, crb_generate_file_version($src), $in_footer);
}

/**
 * Enqueues a single CSS file
 *
 * @see crb_generate_file_version()
 *
 * @param string $handle [required] Name used as a handle for the CSS file
 * @param string $src    [required] The URL to the CSS file, which should be enqueued
 * @param array  $dependencies [optional] An array of files' handle names that this file depends on
 * @param string $media  [optional] String specifying the media for which this stylesheet has been defined. Defaults to all.
 */
function crb_enqueue_style($handle, $src, $dependencies=array(), $media='all') {
	wp_enqueue_style($handle, $src, $dependencies, crb_generate_file_version($src), $media);
}

/**
 * Removes empty paragraphes from content when using shortcodes
 * 
 * @param string $content
 */
add_filter('the_content', 'crb_shortcode_empty_paragraph_fix');
function crb_shortcode_empty_paragraph_fix($content) {
	$array = array(
		'<p>['    => '[',
		']</p>'   => ']',
		']<br />' => ']',
		']<br>'   => ']',
	);

	$content = strtr($content, $array);

	return $content;
}

/**
 * Displays the favicon, if it exists
 */
add_action('wp_head', 'crb_display_favicon', 5);
function crb_display_favicon() {
	# Theme and favicon URI
	$theme_uri = get_template_directory_uri();
	$favicon_uri = $theme_uri . '/images/favicon.ico';

	# Determine version based on file modified time. 
	# If the $version is false, the file does not exist
	$version = crb_generate_file_version($favicon_uri);

	# Display the favicon only if it exists
	if ( $version ) {

		# Add the version string to the favicon URI
		$favicon_uri = add_query_arg('ver', $version, $favicon_uri);

		echo '<link rel="shortcut icon" href="' . $favicon_uri . '" />' . "\n";
	}
}

/**
 * A safer alternative of $_REQUEST - only for $_GET and $_POST
 * @param  string $key the name of the requested parameter
 * @return the requested parameter value
 */
function crb_request_param($key = '') {
	$value = false;
	if (!$key) {
		return $value;
	}
 
	if ( isset($_POST[$key]) ) {
		$value = $_POST[$key];
	} elseif ( isset($_GET[$key]) ) {
		$value = $_GET[$key];
	}
 
	return $value;
}

/**
 * Set a cookie - wrapper for setcookie using WP constants
 *
 * @param  string  $name   Name of the cookie being set
 * @param  string  $value  Value of the cookie
 * @param  integer $expire Expiry of the cookie
 * @param  string  $secure Whether the cookie should be served only over https
 */
function crb_setcookie( $name, $value, $expire = 0, $secure = false ) {
	if ( ! headers_sent() ) {
		setcookie( $name, $value, $expire, COOKIEPATH, COOKIE_DOMAIN, $secure );
	} elseif ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		headers_sent( $file, $line );
		trigger_error( "{$name} cookie cannot be set - headers already sent by {$file} on line {$line}", E_USER_NOTICE );
	}
}