<?php

class ShopingCart_UI extends UI {

	protected $folder_class = '';

	protected $slider = NULL;

	protected $href_cart_params = NULL;

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/shoping_cart/';

		$href_cart_params = array (
			array ( 'name' => 't',          'value' => $_REQUEST ['t']          ),
			array ( 'name' => 'action',     'value' => $_REQUEST ['action']     ),
			array ( 'name' => 'id_product', 'value' => $_REQUEST ['id_product'] ),
			array ( 'name' => 'id_item',    'value' => $_REQUEST ['id_item']    ),
			array ( 'name' => 'qty',        'value' => $_REQUEST ['qty']        )
		);

	}

	public function render() {

		global $site_root;

		$shoping_cart_bllc = new ShopingCart_BLLC();

		$data = $shoping_cart_bllc->GetItems();

		if ( is_null($data) || ! array_key_exists('cart_items', $data) || is_null($data['cart_items']) ) {

			include $this->folder_class . 'tmp/empty.tmp';

		} else {

			include $this->folder_class . 'tmp/default.tmp';
		
		}
	}

	//--------------------------------------------------------------------------
	//

	public function href( $vars = array(), $is_return = 0, $is_sef = 1 ) {

		$href_cart_params = array (
			array ( 'name' => 't',          'value' => 'cart' ),
			array ( 'name' => 'action',     'value' => ''     ),
			array ( 'name' => 'id_product', 'value' => 0      ),
			array ( 'name' => 'id_item',    'value' => 0      ),
			array ( 'name' => 'qty',        'value' => 0      )
		);

		$this->href_params = $href_cart_params;

		if ($is_sef) {

			return parent::href_sef( 'cart.html?action={action}&id_product={id_product}&id_item={id_item}&qty={qty}', $vars, $is_return );

		} else {

			return parent::href( $vars, $is_return );

		}
	}
};

?>