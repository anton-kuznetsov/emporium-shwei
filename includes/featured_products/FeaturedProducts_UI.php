<?php

class FeaturedProducts_UI {

	protected $folder_class = '';

	protected $slider = NULL;

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/featured_products/';

	}

	public function render() {

		$featured_products_bllc = new FeaturedProducts_BLLC();

		$data = $featured_products_bllc->GetItems();

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>