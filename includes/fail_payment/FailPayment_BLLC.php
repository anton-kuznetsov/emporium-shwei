<?php

class FailPayment_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/fail_payment/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetActiveClientManager() {

		$managers_dalc = new Managers_DALC();

		$client_manager = $managers_dalc->GetActiveClientManager();

		return $client_manager;

	}

};



?>