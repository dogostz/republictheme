<?php 
	$images = carbon_get_post_meta( get_the_ID(), 'property_images', 'complex' );

	if ( empty($images) ) {
		return;
	}

	$size_small = array(
		'width' 	=> 268,
		'height' 	=> 178,
		'crop' 		=> true
	);

	$size_large = array(
		'width' 	=> 548,
		'height' 	=> 298,
		'crop' 		=> true
	);
?>

<div class="col col-1of2">
	<div class="estate-gallery">
		<ul class="list-galleries">

			<?php foreach ($images as $i => $img): 
				$src = $img['image'];

				$args = $size_small;

				if ( !$i ) {
					$args = $size_large;
				}
			?>
				
				<li>
					<a href="<?php echo $src; ?>" rel="group">
						<img src="<?php echo wpthumb( $src, $args ); ?>" alt="" / >
					</a>
				</li>

			<?php endforeach ?>
			
		</ul><!-- /.list-galleries -->
	</div><!-- /.estate-gallery -->
</div><!-- /.col col-1of2 -->