<?php

class NewFooterList_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/new_footer_list/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// Запрос на получение данных

		$new_footer_list_dalc = new NewFooterList_DALC();

		$items = $new_footer_list_dalc->GetItems();

		return $items;

	}

};

?>