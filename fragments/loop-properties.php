<?php
	$page_type = crb_get_meta( '_page_search_type' );
    $is_predefined = (isset($_GET['predefined']) AND (int)$_GET['predefined'] === 1) ? true : false;

	$types = ( $page_type == 'rent' ?
				array( 'property-rental' ) :
				array( 'property' )
			);

	if ( is_user_logged_in() ) {
        $base_properties = ($page_type == 'rent')
            ? array('property-rental-base') : array('property-base');
		$types = array_merge($types, $base_properties);
	}

	$key_map = crb_query_key_map();

	$standard_data = array(
		'property-area' 		=> crb_property_area_inner(),
		'property-type' 		=> crb_property_types_data(),
	);

	$refining_data = array(
		'property-main-area' 	=> crb_property_area(),
		'construction-type' 	=> crb_build_types(),
		'building-position' 	=> crb_position_types(),
	);

	$range_data = array(
		'_property_size' 		=> array( 'sqf-min', 'sqf-max' ),
		'_property_real_price' 	=> array( 'price-min', 'price-max' ),
		'_property_sqf_price' 	=> array( 'sqfp-min', 'sqfp-max' ),
	);

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	$args = array(
		'post_type' 		=> $types,
		'posts_per_page' 	=> 10,
		'paged' 			=> $paged
	);

	$query_stage_1 = array();
	$query_stage_2 = array();
	$query_stage_3 = array();
	// stage 4
	// stage 5
	$query_stage_6 = array(); // Custom admin search

	// Meta query - stage 1
	foreach ($standard_data as $key => $data) {

		$value = crb_get_standard_meta_data( $key, $data );

		if ( empty($value) ) {
			continue;
		}

		$meta_key = $key_map[$key];

		$query_stage_1[] = array(
			'key'     	=> $meta_key,
			'value'   	=> $value,
			'operator' 	=> 'LIKE',
		);
	}

	// Meta query - stage 2
	foreach ($refining_data as $rf_key => $rf_data) {

		$rf_value = crb_get_standard_meta_data( $rf_key, $rf_data );

		if ( empty($rf_value) ) {
			continue;
		}

		$rf_meta_key = $key_map[$rf_key];

		$query_stage_2[] = array(
			'key'     	=> $rf_meta_key,
			'value'   	=> $rf_value,
			'operator' 	=> 'LIKE',
		);
	}

	// Meta query - stage 3
	foreach ($range_data as $range_key => $range_values) {
		$min = '';
		$max = '';

		foreach ($range_values as $range_value) {
			if ( !isset($_GET[$range_value]) ) {
				continue;
			}
			
			if ( preg_match('/min/', $range_value) ) {
				$min = $_GET[$range_value];
			} else {
				$max = $_GET[$range_value];
			}
		}

		if ( ($min != '') && ($max != '') ) {
			$query_stage_3[] = array(
				'key' 		=> $range_key,
				'value' 	=> array($min, $max),
				'compare' 	=> 'BETWEEN',
				'type' 		=> 'NUMERIC'
			);
		}
	}

	// $args['meta_query']['relation'] = 'AND';
	$args['meta_query'][] = array(
		$query_stage_1
	);

	$args['meta_query'][] = array(
		$query_stage_2
	);

	$args['meta_query'][] = array(
		$query_stage_3
	);

	// Meta query - stage 4
	if ( isset($_GET['build-year']) && !empty($_GET['build-year']) ) {
		$year = crb_get_standard_meta_data( 'build-year', crb_year_options() );
		$ints = preg_replace('/\D/', '', $year[0]);

		$operator = '>=';

		if ( $year[0] == 'преди 2000' ) {
			$operator = '<';
		}

		$args['meta_query'][] = array(
			'key' 		=> '_property_year',
			'value' 	=> $ints,
			'compare' 	=> $operator,
			'type' 		=> 'NUMERIC'
		);
	}

	// Meta query - stage 5
	$criteria = crb_criteria_data();
	if ( $criteria ) {
		foreach ($criteria as $crt => $key) {

			$cr_value = $crt;

			if ( $key == '_property_parking' || $key == '_property_elevator' ) {
				$cr_value = 'yes';
			}

			$args['meta_query'][] = array(
				'key' 		=> $key,
				'value' 	=> $cr_value,
				'compare' 	=> 'LIKE',
			);
		}
	}

	// Filter rentals, if the user isn't logged in
	if ( $page_type == 'rent' AND !is_user_logged_in() ) {
		$args['meta_query'][] = array(
			'key' 		=> '_property_is_rental',
			'value' 	=> 'yes',
			'compare' 	=> 'LIKE',
		);
	}

	$custom_search_data = array(
		'ref-number' 			=> array( '_property_ref_number', 'use-value' ),
		'property-status' 		=> array( '_property_status', 'get-value' ),
		'property-broker' 		=> array( '_property_broker', 'use-value' ),
		'phone-number' 			=> array( '_property_phone', 'use-value' ),
		'property_address' 		=> array( '_property_address', 'use-value' ),
	);

	foreach ($custom_search_data as $arg_key => $actions) {

		// if ( !isset($_GET[$arg_key]) || empty($_GET[$arg_key]) ) {
		if (
			!isset($_GET[$arg_key]) OR
			($arg_key != 'property-broker' AND empty($_GET[$arg_key])) OR
			($arg_key == 'property-broker' AND $_GET[$arg_key] == 'all')
		) {
			continue;
		}

		if ( $actions[1] == 'get-value' ) {
			$action_value = crb_get_standard_meta_data( $arg_key, crb_statuses() );
			$action_value = $action_value[0];
		} else {
			$action_value = $_GET[$arg_key];
		}

		$query_stage_6[] = array(
			'key'     	=> $actions[0],
			'value'   	=> $action_value,
			'operator' 	=> 'LIKE',
		);

	}

	if ( !empty($query_stage_6) ) {
		// As this is a very specif search
		// We ignore the previous criteria
		// $args['meta_query'] = array();

		$args['meta_query'][] = array(
			$query_stage_6
		);
	}

	if ( isset($_GET['sort']) ) {

		if ( isset($_GET['priority']) && !empty($_GET['priority']) ) {
			
			$args['meta_key'] 	= '_property_priority';
			$args['meta_value'] = crb_get_query_data( 'priority' );
			$args['orderby'] 	= 'meta_value';
			$args['order'] 		= 'ASC';

		} else {

			switch ( $_GET['sort'] ) {
				case '1':
					$args['order'] = 'DESC';
					break;

				case '2':
					$args['order'] = 'ASC';
					break;

				default:
					$args['orderby'] 	= 'title';
					$args['order'] 		= 'ASC';
					break;
			}

		}

	}

	query_posts( $args );

	if ( !have_posts() ) {
		echo '<h3>Няма намерени имоти, отговорящи на Вашите критерии</h3>';
	}

	$img_args = array(
		'width' 	=> 500,
		'height' 	=> 372,
		'crop' 		=> true
	);

	$priorities = crb_priorities();
