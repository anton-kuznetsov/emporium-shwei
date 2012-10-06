<?php

class FailPayment_UI {

	protected $folder_class = '';

	protected $current_page_label = 'default';

	function __construct( $data = array () ) {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/fail_payment/';

	}

	public function render() {

		global $site_root;

		$data = array();

		$fail_payment_bllc = new FailPayment_BLLC();

		$data['client_manager'] = $fail_payment_bllc->GetActiveClientManager();

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>