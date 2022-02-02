<?php

function crb_sources() {
	return array(
		'от обява' 	=> 'От обява',
		'от фирма' 	=> 'От фирма',
		'препоръка' => 'Препоръка',
	);
}

function crb_statuses() {
	return array(
		'Обява' 			=> 'Обява',
		'Обаждане' 			=> 'Обаждане',
		'Правен е оглед' 	=> 'Правен е оглед',
		'Качена в базата' 	=> 'Качена в базата',
		'Публикувана' 		=> 'Публикувана',
		'Ексклузив' 		=> 'Ексклузив',
		'Продаден' 			=> 'Продаден',
		'Отдаден' 			=> 'Отдаден',
	);
}

function crb_stages( $show_empty = false ) {
	return array_merge( crb_empty_array_value( $show_empty ), array(
		'in-progress' 	=> 'В процес на изграждане',
		'ready' 		=> 'Завършен',
	) );
}

function crb_build_types( $show_empty = false ) {
	return array_merge( crb_empty_array_value( $show_empty ), array(
		'Панел' 	=> 'Панел',
		'Тухла' 	=> 'Тухла',
		'ЕПК' 		=> 'ЕПК',
		'ПК' 		=> 'ПК',
		'Гредоред' 	=> 'Гредоред',
	) );
}

function crb_position_types( $show_empty = false ) {
	return array_merge( crb_empty_array_value( $show_empty ), array(
		'Юг' 			=> 'Юг',
		'Югоизток' 		=> 'Югоизток',
		'Югозапад' 		=> 'Югозапад',
		'Изток' 		=> 'Изток',
		'Запад' 		=> 'Запад',
		'Североизток' 	=> 'Североизток',
		'Северозапад' 	=> 'Северозапад',
		'Север' 		=> 'Север',
	) );
}

function crb_property_types() {
	return array(
		'апартамент' 	=> 'Апартамент',
		'къща' 			=> 'Къща',
		'парцел' 		=> 'Парцел',
	);
}

function crb_common_data() {
	return array(
		'гараж' 			=>'гараж',
		'паркинг' 			=>'паркинг',
		'лизинг' 			=>'лизинг',
		'ипотека' 			=>'ипотека',
		'саниран' 			=>'саниран',
		'бартер' 			=>'бартер',
		'портиер, охрана' 	=>'портиер, охрана',
		'затворен комплекс' =>'затворен комплекс',
		'с преход' 			=>'с преход',
		'без преход' 		=>'без преход',
		'обзаведен' 		=>'обзаведен',
	);
}

function crb_property_types_data( $show_empty = false ) {
	return array_merge( crb_empty_array_value( $show_empty ), array(
		'1-Стаен' 			=> '1-Стаен',
		'2-Стаен' 			=> '2-Стаен',
		'3-Стаен' 			=> '3-Стаен',
		'4-Стаен' 			=> '4-Стаен',
		'Многостаен' 		=> 'Многостаен',
		'Мезонет' 			=> 'Мезонет',
		'Ателие, таван' 	=> 'Ателие, таван',
		'Офис' 				=> 'Офис',
		'Магазин' 			=> 'Магазин',
		'Заведение' 		=> 'Заведение',
		'Склад' 			=> 'Склад',
		'Хотел' 			=> 'Хотел',
		'Пром. помещение' 	=> 'Пром. помещение',
		'Етаж от къща' 		=> 'Етаж от къща',
		'Къща' 				=> 'Къща',
		'Вила' 				=> 'Вила',
		'Парцел' 			=> 'Парцел',
		'Гараж' 			=> 'Гараж',
		'Земеделска земя' 	=> 'Земеделска земя',
	) );
}

function crb_property_area() {
	return array(
		'град Варна' 	=> 'град Варна',
		'област Варна' 	=> 'област Варна'
	);
}

