<?php

class ColumnCompareProducts_UI {

	protected $folder_class = '';

	protected $slider = NULL;

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/column_compare_products/';

	}

	public function render() {

		$column_compare_products_bllc = new ColumnCompareProducts_BLLC();

		//include $this->folder_class . 'tmp/default.tmp';

	}

};

?>