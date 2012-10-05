<?php

class InfoPage_UI extends Page_UI {

	protected $options = array();

	function __construct( $modules = array(), $options = array() ) {

		global $folder_root;

		parent::__construct( $modules );

		$this->folder_class = $folder_root . '/includes/_pages/InfoPage/';

		$this->options = $options;

	}

	function render() {

		global $week_days_rus;
		global $month_rus;
		global $site_root;

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>