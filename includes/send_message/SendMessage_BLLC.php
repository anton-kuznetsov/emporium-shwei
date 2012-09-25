<?php

class SendMessage_BLLC {

	const STATUS_CREATE = 1;
	const STATUS_SEND   = 2;

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/send_message/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetData( $id ) {

		global $month_rus;

		//

		$send_message_dalc = new SendMessage_DALC();

		$data = $send_message_dalc->GetItem( $id );

 		$date = date_create( $data['dt'] );
		$data['dt_str'] = date_format($date, 'd ') . $month_rus[date_format($date, 'n') - 1] . date_format($date, ' Y');

		//

		$managers_dalc = new Managers_DALC();

		$data['client_manager'] = $managers_dalc->GetActiveClientManager();

		return $data;

	}

	//--------------------------------------------------------------------------
	// 

	public function SetStatus( $id, $status ) {

		$send_message_dalc = new SendMessage_DALC();

		$data = $send_message_dalc->SetStatus( $id, $status );

	}	

};

?>