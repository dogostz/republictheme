<?php 
	$slides = get_posts( 'post_type=slide&posts_per_page=-1&orderby=menu_order&order=ASC' );
	if ( empty($slides) ) {
		return;
	}

	$img_args = array(
		'height' => 440
	);
?>

<div class="slider">
	<div class="slider-clip flexslider">
		<ul class="slides">

			<?php foreach ($slides as $slide): 
				$slide_image 	= crb_get_meta( '_slide_image', $slide->ID );
				$slide_size 	= crb_get_meta( '_slide_size', $slide->ID );
				$slide_price 	= crb_get_meta( '_slide_price', $slide->ID );
			?>
				
				<li class="slide">
					<div class="slide-image">
						<img src="<?php echo wpthumb( $slide_image, $img_args ) ?>" height="440" alt="" / >
					</div>

					<div class="slider-content">
						<div class="shell">
							<p><?php echo apply_filters( 'the_title', $slide->post_title ); ?></p>

							<?php 
								$icons = array(
									'ico-size-white' 	=> $slide_size,
									'ico-price-red' 	=> $slide_price,
								);
							?>

							<ul class="list-options">

								<?php foreach ($icons as $icon => $data): 
									if ( empty($data) ) {
										continue;
									}
								?>
									
								<li>
									<i class="<?php echo $icon; ?>"></i>
									<?php echo $data; ?>
								</li>

								<?php endforeach ?>

							</ul>
						</div><!-- /.shell -->
					</div>
				</li>
				
			<?php endforeach ?>

		</ul>
		
		<div class="slider-actions">
			<a href="#" class="slider-next">
				<i class="slider-arrow-left"></i>
			</a>
			
			<a href="#" class="slider-prev">
				<i class="slider-arrow-right"></i>
			</a>
		</div>
	</div>
</div>