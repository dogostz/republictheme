<?php

/*
	Data Entry Custom Data
*/
if ( crb_user_can_view_details() ) {
	Carbon_Container::factory('custom_fields', __('Вътрешни данни на обява', 'domain'))
		->show_on_post_type( crb_properties_cpts() )
		->add_fields([
			// Carbon_Field::factory('text', 'property_parent_id'),
			// Carbon_Field::factory('text', 'property_child_id'),
			// Carbon_Field::factory('text', 'property_child_rental_id'),
			// Carbon_Field::factory('checkbox', 'property_is_rental'),

			Carbon_Field::factory('select', 'property_source', 'Източник')
				->set_required( true )
				->add_options( crb_sources() ),
			// Carbon_Field::factory('text', 'property_ref_number', 'Референтен номер'),
			Carbon_Field::factory('select', 'property_status', 'Статус на имота')
				->add_options( crb_statuses() ),
			Carbon_Field::factory('select', 'property_priority', 'Приоритет')
				->set_default_value( 1 )
				->add_options( crb_priorities() ),
			Carbon_Field::factory('date', 'property_view_data', 'Дата на оглед')
				->help_text( 'Отбележете кога е правен оглед.' ),

			// Property Data
			Carbon_Field::factory('select', 'property_stage', 'Етап на стройтелство')
				->add_options( crb_stages( true ) ),
			Carbon_Field::factory('text', 'property_address', 'Адрес на имота')
				->help_text( 'Използва се за търсене.' )
				->set_required( true ),
			Carbon_Field::factory('text', 'property_phone', 'Телефонен номер')
				->help_text( 'Въвеждайте телефона без разстояния между цифрите.' )
				->set_required( true ),
			Carbon_Field::factory('text', 'property_owner', 'Име на собственик'),
			Carbon_Field::factory('textarea', 'property_notes', 'Бележки'),
        ]);
}

// Display controls based on the current user settings
crb_render_property_controls();

/*
	Common Property Data
*/
if ( crb_user_can_view_details() ) {
	Carbon_Container::factory('custom_fields', __('Публични данни за сайта', 'domain'))
		->show_on_post_type( crb_properties_cpts() )
		->add_fields([
			Carbon_Field::factory('select', 'property_area', 'Местоположение на имота')
				->add_options( crb_property_area() ),
			Carbon_Field::factory('select', 'property_area_inner', 'Квартал на имота')
				->add_options( crb_property_area_inner( true ) ),
			Carbon_Field::factory('select', 'property_type_size', 'Брой стай')
				->add_options( crb_property_types_data( true ) ),
			Carbon_Field::factory('text', 'property_real_price', 'Цена')
				->help_text( 'Показва се в сайта' ),
			Carbon_Field::factory('text', 'property_year', 'Година на построяване'),
			Carbon_Field::factory('text', 'property_size', 'Квадратура'),
			Carbon_Field::factory('text', 'property_floor', 'Етаж'),
			Carbon_Field::factory('text', 'property_floors_total', 'Общ брой етажи'),
			// Carbon_Field::factory('text', 'property_baths', 'Брой бани'),
			Carbon_Field::factory('select', 'property_type', 'Вид на имота')
				->add_options( crb_property_types() ),
			Carbon_Field::factory('select', 'property_build', 'Тип на строителство')
				->add_options( crb_build_types( true ) ),
			Carbon_Field::factory('select', 'property_position', 'Изложение')
				->add_options( crb_position_types( true ) ),

			Carbon_Field::factory('checkbox', 'property_parking', 'Парко място?'),
			Carbon_Field::factory('checkbox', 'property_elevator', 'Асансьор?'),
			Carbon_Field::factory('checkbox', 'property_is_featured', 'Показвай имота в секция "Най-търсени"?'),
			Carbon_Field::factory('set', 'property_relative_data', 'Особености')
				->add_options( crb_common_data() ),

			Carbon_Field::factory('complex', 'property_main_chars', 'Основни характеристики за имот')
				->add_fields([
					Carbon_Field::factory('text', 'text', 'Текст')
						->set_required( true ),
                ]),
        ]);
}

/*
	Images
*/
if ( crb_user_can_view_details() ) {
	Carbon_Container::factory('custom_fields', __('Снимки на имота', 'domain'))
		->show_on_post_type( crb_properties_cpts() )
		->add_fields([
			Carbon_Field::factory('complex', 'property_images', 'Снимки')
				->set_layout( 'list' )
				->add_fields([
					Carbon_Field::factory('image', 'image', 'Снимка')
						->set_required( true ),
					Carbon_Field::factory('text', 'description', 'Описание на снимка')
						->help_text( 'Опционално.' ),
					Carbon_Field::factory('checkbox', 'use', 'Използвай снимката в обявата')
						->help_text( 'Ако полето е избрано, снимката автоматично ще бъде добавена към обявата.' )
                ]),
        ]);
}


