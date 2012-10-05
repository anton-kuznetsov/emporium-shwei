<?php

class Breadcrumbs_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/breadcrumbs/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetDataByCategory( $id_category ) {

		// Запрос на получение данных

		$breadcrumbs_dalc = new Breadcrumbs_DALC();

		$items = $breadcrumbs_dalc->GetItemsByCategory($id_category);

		return $items;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetDataByProduct( $id_product ) {

		// Запрос на получение данных

		$breadcrumbs_dalc = new Breadcrumbs_DALC();

		$items = $breadcrumbs_dalc->GetItemsByProduct($id_product);

		return $items;

	}

};

?>