<?php 
	$args = array(
		'post_type' 		=> 'property',
		'posts_per_page' 	=> 12,
		'orderby' => 'rand',
		'meta_query' => array(
			'relation' => 'AND',
			'status_clause' => array(
				'key' => '_property_status',
				'value' => 'Продаден',
				'compare' => 'NOT LIKE',
			),
			'featured_clause' => array(
				'key' => '_property_is_featured',
				'value' => 'yes',
				'compare' => 'LIKE',
			), 
		),
		/*'meta_key' 			=> '_crb_post_views_count',
		'orderby' 			=> 'meta_value',
		'meta_key' 			=> '_property_is_featured',
		'orderby' 			=> 'meta_value',
		'meta_query' => array(
			array(
				'key'     => '_property_status',
				'value'   => 'Продаден',
				'compare' => 'NOT LIKE',
			),
		),*/
	);

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

<div class="container-body">
	<div class="section section-most-viewed">
		<div class="section-head section-head-primary">
			<h1><span>Най-търсени</span></h1>

			<a href="<?php echo get_permalink( get_option( 'crb_search_page' ) ) ?>" class="btn"><span>Виж всички</span></a>
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

								$image = crb_property_featured_image( $pid );
							?>
								
								<div class="property">
									<a href="<?php echo get_permalink( $pid ) ?>" class="property-link"></a>
									
									<div class="property-image">
										<img src="<?php echo wpthumb( $image, $img_args ); ?>" alt="" / >
									</div>
									
									<div class="property-body">
										<h5><?php echo apply_filters('the_title', $property->post_title); ?></h5>

										<?php crb_property_location( $pid ); ?>
									</div>
									
									<div class="property-foot">
										<ul class="list-options">

											<?php if ( $size ) : ?>

												<li>
													<i class="ico-size-gray"></i>
													<?php echo $size; ?> кв.м 
												</li>

											<?php endif; ?>
											
											<li>
												<i class="ico-price-red2"></i>
												<strong><?php echo $price; ?> Euro</strong>
											</li>
										</ul>
									</div>
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
</div>