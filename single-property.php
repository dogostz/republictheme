<?php get_header();
	the_post(); ?>

	<div class="intro intro-primary">
		<div class="breadcrumbs">
			<div class="shell">
				<?php crb_breadcrumbs(); ?>
			</div><!-- /.shell -->
		</div><!-- /.breadctubs -->
	</div>

	<?php
		// Metas
		$price 	= crb_get_meta( '_property_real_price' );
		$number = crb_get_meta( '_property_ref_number' );

		$type = get_post_type();
	?>
	
	<div class="container container-secondary">
		<div class="shell">
			<div class="main">
				<div class="estate clearfix">
					<div class="col col-1of2">
						<div class="estate-head">
							<h3>
								<?php
									// if ( $type == 'property-rental' ) {
									// 	echo '<img class="rent-icon-inner" src="'. get_template_directory_uri() .'/images/icons/icon-rent.png">';
									// }
									the_title();
									crb_property_location( null, 'span' );
								?>
							</h3>
						</div><!-- /.estate-head -->

						<div class="estate-head-secondary">
							<?php crb_property_main_features( 'list-estate' ); ?>

							<?php if ( $price ) : ?>

								<p class="price">
									Цена
									<strong><?php echo $price; ?> Euro</strong>
								</p><!-- /.price -->

							<?php endif; ?>

						</div><!-- /.estate-head-secondary -->
						
						<div class="estate-body">
							<p class="ref-num">
								Реф, номер: № <strong><?php echo $number; ?></strong> 
							</p><!-- /.ref-num -->

							<?php crb_property_exclusive_data(); ?>

							<?php the_content(); ?>

							<?php if ( is_user_logged_in() ) : 

								// PD:20170219
								$logged_user_id = get_current_user_id();
								//get_post_meta( get_the_ID(), 'be_content', true );

								$broker_id = crb_get_meta( '_property_broker' );

								/*if ( empty($broker_id) ) {
									return;
								}*/

								/*$user_id = carbon_get_user_meta( $broker_id, 'assoc_user' );

								if ( empty($user_id) ) {
									return;
								}*/

								/*echo 'property_user_id: '.$user_id;
								echo '<br>';
								echo 'property_broker_id: '.$broker_id;
								echo '<br>';
								echo 'logged_user_id: '.$logged_user_id;*/

								$logged_user_meta_arr = get_user_meta($logged_user_id);

								/*echo '<pre>';
								print_r($logged_user_meta_arr);
								echo '</pre>';*/

								$isAdmin = in_array(10, $logged_user_meta_arr['wp_user_level']);

								//echo $isAdmin ? 'admin': 'not admin';


								if((!empty($broker_id) && $logged_user_id==$broker_id) || $isAdmin){
									$properties = array(
										'property_owner' 	=> 'Име на собственик',
										'property_phone' 	=> 'Телефонен номер',
										'property_address' 	=> 'Адрес на имота',
										'property_status' 	=> 'Статус на имота',
										'property_notes' 	=> 'Бележки',
									);
								}else{
									$properties = array(										
										'property_status' 	=> 'Статус на имота',									
									);
								}
							?>

								<ul class="property-info">

									<?php foreach ($properties as $key => $label): 
										$value = crb_get_meta( '_' . $key );

										if ( empty($value) ) {
											continue;
										}
									?>
										
										<li>
											<h4><?php echo $label; ?></h4>
											<?php echo wpautop( $value ); ?>
										</li>

									<?php endforeach ?>

								</ul>

							<?php endif; ?>

						</div><!-- /.estate-body -->

						<?php get_template_part( 'fragments/property-broker' ); ?>
						
					</div><!-- /.col col-1of2 -->
						
					<?php get_template_part( 'fragments/property-gallery' ); ?>
					
				</div><!-- /.estate -->

				<?php
					get_template_part( 'fragments/related-properties' );
					get_template_part( 'fragments/admin-buttons' );
				?>

			</div>
		</div>
	</div>

<?php get_footer(); ?>