/*
    Common Property Data
*/
if ( isset($_GET['post']) && isset($_GET['action']) && $_GET['action'] === 'edit' ) {
    $live_property_field = Carbon_Field::factory('button', 'property_make_live', 'Добави имота в продажби')
        ->set_cpt( 'property' )
        ->set_button_class( 'button-secondary button-red' );
    $rental_property_field = Carbon_Field::factory('button', 'property_make_rental', 'Добави имота в наеми')
        ->set_cpt( 'property-rental' )
        ->set_button_class( 'button-secondary button-green' );

	if ( get_property_children_data( '_property_child_id', 'Имотът е добавен в сайта' ) ) {
		$live_property_field = get_property_children_data( '_property_child_id', 'Имотът е добавен в сайта' );
	}

	if ( get_property_children_data( '_property_child_rental_id', 'Имотът е добавен в Наеми' ) ) {
		$rental_property_field = get_property_children_data( '_property_child_rental_id', 'Имотът е добавен в Наеми' );
	}

    if ( crb_user_can_view_details() ) {
        Carbon_Container::factory('custom_fields', __('Добавяне на имота в Продажби', 'domain'))
            ->show_on_post_type( 'property-base' )
            ->add_fields([
                $live_property_field
            ]);

        Carbon_Container::factory('custom_fields', __('Добавяне на имота в Наеми', 'domain'))
            ->show_on_post_type( 'property-rental-base' )
            ->add_fields([
                $rental_property_field
            ]);
    }
}

function get_property_children_data( $key, $label ) {
	$post_id = $_GET['post'];
	$child_id = crb_get_meta( $key, $post_id );

	if ( !$child_id ) {
		return false;
	}

	$link = get_edit_post_link( $child_id );
	if ( preg_match('~наеми~', mb_strtolower($label)) ) {
		$cpt = 'property-rental';
	} else {
		$cpt = 'property';
	}

	if ( empty($link) ) {
		$child_text = '<p class="broker-admin-info with-error">Имот с ID ' . $child_id . ' е изтрит <br ><a href="'. add_query_arg( 'publish-property', $cpt ) .'">Добави отново</a></p>';
	} else if ( get_post_status($child_id) == 'trash' ) {
		$child_text = '<p class="broker-admin-info with-error">Имот с ID ' . $child_id . ' е преместен в кошчето</p>';
	} else {
		$child_text = '<p class="broker-admin-info">' . $label . '<br /> <a title="Имот '. $child_id .'" href="'. get_edit_post_link( $child_id ) .'">Редактиране на имот</a></p>';
	}

	return Carbon_Field::factory('separator', 'property_is_added_' . $key, $child_text);
}

if ( isset($_GET['post']) AND crb_get_meta('_property_parent_id', $_GET['post']) ) {
    get_property_db_info();
}


/*
	Slide Data
*/
Carbon_Container::factory('custom_fields', __('Свойства на слайда', 'domain'))
	->show_on_post_type( 'slide' )
	->add_fields([
		Carbon_Field::factory('image', 'slide_image', 'Картинка на слайда')
			->set_required( true )
			->help_text( 'Максимална височина - 400px' ),
		Carbon_Field::factory('text', 'slide_size', 'Квадратура'),
		Carbon_Field::factory('text', 'slide_price', 'Цена'),
    ]);


/*
	Broker Data
*/
Carbon_Container::factory('custom_fields', __('Данни на брокера', 'domain'))
	->show_on_post_type( 'broker' )
	->add_fields([
		Carbon_Field::factory('image', 'broker_image', 'Снимка на брокера')
			->set_required( true )
			->help_text( 'Максимална дължина - 253px' ),
		Carbon_Field::factory('text', 'broker_position', 'Позиция'),
		Carbon_Field::factory('text', 'broker_phone', 'Стационарен телефон'),
		Carbon_Field::factory('text', 'broker_mobile', 'Мобилен телефон'),
		Carbon_Field::factory('text', 'broker_address', 'Адрес'),
		Carbon_Field::factory('text', 'broker_mail', 'Email'),
    ]);


/*
	Page Data
*/
Carbon_Container::factory('custom_fields', __('Свойства на страница', 'domain'))
	->show_on_post_type( 'page' )
	->add_fields([
		Carbon_Field::factory('image', 'page_image', 'Картинка на страница')
			->help_text( 'Максимална дължина - 229px' ),
		Carbon_Field::factory('select', 'page_search_type', 'Търсене в:')
			->add_options([
					'sell' => 'Обяви за продан',
					'rent' => 'Наеми',
            ])
    ]);


