<?php

function crb_get_query_data( $arg ) {

	if ( !isset($_GET[$arg]) ) {
		return array();
	}

	$queried_data = $_GET[$arg];

	if ( $queried_data == '' ) {
		return array();
	}

	if ( !is_array( $queried_data ) ) {
		$queried_data = array( $queried_data );
	}

	return $queried_data;
}

function crb_slider_values( $min, $max, $arg_min, $arg_max ) {

	if ( isset($_GET[$arg_min]) ) {
		$min = $_GET[$arg_min];
	}

	if ( isset($_GET[$arg_max]) ) {
		$max = $_GET[$arg_max];
	}

	return array(
		'min' => $min,
		'max' => $max,
	);
}

function crb_render_type_filter( $html = 'checkboxes' ) {

	$data = crb_property_types_data();

	$queried_data = crb_get_query_data( 'property-type' );
?>

	<?php if ( $html === 'checkboxes' ) : ?>

	<ul class="checkboxes">

		<?php foreach ($data as $type):
			$type_id = crb_array_value_index( $type, $data );

			$active = '';

			if ( in_array($type_id, $queried_data) ) {
				$active = 'checked';
			}

		?>

			<li class="checkbox">
				<input <?php echo $active; ?> name="property-type[]" value="<?php echo $type_id ?>" type="checkbox" id="type-<?php echo $type_id; ?>" />
				<label for="type-<?php echo $type_id; ?>"><?php echo $type; ?></label>
			</li><!-- /.checkbox -->

		<?php endforeach ?>

	</ul><!-- /.checkboxes -->

	<?php else : ?>

		<label class="select">
			<select name="property-type" id="property-type">

				<option value="">Избери тип</option>

				<?php foreach ($data as $type):
					$type_id = crb_array_value_index( $type, $data );

					$active = '';

					if ( in_array($type_id, $queried_data) ) {
						$active = 'selected';
					}
				?>

					<option <?php echo $active; ?> value="<?php echo $type_id; ?>"><?php echo $type; ?></option>

				<?php endforeach ?>

			</select>
		</label><!-- /.select -->

	<?php endif; ?>

	<?php
}

function crb_building_type_filter( $label = null ) {

	$types = crb_build_types();

	$default = 'Всички';

	if ( $label ) {
		$default = $label;
	}

	$queried_data = crb_get_query_data( 'construction-type' );

?>

	<label class="select">
		<select name="construction-type" id="construction-type">

			<option value=""><?php echo $default; ?></option>

			<?php foreach ($types as $type):
				$type_id = crb_array_value_index( $type, $types );

				$active = '';

				if ( in_array($type_id, $queried_data) ) {
					$active = 'selected';
				}
			?>

				<option <?php echo $active; ?> value="<?php echo $type_id; ?>"><?php echo $type; ?></option>

			<?php endforeach ?>

		</select>
	</label><!-- /.select -->

	<?php
}

function crb_building_position_filter() {

	$positions = crb_position_types();

	$queried_data = crb_get_query_data( 'building-position' );
?>

	<label class="select">
		<select name="building-position" id="building-position">

			<option value="">Всички</option>

			<?php foreach ($positions as $type):
				$positions_id = crb_array_value_index( $type, $positions );

				$active = '';

				if ( in_array($positions_id, $queried_data) ) {
					$active = 'selected';
				}
			?>

				<option <?php echo $active; ?> value="<?php echo $positions_id; ?>"><?php echo $type; ?></option>

			<?php endforeach ?>

		</select>
	</label><!-- /.select -->

	<?php
}

function crb_property_main_areas() {

	$areas = crb_property_area();

	$queried_data = crb_get_query_data( 'property-main-area' );
?>

	<label class="select place-select">
		<select name="property-main-area" id="">

			<?php foreach ($areas as $area_key => $area):
				$area_id = crb_array_value_index( $area_key, $areas );

				$active = '';

				if ( in_array($area_id, $queried_data) ) {
					$active = 'selected';
				}
			?>

				<option <?php echo $active; ?> value="<?php echo $area_id; ?>"><?php echo $area; ?></option>

			<?php endforeach ?>

		</select>
	</label><!-- /.select -->

	<?php
}

