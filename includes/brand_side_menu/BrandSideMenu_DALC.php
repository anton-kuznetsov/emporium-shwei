<?php

class BrandSideMenu_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/brand_side_menu/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// Запрос на получение данных
		// структура :
		// массив элементов $items
		//   id_category
		//   label_category
		//   brands []
		//     id
		//     label
		//     product_qty

		$items = array ();
		$categories = array ();

		$categories = $this -> SQL_SelectList('categories', NULL, ' parent = 100 AND level = 2 ');

		foreach ($categories as $category) {

			$items[$category['id']]['id_category'] = $category['id'];
			$items[$category['id']]['label_category'] = $category['label'];
			$items[$category['id']]['brands'] = array();

			$ids_child = $this -> SQL_SelectIdsTree('categories', 'parent', $category['id']);			
			$ids = $category['id'] . ($ids_child != '' ? ',' : '') . $ids_child;

			$result = mysql_query( 
				" SELECT " .
				"    brands.id AS id_brand " .
				"    , brands.label AS label_brand " .
				"    , COUNT(*) AS product_qty " .
				" FROM " .
				"    products_and_categories " .
				"    INNER JOIN products ON products.id = products_and_categories.id_product " .
				"    INNER JOIN brands ON brands.id = products.id_brand " .
				" WHERE " .
				"    products_and_categories.id_category IN (" . $ids . ") " .
				" GROUP BY " .
				"    brands.id ",
				$this->db
			);
	
			if (!$result) {
				die('Неверный запрос: ' . mysql_error());
			}
	
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	
				$items[$category['id']]['brands'][$row['id_brand']]['id'] = $row['id_brand'];
				$items[$category['id']]['brands'][$row['id_brand']]['label'] = $row['label_brand'];
				$items[$category['id']]['brands'][$row['id_brand']]['product_qty'] = $row['product_qty'];
	
			}
	
			mysql_free_result($result);

		}

		//

		return $items;

	}

};

?>