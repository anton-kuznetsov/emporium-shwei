<?php

class DALC {

	// �����
	var $login = 'ds4497_shwei';
	// ������
	var $pass = 'ztnNqdEA';
	// ��� �����
	var $host = 'localhost';
	// ��� ���� ������
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