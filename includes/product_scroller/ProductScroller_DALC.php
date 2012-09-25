<?php

class ProductScroller_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/product_scroller/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// Запрос на получение данных

		$items = $this->SQL_SelectAll('product_scroller_items', array ( 'id_product' ));

		$ids_product = '-1';

		foreach ($items as $item) {

			$ids_product .= ',' . $item['id_product'];		

		}

		// Товары

		$produst_dalc = new Product_DALC();

		$product_items = $produst_dalc->GetItemsByIds($ids_product);

		foreach ($items as $item) {

			$items[$item['id']]['product'] = $product_items[$item['id_product']];

		}

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

			$format = $currencies[$item['product']['id_currency']]['format'];
			$price = number_format( $items[$item['id']]['product']['price'], 2, '.', ' ' );
			$items[$item['id']]['product']['price_str'] = sprintf($format, $price);

		}
		
		// Готово

		return $items;

	}

};

?>