<?php

class AccessoriesSideMenu_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/accessories_side_menu/';

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

		$categories = $this -> SQL_SelectList('categories', NULL, ' parent = 101 AND level = 2 ');

		foreach ($categories as $category) {

			$items[$category['id']]['id_category'] = $category['id'];
			$items[$category['id']]['label_category'] = $category['label'];
			$items[$category['id']]['categories'] = array();

			$result = mysql_query( 
				" SELECT " .
				"    categories.id AS id " .
				"    , categories.label AS label " .
				"    , COUNT(*) AS product_qty " .
				" FROM " .
				"    categories " .
				"    LEFT JOIN products_and_categories ON categories.id = products_and_categories.id_category " .
				" WHERE " .
				"    categories.parent = (" . $category['id'] . ") " .
				" GROUP BY " .
				"    categories.id ",
				$this->db
			);
	
			if (!$result) {
				die('Неверный запрос: ' . mysql_error());
			}
	
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	
				$items[$category['id']]['categories'][$row['id']]['id'] = $row['id'];
				$items[$category['id']]['categories'][$row['id']]['label'] = $row['label'];
				$items[$category['id']]['categories'][$row['id']]['product_qty'] = $row['product_qty'];
	
			}
	
			mysql_free_result($result);

		}

		//

		return $items;

	}

};

?>