function crb_property_area_inner( $show_empty = false ) {
	return array_merge( crb_empty_array_value( $show_empty ), array(
		'Автогарата' 				=> 'Автогарата',
		'Аспарухово' 				=> 'Аспарухово',
		'Бриз' 						=> 'Бриз',
		'Виница' 					=> 'Виница',
		'ВИНС' 						=> 'ВИНС',
		'Владиславово' 				=> 'Владиславово',
		'Военна Болница' 			=> 'Военна Болница',
		'Възраждане' 				=> 'Възраждане',
		'Галата' 					=> 'Галата',
		'Генералите' 				=> 'Генералите',
		'Гранд Мол' 				=> 'Гранд Мол',
		'Гръцки квартал' 			=> 'Гръцки квартал',
		'Електрон' 					=> 'Електрон',
		'ЖП Гара' 					=> 'ЖП Гара',
        'Дружба' 					=> 'Завод Дружба',
		'Западна Промишлена Зона' 	=> 'Западна Промишлена Зона',
		'ЗК Тракия' 				=> 'ЗК Тракия',
		'Идеален Център' 			=> 'Идеален Център',
		'Изгрев' 					=> 'Изгрев',
		'Кайсиева Градина' 			=> 'Кайсиева Градина',
		'Колхозен Пазар' 			=> 'Колхозен Пазар',
        'Техникумите' 				=> 'Конфуто',
		'Левски' 					=> 'Левски',
		'Летище' 					=> 'Летище',
		'ЛК Тракия' 				=> 'ЛК Тракия',
		'Младост' 					=> 'Младост',
		'Морска Градина' 			=> 'Морска Градина',
		'Нептун' 					=> 'Нептун',
		'Нов Хлебозавод' 			=> 'Нов Хлебозавод',
		'Общината' 					=> 'Общината',
		'Окръжна Болница' 			=> 'Окръжна Болница',
		'Пикадили' 					=> 'Пикадили',
		'Победа' 					=> 'Победа',
		'Погребите' 				=> 'Погребите',
		'Промишлена Зона Метро' 	=> 'Промишлена Зона Метро',
		'Промишлена Зона Планова' 	=> 'Промишлена Зона Планова',
		'Северна Промишлена Зона' 	=> 'Северна Промишлена Зона',
		'Спортна Зала' 				=> 'Спортна Зала',
		'Трошево' 					=> 'Трошево',
		'ХЕИ' 						=> 'ХЕИ',
		'Христо Ботев' 				=> 'Христо Ботев',
		'Цветен' 					=> 'Цветен',
		'Център' 					=> 'Център',
		'Чайка' 					=> 'Чайка',
		'Чаталджа' 					=> 'Чаталджа',
		'Червен Площад' 			=> 'Червен Площад',
		'Южна Промишлена Зона' 		=> 'Южна Промишлена Зона',
        'к.к. Златни пясъци'        => 'к.к. Златни пясъци',
        'к.к. Св. Св. Константин и Елена' => 'к.к. Св. Св. Константин и Елена',
		'м-т Ален мак' 				=> 'м-т Ален мак',
        'м-т Акчелар'               => 'м-т Акчелар',
        'м-т Боровец-север'         => 'м-т Боровец-север',
        'м-т Боровец-юг'            => 'м-т Боровец-юг',
        'м-т Добрева чешма'         => 'м-т Добрева чешма',
        'м-т  Евксиноград'          => 'м-т Евксиноград',
        'м-т Зеленика'              => 'м-т Зеленика',
        'м-т Кабакум' 				=> 'м-т Кабакум',
        'м-т Ракитника'             => 'м-т Ракитника',
        'м-т Св. Никола'            => 'м-т Св. Никола',
        'м-т Сотира'                => 'м-т Сотира',
        'м-т Пчелина'               => 'м-т Пчелина',
        'м-т Манастирски рид'       => 'м-т Манастирски рид',
        'м-т Фичоза'                => 'м-т Фичоза',
        'м-т Прибой'                => 'м-т Прибой',
        'Траката' 				    => 'м-т Траката',
	) );
}

function crb_extra_search_criteria() {
	return array(
		'Гараж' 		=> 'Гараж',
		'Парко място' 	=> 'Парко място',
		'Паркинг' 		=> 'Паркинг',
		'Aсансьор' 		=> 'Aсансьор',
		'Саниран' 		=> 'Саниран',
		'Затворен комплекс' => 'Затворен комплекс',
		'С преход' 			=> 'С преход',
		'Без преход' 		=> 'Без преход',
		'Обзаведен' 		=> 'Обзаведен',
	);
}

function crb_sorting_data() {
	return array(
		'Име / Район / Цена' 	=> 'Име / Район / Цена',
		'Най-нови' 				=> 'Най-нови',
		'Най-стари' 			=> 'Най-стари',
	);
}

function crb_year_options() {
	return array(
		'след 2006' 	=> 'след 2006',
		'след 2000' 	=> 'след 2000',
		'преди 2000' 	=> 'преди 2000',
	);
}

function crb_priorities() {
	return array(
		'1' => 'Нисък',
		'2' => 'Среден',
		'3' => 'Висок',
	);
}

function crb_empty_array_value( $show_empty ) {
	$tmp_array = array();
	if ( $show_empty ) {
		$tmp_array = array(
			'' => 'N/A',
		);
	}
	return $tmp_array;
}