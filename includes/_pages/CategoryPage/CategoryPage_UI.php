<?php

class CategoryPage_UI extends Page_UI {

	protected $options = array();

	function __construct( $modules = array(), $options = array() ) {

		global $folder_root;

		parent::__construct( $modules );

		$this->folder_class = $folder_root . '/includes/_pages/CategoryPage/';

		$this->options = $options;

	}

	function render() {

		global $week_days_rus;
		global $month_rus;
		global $site_root;

		$category_bllc = new CategoryProducts_BLLC();

		$category = $category_bllc->GetCategory( $this->options['id_category'] );

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>