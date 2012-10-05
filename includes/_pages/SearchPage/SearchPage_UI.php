<?php

class SearchPage_UI extends Page_UI {

	function __construct( $modules = array() ) {

		global $folder_root;

		parent::__construct( $modules );

		$this->folder_class = $folder_root . '/includes/_pages/SearchPage/';

	}

	function render() {

		global $week_days_rus;
		global $month_rus;
		global $sitename;
		global $site_root;

		include $this->folder_class . 'tmp/default.tmp';

	}
};

?>