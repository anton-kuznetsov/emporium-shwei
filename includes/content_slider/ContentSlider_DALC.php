<?php

class ContentSlider_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/content_slider/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems( $id_category, $id_brand = 0 ) {

		global $site_root;

		$items = array ();

		$ids_child = $this -> SQL_SelectIdsTree('categories', 'parent', $id_category);			
		$ids = $id_category . ($ids_child != '' ? ',' : '') . $ids_child;

		//

		$where = '';
		
		if ( $id_brand > 0 ) {

			$where .= ' AND products.id_brand = ' . $id_brand . ' ';

		}

		//

		$result = mysql_query( 
			" SELECT " .
			"    products.* " .
			" FROM " .
			"    products_and_categories " .
			"    INNER JOIN products ON products.id = products_and_categories.id_product " .
			" WHERE " .
			"    products_and_categories.id_category IN (" . $ids . ") " .
			$where .
			" ORDER BY " .
			"    products.dt DESC " .
			"    , products.id DESC " .
			" LIMIT 4 ",
			$this->db
		);

		if (!$result) {
			die('Неверный запрос: ' . mysql_error());
		}

		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

			$items[$row['id']] = $row;
			
			$items[$row['id']]['href_image_250'] = $site_root . '/upload/250x250/' . $items[$row['id']]['href_image_250'];

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

		//

		return $items;

	}

};

?>