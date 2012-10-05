<?php

class Category_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/_base/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetCategory( $id_category ) {

		global $site_root;

		$data = $this->SQL_SelectItem('categories', NULL, $id_category );

		return $data;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetRootCategory( $id_category ) {

		$category = $this->SQL_SelectItem('categories', NULL, $id_category );

		$i = 100;

		while ( $category['parent'] > 0 && $i > 0 ) {

			$i++;
			$category = $this->SQL_SelectItem('categories', NULL, $category['parent'] );

		}

		return $category;

	}
};

?>