?>

<ul class="items">

	<?php while ( have_posts() ) : the_post(); 

		// Metas
		$price 		= crb_get_meta( '_property_real_price' );
		$db_status 	= crb_get_meta( '_property_status' );
		$image 		= crb_property_featured_image();
		$broker_id  = crb_get_meta( '_property_broker' );
		$user_id    = carbon_get_user_meta( $broker_id, 'assoc_user' );
		$mobile 	= crb_get_meta( '_broker_mobile', $user_id );

		$pr_class = '';

		$type = get_post_type();

		if ( is_user_logged_in() ) {
			if ( $type == 'property' ) {
				$class  = 'green';
				$status = 'Публикувана обява';
			} else if ( $type == 'property-rental' ) {
				$class  = 'green';
				$status = 'Публикувана обява в наеми';
			} else if ( $type == 'property-rental-base' ) {
                $class  = 'red';
                $status = 'Обява база данни "Наеми"';
            } else {
				$class  = 'red';
				$status = 'Обява база данни "Продажби"';
			}

			$priority = crb_get_meta( '_property_priority' );
			$pr_class = 'priority-status-' . $priority;
		}

		$general_class 	= '';
		$is_sold 		= false;

		if ( $db_status == 'Продаден' || $db_status == 'Отдаден' ) {
			$general_class 	= 'property-sold';
			$is_sold 		= true;
		}
	?>
    
	<li class="item <?php echo $pr_class; ?> <?php echo $general_class; ?>">

		<?php
			if ( $type == 'property-rental' ) {
				echo '<img class="rent-image-icon" src="'. get_template_directory_uri() .'/images/icons/icon-rent.png">';
			} else if ( $type == 'property' ) {
			    if (isset($_GET['predefined']) AND (int)$_GET['predefined'] === 1) {
                    echo '<img class="promo-icon" src="'. get_template_directory_uri() .'/images/icons/promo.png">';
                } else {
                    echo '<img class="rent-image-icon" src="'. get_template_directory_uri() .'/images/icons/icon-key.png">';
                }
			}
		?>

		<div class="item-image">
			<a href="<?php echo (crb_can_open_property($is_sold) ? get_permalink() : '#' ) ?>">
				<img src="<?php echo wpthumb( $image, $img_args ); ?>" width="500" height="372" alt="" / >
				<?php if ( $is_sold ) : ?>
					
					<?php if ( $page_type == 'rent' ) : ?>
						<span class="overlay rental-overlay"></span>
					<?php elseif ( $page_type == 'sell' ) : ?>
						<span class="overlay"></span>
					<?php endif; ?>

				<?php endif; ?>
			</a>
		</div><!-- /.item-image -->

		<?php crb_property_main_features( 'list-properties' ); ?>

		<div class="item-content">
			<div class="item-head">
				<h3>
                    <?php if (crb_can_open_property($is_sold)) : ?>
					    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <?php else : ?>
                        <?php the_title(); ?>
                    <?php endif; ?>

					<?php if ( isset($status) AND $status ) : ?>
						<span class="<?php echo $class ?>"><?php echo $status; ?></span>
					<?php endif; ?>
				</h3>

				<?php crb_property_location(); ?>
			</div><!-- /.item-head -->
			
			<div class="item-body">
				<div class="item-body-excerpt">
					<?php
						$excerpt = get_the_excerpt();
						$limit = 25;

						if ( isset($status) AND $status )
							$limit = 20;

						echo wp_trim_words( $excerpt, $limit );
					?>
				</div>

				<?php if ( $price ) : ?>
					
					<p class="price">
						Цена: <strong><?php echo $price; ?> Euro</strong>

                        <?php if ( $mobile ) : ?>

                            <a class="mobile-call-link" href="tel:<?php echo crb_get_clean_number($mobile); ?>">
                                <span>&nbsp;</span>
                                <stong>Обади се</stong>
                            </a>

                        <?php endif; ?>

					</p><!-- /.price -->

				<?php endif; ?>

			</div><!-- /.item-body -->

            <?php if (crb_can_open_property($is_sold)) : ?>
			    <a href="<?php the_permalink(); ?>" class="btn btn-small">Виж детайли</a>
            <?php endif; ?>
		</div><!-- /.item-content -->
	</li><!-- /.item-image item-content -->

	<?php endwhile; ?>

</ul><!-- /.items -->


<?php if (  $wp_query->max_num_pages > 1 ) : ?>

	<div class="pagination">
		<?php crb_corenavi(); ?>
	</div><!-- /.pagination -->
	
<?php endif; ?>

<?php wp_reset_query(); ?>