<?php

class CreateOrder_UI extends UI {

	protected $folder_class = '';

	protected $data = array();

	protected $href_cart_params = NULL;

	function __construct( $data = array() ) {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/create_order/';

		$this->data = $data;

		$href_order_params = array (
			array ( 'name' => 't',        'value' => $_REQUEST ['t']        ),
			array ( 'name' => 'action',   'value' => $_REQUEST ['action']   ),
			array ( 'name' => 'id_order', 'value' => $_REQUEST ['id_order'] ),
			array ( 'name' => 'id_cart',  'value' => $_REQUEST ['id_cart']  ),
			array ( 'name' => 'fio',      'value' => $_REQUEST ['fio']      ),
			array ( 'name' => 'email',    'value' => $_REQUEST ['email']    ),
			array ( 'name' => 'phone',    'value' => $_REQUEST ['phone']    )
		);

	}

	//--------------------------------------------------------------------------
	//

	public function render() {

		global $site_root;
		global $robocassa_login;
		global $robocassa_pass1;

		$data = array ();

		switch ( $this->data['action'] ) {
			case 'step1':
				include $this->folder_class . 'tmp/step1.tmp';
				break;
			case 'back_to_step1':
				$data['fio']   = $this->data['fio'];
				$data['email'] = $this->data['email'];
				$data['phone'] = $this->data['phone'];
				//
				include $this->folder_class . 'tmp/step1.tmp';
				break;
			case 'step2':
				$create_order_bllc = new CreateOrder_BLLC();
				$data = $create_order_bllc->GetData( $this->data['id_order'] );
				include $this->folder_class . 'tmp/step2.tmp';
				break;
			case 'step3':
				$create_order_bllc = new CreateOrder_BLLC();
				$data = $create_order_bllc->GetOrderData( $this->data['id_order'] );
				include $this->folder_class . 'tmp/step3.tmp';
				break;
			default:
				include $this->folder_class . 'tmp/empty.tmp';
				break;
		}
	}

	//--------------------------------------------------------------------------
	//

	public function href( $vars = array(), $is_return = 0, $is_sef = 1 ) {

		$href_order_params = array (
			array ( 'name' => 't',        'value' => 'create_order' ),
			array ( 'name' => 'action',   'value' => 'step1'        ),
			array ( 'name' => 'id_order', 'value' => 0              ),
			array ( 'name' => 'id_cart',  'value' => 0              ),
 			array ( 'name' => 'fio',      'value' => ''             ),
 			array ( 'name' => 'email',    'value' => ''             ),
 			array ( 'name' => 'phone',    'value' => ''             )
		);

		$this->href_params = $href_order_params;

		if ($is_sef) {

			return parent::href_sef( 'orders/create.html?action={action}&id_order={id_order}&id_cart={id_cart}&fio={fio}&email={email}&phone={phone}', $vars, $is_return );

		} else {

			return parent::href( $vars, $is_return );

		}
	}
};

?>