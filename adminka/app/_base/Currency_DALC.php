<?php

class Currency_DALC extends DALC {

	protected $folder_class = '';

	private $TABLE_NAME = 'currencies';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/_base/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		$items = $this->SQL_SelectAll( $this->TABLE_NAME, NULL );

		return $items;

	}

};

?>