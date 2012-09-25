<?php

class CategoryProducts_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/category_products/';

	}

	//--------------------------------------------------------------------------
	//

	public function GetCategory ( $id = 0 ) {

		// Запрос на получение данных

		$category_products_dalc = new CategoryProducts_DALC();

		$data = $category_products_dalc->GetCategory( $id );

		return $data;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems( $config = array() ) {

		// Запрос на получение данных

		$category_products_dalc = new CategoryProducts_DALC();

		$data = $category_products_dalc->GetItems( $config['id_category'], $config['id_brand'], $config['p'], $config['limit'], $config['order'] );

		return $data;

	}

};

?>