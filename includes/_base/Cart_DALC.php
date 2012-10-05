<?php

class Cart_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/_base/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetCartById( $id_cart ) {

		global $site_root;

		$data = $this->SQL_SelectItem('cart', NULL, $id_cart );

		return $data;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetCartBySession( $session_id ) {

		$items = $this->SQL_SelectList( 'cart', NULL, " session_id = '".$session_id."' AND status = 0 " );

		foreach ($items as $item) {

			return $item;

		}

		return NULL;

	}

	//--------------------------------------------------------------------------
	//

	public function GetCartItems( $id_cart ) {

		// Запрос на получение данных

		$items = $this->SQL_SelectList('cart_items', NULL, ' id_cart = '.$id_cart );

		if ( is_null($items) ) { 

			return $items;

		}

		//

		$ids_product = '-1';

		foreach ($items as $item) {

			$ids_product .= ',' . $item['id_product'];		

		}

		// Товары

		$produst_dalc = new Product_DALC();

		$product_items = $produst_dalc->GetItemsByIds($ids_product);

		foreach ($items as $item) {

			$items[$item['id']]['label']         = $product_items[$item['id_product']]['label'];
			$items[$item['id']]['id_currency']   = $product_items[$item['id_product']]['id_currency'];
			$items[$item['id']]['price']         = $product_items[$item['id_product']]['price'];
			$items[$item['id']]['subtotal']      = $items[$item['id']]['price'] * $items[$item['id']]['qty'];
			$items[$item['id']]['href_image_50'] = $product_items[$item['id_product']]['href_image_50'];
			$items[$item['id']]['href_image_90'] = $product_items[$item['id_product']]['href_image_90'];

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
			$items[$item['id']]['format'] = $format;

			$price = number_format( $items[$item['id']]['price'], 2, '.', ' ' );
			$items[$item['id']]['price_str'] = sprintf($format, $price);
			$subtotal = number_format( $items[$item['id']]['subtotal'], 2, '.', ' ' );
			$items[$item['id']]['subtotal_str'] = sprintf($format, $subtotal);

		}
		
		// Готово

		return $items;

	}

	//--------------------------------------------------------------------------
	//

	public function NewCart( $session_id ) {

		$item = $this->SQL_CreateItem( 'cart', array( 'session_id' => $session_id ));

		return $item;

	}
};

?>