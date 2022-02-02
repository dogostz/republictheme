<?php

define('CRB_THEME_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);

# Enqueue JS and CSS assets on the front-end
add_action('wp_enqueue_scripts', 'crb_wp_enqueue_scripts');
function crb_wp_enqueue_scripts() {
	$template_dir = get_template_directory_uri();

	# Enqueue jQuery
	wp_enqueue_script('jquery');

    # Enqueue Custom JS files
	crb_enqueue_script('jquery.fancybox', get_bloginfo('stylesheet_directory') . '/js/jquery.fancybox.min.js', array('jquery'));
	crb_enqueue_script('jquery.flexslider', get_bloginfo('stylesheet_directory') . '/js/jquery.flexslider.js', array('jquery'));
	crb_enqueue_script('jquery.uploadfile', get_bloginfo('stylesheet_directory') . '/js/jquery.uploadfile.js', array('jquery'));
	crb_enqueue_script('jquery-ui.min', get_bloginfo('stylesheet_directory') . '/js/jquery-ui.min.js', array('jquery'));
	crb_enqueue_script('js-functions', get_bloginfo('stylesheet_directory') . '/js/functions.js', array('jquery'));
    wp_localize_script( 'js-functions', 'wp_common_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	# Enqueue Custom CSS files
	crb_enqueue_style('flexslider', $template_dir . '/css/flexslider.css');
	crb_enqueue_style('jquery.fancybox', $template_dir . '/css/jquery.fancybox.min.css');
	crb_enqueue_style('jquery-ui.structure', $template_dir . '/css/jquery-ui.structure.css');
	crb_enqueue_style('jquery-ui.theme.min', $template_dir . '/css/jquery-ui.theme.min.css');
	crb_enqueue_style('uploadfile', $template_dir . '/css/uploadfile.css');
	crb_enqueue_style('theme-styles', $template_dir . '/style.css');

	# Enqueue Comments JS file
	if (is_singular()) {
		wp_enqueue_script('comment-reply');
	}
}

# Enqueue JS and CSS assets on admin pages
add_action('admin_enqueue_scripts', 'crb_admin_enqueue_scripts');
function crb_admin_enqueue_scripts() {
	$template_dir = get_template_directory_uri();

	# Enqueue Styles
	# @crb_enqueue_script attributes -- id, location, dependencies, in_footer = false
	if ( !current_user_can( 'administrator' ) ) {
		crb_enqueue_script('theme-admin-functions', $template_dir . '/js/admin-js.js', array('jquery'));
	}
	
	# Enqueue Scripts
	# @crb_enqueue_style attributes -- id, location, dependencies, media = all

	if ( current_user_can( 'administrator' ) ) {
		crb_enqueue_style('theme-admin-styles', $template_dir . '/css/broker-admin.css');
	} else {
		crb_enqueue_style('theme-admin-styles', $template_dir . '/css/main-admin.css');
	}

}

# Attach Custom Post Types and Custom Taxonomies
add_action('init', 'crb_attach_post_types_and_taxonomies');
function crb_attach_post_types_and_taxonomies() {
	# Attach Custom Post Types
	include_once(CRB_THEME_DIR . 'options/post-types.php');

	# Attach Custom Taxonomies
	include_once(CRB_THEME_DIR . 'options/taxonomies.php');
}

add_action('after_setup_theme', 'crb_setup_theme');

# To override theme setup process in a child theme, add your own crb_setup_theme() to your child theme's
# functions.php file.
if (!function_exists('crb_setup_theme')) {
	function crb_setup_theme() {

		# Include translations
    	load_theme_textdomain('crb', get_stylesheet_directory() . '/languages');

		include_once(CRB_THEME_DIR . 'lib/common.php');
		include_once(CRB_THEME_DIR . 'lib/carbon-fields/carbon-fields.php');
		include_once(CRB_THEME_DIR . 'lib/admin-column-manager/carbon-admin-columns-manager.php');

		# Theme supports
		add_theme_support('automatic-feed-links');
		add_theme_support('post-thumbnails');

		if ( function_exists( 'add_image_size' ) ) {
			add_image_size( 'thumb59', 59, 45, true );
		}
		
		# Manually select Post Formats to be supported - http://codex.wordpress.org/Post_Formats
		// add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ) );

		# Register Theme Menu Locations
		add_theme_support('menus');
		register_nav_menus(array(
			'main-menu' => __('Main Menu'),
			'footer-menu' => __('Footer Menu'),
		));
		
		# Attach custom widgets
		include_once(CRB_THEME_DIR . 'options/widgets.php');

		# Attach custom shortcodes
		include_once(CRB_THEME_DIR . 'options/shortcodes.php');
		
		# Add Actions
		add_action('widgets_init', 'crb_widgets_init');

		add_action('carbon_register_fields', 'crb_attach_theme_options');

		# Additional functions
		if( !function_exists('wpthumb') ) {
			include_once(CRB_THEME_DIR . 'includes/wpthumb/wpthumb.php');
		}
		include_once(CRB_THEME_DIR . 'includes/property-data-arrays.php');
		// include_once(CRB_THEME_DIR . 'includes/property-migrations.php');
		include_once(CRB_THEME_DIR . 'includes/ajax-actions.php');
		include_once(CRB_THEME_DIR . 'includes/breadcrumbs.php');
		include_once(CRB_THEME_DIR . 'includes/filters.php');
		include_once(CRB_THEME_DIR . 'includes/gravity-forms.php');

		# Add Filters
		add_filter( 'the_content', 'crb_shortcode_fix_tags' );
		add_filter( 'the_title', 'crb_htmlize' );
	}
}

# Register Sidebars
# Note: In a child theme with custom crb_setup_theme() this function is not hooked to widgets_init
function crb_widgets_init() {

	$sidebars = array(
		'default-sidebar' 	=> 'Default Sidebar',
		'home-sidebar' 		=> 'Home Sidebar',
	);

	foreach ($sidebars as $id => $name) {
		$args = array_merge(crb_get_default_sidebar_options(), array(
			'name' => $name,
			'id'   => $id,
		));

		register_sidebar( $args );
	}

}

# Sidebar Options
function crb_get_default_sidebar_options() {
	return array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<div class="widget-head"><h4><span>',
		'after_title'   => '</span></h4></div>',
	);
}

function crb_attach_theme_options() {
	# Attach fields
	include_once(CRB_THEME_DIR . 'options/theme-options.php');
	include_once(CRB_THEME_DIR . 'options/custom-fields.php');
}

function crb_array_value_index($value, $array) {
    return array_search($value, array_keys($array));
}


# Shortcodes fixes
function crb_shortcode_fix_tags($content) {
	$array = array (
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']'
	);
	$content = strtr($content, $array);
	return $content;
}

# Get all categories and return an array with their ids
function crb_terms_array( $tax ) {

	$terms 		= get_terms( $tax, 'order=ASC' );
	$term_ids 	= array('N/A');

	foreach ($terms as $term) {
		$term_ids[$term->term_id] = $term->name;		
	}

	return $term_ids;
}

# Return a basic yes/no array
function crb_switcher() {
	return array(
		'no' => 'Не',
		'yes' => 'Да'
	);
}

# Return an array with post IDs
function crb_get_cpt_ids($post_type) {

	$posts = get_posts('post_type='. $post_type .'&posts_per_page=-1');
	$post_ids = array('N/A');

	foreach ($posts as $p) {
		$post_ids[$p->ID] = $p->post_title;
	}

	return $post_ids;
}

function crb_htmlize($text, $tag = 'span') {
	$htmlized = preg_replace('~\*([^*]*)\*~', '<' . $tag . '>$1</' . $tag . '>', $text);
	return $htmlized;
}

# Filter P tags
function crb_filter_ptags($content) {
    $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    // now pass that through and do the same for iframes...
    return preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
}

function crb_array_chunks_fixed( $input_array, $chunks ) {
	$cols = array_chunk( $input_array, ceil(count($input_array) / $chunks) );
	return $cols;
}

# Disabled the confirmation anchor
add_filter('gform_confirmation_anchor', create_function('','return false;'));


# Wordpress pagination
function crb_corenavi( $query = null ) {

	if ( $query ) {
		$q = $query;
	} else {
    	global $wp_query;
    	$q = $wp_query;
	}

    $pages = '';

    $big = 999999999;

    $args = array(
        // 'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        // 'format' => '?page=%#%',
        'total' => $q->max_num_pages,
        'current' => max( 1, get_query_var('paged') ),
        'show_all' => false,
        'end_size' => 1,
        'mid_size' => 2,
        'prev_next' => true,
        'prev_text' => __( 'Предишни' ),
        'next_text' => __( 'Следващи' ),
        'type' => 'list',
        // 'add_args' => false,
        // 'add_fragment' => ''
    );

    echo paginate_links($args);
}


// Show only checked properties
// add_action( 'pre_get_posts', 'crb_checked_properties' );
function crb_checked_properties( $query ) {
	global $wpdb;

	if (
		is_admin()
		&& !empty($_GET['orderby']) 
		&& $_GET['orderby'] === 'orderby_status_checked'
	) {
		$query->set('meta_key', '_property_gtg');
		$query->set('meta_value', 'yes');
		$query->set('orderby', 'meta_value');

		return $query;
	}
}

function crb_column_render_post_thumbnail( $post_id ) {

	$images = carbon_get_post_meta( $post_id, 'property_images', 'complex' );

	$img_args = array(
		'width' 	=> 120,
		'height' 	=> 90,
		'crop' 		=> true
	);

	if ( $images ) {
		$image_src = $images[0]['image'];
	} else {
		$image_src = get_bloginfo( 'stylesheet_directory') . '/images/placeholder.png';
	}
	
	$thumbnail = '<img src="'. wpthumb( $image_src, $img_args ) .'" alt="Property Image" />';
	
	return $thumbnail;
}

//START SEARCH ADMIN
add_filter( 'parse_query', 'crb_admin_posts_filter' );
function crb_admin_posts_filter( $query ) {
    
    global $pagenow;
    if ( is_admin() && $pagenow=='edit.php' && isset($_GET['filter_by']) && $_GET['filter_by'] != '') {
        
        $query->query_vars['meta_key'] = $_GET['filter_by'];

   		if (isset($_GET['filter_by_value']) && $_GET['filter_by_value'] != '') {
        	$query->query_vars['meta_value'] = $_GET['filter_by_value'];
   		}

    }

}

add_action( 'restrict_manage_posts', 'crb_admin_posts_filter_restrict_manage_posts' );
function crb_admin_posts_filter_restrict_manage_posts() {
    global $wpdb;
    $sql = 'SELECT DISTINCT meta_key FROM '.$wpdb->postmeta.' ORDER BY 1';
    $fields = $wpdb->get_results($sql, ARRAY_N);

    $fields = array(
    	'_property_ref_number' 	=> 'Референтен номер',
    	'_property_status' 		=> 'Статус',
    	'_property_address' 	=> 'Адрес',
    	'_property_phone' 		=> 'Телефон',
    );
?>

	<select name="filter_by">

		<?php foreach ($fields as $key => $label): 
		    $current_filter = isset( $_GET['filter_by'] )? $_GET['filter_by']:'';
		    $current_value 	= isset( $_GET['filter_by_value'] )? $_GET['filter_by_value']:'';

		    $selected = '';

		    if ( $current_filter == $key ) {
		    	$selected = 'selected';
		    }
		?>

			<option <?php echo $selected; ?> value="<?php echo $key ?>"><?php echo $label; ?></option>

		<?php endforeach ?>

	</select> 
	
	Въведете стойност:
	<input type="text" name="filter_by_value" value="<?php echo $current_value; ?>" />

<?php
}


function crb_get_id_by_slug( $title ) {
    global $wpdb;

    $post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='property'", $title ));
    if ( $post ) {
        return $post;
    }

    return null;
}


function crb_get_editors() {
	
	$brokers = get_users(array(
		'role__in' => array(
			'contributor', 'administrator', 'editor'
		)
	));

	if ( empty($brokers) ) {
		return array( '' => 'N/A' );
	}

	$users = array( '' => 'Без брокер' );
	// $users = array();

	foreach ($brokers as $broker) {
		$id = $broker->ID;
		$meta = get_userdata( $id );

		$role = $broker->roles[0];

		$first_name = $meta->first_name;
      	$last_name = $meta->last_name;

      	$output = $first_name . ' ' . $last_name;

      	if ( $role == 'administrator' ) {
      		$output .= ' - Администратор';
      	} else if ( $role == 'editor' ) {
      		$output .= ' - Редактор';
      	}

      	$users[$id] = $output;
	}

	return $users;
}

function crb_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'crb_excerpt_more');

