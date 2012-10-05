<?php

class ProductScroller_UI {

	protected $folder_class = '';

	protected $slider = NULL;

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/product_scroller/';

	}

	public function render() {

		$prd_scroller_bllc = new ProductScroller_BLLC();

		$data = $prd_scroller_bllc->GetItems();

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>