<?php

class Newsletter_UI {

	protected $folder_class = '';

	protected $slider = NULL;

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/newsletter/';

	}

	public function render() {

		$newsletter_bllc = new Newsletter_BLLC();

		//include $this->folder_class . 'tmp/default.tmp';

	}

};

?>