<?php

class BrandSideMenu_UI extends SideMenu_UI {

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/brand_side_menu/';

	}

	public function render() {

		$brand_side_menu_bllc = new BrandSideMenu_BLLC();

		// Структурированные данные
		// 1 уровень меню - 1 уровень категорий товаров (название и id категории)
		// 2 уровень меню - список брендов представленных в категории (название и id бренда + кол-во товаров)
		$pre_data = $brand_side_menu_bllc->GetData();

		// По собранным данным формирую заголовки-ссылки для пунктов меню 
		$data = array();
		$data_qty = 0;
		foreach ($pre_data as $item) {

			$data[$data_qty] = array();

			$data[$data_qty]['title'] = 
				"<a class='mageside-menu-heading' href='" .
				CategoryProducts_UI::href(array( 'id_category' => $item['id_category'] ), 1) .
				"'><span class='parent'>" . $item['label_category'] . "</span></a>";

			$data[$data_qty]['items'] = array();

			foreach ($item['brands'] as $brand) {

				$data[$data_qty]['items'][$brand['id']] = 
					"<a href='" .
					CategoryProducts_UI::href(array('id_category' => $item['id_category'], 'id_brand' => $brand['id']), 1) .
					"'>" . $brand['label'] . "</a><span class='mageside-prod-num'>&nbsp;(" . $brand['product_qty'] . ")</span>";

			}

			$data_qty++;
		}

		include $this->folder_class . 'tmp/default.tmp';

	}
};

?>