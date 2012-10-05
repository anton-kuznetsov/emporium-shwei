<?php

class SideMenu_UI {

	protected $folder_class = '';

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/side_menu/';

	}

	public function render($data) {

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>