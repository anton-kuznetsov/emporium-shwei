<?php



class Product_UI extends UI {



	protected $folder_class = '';



	protected $slider = NULL;



	protected $data = array();

	

	protected $href_product_params = NULL;



	function __construct( $data = array() ) {



		global $folder_root;



		parent::__construct();



		$this->folder_class = $folder_root . '/includes/product/';



		$this->data = $data;



		$this->href_product_params = array (

			array ( 'name' => 't',          'value' => $_REQUEST ['t']          ),

			array ( 'name' => 'id_product', 'value' => $_REQUEST ['id_product'] )

		);



	}



	//--------------------------------------------------------------------------

	//



	public function render() {



		$product_bllc = new Product_BLLC();



		$data = $product_bllc->GetData( $this->data['id_product'] );



		$html_title_page = 

			'<span class="color">' .

			preg_replace("/(\s+\S+)+$/", "", $data['label']) .

			'</span>' . preg_replace("/^(\S+)((\s+)|($))/", " ", $data['label']);



		include $this->folder_class . 'tmp/default.tmp';



	}

	//--------------------------------------------------------------------------
	//

	public function href( $vars = array(), $is_return = 0 ) {

		$href_product_params = array (

			array ( 'name' => 't',          'value' => 'product' ),

			array ( 'name' => 'id_product', 'value' => 0         )

		);

		$this->href_params = $href_product_params;

// 		return parent::href( $vars, $is_return );

		return parent::href_sef( 'products/{id_product}.html', $vars, $is_return );

	}

};



?>