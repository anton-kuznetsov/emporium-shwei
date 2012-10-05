<?php

class ProductPage_UI extends Page_UI {

	protected $options = array();

	function __construct( $modules = array(), $options = array() ) {

		global $folder_root;

		parent::__construct( $modules );

		$this->folder_class = $folder_root . '/includes/_pages/ProductPage/';

		$this->options = $options;

	}

	function action() {

		$product_page_bllc = new ProductPage_BLLC();

		$product_page_bllc->CountingShow( $this->options['id_product'] );

		$product_page_bllc->CountingView( $this->options['id_product'] );

	}

	function render() {

		global $week_days_rus;
		global $month_rus;
		global $site_root;

		$product_bllc = new Product_BLLC();

		$product = $product_bllc->GetData( $this->options['id_product'] );

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>