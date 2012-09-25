<?php

class ColumnCart_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/column_cart/';

	}

	public function GetData() {

		$data = array();

		//

		$cart_dalc = new Cart_DALC();

		$cart = $cart_dalc->GetCartBySession( session_id() );

		//

		if ( is_null($cart) ) {

			$cart = $cart_dalc->NewCart( session_id() );

			$data['subtotal'] = 0;
			$data['qty'] = 0;
			$data['subtotal_str'] = '0';

		} else {

			$shoping_cart_dalc = new ShopingCart_DALC();
	
			$cart_items = $shoping_cart_dalc->GetCartItems( $cart['id'] );
	
			$data['subtotal'] = 0;
			$data['qty'] = 0;
	
			$format = '';
	
			foreach ( $cart_items as $cart_item ) {
	
				$data['subtotal'] += $cart_item['subtotal'];
				$data['qty']++;
				$format = $cart_item['format'];
	
			}
			
			$data['subtotal_str'] = number_format( $data['subtotal'], 2, '.', ' ' );
			$data['subtotal_str'] = sprintf($format, $data['subtotal_str']);

		}

		//

		return $data;

	}

};

?>