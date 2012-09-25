<?php

class BrandFooterViewed_UI extends FooterViewed_UI {

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/brand_footer_viewed/';

		$this->title = '<span><span class="color">Бренды</span></span>';

	}

	public function render() {

		$brand_footer_viewed_bllc = new BrandFooterViewed_BLLC();

		$data = $brand_footer_viewed_bllc->GetItems();

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>