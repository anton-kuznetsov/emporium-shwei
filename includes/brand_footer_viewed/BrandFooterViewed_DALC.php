<?php

class BrandFooterViewed_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/brand_footer_viewed/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		global $site_root;

		// Запрос на получение данных

		$items = $this->SQL_SelectAll('brand_footer_viewed_items');

		$brand_ids = '-1';

		foreach ($items as $item) {

			$brand_ids .= ',' . $item['id_brand'];

		}

		// Брэнды

		$brand_items = $this->SQL_SelectAllByIds('brands', $brand_ids);

		foreach ($items as $item) {

			$items[$item['id']]['label_brand'] = $brand_items[$item['id_brand']]['label'];
			
			$items[$item['id']]['href_image_50_gray']  = $site_root . '/upload/50x50/' . $brand_items[$item['id_brand']]['href_image_50_gray'];

		}

		// Готово

		return $items;

	}

};

?>