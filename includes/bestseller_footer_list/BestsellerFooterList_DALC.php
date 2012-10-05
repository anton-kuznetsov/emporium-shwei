<?php

class BestsellerFooterList_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/bestseller_footer_list/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// Запрос на получение данных

		$produst_dalc = new Product_DALC();

		$product_items = $produst_dalc->SQL_SelectList('products', NULL, '', 'count_buy DESC', '6');

		return $product_items;

	}

};

?>