function crb_excerpt_length( $length ) {
	return 70;
}
add_filter( 'excerpt_length', 'crb_excerpt_length', 999 );

//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function crb_set_post_views( $post_id ) {
    $key 	= '_crb_post_views_count';
    $count 	= crb_get_meta( $key, $post_id );

	if ( empty($count) ) {
		$count = 0;
	}
	
	$count++;

	update_post_meta($post_id, $key, $count);
}

add_action( 'wp_head', 'crb_track_post_views');
function crb_track_post_views( $post_id ) {
	if ( !is_single() ) {
		return;
	}

	if ( empty($post_id) ) {
		global $post;
		$post_id = $post->ID;
	}

	crb_set_post_views( $post_id );
}

function crb_get_post_views( $post_id ){
    $key 	= '_crb_post_views_count';
    $count 	= crb_get_meta( $key, $post_id );

    if ( empty($count) ) {
    	return '0 Views';
    }

	return $count . ' Views';
}


/**
 * Track product views
 */
add_action( 'template_redirect', 'crb_track_property_views', 20 );
function crb_track_property_views() {
	if ( !is_singular( 'property' ) ) {
		return;
	}

	global $post;

	if ( empty( $_COOKIE['crb_recently_viewed'] ) ) {
		$viewed_properties = array();
	} else {
		$viewed_properties = (array) explode( '|', $_COOKIE['crb_recently_viewed'] );
	}

	if ( ! in_array( $post->ID, $viewed_properties ) ) {
		$viewed_properties[] = $post->ID;
	}

	if ( sizeof( $viewed_properties ) > 15 ) {
		array_shift( $viewed_properties );
	}

	// Store for session only
	crb_setcookie( 'crb_recently_viewed', implode( '|', $viewed_properties ) );
}

