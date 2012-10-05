<?php

class PopularFooterList_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/popular_footer_list/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// Запрос на получение данных

		$popular_footer_list_dalc = new PopularFooterList_DALC();

		$items = $popular_footer_list_dalc->GetItems();

		return $items;

	}

};

?>