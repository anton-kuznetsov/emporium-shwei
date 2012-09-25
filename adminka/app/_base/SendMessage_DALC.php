<?php

class SendMessage_DALC extends DALC {

	protected $folder_class = '';

	private $TABLE_NAME = 'send_messages';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/_base/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetMessage( $id ) {

		global $site_root;

		$data = $this->SQL_SelectItem($this->TABLE_NAME, NULL, $id );

		return $data;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		global $site_root;

		$items = $this->SQL_SelectAll($this->TABLE_NAME, NULL);

		//

		foreach ($items as $item) {

			$id = $item['id'];

		}

		//

		return $items;

	}

	//--------------------------------------------------------------------------
	//

	public function Count() {

		$count = $this->SQL_SelectCount( $this->TABLE_NAME );

		return $count;

	}

	//--------------------------------------------------------------------------
	//

	public function GetItemsLimit($fields = NULL, $start = 0, $limit = 0) {

		$items = $this->SQL_SelectList($this->TABLE_NAME, $fields, '', '', $limit, $start);

		return $items;

	}

};

?>