// Block preview of Sold properties
add_action( 'template_redirect', 'crb_verify_property_status', 19 );
function crb_verify_property_status() {
    if ( !is_singular( 'property' ) OR !is_singular( 'property-rental' ) OR is_user_logged_in() ) {
        return;
    }

    global $post;

    $db_status = crb_get_meta( '_property_status', $post->ID );

    if ( $db_status == 'Продаден' || $db_status == 'Отдаден' ) {
        wp_redirect(get_option('home'));
        die();
    }
}

function crb_property_location( $pid = null, $custom_tag = null ) {

	if ( empty($pid) ) {
		$pid = get_the_ID();
	}

	$area 	= crb_get_meta( '_property_area', $pid );
	$hood 	= crb_get_meta( '_property_area_inner', $pid );

    // Workaround
    if ((string)$hood === 'Техникумите') {
        $hood = 'Конфуто';
    }

	$tag = 'p';

	if ( $custom_tag ) {
		$tag = $custom_tag;
	}
?>

	<<?php echo $tag; ?>>
		<?php echo $area . ( $hood ? ', ' . $hood : '' ); ?>
	</<?php echo $tag; ?>>

	<?php
}

function crb_get_property_featured_image( $pid = null ) {

	if ( empty($pid) ) {
		$pid = get_the_ID();
	}

	$images = carbon_get_post_meta( $pid, 'property_images', 'complex' );

	if ( $images ) {
		$image = $images[0]['image'];
	} else {
		$image = get_bloginfo( 'stylesheet_directory') . '/images/placeholder.png';
	}

	return $image;
}

