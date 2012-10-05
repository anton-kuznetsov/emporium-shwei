<?php

class CategoryProducts_UI extends UI {

	protected $folder_class = '';

	protected $slider = NULL;

	protected $data = array();

	function __construct( $data = array() ) {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/category_products/';

		$this->data = $data;

		$this->href_params = array (
			array ( 'name' => 't',           'value' => $_REQUEST ['t']           ),
			array ( 'name' => 'id_category', 'value' => $_REQUEST ['id_category'] ),
			array ( 'name' => 'id_brand',    'value' => $_REQUEST ['id_brand']    ),
			array ( 'name' => 'order',       'value' => $_REQUEST ['order']       ),
			array ( 'name' => 'p',           'value' => $_REQUEST ['p']           ),
			array ( 'name' => 'limit',       'value' => $_REQUEST ['limit']       ),
		);

	}

	//--------------------------------------------------------------------------
	//

	public function render() {

		$category_products_bllc = new CategoryProducts_BLLC();

		$data = $category_products_bllc->GetItems( $this->data );

		//
		$limits = array (9, 15, 30);

		//
		$page_qty = ceil($data['product_qty'] / $this->data['limit']);

		//
		$sorts = array ();
		$sorts[1]['name']  = 'date';
		$sorts[1]['label'] = 'Дате публикации';
		$sorts[2]['name']  = 'name';
		$sorts[2]['label'] = 'Наименованию';
		$sorts[3]['name']  = 'price';
		$sorts[3]['label'] = 'Цене';

		include $this->folder_class . 'tmp/default.tmp';

	}

	//--------------------------------------------------------------------------
	//

	public function href( $vars = array(), $is_return = 0 ) {

		if ( is_null($this->href_params) ) {

			$this->href_params = array (
				array ( 'name' => 't',           'value' => 'category' ),
				array ( 'name' => 'id_category', 'value' => 0          ),
				array ( 'name' => 'id_brand',    'value' => 0          ),
				array ( 'name' => 'order',       'value' => ''         ),
				array ( 'name' => 'p',           'value' => 1          ),
				array ( 'name' => 'limit',       'value' => 9          ),
			);
		}

// 		return parent::href( $vars, $is_return );

		return parent::href_sef( 'product_categories/{id_category}.html?id_brand={id_brand}&order={order}&p={p}&limit={limit}', $vars, $is_return );

	}
};

?>