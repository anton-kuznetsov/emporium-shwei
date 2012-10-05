<?php

class CartPage_BLLC {

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/_pages/CartPage/';

	}

	//--------------------------------------------------------------------------
	//

	public function AddItem( $id_product, $qty ) {

		$cart_dalc = new Cart_DALC();
		
		$cart = $cart_dalc->GetCartBySession( session_id() );

		if ( is_null($cart) ) {

			$cart = $cart_dalc->NewCart( session_id() );

		}
		
		//

		$shoping_cart_dalc = new ShopingCart_DALC();

		$cart_items = $shoping_cart_dalc->GetCartItems( $cart['id'] );

		$item = NULL;

		foreach ( $cart_items as $cart_item ) {
			if ( $cart_item['id_product'] == $id_product ) {
				$item = $cart_item;
				break;
			}
		}

		if ( is_null($item) ) { 

			$cart_dalc->SQL_CreateItem( 'cart_items', array( 'id_cart' => $cart['id'], 'id_product' => $id_product, 'qty' => $qty ) );

		} else {

			$item['qty'] += $qty;

			$cart_dalc->SQL_UpdateItems( 'cart_items', array( $item ), array( 'qty' ) );

		}

		//

		header("Location: " . ShopingCart_UI::href(NULL, 1));
		exit;

	}

	//--------------------------------------------------------------------------
	//

	public function UpdateItems() {

		$cart_dalc = new Cart_DALC();
		
		$cart = $cart_dalc->GetCartBySession( session_id() );

		if ( is_null($cart) ) {

			$cart = $cart_dalc->NewCart( session_id() );

		}
		
		//

		$items = $cart_dalc->SQL_SelectList('cart_items', NULL, ' id_cart = '.$cart['id'] );

		foreach ( $items as $item ) {

			if (
				array_key_exists('qty_'.$item['id'], $_REQUEST) &&
				! empty ($_REQUEST ['qty_'.$item['id']])
			) {

				$a = intval($_REQUEST ['qty_'.$item['id']]);

				$items[$item['id']]['qty'] = $a > 0 ? $a : $items[$item['id']]['qty'];

			}
		}

		//

		$cart_dalc->SQL_UpdateItems( 'cart_items', $items, array( 'qty' ) );

		//

		header("Location: " . ShopingCart_UI::href(NULL, 1));
		exit;

	}

	//--------------------------------------------------------------------------
	//

	public function DeleteItem( $id_item ) {

		$dalc = new DALC();

		$dalc->SQL_DeleteItems( 'cart_items', ' id = ' . (int)$id_item );

		//

		header("Location: " . ShopingCart_UI::href(NULL, 1));
		exit;

	}
};

?>