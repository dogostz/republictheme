<?php

/* Template name: Начало */

get_header();
	the_post();
?>

	<div class="intro">

		<?php get_template_part( 'fragments/slider' ); ?>


	</div>

	<div class="container">
		<div class="shell">
			<div class="container-head">
				<h1>Алфа Агенти <span>България</span></h1>

				<?php // $properties = crb_get_posts_count(); ?>

				<!-- <p>
					<?php echo $properties[0]->count ?> недвижими имота се продават
				</p> -->

				<div class="search-property">
					<div class="form-fast-search">
						<form action="<?php echo get_permalink( get_option( 'crb_search_page' ) ) ?>" method="GET">
							<div class="form-head clearfix">
								<h2>Търси Имот</h2>

								<p>
									<a href="<?php echo get_permalink( get_option( 'crb_extended_search_page' ) ); ?>">Разширено търсене</a>
								</p>
							</div>

							<div class="form-body">
								<div class="grid">
								<div class="form-row">
									<?php crb_property_main_areas(); ?>
								</div><!-- /.form-row -->

								<div class="form-row">
									<div class="form-col">
										<?php crb_building_type_filter( 'Избери вид' ); ?>
									</div><!-- /.form-col -->

									<div class="form-col">
										<?php crb_render_type_filter( 'selectbox' ); ?>
									</div><!-- /.form-col -->
								</div><!-- /.form-row -->
							</div><!-- /.grid -->

							<div class="grid">
								<div class="form-row">
									<?php crb_slider_price(); ?>
								</div><!-- /.form-row -->

								<div class="form-row">
									<?php crb_slider_sqf(); ?>
								</div><!-- /.form-row -->
							</div><!-- /.grid -->
							<div class="grid">
								<div class="form-row">
									<input type="text" name="ref-number" placeholder="Търси по референтен номер " />
								</div><!-- /.form-row -->
							</div><!-- /.grid -->
							<div class="grid">
								<div class="form-controls">
									<input type="submit" class="form-btn" value="Търси имот" />
								</div>
							</div><!-- /.grid -->
							</div>


						</form>
					</div>
				</div>





			</div>

			<?php get_template_part( 'fragments/properties-most-popular' ); ?>

			<div class="main">
				<div class="content">
					<?php get_template_part( 'fragments/properties-latest' ); ?>
				</div>

				<div class="sidebar">
					<ul class="widgets">

						<?php dynamic_sidebar( 'home-sidebar' ); ?>

					</ul>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
