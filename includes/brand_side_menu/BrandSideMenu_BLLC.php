<?php

class BrandSideMenu_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/brand_side_menu/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetData() {

		// Запрос на получение данных

		$brand_side_menu_dalc = new BrandSideMenu_DALC();

		$items = $brand_side_menu_dalc->GetItems();

		return $items;

	}

};

?>