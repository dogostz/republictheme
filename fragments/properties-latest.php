<?php
    wp_reset_query();

	$args = array(
		'post_type' 		=> 'property',
		'posts_per_page' 	=> 6,
		'orderby' => 'rand',
    	'order' => 'ASC',
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => '_property_priority',
				'value' => '2',
				'compare' => '=',
			),
			array(
				'key'     => '_property_status',
				'value'   => 'Продаден',
				'compare' => 'NOT LIKE',
			),
		)
	);

	query_posts( $args );

	if ( !have_posts() ) {
		return;
	}

	$img_args = array(
		'width' 	=> 140,
		'height' 	=> 106,
		'crop' 		=> true
	);
?>

<div class="section section-last-properties">
	<div class="section-head">
		<h3>
			<a href="" class="link-last-properties">
				<span>Нашите топ предложения</span> <strong>в Продажби</strong>
			</a>
		</h3>
	</div>
	
	<div class="section-body">
		<ul class="properties-secondary" id="sale">

			<?php while( have_posts() ) : the_post(); 

				// Metas
				$price 	= crb_get_meta( '_property_real_price' );
				$size 	= crb_get_meta( '_property_size' );

				$image = crb_get_property_featured_image();
			?>

				<li class="property-seconadary">
					<div class="property-image">
						<a href="<?php the_permalink(); ?>">
							<img src="<?php echo wpthumb( $image, $img_args ); ?>" height="106" width="140" alt="" / >
						</a>
					</div>
					
					<div class="property-content">
						<h3>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						
						<?php crb_property_location(); ?>
						
						<ul class="list-options">
							<li>
								<i class="ico-price-red2"></i>
								<span><?php echo $price; ?> Euro</span> 
							</li>

							<?php if ( $size ) : ?>
								
								<li>
									<i class="ico-size-gray"></i>
									<?php echo $size; ?> кв.м
								</li>

							<?php endif; ?>

						</ul>
					</div>
					
					<div class="property-foot">
						<p>
							<strong>Особености:</strong>
							<?php 
								$excerpt = get_the_excerpt();
								echo wp_trim_words( $excerpt, 12 );
							?>
						</p>
					</div>
				</li>

			<?php endwhile; ?>

		</ul>

	</div>
</div>

<?php wp_reset_query(); ?>