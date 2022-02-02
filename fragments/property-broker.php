<?php 
	$broker_id = crb_get_meta( '_property_broker' );

	if ( empty($broker_id) ) {
		return;
	}

	$user_id = carbon_get_user_meta( $broker_id, 'assoc_user' );

	if ( empty($user_id) ) {
		return;
	}

	$image 		= crb_get_meta( '_broker_image', $user_id );
	$phone 		= crb_get_meta( '_broker_phone', $user_id );
	$mobile 	= crb_get_meta( '_broker_mobile', $user_id );
	$address 	= crb_get_meta( '_broker_address', $user_id );
	$mail 		= crb_get_meta( '_broker_mail', $user_id );

	$img_args = array(
		'width' 	=> 135,
		'height' 	=> 135,
		'crop' 		=> true,
		'crop_from_position' 	    => 'top,center',
	);
?>

<div class="estate-foot">
	<div class="estate-head-secondary">
		<h3>
			 Вашият консултант  
		</h3>
	</div>

	<div class="consultant">

		<?php if ( $image ) : ?>

			<div class="consultant-image">
				<img src="<?php echo wpthumb( $image, $img_args ) ?>" alt="" / >
			</div><!-- /.consultat-image -->

		<?php endif; ?>
		
		<div class="consultant-body">
			<h3><?php echo get_the_title( $user_id ); ?></h3>

			<ul class="list-contact">
				<li>

					<?php if ( $phone ) : ?>

						<p>
							<i class="ico-phone2"></i>
                            <a class="no-underline" href="tel:<?php echo crb_get_clean_number($phone); ?>">
								<?php echo $phone; ?>
                            </a>
						</p>

					<?php endif; ?>

					<?php if ( $mobile ) : ?>

						<p>
							<i class="ico-mobile"></i>
                            <a class="no-underline" href="tel:<?php echo crb_get_clean_number($mobile); ?>">
								<?php echo $mobile; ?>
                            </a>
						</p>

					<?php endif; ?>

				</li>
				
				<li>

					<?php if ( $address ) : ?>

						<p>
							<i class="ico-pin2"></i>
							<?php echo $address; ?>
						</p>

					<?php endif; ?>
					
					<?php if ( $mail ) : ?>

						<p>
							<i class="ico-mail2"></i>
							<?php echo $mail; ?>
						</p>

					<?php endif; ?>

				</li>
			</ul>
		</div><!-- /.consultant-body -->

		<div class="clearfix"></div><!-- /.cl -->

		<div class="consult-actions">
			<a href="#inquire-form" class="btn btn-secondary form-btn-trigger">Изпрати запитване</a>
			
			<a href="<?php echo get_permalink( get_option( 'crb_search_page' ) ) ?>/?property-broker=<?php echo $broker_id; ?>" class="btn btn-secondary">
				Всички оферти
			</a>
		</div><!-- /.consult-actions -->

		<?php if ( is_user_logged_in() AND (get_post_type() == 'property' OR get_post_type() == 'property-rental') ) : 
			$subject = 'Агенция REPUBLIC - обява "'. get_the_title() .'"';
			$body = 'Моля разгледайте следната обява: ' . get_permalink();
			$mailto = 'mailto:?body='. $body .'&subject=' . $subject;
		?>
			
			<div class="client-actions">
				<a href="<?php echo $mailto; ?>" class="btn send-client-button" target="_top">
					Изпрати оферта на клиент
				</a>
			</div>

		<?php endif; ?>

		<div id="inquire-form" class="inline-form">
			<h2>Изпратете ни Вашето запитване</h2>
			<?php echo do_shortcode( '[gravityform id="1" title="false" description="false" ajax="true" field_values="property_name='. get_the_title() .'" tabindex="200"]' ); ?>
		</div>

	</div><!-- /.consultant -->
</div><!-- /.estate-foot -->