<?php

class Brand_UI extends UI {

	protected $folder_class = '';

	protected $slider = NULL;

	protected $data = array();
	
	protected $href_brand_params = NULL;

	function __construct( $data = array() ) {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/brand/';

		$this->data = $data;

		$this->href_brand_params = array (
			array ( 'name' => 't',        'value' => $_REQUEST ['t']        ),
			array ( 'name' => 'id_brand', 'value' => $_REQUEST ['id_brand'] )
		);

	}

	//--------------------------------------------------------------------------
	//

	public function render() {

		global $site_root;

		$brand_bllc = new Brand_BLLC();

		$data = $brand_bllc->GetData( $this->data['id_brand'] );

		$html_title_page = 
			'<span class="color">' .
			preg_replace("/(\s+\S+)+$/", "", $data['label']) .
			'</span>' . preg_replace("/^(\S+)((\s+)|($))/", " ", $data['label']);

		include $this->folder_class . 'tmp/default.tmp';

	}

	//--------------------------------------------------------------------------
	//

	public function href( $vars = array(), $is_return = 0 ) {

		$href_brand_params = array (
			array ( 'name' => 't',        'value' => 'brand' ),
			array ( 'name' => 'id_brand', 'value' => 0         )
		);

		$this->href_params = $href_brand_params;

// 		return parent::href( $vars, $is_return );
		
		return parent::href_sef( 'brands/{id_brand}.html', $vars, $is_return );

	}
};

?>