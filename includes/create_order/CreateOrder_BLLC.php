<?php

class CreateOrder_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/create_order/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetData( $id_order ) {

		global $month_rus;

		$data = array();

		$order_dalc = new Order_DALC();

		$order = $order_dalc->GetOrder( $id_order );

		$date = date_create($order['dt']);
		$order['dt_str'] = date_format($date, 'd ') . $month_rus[date_format($date, 'n') - 1] . date_format($date, ' Y');

		//

		$cart_dalc = new Cart_DALC();

		$cart = $cart_dalc->GetCartBySession( session_id() ); 

		$cart_items = $cart_dalc->GetCartItems( $cart['id'] );

		$data = $order;
		$data['cart_items'] = $cart_items;

		$format = '';

		foreach ( $data['cart_items'] as $item ) {

			$data['total'] += $item['subtotal'];
			$format = $item['format'];

		}

		$data['total_str'] = number_format( $data['total'], 2, '.', ' ' );
		$data['total_str'] = sprintf($format, $data['total_str']);

		//
		
		$managers_dalc = new Managers_DALC();

		$data['client_manager'] = $managers_dalc->GetActiveClientManager();

		return $data;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetOrderData( $id_order ) {

		global $month_rus;

		$data = array();

		$order_dalc = new Order_DALC();

		$data = $order_dalc->GetOrder( $id_order );

		//

		$data['order_items'] = $order_dalc->GetOrderItems( $id_order );

		foreach ( $data['order_items'] as $item ) {

			$data['total'] += $item['subtotal'];

		}

		//

		$managers_dalc = new Managers_DALC();

		$data['client_manager'] = $managers_dalc->GetActiveClientManager();

		return $data;

	}

};

?>