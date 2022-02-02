<?php 
	$image = crb_get_meta( '_page_image' );

	if ( empty($image) ) {
		$image = get_option( 'crb_default_page_image' );
	}

	if ( empty($image) ) {
		return;
	}

	$img_args = array(
		'height' => 229
	);
?>

<div class="intro intro-secondary">
	<img src="<?php echo wpthumb( $image, $img_args ); ?>" height="229" class="intro-image" alt="" / >

	<div class="breadcrumbs">
		<div class="shell">
			<?php crb_breadcrumbs(); ?>
		</div><!-- /.shell -->
	</div>
</div>