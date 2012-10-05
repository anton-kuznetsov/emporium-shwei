<?php

class NewFooterList_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/new_footer_list/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// Запрос на получение данных

		$produst_dalc = new Product_DALC();

		$product_items = $produst_dalc->SQL_SelectList('products', NULL, '', 'dt DESC', '6');

		return $product_items;

	}

};

?>