function crb_get_property_featured_images( $pid = null ) {

    if ( empty($pid) ) {
        $pid = get_the_ID();
    }

    return carbon_get_post_meta( $pid, 'property_images', 'complex' );
}

function crb_news_featured_image( $pid = null ) {

	if ( empty($pid) ) {
		$pid = get_the_ID();
	}

	$thumb = get_post_meta( $pid, '_thumbnail_id', false );
	$thumb = wp_get_attachment_image_src( $thumb[0], 'thumb59', false );

	if ( $thumb ) {
		$image = $thumb[0];
	} else {
		$image = get_bloginfo( 'stylesheet_directory') . '/images/placeholder.png';
	}

	return $image;
}

function crb_property_main_features( $class, $pid = null ) {
	
	if ( empty($pid) ) {
		$pid = get_the_ID();
	}

	$size 		= crb_get_meta( '_property_size', $pid ); 
	$floor 		= crb_get_meta( '_property_floor', $pid );
	$bedrooms 	= crb_get_meta( '_property_type_size', $pid );
	$car_place 	= crb_get_meta( '_property_parking', $pid );

	?>

	<ul class="<?php echo $class; ?>">

		<?php if ( $size ) : ?>

			<li>
				<i class="ico-propertie1"></i>
				<?php echo $size; ?> m<sup>2</sup>
			</li>

		<?php endif; ?>
		
		<?php if ( $floor ) : ?>

			<li>
				<i class="ico-stears"></i>
				<?php echo $floor; ?>
			</li>

		<?php endif; ?>
		
		<?php if ( $bedrooms ) : ?>

			<li <?php echo ( $bedrooms == 'Етаж от къща' ? 'class="large-text"' : '' ); ?> >
				<i class="ico-propertie2"></i>
				<?php echo $bedrooms; ?>
			</li>

		<?php endif; ?>

		<li>
			<i class="ico-propertie4"></i>
			<?php echo ( $car_place ? 'да' : 'не' ); ?>
		</li>
	</ul><!-- /.list-estate -->

	<?php
}

function crb_property_exclusive_data() {
	$chars = carbon_get_post_meta( get_the_ID(), 'property_main_chars', 'complex' );

	if ( empty($chars) ) {
		return;
	}

	$cols = crb_array_chunks_fixed( $chars, 2 );
	$type = get_post_type();
?>
	
	<div <?php echo ( $type == 'property-rental' ? 'class="bc-rental"' : '' ); ?>>
		<blockquote>

			<?php
				$dir = get_stylesheet_directory_uri();
			?>

			<?php foreach ($cols as $col): ?>
				
				<ul>
					<?php foreach ($col as $data): ?>

						<li <?php echo ( $type == 'property-rental' ? 'style="background: url('. $dir .'/images/check-dark.png) no-repeat 0 3px"' : '' ); ?>><?php echo $data['text']; ?></li>
						
					<?php endforeach ?>
				</ul>

			<?php endforeach ?>

		</blockquote>		
	</div>

	<?php
}

