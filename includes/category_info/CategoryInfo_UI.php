<?php

class CategoryInfo_UI {

	protected $folder_class = '';

	protected $data = array();

	//--------------------------------------------------------------------------
	//

	function __construct( $data = array() ) {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/category_info/';

		$this->data = $data;

	}

	//--------------------------------------------------------------------------
	//

	public function render() {

		$category_bllc = new Category_DALC();

		$data = $category_bllc->GetCategory( $this->data['id_category'] );

		//

		$brand_label = '';

		if ( $this->data['id_brand'] > 0 ) {

	  		$brand_bllc = new Brand_DALC();

			$brand = $brand_bllc->GetBrand( $this->data['id_brand'] );

			$brand_label = $brand['label'];

		}

		//

		$html_title_page = 
			'<span class="color">' .
			preg_replace("/(\s+\S+)+$/", "", $data['full_label']) .
			'</span>' . preg_replace("/^(\S+)((\s+)|($))/", " ", $data['full_label'] . ' ' . $brand_label);

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>