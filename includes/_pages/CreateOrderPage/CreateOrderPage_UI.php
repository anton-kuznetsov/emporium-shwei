<?php

class CreateOrderPage_UI extends Page_UI {

	protected $options = array();

	function __construct( $modules = array(), $options = array() ) {

		global $folder_root;

		parent::__construct( $modules );

		$this->folder_class = $folder_root . '/includes/_pages/CreateOrderPage/';

		$this->options = $options;

	}

	public function action() {

		$create_order_page_bllc = new CreateOrderPage_BLLC();

		switch ($this->options['action']) {
			case 'step1_next':
				$create_order_page_bllc->NewOrder( $this->options );
				break;
			case 'done':
				$create_order_page_bllc->DoneOrder( $this->options );
				break;
			default:
				break;
		}

	}

	public function render() {

		global $week_days_rus;
		global $month_rus;
		global $sitename;
		global $site_root;

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>