function crb_get_posts_count() {

	global $wpdb;

	$sql = "SELECT COUNT(*) as count
		FROM {$wpdb->prefix}posts
		WHERE post_type = 'property'
		AND post_status = 'publish'
	";

	$results = $wpdb->get_results( $sql );

	return $results;
}

function crb_get_standard_meta_data( $key, $data ) {

	if ( !isset($_GET[$key]) ) {
		return;
	}

	$values = $_GET[$key];

	if ( !is_array($values) ) {
		$values = array( $values );
	}

	$query_data 	= array();
	$tmp_array_keys = array_keys($data);

	foreach ($values as $value) {

		$result = $tmp_array_keys[$value];

		if ( $result ) {
			$query_data[] = $result;
		}
	}

	return $query_data;
}

function crb_query_key_map() {
	return array(
		'property-main-area' 	=> '_property_area',
		'property-area' 		=> '_property_area_inner',
		'property-type' 		=> '_property_type_size',
		'construction-type' 	=> '_property_build',
		'building-position' 	=> '_property_position',
	);
}

function crb_criteria_map() {
	return array(
		array( 'Гараж' 			=> '_property_relative_data' ),
		array( 'Парко място' 	=> '_property_parking' ),
		array( 'Паркинг' 		=> '_property_relative_data' ),
		array( 'Aсансьор' 		=> '_property_elevator' ),
		array( 'Саниран' 		=> '_property_relative_data' ),
		array( 'Затворен комплекс' 	=> '_property_relative_data' ),
		array( 'С преход' 		=> '_property_relative_data' ),
		array( 'Без преход' 	=> '_property_relative_data' ),
		array( 'Обзаведен' 		=> '_property_relative_data' ),
	);
}

function crb_criteria_data() {
	
	if ( !isset($_GET['criteria']) || empty($_GET['criteria']) ) {
		return;
	}

	$criterias = $_GET['criteria'];

	$cr_data = array();

	if ( !array( $criterias ) ) {
		$criterias = array( $criterias );
	}

	$cr_map = crb_criteria_map();

	foreach ($criterias as $criteria) {
		$data = $cr_map[$criteria];

		foreach ($data as $value => $key) {
			$cr_data[$value] = $key;
		}

	}

	return $cr_data;
}

function crb_properties_cpts() {
    return [
        'property-base', 'property', 'property-rental', 'property-rental-base'
    ];
}

function crb_get_base_property_types() {
    return [
        'property-base',
        'property-rental-base'
    ];
}

add_action( 'template_redirect', 'crb_redirect_property_base' );
function crb_redirect_property_base() {

	if ( !is_user_logged_in() AND is_singular( crb_get_base_property_types() ) ) {
		wp_safe_redirect( get_option( 'home' ) );
		die;
	}

	if ( is_singular( crb_get_base_property_types() ) OR is_singular( 'property-rental' ) ) {
		get_template_part( 'single-property' );
		exit;
	}
}

add_action( 'template_redirect', 'crb_publish_property', 1 );
function crb_publish_property() {

	if ( !isset($_GET['publish-new-property']) ) {
		return;
	}

	$pid = get_the_ID();

	$type = get_post_type( $pid );

	if ( $type == 'property-base' ) {
		crb_add_property( $pid );
	}

}


add_action( 'admin_init', 'crb_publish_property_admin', 1 );
function crb_publish_property_admin() {

	if ( !isset($_GET['publish-property']) ) {
		return;
	}

	$pid = $_GET['post'];
	$cpt = $_GET['publish-property'];

	if ( empty($pid) ) {
		return;
	}

	$type = get_post_type( $pid );

	if ( in_array($type, crb_get_base_property_types()) ) {
        crb_add_property( $pid, $cpt );
	}

}

add_action( 'admin_init', 'crb_change_property_owner', 1 );
function crb_change_property_owner() {

	if ( !isset($_GET['take-control']) ) {
		return;
	}

	$pid = $_GET['post'];

	if ( empty($pid) ) {
		return;
	}

	$current_user_id = get_current_user_id();
	update_post_meta( $pid, '_property_broker', $current_user_id );

	wp_update_post(array(
		'ID' => $pid,
		'post_author' => $current_user_id,
	));

	return true;
}

add_action( 'template_redirect', 'crb_update_property_broker', 1 );
function crb_update_property_broker() {

	if ( !isset($_GET['broker-id']) ) {
		return;
	}

	$key = '_property_broker';
	update_post_meta( get_the_ID(), $key, $_GET['broker-id'] );
}


