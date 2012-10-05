<?php

class Order_DALC extends DALC {

	private $TABLE_NAME = 'orders';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		parent::__construct();

	}

	//--------------------------------------------------------------------------
	//

	public function GetOrder( $id_order ) {

		$data = $this->SQL_SelectItem( $this->TABLE_NAME, NULL, $id_order );

		return $data;

	}

	//--------------------------------------------------------------------------
	//

	public function GetOrderItems( $id_order ) {

		// Запрос на получение данных

		$items = $this->SQL_SelectList('order_items', NULL, ' id_order = '.$id_order );

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

			if (
				count($product_items) &&
				array_key_exists($item['id_product'], $product_items)
			) {

				$items[$item['id']]['label']         = $product_items[$item['id_product']]['label'];
				$items[$item['id']]['id_currency']   = $product_items[$item['id_product']]['id_currency'];

			} else {

				$items[$item['id']]['label']         = '[ товар не найден ]';
				$items[$item['id']]['id_product']    = 0;
				$items[$item['id']]['id_currency']   = 0;

			}

			$items[$item['id']]['subtotal']      = $items[$item['id']]['price'] * $items[$item['id']]['qty'];

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

			if (  array_key_exists($item['id_currency'], $currencies) ) {

				$format = $currencies[$item['id_currency']]['format'];

			} else {

				$format = '%s';

			}

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

	public function CreateOrderItem( $item ) {

		$item = $this->SQL_CreateItem(
			'order_items',
			array(
				'id_order'   => $item['id_order'],
				'id_product' => $item['id_product'],
				'price'      => $item['price'],
				'qty'        => $item['qty']
			)
		);

		return $item;

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

};

?>