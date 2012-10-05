<?php

class SendMessage_UI extends UI {

	protected $folder_class = '';

	protected $data = array();

	protected $href_params = NULL;

	function __construct( $data = array() ) {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/send_message/';

		$this->data = $data;

		$href_order_params = array (
			array ( 'name' => 't',       'value' => $_REQUEST ['t']       ),
			array ( 'name' => 'action',  'value' => $_REQUEST ['action']  ),
			array ( 'name' => 'id',      'value' => $_REQUEST ['id']      ),
			array ( 'name' => 'fio',     'value' => $_REQUEST ['fio']     ),
			array ( 'name' => 'email',   'value' => $_REQUEST ['email']   ),
			array ( 'name' => 'phone',   'value' => $_REQUEST ['phone']   ),
			array ( 'name' => 'subject', 'value' => $_REQUEST ['subject'] ),
			array ( 'name' => 'text',    'value' => $_REQUEST ['text']    )
		);
	}

	//--------------------------------------------------------------------------
	//

	public function render() {

		global $site_root;

		$data = array ();

		switch ( $this->data['action'] ) {
			case 'step1':
				include $this->folder_class . 'tmp/step1.tmp';
				break;
			case 'back_to_step1':
				$send_message_bllc = new SendMessage_BLLC();
				$data = $send_message_bllc->GetData( $this->data['id'] );
				//
				include $this->folder_class . 'tmp/step1.tmp';
				break;
			case 'step2':
				$send_message_bllc = new SendMessage_BLLC();
				$data = $send_message_bllc->GetData( $this->data['id'] );
				//
				include $this->folder_class . 'tmp/step2.tmp';
				break;
			case 'step3':
				include $this->folder_class . 'tmp/step3.tmp';
				break;
			default:
				include $this->folder_class . 'tmp/empty.tmp';
				break;
		}
	}

	//--------------------------------------------------------------------------
	//

	public function href( $vars = array(), $is_return = 0 ) {

		$href_params = array (
			array ( 'name' => 't',       'value' => 'send_message' ),
			array ( 'name' => 'action',  'value' => 'step1'        ),
 			array ( 'name' => 'id',      'value' => ''             ),
 			array ( 'name' => 'fio',     'value' => ''             ),
 			array ( 'name' => 'email',   'value' => ''             ),
 			array ( 'name' => 'phone',   'value' => ''             ),
			array ( 'name' => 'subject', 'value' => ''             ),
			array ( 'name' => 'text',    'value' => ''             )
		);

		$this->href_params = $href_params;

		return parent::href( $vars, $is_return );

	}

};

?>