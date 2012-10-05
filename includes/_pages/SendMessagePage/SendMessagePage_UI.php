<?php

class SendMessagePage_UI extends Page_UI {

	protected $options = array();

	function __construct( $modules = array(), $options = array() ) {

		global $folder_root;

		parent::__construct( $modules );

		$this->folder_class = $folder_root . '/includes/_pages/SendMessagePage/';

		$this->options = $options;

	}

	public function action() {

		$send_message_page_bllc = new SendMessagePage_BLLC();

		switch ($this->options['action']) {
			case 'step1_next':
				$send_message_page_bllc->NewMessage( $this->options );
				break;
			case 'done':
				$send_message_page_bllc->SendMessage( $this->options );
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