<?php

class SearchResults_DALC extends DALC {

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

	public function GetItems( $q = '', $p = 1, $limit = 9, $order = '' ) {

		// Товары

		global $site_root;

		$items = array ();

		//

		$where = '';

		$q = trim ($q);

		if ( $q != '' ) {

			$where .= " AND products.label LIKE '%" . $q . "%' ";

		}

		// Кол-во

		$result = mysql_query( 
			" SELECT " .
			"    COUNT(*) AS product_qty " .
			" FROM " .
			"    products_and_categories " .
			"    INNER JOIN products ON products.id = products_and_categories.id_product " .
			" WHERE " .
			"    1 = 1 " .
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
			" FROM " .
			"    products_and_categories " .
			"    INNER JOIN products ON products.id = products_and_categories.id_product " .
			" WHERE " .
			"    1 = 1 " .
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
			
			$items[$row['id']]['href_image_90'] = $site_root . '/upload/90x90/' . $items[$row['id']]['href_image_90'];

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

		$data['items'] = $items;
		$data['product_qty'] = $product_qty; 
		$data['begin'] = (($p - 1) * $limit) + 1;
		$data['end'] = (($p - 1) * $limit) + count($items);

		return $data;

	}

};

?>