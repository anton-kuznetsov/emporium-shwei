<?php

class CategoryInfo_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/category_info/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetData( $id_category ) {

		// Запрос на получение данных

		$category_info_dalc = new CategoryInfo_DALC();

		$items = $category_info_dalc->GetItems($id_category);

		return $items;

	}

};

?>