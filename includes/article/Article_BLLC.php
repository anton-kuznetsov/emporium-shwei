<?php

class Article_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/article/';

	}

	//--------------------------------------------------------------------------
	//

	public function GetArticle ( $id = 0 ) {

		// Запрос на получение данных

		$article_dalc = new Article_DALC();

		$data = $article_dalc->GetArticle( $id );

		//

		return $data;

	}

};

?>