<?php 

/* Template name: Начало */

get_header();
	the_post();
?>

	<div class="intro">
		
		<?php get_template_part( 'fragments/slider' ); ?>

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

						<div class="form-row">
							<?php crb_slider_price(); ?>
						</div><!-- /.form-row -->
						
						<div class="form-row">
							<?php crb_slider_sqf(); ?>
						</div><!-- /.form-row -->

						<!-- <div class="form-row">
							<label class="select type-select">
								<select id="search-in-filter">
									<option data-url="<?php echo get_permalink( get_option( 'crb_search_page' ) ) ?>" value="sell">Търси в продажби</option>
									<option data-url="<?php echo get_permalink( get_option( 'crb_search_page_rentals' ) ) ?>" value="rent">Търси в наеми</option>
								</select>
							</label>
						</div> -->
					</div>
					
					<div class="form-controls quick-search">
						<input data-url="<?php echo get_permalink( get_option( 'crb_search_page_rentals' ) ) ?>" type="submit" class="form-btn blue-btn" value="Наеми" />
						<input data-url="<?php echo get_permalink( get_option( 'crb_search_page' ) ) ?>" type="submit" class="form-btn" value="Продажби" />
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="shell">
			<div class="container-head">
                <h1 style="color: #26374d">Републик Недвижими Имоти Варна: "Вие избирате, <span>Ние гарантираме</span>..."</h1>

				<?php // $properties = crb_get_posts_count(); ?>

				<!-- <p>
					<?php echo $properties[0]->count ?> недвижими имота се продават
				</p> -->
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