<?php

class TopMenu_UI {

	protected $folder_class = '';

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/top_menu/';

	}

	public function render() {

		global $site_root;

		include $this->folder_class . 'tmp/default.tmp';

	}
};

?>