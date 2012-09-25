<?php

class AccessoriesSideMenu_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/accessories_side_menu/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetData() {

		// Запрос на получение данных

		$accessories_side_menu_dalc = new AccessoriesSideMenu_DALC();

		$items = $accessories_side_menu_dalc->GetItems();

		return $items;

	}

};

?>