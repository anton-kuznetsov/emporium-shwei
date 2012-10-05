<?php

class PopularFooterList_UI {

	protected $folder_class = '';

	protected $slider = NULL;

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/popular_footer_list/';

	}

	public function render() {

		$popular_footer_list_bllc = new PopularFooterList_BLLC();

		$data = $popular_footer_list_bllc->GetItems();

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>