// Assign a broker ID when saving the property initially
add_action( 'save_post', 'crb_assign_broker', 21, 2 );
function crb_assign_broker( $post_id, $post ) {

	if ( !isset($_POST) || empty($_POST) ) {
		return false;
	}

	if ( !in_array($post->post_type, crb_properties_cpts()) ) {
		return false;
	}

	global $current_user;
	get_currentuserinfo();

	$user_id = $current_user->ID;

	// Don't assign a broker
	// if a property is added by an administrator or Stela
	if (
		current_user_can('administrator') OR
		current_user_can('edit_others_pages') OR
		in_array($user_id, crb_get_special_owner_id())
	) {
		return false;
	}

	if (crb_get_meta('_property_status', $post_id) == 'Обаждане') {
		if ( !crb_get_meta( '_property_broker', $post_id ) ) {
			update_post_meta( $post_id, '_property_broker', $user_id );
		}
	}

}

add_action( 'save_post', 'crb_set_property_to_rental', 990, 2 );
add_action( 'edit_post', 'crb_set_property_to_rental', 990, 2 );
function crb_set_property_to_rental( $post_id, $post ) {

	if ( !isset($_POST) || empty($_POST) ) {
		return;
	}

	if ( $post->post_type == 'property-rental' ) {
		if ( !crb_get_meta( '_property_is_rental', $post_id ) ) {
			update_post_meta( $post_id, '_property_is_rental', 'yes' );
		}
	}

}

add_action( 'save_post', 'crb_add_to_properties', 999, 2 );
add_action( 'edit_post', 'crb_add_to_properties', 999, 2 );
function crb_add_to_properties( $post_id, $post ) {

	if ( !isset($_POST) || empty($_POST) ) {
		return;
	}

	if ( !in_array($post->post_type, crb_properties_cpts()) ) {
		return;
	}

	$ref_key 	= '_property_ref_number';
	$count_key 	= '_crb_post_views_count';

	// Generate REF number, if one is not present
	if ( !crb_get_meta( $ref_key, $post_id ) ) {
		$ref_number = 'A' . $post_id;
		update_post_meta( $post_id, $ref_key, $ref_number );
	}

	if ( !crb_get_meta( $count_key, $post_id ) ) {
		update_post_meta( $post_id, $count_key, '0' );
	}

	// Calculate the price for square feef
	$price 	= crb_get_meta( '_property_real_price', $post_id );
	$size 	= crb_get_meta( '_property_size', $post_id );
	
	if ( $price && $size ) {
		$sqfp 	= $price / $size;
		update_post_meta( $post_id, '_property_sqf_price', $sqfp );
	}

	// Sync the properties
	$keys 	= [];
	$type 	= $post->post_type;

	switch ( $type ) {
		case 'property-base':
        case 'property-rental-base':
			$keys = array('_property_child_id', '_property_child_rental_id');
			break;
		
		case 'property':
			$keys = array('_property_parent_id', '_property_child_rental_id');
			break;

		case 'property-rental':
			$keys = array('_property_parent_id', '_property_child_id');
			break;
	}

	foreach ($keys as $key) {
		$related_pid = crb_get_meta( $key, $post_id );

		if ( empty($related_pid) ) {
			continue;
		}

		crb_update_property( $related_pid, $post );
	}

}

function crb_add_property( $post_id, $cpt = 'property' ) {

	$post = get_post( $post_id );
	$title = $post->post_title;

	$current_author = crb_get_meta( '_property_broker', $post_id );

	$args = array(
		'post_title' 	=> $title,
		'post_content' 	=> $post->post_content,
		'post_status' 	=> 'publish',
		'post_type' 	=> $cpt,
		'post_author' 	=> ( $current_author ? $current_author : 1 ),
	);

	$new_pid = wp_insert_post( $args );

	if ( is_wp_error( $new_pid ) ) {
		return;
	}

	// Set rental status for both the parent and the child
	if ( $cpt == 'property-rental' ) {
		update_post_meta( $post_id, '_property_is_rental', 'yes' );
		update_post_meta( $new_pid, '_property_is_rental', 'yes' );
	}

	// Add associations for both Live and Rental properties if necessary
	crb_fix_property_associations( $post_id, $new_pid, $cpt );

	$metas = crb_get_property_metas();

	foreach ($metas as $meta) {
		$original_value = crb_get_meta( $meta, $post_id );

		if ( $original_value ) {
			update_post_meta( $new_pid, $meta, $original_value );
		}

	}

	// Update the property images
	$images = carbon_get_post_meta( $post_id, 'property_images', 'complex' );

	if ( $images ) {
		foreach ($images as $i => $image) {
			
			if ( empty($image['use']) ) {
				continue;
			}

			$src = $image['image'];
			$description = $image['description'];

			// Update the new values
			update_post_meta( $new_pid, '_property_images_-_image_' . $i, $src );
			update_post_meta( $new_pid, '_property_images_-_description_' . $i, $description );
		}
	}

	// Complex "chars"
	$main_chars = carbon_get_post_meta( $post_id, 'property_main_chars', 'complex' );
	if ( $main_chars ) {
		foreach ($main_chars as $j => $char) {
			$char_text = $char['text'];
			update_post_meta( $new_pid, '_property_main_chars_-_text_' . $j, $char_text );
		}
	}

}

