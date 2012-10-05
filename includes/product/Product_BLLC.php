<?php

class Product_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/product/';

	}

	public function GetData( $id_product ) {

		$data = array();

		//

		$product_dalc = new Product_DALC();

		$product = $product_dalc->GetProduct( $id_product );

		//

		$data = $product;

		// Фотки

		$data['photos'] = $product_dalc->GetPhotos( $id_product );

		//

		$data['accessories'] = $product_dalc->GetAccessories( $id_product );

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

		$format = $currencies[$data['id_currency']]['format'];

		$price = number_format( $data['price'], 2, '.', ' ' );

		$data['price_str'] = sprintf($format, $price);

		return $data;

	}
};

?>