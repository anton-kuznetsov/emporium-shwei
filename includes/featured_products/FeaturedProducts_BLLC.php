<?php

class FeaturedProducts_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/featured_products/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// Запрос на получение данных

		$featured_products_dalc = new FeaturedProducts_DALC();

		$items = $featured_products_dalc->GetItems();

		return $items;

	}

};

?>