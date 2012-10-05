<?php

	// Подключение к базе MySQL
	$db_login = 'ds4497_shwei';
	$db_pass  = 'ztnNqdEA';
	$db_host  = 'localhost';
	$db_name  = 'ds4497_shwei';

	// URL админки
	$site_url = 'http://shwei.ru/adminka/';
	// URL сайта
	$public_site_url = 'http://shwei.ru/';

	// Каталог админки
	$site_folder = $_SERVER['DOCUMENT_ROOT'] . '/adminka/';
	// Каталог сайта
	$public_site_folder = $_SERVER['DOCUMENT_ROOT'] . '';

	// Заголовок
	$site_title = 'Система управления интернет-магазином Shwei.Ru';

	//------------------------------------------------------------------------------------------

	$week_days_rus = array (
		'Понедельник',
		'Вторник',
		'Среда',
		'Четверг',
		'Пятница',
		'Суббота',
		'Воскресенье'
	);

	$month_rus = array (
		'января',
		'февраля',
		'марта',
		'апреля',
		'мая',
		'июня',
		'июля',
		'августа',
		'сентября',
		'октября',
		'ноября',
		'декабря'
	);

	$site_counters = '';

?>