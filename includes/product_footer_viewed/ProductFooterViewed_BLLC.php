<?php

class ProductFooterViewed_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// �����������

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/product_footer_viewed/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// ������ �� ��������� ������

		$prd_footer_viewed_dalc = new ProductFooterViewed_DALC();

		$items = $prd_footer_viewed_dalc->GetItems();

		return $items;

	}

};

?>