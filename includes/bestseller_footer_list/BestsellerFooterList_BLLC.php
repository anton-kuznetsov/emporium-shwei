<?php

class BestsellerFooterList_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/bestseller_footer_list/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// Запрос на получение данных

		$bs_footer_list_dalc = new BestsellerFooterList_DALC();

		$items = $bs_footer_list_dalc->GetItems();

		return $items;

	}

};

?>