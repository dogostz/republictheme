<?php
	$key_map = crb_query_key_map();
	

	$args = array(
		'post_type' 		=> 'property',
		'posts_per_page' 	=> 8,
		'post__not_in' 		=> array( get_the_ID() )
	);

	$db_curr_price = crb_get_meta( '_property_real_price' );
	$curr_price = $db_curr_price ? $db_curr_price : 100000;
	
	$args['meta_query'][] = array(
		'key' 		=> '_property_real_price',
		'value' 	=> array( $curr_price - 5000, $curr_price + 5000 ),
		'compare' 	=> 'BETWEEN',
		'type' 		=> 'NUMERIC'
	);

	/*
	$standard_data = array(
		'property-area' 		=> crb_property_area_inner(),
		// 'property-type' 		=> crb_property_types_data(),
	);

	$query_stage_1 = array();

	// Meta query - stage 1
	foreach ($standard_data as $key => $data) {

		$meta_key = $key_map[$key];

		$value = crb_get_meta( $meta_key, get_the_ID() );

		if ( empty($value) ) {
			continue;
		}

		$query_stage_1[] = array(
			'key'     	=> $meta_key,
			'value'   	=> $value,
			'operator' 	=> 'LIKE',
		);
	}

	$args['meta_query'] = array(
		$query_stage_1
	);
	*/

	$properties = get_posts( $args );

	if ( empty($properties) ) {
		return;
	}

	$img_args = array(
		'width' 	=> 265,
		'height' 	=> 200,
		'crop' 		=> true
	);
?>

<div class="section section-most-viewed section-most-viewed-secondary">
	<div class="section-head section-head-primary">
		<h1><span>Подобни имоти</span></h1>
	</div>
	
	<div class="section-body">
		<div class="slider-secondary">
			<div class="slider-clip flexslider">
				<ul class="slides">
					
					<li class="slide">

						<?php foreach ($properties as $i => $property): 

							$pid = $property->ID;

							// Metas
							$price 	= crb_get_meta( '_property_real_price', $pid );
							$size 	= crb_get_meta( '_property_size', $pid );

							$image = crb_get_property_featured_image( $pid );
						?>
							
							<div class="property">
								<a href="<?php echo get_permalink( $pid ) ?>" class="property-link"></a>
								
								<div class="property-image do-crop">
									<img src="<?php echo wpthumb( $image, $img_args ); ?>" alt="" / >
								</div>
								
								<div class="property-body">
									<h5><?php echo apply_filters('the_title', $property->post_title); ?></h5>

									<?php crb_property_location( $pid ); ?>
								</div>
								
								<div class="property-foot"></div>
							</div>

							<?php if ( (($i+1) % 4) == 0 && (count( $properties ) != ($i+1)) ) : ?>
								</li><li class="slide">
							<?php endif; ?>

						<?php endforeach ?>

					</li>

				</ul>
				
				<div class="slider-actions">
					<a href="#" class="slider-next">
						<i class="ico-slider-left-gray"></i>
					</a>
					
					<a href="#" class="slider-prev">
						<i class="ico-slider-right-gray"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>