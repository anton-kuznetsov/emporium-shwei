<?php

class Slider_UI {

	protected $folder_class = '';

	protected $slider = NULL;

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/slider/';

	}

	public function render() {

		$slider_bllc = new Slider_BLLC();

		$data = $slider_bllc->GetItems();

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>