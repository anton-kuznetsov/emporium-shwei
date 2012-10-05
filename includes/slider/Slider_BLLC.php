<?php

class Slider_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/slider/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// Запрос на получение данных

		$slider_dalc = new Slider_DALC();

		$items = $slider_dalc->GetItems();

		return $items;

	}

};

?>