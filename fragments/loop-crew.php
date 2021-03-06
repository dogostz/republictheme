<?php 
	$crew = get_posts( 'post_type=broker&posts_per_page=-1&orderby=menu_order&order=ASC' );

	if ( empty($crew) ) {
		return;
	}

	$img_args = array(
		'width' => 1280,
	);
?>

<div class="shell">
	<ul class="profiles">

		<?php foreach ($crew as $i => $broker):
			$image 		= crb_get_meta( '_broker_image', $broker->ID );
			$position 	= crb_get_meta( '_broker_position', $broker->ID );
			$phone 		= crb_get_meta( '_broker_phone', $broker->ID );
			$mobile 	= crb_get_meta( '_broker_mobile', $broker->ID );
			$address 	= crb_get_meta( '_broker_address', $broker->ID );
			$mail 		= crb_get_meta( '_broker_mail', $broker->ID );

			$contact_data = array(
				'ico-phone2' => $phone,
				'ico-mobile' => $mobile,
			);

			$address_data = array(
				'ico-pin2' 	=> $address,
				'ico-mail2' => $mail,
			);
		?>
		
			<li class="profile <?php echo $i%2==0 ? 'afterClearBoth' : '' ?>">
				<div class="profile-image">
					<img src="<?php echo wpthumb( $image, $img_args ); ?>" alt="" / >
				</div><!-- /.profile-image -->
				
				<div class="profile-content">
					<div class="profile-head">
						<h5><?php echo apply_filters( 'the_title', $broker->post_title ); ?></h5>
					
						<?php if ( $position ) : ?>
							<p><?php echo $position; ?></p>
						<?php endif; ?>
					</div><!-- /.profile-head -->
					
					<div class="profile-body">
						<?php echo wpautop($broker->post_content); ?>
					</div><!-- /.profile-body -->
				
					<div class="profile-foot">
						<ul class="list-contact">

							<li>

								<?php foreach ($contact_data as $icon => $number): 
									if ( empty($number) ) {
										continue;
									}
								?>
									
									<p>
										<i class="<?php echo $icon; ?>"></i>
                                        <a class="no-underline" href="tel:<?php echo crb_get_clean_number($number); ?>">
	                                        <?php echo $number; ?>
                                        </a>
									</p>
									
								<?php endforeach ?>

							</li>
							
							<li>

								<?php foreach ($address_data as $addr_icon => $value): 
									if ( empty($value) ) {
										continue;
									}
								?>
									
									<p>
										<i class="<?php echo $addr_icon; ?>"></i>
										<?php echo $value; ?>
									</p>
									
								<?php endforeach ?>

							</li>
						</ul>
					</div><!-- /.profile-foot -->
				</div><!-- /.profile-content -->
			</li><!-- /.profile -->

		<?php endforeach; ?>
		
	</ul><!-- /.profiles -->

</div><!-- /.shell -->