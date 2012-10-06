<?php

class SuccessPayment_UI {

	protected $folder_class = '';

	protected $current_page_label = 'default';

	function __construct( $data = array () ) {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/success_payment/';

		$this->data = $data;

	}

	public function render() {

		global $site_root;
		global $robocassa_pass1;

		$data = array();

		$this->data['crc'] = strtoupper($this->data['crc']);

		$my_crc = strtoupper(
			md5( $this->data['sum'] . ':' . $this->data['id_order'] . ':' . $robocassa_pass1 )
		);

		if (strtoupper($my_crc) != strtoupper($this->data['crc'])) {

			$success_payment_bllc = new SuccessPayment_BLLC();

			$data['client_manager'] = $success_payment_bllc->GetActiveClientManager();

			include $this->folder_class . 'tmp/error_crc.tmp';

		} else {

			include $this->folder_class . 'tmp/default.tmp';

		}

	}

};

?>