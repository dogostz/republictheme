<?php
/**
 * Register the new widget classes here so that they show up in the widget list 
 */
function crb_load_widgets() {
	// register_widget('CrbLatestTweetsWidget');
	register_widget('ThemeWidgetLatestBrowsed');
	register_widget('ThemeWidgetLatestNews');
	register_widget('ThemeWidgetPropertyTypes');
	register_widget('ThemeWidgetFacebook');
}
add_action('widgets_init', 'crb_load_widgets');

/**
 * Displays a block with latest tweets from particular user
 */
class CrbLatestTweetsWidget extends Carbon_Widget {
	protected $form_options = array(
		'width' => 300
	);

	function __construct() {
		$this->setup('Latest Tweets', 'Displays a block with your latest tweets', array(
			Carbon_Field::factory('text', 'title', 'Title'),
			Carbon_Field::factory('text', 'username', 'Username'),
			Carbon_Field::factory('text', 'count', 'Number of Tweets to show')->set_default_value('5')
		));
	}

	/**
	 * Called when rendering the widget in the front-end
	 */
	function front_end($args, $instance) {
		if ( !carbon_twitter_is_configured() ) {
			return; //twitter settings are not configured
		}

		$tweets = TwitterHelper::get_tweets($instance['username'], $instance['count']);
		if (empty($tweets)) {
			return; //no tweets, or error while retrieving
		}

		extract($args);
		if ($instance['title']) {
			echo $before_title . $instance['title'] . $after_title;
		}
		?>
		<ul>
			<?php foreach ($tweets as $tweet): ?>
				<li><?php echo $tweet->tweet_text ?> - <span><?php echo $tweet->time_distance ?> ago</span></li>
			<?php endforeach ?>
		</ul>
		<?php
	}
}

/**
 * A Latest Browsed Properties widget
 */
class ThemeWidgetLatestBrowsed extends Carbon_Widget {
	/**
	 * Register widget function. Must have the same name as the class
	 */
	function __construct() {
		$this->setup('Theme Widget - Latest Browsed', 'Displays the latest browsed properties', array(
			Carbon_Field::factory('text', 'title')
				->set_default_value('Последно разглеждани'),
			Carbon_Field::factory('text', 'posts_count')
				->set_default_value( 4 )
		));
	}
	
	/**
	 * Called when rendering the widget in the front-end
	 */
	function front_end($args, $instance) {
		extract($args);
		
		if ($instance['title'] != '') {
			echo $before_title . $instance['title'] . $after_title;
		}

		$properties = ! empty( $_COOKIE['crb_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['crb_recently_viewed'] ) : array();
		$properties = array_filter( array_map( 'absint', $properties ) );

		if ( empty( $properties ) ) {
			return;
		}

		$img_args = array(
			'width' 	=> 59,
			'height' 	=> 45,
			'crop' 		=> true
		);
	?>
		
		<div class="widget-body">
			<ul class="updates">
					
				<?php foreach ($properties as $i => $pid): 

					if ( $i > $instance['posts_count'] ) {
						break;
					}

					// Metas
					$price 	= crb_get_meta( '_property_real_price', $pid );
					$size 	= crb_get_meta( '_property_size', $pid );

					$image = crb_property_featured_image( $pid );
				?>
					
					<li class="update">
						<a href="<?php echo get_permalink( $pid ); ?>">
							<span class="update-image">
								<img src="<?php echo wpthumb( $image, $img_args ); ?>" alt="" / >
							</span>
							
							<span class="update-content">
								<strong><?php echo get_the_title( $pid ); ?></strong>
									
								<?php crb_property_location( $pid, 'span' ); ?>
							</span>

							<i class="ico-arrow-link-gray"></i>
						</a>
					</li>
					
				<?php endforeach; ?>

			</ul>
		</div>

		<?php
	}
}


/**
 * A Latest News Widget
 */
class ThemeWidgetLatestNews extends Carbon_Widget {
	/**
	 * Register widget function. Must have the same name as the class
	 */
	function __construct() {
		$this->setup('Theme Widget - Latest News', 'Displays the latest news', array(
			Carbon_Field::factory('text', 'title')
				->set_default_value('Новини'),
			Carbon_Field::factory('text', 'posts_count')
				->set_default_value( 4 )
		));
	}
	
	/**
	 * Called when rendering the widget in the front-end
	 */
	function front_end($args, $instance) {
		extract($args);
		
		if ($instance['title'] != '') {
			echo $before_title . $instance['title'] . $after_title;
		}

		$args = array(
			'posts_per_page' => $instance['posts_count']
		);

		$news = get_posts( $args );

		if ( empty( $news ) ) {
			return;
		}

		$img_args = array(
			'width' 	=> 59,
			'height' 	=> 45,
			'crop' 		=> true
		);
	?>
		
		<div class="widget-body">
			<ul class="updates">
					
				<?php foreach ($news as $item):

					$image = crb_news_featured_image( $pid );
				?>
						
					<li class="update">
						<a href="<?php echo get_permalink( $item->ID ); ?>">
							<span class="update-image">
								<img src="<?php echo wpthumb( $image, $img_args ); ?>" alt="" / >
							</span>
							
							<span class="update-content">
								<strong><?php echo apply_filters('the_title', $item->post_title); ?></strong>
								
								<span><?php echo date( 'd/m/Y', strtotime( $item->post_date ) ); ?> г.</span>
							</span>

							<i class="ico-arrow-link-gray"></i>
						</a>
					</li>
					
				<?php endforeach; ?>

			</ul>
		</div>

		<?php
	}
}


/**
 * A Category Listing Widget
 */
class ThemeWidgetPropertyTypes extends Carbon_Widget {
	/**
	 * Register widget function. Must have the same name as the class
	 */
	function __construct() {
		$this->setup('Theme Widget - Property Types', 'Displays property types categories', array(
			Carbon_Field::factory('text', 'title')
				->set_default_value('Категории'),
		));
	}
	
	/**
	 * Called when rendering the widget in the front-end
	 */
	function front_end($args, $instance) {
		extract($args);
		
		if ($instance['title'] != '') {
			echo $before_title . $instance['title'] . $after_title;
		}

		$data = crb_property_types_data();

		$search_page_id = get_option( 'crb_search_page' );
		$search_page 	= get_permalink( $search_page_id );
	?>

		<div class="widget-body">
			<ul class="list-arrows">
				<ul>
					
					<?php foreach ($data as $type): 
						$type_id = crb_array_value_index( $type, $data );
					?>
						
						<li>
							<a href="<?php echo $search_page; ?>/?property-type[]=<?php echo $type_id; ?>"><?php echo $type; ?></a>
						</li>

					<?php endforeach ?>

				</ul>
			</ul>
		</div>

		<?php
	}
}


/**
 * A Category Listing Widget
 */
class ThemeWidgetFacebook extends Carbon_Widget {
	/**
	 * Register widget function. Must have the same name as the class
	 */
	function __construct() {
		$this->setup('Theme Widget - Facebook', 'Displays a Facebook sharing box', array(
		));
	}
	
	/**
	 * Called when rendering the widget in the front-end
	 */
	function front_end($args, $instance) {
		extract($args);

	?>

		<div class="fb-like-box" data-href="<?php echo get_option( 'crb_facebook' ); ?>" data-width="267" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>

		<?php
	}
}