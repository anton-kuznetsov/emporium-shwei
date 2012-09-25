<?php

class GlobalDALC {

	// имя таблицы для установок магазина
	var $tAdmin = 'adminip';

	var $params;

	function GlobalDALC () {

		/*
			del period
			not pay del period
			pay del period
			news on main
			news number
			liders on main
			liders number
			goods on main
			goods number
			convert valute
			show price
			show valute
			show alt price
		*/		
		
	}

	//
	function getGlobalParams () {

		$arr = null;
		$data = @mysql_query("SELECT * FROM $this->tAdmin");

		while ($row = mysql_fetch_array($result)) {
			$arr->params[$row["label"]] = $row["value"];
		}

		return $arr;

	}

};

?>