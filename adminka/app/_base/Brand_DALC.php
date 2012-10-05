<?php

class Brand_DALC extends DALC {

	private $TABLE_NAME = 'brands';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		parent::__construct();

	}

	//--------------------------------------------------------------------------
	// 

	public function GetBrand( $id_brand ) {

		global $site_root;

		$data = $this->SQL_SelectItem($this->TABLE_NAME, NULL, $id_brand );

		return $data;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		global $site_root;

		$items = $this->SQL_SelectAll($this->TABLE_NAME, NULL);

		//

		foreach ($items as $item) {

			$id = $item['id'];

		}

		//

		return $items;

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

		$items = $this->SQL_SelectList($this->TABLE_NAME, $fields, '', '', $limit, $start);

		return $items;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetRecomendedProducts( $id_brand, $qty = 4 ) {

		global $site_root;

		$items = $this->SQL_SelectList('brand_recomended_products', NULL, ' id_brand = ' . $id_brand );

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

		//

		return $products;

	}

};

?>