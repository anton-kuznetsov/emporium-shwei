<?php

class Breadcrumbs_UI {

	protected $folder_class = '';

	const BC_TYPE_CATEGORY         = 1;
	const BC_TYPE_PRODUCT          = 2;
	const BC_TYPE_INFO             = 3;
	const BC_TYPE_ARTICLE_CATEGORY = 4;
	const BC_TYPE_ARTICLE          = 5;

	protected $bc_type = BC_TYPE_CATEGORY; 
	protected $data = NULL;

	//--------------------------------------------------------------------------
	//

	function __construct( $bc_type = BC_TYPE_CATEGORY, $data = NULL ) {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/breadcrumbs/';
		$this->bc_type = $bc_type;
		$this->data = $data;

	}

	//--------------------------------------------------------------------------
	//

	public function render() {

		$breadcrumbs_bllc = new Breadcrumbs_BLLC();

		switch ($this->bc_type) {

			case Breadcrumbs_UI::BC_TYPE_CATEGORY :
				$data = $breadcrumbs_bllc->GetDataByCategory( $this->data['id_category'] );
				include $this->folder_class . 'tmp/category.tmp';
				break;

			case Breadcrumbs_UI::BC_TYPE_PRODUCT :
				$data = $breadcrumbs_bllc->GetDataByProduct( $this->data['id_product'] );
				include $this->folder_class . 'tmp/product.tmp';
				break;

			case Breadcrumbs_UI::BC_TYPE_ARTICLE_CATEGORY :
				$data = $breadcrumbs_bllc->GetDataByArticleCategory( $this->data['id_article_category'] );
				include $this->folder_class . 'tmp/article_category.tmp';
				break;

			case Breadcrumbs_UI::BC_TYPE_ARTICLE :
				$data = $breadcrumbs_bllc->GetDataByArticle( $this->data['id_article'] );
				include $this->folder_class . 'tmp/article.tmp';
				break;

		}
	}
};

?>