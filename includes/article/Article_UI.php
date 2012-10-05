<?php

class Article_UI extends UI {

	protected $folder_class = '';

	protected $data = array();

	function __construct( $data = array() ) {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/article/';

		$this->data = $data;

		$this->href_params = array (
			array ( 'name' => 't',          'value' => $_REQUEST ['t'] ),
			array ( 'name' => 'id_article', 'value' => $_REQUEST ['id_article'] ),
		);

	}

	//--------------------------------------------------------------------------
	//

	public function render() {

		$article_bllc = new Article_BLLC();

		$data = $article_bllc->GetArticle( $this->data['id_article'] );

		//

		$html_title_page = 
			'<span class="color">' .
			preg_replace("/(\s+\S+)+$/", "", $data['title']) .
			'</span>' . preg_replace("/^(\S+)((\s+)|($))/", " ", $data['title']);

		//

		include $this->folder_class . 'tmp/default.tmp';

	}

	//--------------------------------------------------------------------------
	//

	public function href( $vars = array(), $is_return = 0 ) {

		$this->href_params = array (
			array ( 'name' => 't',  'value' => 'article' ),
			array ( 'name' => 'id', 'value' => 0         ),
		);

		return parent::href( $vars, $is_return );

	}
};

?>