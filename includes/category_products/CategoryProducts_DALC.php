<?php

class CategoryProducts_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/category_products/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetCategory ( $id_category = 0 ) {

		$item = $this -> SQL_SelectItem('categories', NULL, $id_category);

		return $item;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems( $id_category = 0, $id_brand = 0, $p = 1, $limit = 9, $order = '' ) {

		// Товары

		global $site_root;

		$items = array ();

		$ids_child = $this -> SQL_SelectIdsTree('categories', 'parent', $id_category);			

		$ids = $id_category . ($ids_child != '' ? ',' : '') . $ids_child;

		//

		$where = '';

		if ( $id_brand > 0 ) {

			$where .= ' AND products.id_brand = ' . $id_brand . ' ';

		}

		// Кол-во

		$result = mysql_query( 

			" SELECT " .
			"    COUNT(*) AS product_qty " .
			" FROM " .
			"    products " .
			" WHERE " .
			"    products.id_category IN (" . $ids . ") " .
			$where .
			" ORDER BY " .
			"    products.dt DESC " .
			"    , products.id DESC ",

			$this->db

		);

		if (!$result) {

			die('Неверный запрос: ' . mysql_error());

		}

		$product_qty = 0;

		if ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

			$product_qty = $row['product_qty'];

		}

		mysql_free_result($result);

		//

		switch ($order) {
			case 'name':
				$order = " products.label ASC, products.id DESC ";
				break;
			case 'price':
				$order = " products.price ASC, products.id DESC ";
				break;
			case 'date':
			default:
				$order = " products.dt DESC, products.id DESC ";
				break;
		} 

		$result = mysql_query( 

			" SELECT " .
			"    products.* " .
			"    , product_photos.file_name AS photo_file_name " .
			" FROM " .
			"    products " .
			"    INNER JOIN product_photos ON product_photos.id_product = products.id " .
			" WHERE " .
			"    products.id_category IN (" . $ids . ") " .
			$where .
			" ORDER BY " . $order . " " .
			" LIMIT " . (($p - 1) * $limit) . ", " . $limit . " ",

			$this->db

		);

		if (! $result) {

			die('Неверный запрос: ' . mysql_error());

		}

		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

			$items[$row['id']] = $row;

			$items[$row['id']]['href_image_90'] = $site_root . '/upload/90x90/' . $items[$row['id']]['photo_file_name'];

		}

		mysql_free_result($result);

		// Валюта

		$currency_dalc = new Currency_DALC();

		$currencies = $currency_dalc->GetItems();

		// Используя формат представления цены, выполняется
		// формирование строки для показа цены на странице.
		// Дополнительно выставляются пробелы через каждые 3 цифры.
		// Пример: 
		//     currencies.format = '%s руб.'
		//     products.price = 10000.00
		// Результат:
		//     price_str = '10 000.00 руб.' 

		foreach ($items as $item) {

			$format = $currencies[$item['id_currency']]['format'];

			$price = number_format( $items[$item['id']]['price'], 2, '.', ' ' );

			$items[$item['id']]['price_str'] = sprintf($format, $price);

		}

		// Готово

		$data['items']       = $items;
		$data['product_qty'] = $product_qty; 
		$data['begin']       = (($p - 1) * $limit) + 1;
		$data['end']         = (($p - 1) * $limit) + count($items);

		return $data;

	}

};

?>