function crb_property_areas() {

	$areas = crb_property_area_inner();

	$queried_data = crb_get_query_data( 'property-area' );
?>

	<ul class="checkboxes areas-filter">

		<?php foreach ($areas as $area_key => $area):
			$area_id = crb_array_value_index( $area_key, $areas );

			$active = '';

			if ( in_array($area_id, $queried_data) ) {
				$active = 'checked';
			}

			$alt_title = false;
			if ( $area == 'Автогарата' ) {
				$alt_title = 'Гранд Мол';
			}

			if ( $area == 'Техникумите' ) {
				$alt_title = 'Конфуто';
			}
		?>

			<li class="checkbox">
				<input <?php echo $active; ?> name="property-area[]" value="<?php echo $area_id; ?>" type="checkbox" id="area-<?php echo $area_id; ?>" />
				<label data-sp-case="<?php echo $alt_title; ?>" for="area-<?php echo $area_id; ?>"><?php echo $area; ?></label>
			</li><!-- /.checkbox -->

		<?php endforeach ?>

	</ul>

	<?php
}

function crb_extra_criteria() {

	$all_criteria = crb_extra_search_criteria();

	$queried_data = crb_get_query_data( 'criteria' );
?>

	<ul class="checkboxes">

		<?php foreach ($all_criteria as $criteria):
			$criteria_id = crb_array_value_index( $criteria, $all_criteria );

			$active = '';

			if ( in_array($criteria_id, $queried_data) ) {
				$active = 'checked';
			}
		?>

			<li class="checkbox">
				<input <?php echo $active; ?> name="criteria[]" value="<?php echo $criteria_id; ?>" type="checkbox" id="criteria-<?php echo $criteria_id; ?>" />
				<label for="criteria-<?php echo $criteria_id; ?>"><?php echo $criteria; ?></label>
			</li><!-- /.checkbox -->

		<?php endforeach ?>

	</ul><!-- /.checkboxes -->

	<?php
}

function crb_slider_sqf() {

	$values = crb_slider_values( '0', '500', 'sqf-min', 'sqf-max' );

?>

	<div id="slider-sqf" class="range-slider">
		<span class="range-from">
			от <span><?php echo $values['min']; ?></span> кв.м.
		</span><!-- /.range-from -->

		<span class="range-to">
			до <span><?php echo $values['max']; ?></span> кв.м.
		</span><!-- /.range-to -->

		<div class="slider-range"></div><!-- /.slider-range -->

		<input type="hidden" name="sqf-min" value="<?php echo $values['min']; ?>" class="sqf-min" />
		<input type="hidden" name="sqf-max" value="<?php echo $values['max']; ?>" class="sqf-max" />

	</div><!-- /.range-slider -->

	<div class="mobile-range-values">
		<p class="range-from">
			кв.м. от
			<input type="text" name="sqf-min" value="<?php echo $values['min']; ?>" class="sqf-min" />
		</p><!-- /.range-from -->

		<p class="range-to">
			кв.м. до
			<input type="text" name="sqf-max" value="<?php echo $values['max']; ?>" class="sqf-max" />
		</p><!-- /.range-to -->
	</div>

	<?php
}

function crb_slider_price() {

	$values = crb_slider_values( '0', '300000', 'price-min', 'price-max' );

?>

	<div id="slider-price" class="range-slider">
		<span class="range-from">
			от <span><?php echo $values['min']; ?></span> euro
		</span><!-- /.range-from -->

		<span class="range-to">
			до <span><?php echo $values['max']; ?></span> euro
		</span><!-- /.range-to -->

		<div class="slider-range"></div><!-- /.slider-range -->

		<input type="hidden" name="price-min" value="<?php echo $values['min']; ?>" class="price-min" />
		<input type="hidden" name="price-max" value="<?php echo $values['max']; ?>" class="price-max" />

	</div><!-- /.range-slider -->

	<div class="mobile-range-values">
		<p class="range-from">
			цена ( euro ) от
			<input type="text" name="price-min" value="<?php echo $values['min']; ?>" class="price-min" />
		</p><!-- /.range-from -->

		<p class="range-to">
			цена ( euro ) до
			<input type="text" name="price-max" value="<?php echo $values['max']; ?>" class="price-max" />
		</p><!-- /.range-to -->
	</div>

	<?php
}

