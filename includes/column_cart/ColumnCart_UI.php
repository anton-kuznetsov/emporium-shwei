<?php

class ColumnCart_UI {

	protected $folder_class = '';

	protected $slider = NULL;

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/column_cart/';

	}

	public function render() {

		$column_cart_bllc = new ColumnCart_BLLC();

		$data = $column_cart_bllc->GetData();

		if ( $data['qty'] > 0 ) {

			include $this->folder_class . 'tmp/default.tmp';

		} else {

			include $this->folder_class . 'tmp/empty.tmp';

		}
	}
};

?>