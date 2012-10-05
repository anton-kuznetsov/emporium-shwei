<?php

class Category_DALC extends DALC {

	private $TABLE_NAME = 'categories';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		parent::__construct();

	}

	//--------------------------------------------------------------------------
	// 

	public function GetCategory( $id_category ) {

		global $site_root;

		$data = $this->SQL_SelectItem( $this->TABLE_NAME, NULL, $id_category );

		return $data;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetRootCategory( $id_category ) {

		$category = $this->SQL_SelectItem( $this->TABLE_NAME, NULL, $id_category );

		$i = 100;

		while ( $category['parent'] > 0 && $i > 0 ) {

			$i++;

			$category = $this->SQL_SelectItem( $this->TABLE_NAME, NULL, $category['parent'] );

		}

		return $category;

	}

	//--------------------------------------------------------------------------
	// 

	public function Count() {

		$count = $this->SQL_SelectCount( $this->TABLE_NAME );

		return $count;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItemsLimit($fields = NULL, $start = 0, $limit = 0) {

		$items = $this->SQL_SelectList( $this->TABLE_NAME, $fields, '', '', $limit, $start);

		return $items;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetProducts( $id_category, $where = ' 1 = 1 ' ) {

		// Товары

		global $site_root;

		$items = array ();

		$ids_child = $this -> SQL_SelectIdsTree( $this->TABLE_NAME, 'parent', $id_category );			

		$ids = $id_category . ($ids_child != '' ? ',' : '') . $ids_child;

		//

		$result = mysql_query( 

			" SELECT " .
			"    products.id " .
			"    , products.label " .
			"    , products.price " .
			"    , products.articul " .
			"    , products.id_currency " .
			" FROM " .
			"    products_and_categories " .
			"    INNER JOIN products ON products.id = products_and_categories.id_product " .
			" WHERE " .
			$where .
			"    AND products_and_categories.id_category IN (" . $ids . ") ",

			$this->db

		);

		if (! $result) {

			die('Неверный запрос: ' . mysql_error());

		}

		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

			$items[$row['id']] = $row;

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

		return $items;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetRecomendedProducts( $id_category, $qty = 4 ) {

		global $site_root;

		$items = $this->SQL_SelectList('category_recomended_products', NULL, ' id_category = ' . $id_category );

		$ids = '-1';

		if (isset($items)) {

			shuffle($items); // Перемешиваю массив в случайном порядке
	
			$i = 0;
	
			foreach ($items as $item) {
	
				$ids .= ', ' . $item['id_product'];
	
				if ( ++$i == $qty ) break;
	
			}
		}

		//

		$product_dalc = new Product_DALC();

		$products = $product_dalc->GetItemsByIds($ids);

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

		if (isset($products) && isset($currencies)) {

			foreach ($products as $product) {
	
				if (  array_key_exists($product['id_currency'], $currencies) ) {
	
					$format = $currencies[$product['id_currency']]['format'];
	
				} else {
	
					$format = '%s';
	
				}
	
				$format = $currencies[$product['id_currency']]['format'];
	
				$price = number_format( $products[$product['id']]['price'], 2, '.', ' ' );
	
				$products[$product['id']]['price_str'] = sprintf($format, $price);
	
			}
		}

		//

		return $products;

	}

};

?>