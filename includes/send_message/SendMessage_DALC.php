<?php

class SendMessage_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;
		
		parent::__construct();

		$this->folder_class = $folder_root . '/includes/send_message/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItem( $id ) {

		$data = $this->SQL_SelectItem('send_messages', NULL, $id );

		return $data;

	}

	//--------------------------------------------------------------------------
	// 

	public function SetStatus( $id, $status ) {

		$item = array();

		$item['id'] = $id;
		$item['status'] = $status;

		$this->SQL_UpdateItems( 'send_messages', array( $item ), array( 'status' ) );

	}	

};

?>