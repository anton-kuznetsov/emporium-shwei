<?php

class ProductFooterViewed_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/product_footer_viewed/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// Запрос на получение данных

		$viewed_items = $this->SQL_SelectListDistinct('product_footer_viewed_items', array ( 'id_product' ), " session_id = '" . session_id() . "' ", ' datetime DESC ', 5 );

		$ids_product = '-1';

		$items = array();

		foreach ($viewed_items as $viewed_item) {

			$ids_product .= ',' . $viewed_item['id_product'];

			$items[$viewed_item['id_product']] = array();

		}

		// Товары

		$produst_dalc = new Product_DALC();

		$produst_items = $produst_dalc->GetItemsByIds($ids_product);

		foreach ( $produst_items as $produst_item ) {

			$items[$produst_item['id']] = $produst_item;

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

			$format = $currencies[$item['id_currency']]['format'];
			$price = number_format( $items[$item['id']]['price'], 2, '.', ' ' );
			$items[$item['id']]['price_str'] = sprintf($format, $price);

		}

		// Готово

		return $items;

	}

};

?>