<?php

	// Подключение к базе MySQL
	$db_login = 'root';
	$db_pass  = '';
	$db_host  = 'localhost';
	$db_name  = 'shwei';

	// URL админки
	$site_url = 'http://localhost/shwei/adminka/';
	// URL сайта
	$public_site_url = 'http://localhost/shwei/';

	// Каталог админки
	$site_folder = $_SERVER['DOCUMENT_ROOT'] . '/shwei/adminka/';
	// Каталог сайта
	$public_site_folder = $_SERVER['DOCUMENT_ROOT'] . '/shwei/';

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