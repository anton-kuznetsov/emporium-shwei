<?php

class DALC {

	// логин
	var $login = 'ds4497_shwei';
	// пароль
	var $pass = 'ztnNqdEA';
	// имя хоста
	var $host = 'localhost';
	// имя базы данных
	var $name = 'ds4497_shwei';

	//
	function DALC() { }

	//
	function init() {

		$db = mysql_connect($this->host, $this->login, $this->pass);
		mysql_select_db($this->name, $db);

	}

};

?>