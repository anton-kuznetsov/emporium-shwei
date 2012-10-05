<?php

class CategoryInfo_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/category_info/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems( $id_category ) {

		$items = array ();

		$categories = $this->SQL_SelectList('categories', NULL, ' id = ' . $id_category );
		
		$category = $categories[$id_category];

		return $category;

	}

};

?>