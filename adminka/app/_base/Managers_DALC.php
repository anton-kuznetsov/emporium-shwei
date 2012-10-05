<?php

class Managers_DALC extends DALC {

	private $TABLE_NAME = 'client_managers';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		parent::__construct();

	}

	//--------------------------------------------------------------------------
	// 

	public function GetActiveClientManager() {

		$items = $this->SQL_SelectList( $this->TABLE_NAME, NULL, ' is_active = 1 ', '', 1 );

		foreach ($items as $item) {

			return $item;

		}	

		return NULL;

	}

};

?>