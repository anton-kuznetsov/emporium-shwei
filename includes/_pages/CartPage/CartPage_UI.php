<?php

class CartPage_UI extends Page_UI {

	protected $options = array();

	function __construct( $modules = array(), $options = array() ) {

		global $folder_root;

		parent::__construct( $modules );

		$this->folder_class = $folder_root . '/includes/_pages/CartPage/';

		$this->options = $options;

	}

	public function action() {

		$cart_page_bllc = new CartPage_BLLC();

		switch ($this->options['action']) {
			case 'add':
				$cart_page_bllc->AddItem( $this->options['id_product'], $this->options['qty'] );
				break;
			case 'delete':
				$cart_page_bllc->DeleteItem( $this->options['id_item'] );
				break;
			case 'update_post':
				$cart_page_bllc->UpdateItems();
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