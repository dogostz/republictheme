<?php 

/* Template name: Разширено търсене */

get_header();
	the_post();
?>

	<?php get_template_part( 'fragments/page-heading' ); ?>
	
	<div class="container container-secondary">
		<div class="main">
			<div class="shell">
				<div class="container-head">
					<h1><?php the_title(); ?></h1><!-- /.shell -->
				</div>

				<?php
					$search_type = crb_get_meta( '_page_search_type' );
					$search_page = 'crb_search_page';

					if ( $search_type == 'rent' ) {
						$search_page = 'crb_search_page_rentals';
					}
				?>
				
				<div class="form form-search">
					<form action="<?php echo get_permalink( get_option( $search_page ) ) ?>" method="GET">
						<div class="form-head">
							<?php the_content(); ?>
						</div><!-- /.form-head -->
						
						<div class="form-body">
							<div class="form-section">
								<div class="form-row">

									<div class="form-col form-col-3of4">
										
										<div class="form-col form-col-1of4">
											<label for="">Вид на имота</label>

											<div class="form-group">
												<?php crb_render_type_filter(); ?>
											</div><!-- /.form-group -->

											<label class="padding" for="">Вид строителство</label>
											<?php crb_building_type_filter(); ?>

											<label class="padding" for="">Година на построяване</label>
											<?php crb_property_years(); ?>

											<label class="padding" for="">Изложение</label>
											<?php crb_building_position_filter(); ?>

											<label class="padding" for="">Референтен номер</label>
											<input type="text" name="ref-number" value="" />
										</div>
										<!-- /.form-col -->

										<div class="form-col form-col-1of4">
											<label for="">Райони</label>

											<div class="form-group">
												
												<?php crb_property_areas(); ?>

											</div><!-- /.form-group -->
											
											<label class="padding" for="">Квадратура</label>
											<?php crb_slider_sqf(); ?>

											<label class="padding" for="">Цена</label>
											<?php crb_slider_price(); ?>

											<label class="padding" for="">Цена на кв.м</label>
											<?php crb_slider_sqf_price(); ?>
										</div><!-- /.form-col -->

										<div class="cl"></div>

										<label class="padding" for="">Допълнителни критерии</label>

										<div class="form-group extra-group">
											<?php crb_extra_criteria(); ?>
										</div><!-- /.form-group -->

									</div><!-- /.form-col -->

									<div class="form-col form-col-2of4">
										<label for="">Населено място</label>
										<?php crb_property_main_areas(); ?>

										<label for="">Избери:</label>
										
										<?php get_template_part( 'fragments/varna-map' ); ?>

										<br />
										<label class="select type-select">
											<select id="search-in-filter">
												<option data-url="<?php echo get_permalink( get_option( 'crb_search_page' ) ) ?>" value="sell">Търси в продажби</option>
												<option data-url="<?php echo get_permalink( get_option( 'crb_search_page_rentals' ) ) ?>" value="rent">Търси в наеми</option>
											</select>
										</label>

										<div class="form-actions">
											<input type="submit" value="Търси" class="form-btn" />
										</div><!-- /.form-actions -->

										<label class="padding" for="">Сортиране по:</label>

										<?php crb_sorting_options(); ?>

									</div><!-- /.form-col form-col-2of4 -->
								</div>

								<?php if ( is_user_logged_in() ) : ?>

									<div class="form-row">

										<div class="form-col form-col-1of4">
											<label class="padding" for="">Статус на обява</label>
											<?php crb_statuses_filter(); ?>
										</div><!-- /.form-col -->

										<div class="form-col form-col-1of4">
											<label class="padding" for="">Брокер</label>
											<?php crb_brokers_filter(); ?>
										</div><!-- /.form-col -->

										<div class="form-col form-col-1of4">
											<label class="padding" for="">Приоритет</label>
											<?php crb_priorities_filter(); ?>
										</div><!-- /.form-col -->
										
									</div>

									<div class="form-row">

										<!-- <div class="form-col form-col-1of4">
											<label class="padding" for="">Референтен номер</label>
											<input type="text" name="ref-number" value="" />
										</div>-->

										<div class="form-col form-col-1of4">
											<label class="padding" for="">Телефонен номер</label>
											<input type="text" name="phone-number" value="" />
										</div><!-- /.form-col -->

										<div class="form-col form-col-2of4">
											<label class="padding" for="">Адрес</label>
											<input type="text" name="property_address" value="" />
										</div><!-- /.form-col -->

									</div>

								<?php endif; ?>

							</div><!-- /.form-section -->
						</div><!-- /.form-body -->

					</form>
				</div>

			</div><!-- /.shell -->
		</div>
	</div>

<?php get_footer(); ?>