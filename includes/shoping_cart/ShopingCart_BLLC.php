<?php

class ShopingCart_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/shoping_cart/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		$cart_dalc = new Cart_DALC();
		
		$cart = $cart_dalc->GetCartBySession( session_id() );

		if ( is_null($cart) ) {

			$cart = $cart_dalc->NewCart( session_id() );

			return NULL;

		}

		//

		$shoping_cart_dalc = new ShopingCart_DALC();

		$items = $shoping_cart_dalc->GetCartItems( $cart['id'] );

		$data = array();
		$data['cart_items'] = $items;
		$data['subtotal'] = 0;

		$format = '';

		foreach ( $data['cart_items'] as $item ) {

			$data['subtotal'] += $item['subtotal'];
			$format = $item['format'];

		}
		
		$data['subtotal_str'] = number_format( $data['subtotal'], 2, '.', ' ' );
		$data['subtotal_str'] = sprintf($format, $data['subtotal_str']);
		
		$data['total'] = $data['subtotal'];
		$data['total_str'] = number_format( $data['total'], 2, '.', ' ' );
		$data['total_str'] = sprintf($format, $data['total_str']);

		// Акссесуары к товарам

		$ids = '-1';

		foreach ( $data['cart_items'] as $item ) {

			$ids .= ', ' . $item['id_product'];

		}

		$product_dalc = new Product_DALC();

		$data['recomended_list'] = $product_dalc->GetAccessoriesByIds( $ids );

		//

		return $data;

	}

};

?>