/*
	Contact Page Data
*/
Carbon_Container::factory('custom_fields', __('Настройки на формата', 'domain'))
	->show_on_post_type( 'page' )
	->show_on_template( 'templates/forms.php' )
	->add_fields([
		Carbon_Field::factory('gravity_form', 'page_form_id', 'Изберете форма')
    ]);

Carbon_Container::factory('custom_fields', __('Настройки на страницата', 'domain'))
	->show_on_post_type( 'page' )
	->show_on_template( 'templates/career.php' )
	->add_fields([
		Carbon_Field::factory('rich_text', 'career_page_description', 'Описание')
    ]);


/*
	Custom User Fields
*/
Carbon_Container::factory('user_meta', 'General User Data')
	->add_fields([
		Carbon_Field::factory('select', 'assoc_user', 'Асоцииран профил')
			->add_options( crb_get_cpt_ids( 'broker' ) )
	]);


/*
	Admin columns
*/
Carbon_Admin_Columns_Manager::modify_columns('post', crb_properties_cpts() )
	->add( [
		Carbon_Admin_Column::create('Референтен номер')
			->set_field('_property_ref_number')
			->set_name('Референтен номер')
			// ->set_sort_field('orderby_status_checked'),
	] );


Carbon_Admin_Columns_Manager::modify_columns('post', crb_properties_cpts() )
	->add( [
		Carbon_Admin_Column::create('Статус')
			->set_field('_property_status')
			->set_name('Статус'),
    ]);

Carbon_Admin_Columns_Manager::modify_columns('post', crb_properties_cpts() )
		// ->sort( 'Снимка на имота' )
		->add( [
			Carbon_Admin_Column::create('Снимка на имота')
				->set_name('Снимка на имота')
				->set_callback('crb_column_render_post_thumbnail'),
		 ]);


function crb_render_property_controls() {

	$current_user_id = get_current_user_id();
	$current_post_owner = 0;

	if ( isset($_GET['post']) OR isset($_REQUEST['post_ID']) ) {
		$post_id = $_GET['post'] ? $_GET['post'] : $_REQUEST['post_ID'];
		$current_post_owner = crb_get_meta( '_property_broker', $post_id );

		$post_type = get_post_type( $post_id );
	}

	if ( isset($_GET['take-control']) ) {
		$current_post_owner = get_current_user_id();
	}

	if ( current_user_can( 'administrator' ) OR
		in_array($current_user_id, crb_get_special_owner_id()) OR
		($current_user_id == $current_post_owner)
	) {
		$field = Carbon_Field::factory('select', 'property_broker', 'Асоцииран брокер')
					// ->set_required( true )
					->add_options( crb_get_editors() );
	} else if ( $current_post_owner ) {
		$user = get_userdata( $current_post_owner );
		$text = 'Този имот се контролира от <strong>'. $user->display_name .'</strong>';
		$field = Carbon_Field::factory('separator', 'property_broker_info', '<p class="broker-admin-info">'. $text .'</p>');
	} else {
		$text = 'Свободна обява';

		if (isset($post_type) AND ($post_type == 'property-base' OR $post_type == 'property-rental-base')) {
			$text .= '<br /><br /><a href="'. add_query_arg( 'take-control', 1 ) .'" class="button button-primary button-large">Поеми контрол над обявата</a>';
		}

		$field = Carbon_Field::factory('separator', 'property_broker_info', '<p class="broker-admin-info">' . $text . '</p>');
	}

	Carbon_Container::factory('custom_fields', __('Контрол на обявата', 'domain'))
		->show_on_post_type( crb_properties_cpts() )
		->add_fields([$field]);

	return true;
}

function get_property_db_info() {
    $parent_id = crb_get_meta( '_property_parent_id', $_GET['post']);
    $parent_status = get_post_status($parent_id);

    if ( $parent_status == 'trash' OR empty($parent_status) ) {
        $pr_text = '<p>Основният имот в "База данни" е изтрит</p>';
    } else {
        $pr_text = 'Основен имот<br /> <a title="Имот '. $parent_id .'" href="'. get_edit_post_link( $parent_id ) .'">Редактиране на имот</a><br /><br />';
    }

    Carbon_Container::factory('custom_fields', __('Информация за имот от База данни', 'domain'))
        ->show_on_post_type(['property', 'property-rental'])
        ->add_fields([
            Carbon_Field::factory('separator', 'property_parent_info', $pr_text)
        ]);

    return true;
}