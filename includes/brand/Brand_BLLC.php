<?php

class Brand_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/brand/';

	}
	
	public function GetData( $id_brand ) {

		$data = array();

		//

		$brand_dalc = new Brand_DALC();

		$data = $brand_dalc->GetBrand( $id_brand );

		//

		$data['products'] = $brand_dalc->GetRecomendedProducts( $id_brand );

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

		foreach ( $data['products'] as $product ) {

			$format = $currencies[$product['id_currency']]['format'];
			$price = number_format( $product['price'], 2, '.', ' ' );
			$products[$product['id']]['price_str'] = sprintf($format, $price);

		}

		return $data;

	}

};

?>