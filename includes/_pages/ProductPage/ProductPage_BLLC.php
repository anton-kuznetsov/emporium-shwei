<?php

class ProductPage_BLLC {

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/_pages/ProductPage/';

	}

	//--------------------------------------------------------------------------
	//

	public function CountingShow( $id_product ) {

		$dalc = new DALC();

		$dalc->SQL_CreateItem( 'product_footer_viewed_items', array( 'session_id' => session_id(), 'id_product' => $id_product, 'datetime' => date( 'Y-m-d H:i:s' ) ) );

	}

	//--------------------------------------------------------------------------
	//

	public function CountingView( $id_product ) {

		$product_dalc = new Product_DALC();

		$product = $product_dalc->GetProduct( $id_product );

		$product['count_show']++;

		$product_dalc->SQL_UpdateItems( 'products', array( $product ), array( 'count_show' ) );

	}

	//--------------------------------------------------------------------------
	//

	public function CountingBuy( $id_product ) {

		$product_dalc = new Product_DALC();

		$product = $product_dalc->GetProduct( $id_product );

		$product['count_buy']++;

		$product_dalc->SQL_UpdateItems( 'products', array( $product ), array( 'count_buy' ) );

	}

};

?>