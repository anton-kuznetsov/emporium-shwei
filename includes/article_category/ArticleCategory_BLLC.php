<?php

class ArticleCategory_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/article_category/';

	}

	//--------------------------------------------------------------------------
	//

	public function GetArticleCategory ( $id = 0 ) {

		// Запрос на получение данных

		$article_category_dalc = new ArticleCategory_DALC();

		$data = $article_category_dalc->GetArticleCategory( $id );

		// Список статей

		$article_dalc = new Article_DALC();

		$data['articles'] = $article_dalc->GetItemsByCategory( $id );

		//

		return $data;

	}

};

?>