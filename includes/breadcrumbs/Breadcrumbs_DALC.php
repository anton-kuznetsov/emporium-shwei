<?php

class Breadcrumbs_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/breadcrumbs/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItemsByCategory( $id_category ) {

		global $site_root;

		$items = array ();

		$categories = $this->SQL_SelectList('categories', NULL, ' id = ' . $id_category );
		
		$category = $categories[$id_category];
		$level = $category['level'];

		$items[$category['level']] = array();
		$items[$category['level']]['id'] = $category['id'];
		$items[$category['level']]['href'] = $site_root . 'index.php?t=category&id_category=' . $category['id'];
		$items[$category['level']]['label'] = $category['label'];
		$items[$category['level']]['is_last'] = 1;

		while ( $category['parent'] > 0 ) {

			$categories = $this->SQL_SelectList('categories', NULL, ' id = ' . $category['parent'] );
			
			$category = $categories[$category['parent']];

			$items[$category['level']] = array();
			$items[$category['level']]['id'] = $category['id'];
			$items[$category['level']]['href'] = $site_root . 'index.php?t=category&id_category=' . $category['id'];
			$items[$category['level']]['label'] = $category['label'];
			$items[$category['level']]['is_last'] = 0;

		}

		//
		
		$r_items = array_reverse($items, true);
		
		//

		return $r_items;

	}

	//--------------------------------------------------------------------------
	//

	public function GetItemsByProduct( $id_product ) {

		global $site_root;

		$pc = $this->SQL_SelectList('products_and_categories', NULL, ' id_product = '.$id_product , 1 );

		$id_category = 0; 
		foreach ( $pc as $pci ) {
			$id_category = $pci['id_category'];
			break;
		}

		$items = array ();

		$categories = $this->SQL_SelectList('categories', NULL, ' id = ' . $id_category );
		
		$category = $categories[$id_category];
		$level = $category['level'];

		$items[$category['level']] = array();
		$items[$category['level']]['id'] = $category['id'];
		$items[$category['level']]['href'] = $site_root . 'index.php?t=category&id_category=' . $category['id'];
		$items[$category['level']]['label'] = $category['label'];
		$items[$category['level']]['is_last'] = 1;

		while ( $category['parent'] > 0 ) {

			$categories = $this->SQL_SelectList('categories', NULL, ' id = ' . $category['parent'] );
			
			$category = $categories[$category['parent']];

			$items[$category['level']] = array();
			$items[$category['level']]['id'] = $category['id'];
			$items[$category['level']]['href'] = $site_root . 'index.php?t=category&id_category=' . $category['id'];
			$items[$category['level']]['label'] = $category['label'];
			$items[$category['level']]['is_last'] = 0;

		}

		//
		
		$r_items = array_reverse($items, true);
		
		//

		return $r_items;

	}

};

?>