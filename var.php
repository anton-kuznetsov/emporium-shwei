<?php

	error_reporting (E_ERROR);
	$n = getenv('REQUEST_URI');

	//

	if (!eregi('(',$n) and !eregi('(',$n) and !eregi(',',$n) and !eregi('+',$n) and !eregi(':',$n) and !eregi('http',$n) and !eregi('ftp',$n) and !eregi('"',$n) and !eregi("'",$n) and !eregi('<',$n) and !eregi('>',$n) and !eregi('[',$n) and !eregi(']',$n) and !eregi('{',$n) and !eregi('}',$n)) {

		// MySQL
		$bdlogin = 'root';
		$bdpass  = '';
		$bdhost  = 'localhost';
		$bdname  = 'shwei';

		// Robocassa
		$robocassa_login = 'anton_kuznetsov';
		$robocassa_pass1 = 'FMwn81TmTy';
		$robocassa_pass2 = '411EiH5j9S';

		// название сайта
		$sitename = 'Shwei.Ru - Интернет-магазин швейных, вышивальных и вязальных машин в Чебоксарах';
	
		$folder_root = $_SERVER['DOCUMENT_ROOT'] . '/shwei/';
		$site_root = 'http://localhost/shwei/';
	
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

	}

?>