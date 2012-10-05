<?php

class NewFooterList_UI {

	protected $folder_class = '';

	protected $slider = NULL;

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/new_footer_list/';

	}

	public function render() {

		$new_footer_list_bllc = new NewFooterList_BLLC();

		$data = $new_footer_list_bllc->GetItems();

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>