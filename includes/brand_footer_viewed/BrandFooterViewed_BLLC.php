<?php

class BrandFooterViewed_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// �����������

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/brand_footer_viewed/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// ������ �� ��������� ������

		$brand_footer_viewed_dalc = new BrandFooterViewed_DALC();

		$items = $brand_footer_viewed_dalc->GetItems();

		return $items;

	}

};

?>