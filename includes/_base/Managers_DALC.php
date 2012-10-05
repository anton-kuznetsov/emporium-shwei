<?php

class Managers_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/_base/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetActiveClientManager() {

		$items = $this->SQL_SelectList('client_managers', NULL, ' is_active = 1 ', '', 1 );

		foreach ($items as $item) {

			return $item;

		}	

		return NULL;

	}

};

?>