function crb_slider_sqf_price() {

	$values = crb_slider_values( '0', '2000', 'sqfp-min', 'sqfp-max' );

?>

	<div id="slider-price-sqf" class="range-slider">
		<span class="range-from">
			от <span><?php echo $values['min']; ?></span> euro
		</span><!-- /.range-from -->

		<span class="range-to">
			до <span><?php echo $values['max']; ?></span> euro
		</span><!-- /.range-to -->

		<div class="slider-range"></div><!-- /.slider-range -->

		<input type="hidden" name="sqfp-min" value="<?php echo $values['min']; ?>" class="sqfp-min" />
		<input type="hidden" name="sqfp-max" value="<?php echo $values['max']; ?>" class="sqfp-max" />

	</div><!-- /.range-slider -->

	<div class="mobile-range-values">
		<p class="range-from">
			цена ( euro ) от
			<input type="text" name="sqfp-min" value="<?php echo $values['min']; ?>" class="sqfp-min" />
		</p><!-- /.range-from -->

		<p class="range-to">
			цена ( euro ) до
			<input type="text" name="sqfp-max" value="<?php echo $values['max']; ?>" class="sqfp-max" />
		</p><!-- /.range-to -->
	</div>

	<?php
}

function crb_sorting_options() {

	$types = crb_sorting_data();

	$queried_data = crb_get_query_data( 'sort' );
?>

	<label class="select">

		<select name="sort" id="">

			<?php foreach ($types as $type):
				$option_id = crb_array_value_index( $type, $types );

				$active = '';

				if ( in_array($option_id, $queried_data) ) {
					$active = 'selected';
				}
			?>

				<option <?php echo $active; ?> value="<?php echo $option_id; ?>"><?php echo $type; ?></option>

			<?php endforeach ?>

		</select>
	</label><!-- /.select -->

	<?php
}

function crb_property_years() {

	$years = crb_year_options();

	$queried_data = crb_get_query_data( 'build-year' );
?>

	<label class="select">
		<select name="build-year" id="build-year">

			<option value="">Всички</option>

			<?php foreach ($years as $year):
				$option_id = crb_array_value_index( $year, $years );

				$active = '';

				if ( in_array($option_id, $queried_data) ) {
					$active = 'selected';
				}
			?>

				<option <?php echo $active; ?> value="<?php echo $option_id; ?>"><?php echo $year; ?></option>

			<?php endforeach ?>

		</select>
	</label><!-- /.select -->

	<?php
}

function crb_dd_filter( $label, $function_name, $arg ) {

	$status = '';

	if ( isset($_GET[$arg]) ) {
		$status = 'opened';
	}

?>

	<div class="form-controls">
		<div class="dd-filter <?php echo $status; ?>">
			<div class="dd-filter-head">
				<?php echo $label; ?>
				<span></span>
			</div>
			<div class="dd-filter-inner">
				<?php call_user_func( $function_name ); ?>
			</div>
		</div>
	</div><!-- /.form-controls -->

	<?php
}


function crb_statuses_filter() {
	$statuses = crb_statuses();
?>

	<label class="select">
		<select name="property-status" id="">

			<option value="">Всички</option>

			<?php foreach ($statuses as $status):
				$status_id = crb_array_value_index( $status, $statuses );
			?>

				<option value="<?php echo $status_id; ?>"><?php echo $status; ?></option>

			<?php endforeach ?>

		</select>
	</label><!-- /.select -->

	<?php
}

function crb_brokers_filter() {
	$brokers = crb_get_editors();
?>

	<label class="select">
		<select name="property-broker" id="">

			<option value="all">Всички</option>

			<?php foreach ($brokers as $broker_id => $broker_name): ?>

				<option value="<?php echo $broker_id; ?>"><?php echo $broker_name; ?></option>

			<?php endforeach ?>

		</select>
	</label><!-- /.select -->

	<?php
}

function crb_priorities_filter() {
	$options = crb_priorities();

	$queried_data = crb_get_query_data( 'priority' );
?>

	<label class="select">
		<select name="priority" id="">

			<option value="">Всички</option>

			<?php foreach ($options as $value => $label):
				$active = '';

				if ( in_array($value, $queried_data) ) {
					$active = 'selected="selected"';
				}
			?>

				<option <?php echo $active; ?> value="<?php echo $value; ?>"><?php echo $label; ?></option>

			<?php endforeach ?>

		</select>
	</label><!-- /.select -->

	<?php
}
