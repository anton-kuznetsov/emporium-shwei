<?php

class BrandPage_UI extends Page_UI {

	protected $options = array();

	function __construct( $modules = array(), $options = array() ) {

		global $folder_root;

		parent::__construct( $modules );

		$this->folder_class = $folder_root . '/includes/_pages/BrandPage/';

		$this->options = $options;

	}

	function render() {

		global $week_days_rus;
		global $month_rus;
		global $site_root;

		$brand_dalc = new Brand_DALC();
		$data = $brand_dalc->GetBrand( $this->options['id_brand'] );

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>