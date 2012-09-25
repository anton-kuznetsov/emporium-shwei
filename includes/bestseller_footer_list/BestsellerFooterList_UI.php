<?php

class BestsellerFooterList_UI {

	protected $folder_class = '';

	protected $slider = NULL;

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/bestseller_footer_list/';

	}

	public function render() {

		$prd_scroller_bllc = new BestsellerFooterList_BLLC();

		$data = $prd_scroller_bllc->GetItems();

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>