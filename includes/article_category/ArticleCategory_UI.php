<?php

class ArticleCategory_UI extends UI {

	protected $folder_class = '';

	protected $data = array();
	
	function __construct( $data = array() ) {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/article_category/';

		$this->data = $data;

		$this->href_params = array (
			array ( 'name' => 't',                   'value' => $_REQUEST ['t'] ),
			array ( 'name' => 'id_article_category', 'value' => $_REQUEST ['id_article_category'] ),
		);

	}

	//--------------------------------------------------------------------------
	//

	public function render() {

		$article_category_bllc = new ArticleCategory_BLLC();

		$data = $article_category_bllc->GetArticleCategory( $this->data['id_article_category'] );

		//

		$html_title_page = 
			'<span class="color">' .
			preg_replace("/(\s+\S+)+$/", "", $data['label']) .
			'</span>' . preg_replace("/^(\S+)((\s+)|($))/", " ", $data['label']);

		//

		include $this->folder_class . 'tmp/default.tmp';

	}

	//--------------------------------------------------------------------------
	//

	public function href( $vars = array(), $is_return = 0 ) {

		$this->href_params = array (
			array ( 'name' => 't',  'value' => 'article_category' ),
			array ( 'name' => 'id', 'value' => 0                  ),
		);

		return parent::href( $vars, $is_return );

	}
};

?>