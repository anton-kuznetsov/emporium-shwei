<?php

class FooterMenu_UI {

	protected $folder_class = '';

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/footer_menu/';

	}

	public function render() {

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>