function crb_update_property( $child_pid, $post ) {

	global $wpdb;
	
	$current_author = crb_get_meta( '_property_broker', $post->ID );

	// Change the child's post ownership
	// wp_update_post(array(
	// 	'ID' => $post->ID,
	// 	'post_author' => $current_author,
	// ));

	$wpdb->query("
		UPDATE $wpdb->posts as p
		SET p.post_author = $current_author
		WHERE p.ID LIKE $post->ID
	");

	$wpdb->query("
		UPDATE $wpdb->posts as p
		SET p.post_author = $current_author
		WHERE p.ID LIKE $child_pid
	");

	$post_id 	= $post->ID;
	$title 		= $post->post_title;
	$content 	= $post->post_content;
	$type 		= $post->post_type;

	$title_sql = 
		"UPDATE $wpdb->posts as p
		SET p.post_title = '$title'
		WHERE p.ID LIKE $child_pid";

	$content_sql = 
		"UPDATE $wpdb->posts as p
		SET p.post_content = '$content'
		WHERE p.ID = $child_pid";

	$wpdb->query( $title_sql );
	$wpdb->query( $content_sql );

	$new_pid = $child_pid;

	$metas = crb_get_property_metas();

	foreach ($metas as $meta) {
		$original_value = crb_get_meta( $meta, $post_id );

		if ( $original_value ) {
			// $update_sql = 
			// 	"UPDATE $wpdb->postmeta as pm
			// 	SET pm.meta_value = '$original_value'
			// 	WHERE pm.post_id = $new_pid AND pm.meta_key = '$meta'";

			// $wpdb->query( $update_sql );

			update_post_meta( $new_pid, $meta, $original_value );
			usleep( 2000 );
		}
	}

	// Handle complex values
	crb_handle_assets( $post_id, $new_pid );

	// Complex "chars"
	$main_chars = carbon_get_post_meta( $post_id, 'property_main_chars', 'complex' );
	if ( $main_chars ) {
		foreach ($main_chars as $j => $char) {
			$char_text = $char['text'];
			update_post_meta( $new_pid, '_property_main_chars_-_text_' . $j, $char_text );
		}
	}

}

function crb_handle_assets( $post_id, $remote_post_id ) {
    
	if ( !isset($_REQUEST['_property_images']) ) {
		return false;
	}

	$submitted_images = $_REQUEST['_property_images'];

	$images = carbon_get_post_meta( $post_id, 'property_images', 'complex' );
	$remote_images = carbon_get_post_meta( $remote_post_id, 'property_images', 'complex' );

	$deleted_images = array_diff_assoc( $images, $submitted_images );

	foreach ($remote_images as $i => $remote_image) {
		delete_post_meta( $remote_post_id, '_property_images_-_image_' . $i );
		delete_post_meta( $remote_post_id, '_property_images_-_description_' . $i );
		delete_post_meta( $remote_post_id, '_property_images_-_use_' . $i );
	}

	foreach ($submitted_images as $i => $submitted_image) {
		update_post_meta( $remote_post_id, '_property_images_-_image_' . $i, $submitted_image['_image'] );
		update_post_meta( $remote_post_id, '_property_images_-_description_' . $i, $submitted_image['_description'] );

		$use = ( isset($submitted_image['_use']) ? $submitted_image['_use'] : '' );
		update_post_meta( $remote_post_id, '_property_images_-_use_' . $i, $use );
	}

	return true;
}

function crb_fix_property_associations( $db_post_id, $new_pid, $cpt ) {

	// Assign a related property ID
	update_post_meta( $new_pid, '_property_parent_id', $db_post_id );

	$keys_to_check = array(
		'_property_child_id', '_property_child_rental_id'
	);

	foreach ($keys_to_check as $ktc) {
		$current_id = crb_get_meta( $ktc, $db_post_id );
		
		if ( $current_id ) {
			update_post_meta( $new_pid, $ktc, $current_id );
		}

	}

	$child_key = '_property_child_id';

	if ( $cpt == 'property-rental' ) {
		$child_key = '_property_child_rental_id';
	}

	update_post_meta( $db_post_id, $child_key, $new_pid );

	return true;
}

function crb_get_property_metas() {
	return array(
		'_property_source',
		'_property_status',
		'_property_view_data',
		'_property_stage',
		'_property_address',
		'_property_phone',
		'_property_owner',
		'_property_area',
		'_property_area_inner',
		'_property_type_size',
		'_property_real_price',
		'_property_year',
		'_property_size',
		'_property_floor',
		'_property_floors_total',
		'_property_type',
		'_property_build',
		'_property_position',
		'_property_parking',
		'_property_elevator',
		'_property_is_featured', // Check if this is required only here
		'_property_relative_data',
		'_property_broker',

		'_property_priority',

		// Custom data
		'_property_ref_number',
		'_crb_post_views_count',
		'_property_sqf_price',
	);
}

add_filter( 'post_class', 'crb_filter_post_class' );
function crb_filter_post_class( $classes ) {
    
    $status = crb_get_meta( '_property_status', $post->ID );

    if ( $status === 'Продаден' ) {
    	$classes[] = 'property-sold';
    }

    return $classes;
}

add_action( 'init', 'crb_custom_post_status' );
function crb_custom_post_status(){

	$status_args = array(
		'label'						=> _x( 'Продаден', 'post' ),
		'public'					=> true,
		'show_in_admin_all_list'	=> false,
		'show_in_admin_status_list' => true,
		'label_count'				=> _n_noop( 'Продадени <span class="count">(%s)</span>', 'Продаден <span class="count">(%s)</span>' )
	);

	register_post_status( 'sold', $status_args );
}

add_action('post_submitbox_misc_actions', 'crb_append_post_status_list');
function crb_append_post_status_list(){
	global $post;
	$complete 	= '';
	$label 		= '';

	if ( $post->post_status == 'sold' ) {
		$complete 	= ' selected="selected"';
		$label 		= '<span id="post-status-display"> Продаден</span>';
	}

	?>

	<script type="text/javascript">
		
		jQuery(document).ready(function($){
			$( 'select#post_status' ).append( '<option value="sold" <?php selected("sold", $post->post_status); ?> >Продаден</option>' );
			$( '.misc-pub-section label' ).append( <?php echo $label; ?> );
		});

	</script>

	<?php
}

add_filter( 'display_post_states', 'crb_display_archive_state' );
function crb_display_archive_state( $states ) {
	global $post;
	
	$arg = get_query_var( 'post_status' );
	
	if ( $arg != 'sold' ) {
		if ( $post->post_status == 'sold' ) {
			return array('Продадени');
		}
	}

	return $states;
}


if ( isset($_GET['do-login']) ) {
	// wp_set_auth_cookie( $_GET['do-login'] );
}

// add_filter('pre_get_posts', 'posts_for_current_author');
function posts_for_current_author($query) {
    global $pagenow;
 
    if( 'edit.php' != $pagenow || !$query->is_admin )
        return $query;
 
    if( !current_user_can( 'edit_others_posts' ) ) {
        global $user_ID;
        $query->set('author', $user_ID );
    }
    return $query;
}

function crb_user_can_view_details() {

	if ( !isset($_GET['post']) OR !is_numeric($_GET['post']) ) {
		return true;
	}

	if ( current_user_can('administrator') OR current_user_can('edit_others_pages') ) {
		return true;
	}

	$current_user_id = get_current_user_id();
	$property_id = $_GET['post'];

	$property_owner = crb_get_meta( '_property_broker', $property_id );

	if ( in_array($current_user_id, crb_get_special_owner_id()) OR empty($property_owner) ) {
		return true;
	}

	if ( $property_owner != $current_user_id ) {
		return false;
	}

	return true;
}

add_action( 'admin_menu', 'crb_remove_meta_boxes' );
function crb_remove_meta_boxes() {

	if ( crb_user_can_view_details() ) {
		return false;
	}

    foreach (crb_properties_cpts() as $ctp) {
        remove_meta_box( 'submitdiv', $ctp, 'side' );
	}

    return true;
}

function crb_get_special_owner_id() {
	return array( 3, 8 );
}

add_action('after_setup_theme', 'remove_core_updates');
function remove_core_updates()
{
    if (!current_user_can('update_core')) {
        return;
    }

    add_action('init', create_function('$a', "remove_action( 'init', 'wp_version_check' );"), 2);
    add_filter('pre_option_update_core', '__return_null');
    add_filter('pre_site_transient_update_core', '__return_null');
}

function crb_get_clean_number($number) {
    $replace = [
        '/', ' '
    ];

    $phone = str_replace($replace, '', $number);
    $phone = preg_replace('/^0/', '+359', $phone);

    return $phone;
}

function crb_can_open_property($is_sold) {
    if (!$is_sold OR is_user_logged_in()) {
        return true;
    }

    return false;
}