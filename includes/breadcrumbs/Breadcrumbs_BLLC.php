<?php

class Breadcrumbs_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/breadcrumbs/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetDataByCategory( $id_category ) {

		// Запрос на получение данных

		$breadcrumbs_dalc = new Breadcrumbs_DALC();

		$items = $breadcrumbs_dalc->GetItemsByCategory($id_category);

		return $items;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetDataByProduct( $id_product ) {

		// Запрос на получение данных

		$breadcrumbs_dalc = new Breadcrumbs_DALC();

		$items = $breadcrumbs_dalc->GetItemsByProduct($id_product);

		return $items;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetDataByArticleCategory( $id_article_category ) {

		// Запрос на получение данных

		$article_category_dalc = new ArticleCategory_DALC();

		$article_category = $article_category_dalc->GetArticleCategory($id_article_category);
		
		$items = array ();
		
		$items[$article_category['level']] = array ();

		$items[$article_category['level']]['id'] = $article_category['id'];
		$items[$article_category['level']]['href'] = ArticleCategory_UI::href(array('id' => $article_category['id']), 1);
		$items[$article_category['level']]['label'] = $article_category['label'];
		$items[$article_category['level']]['is_last'] = 1;

		while ( $article_category['parent'] > 0 || $article_category['level'] > 1 ) {

			$article_category = $article_category_dalc->GetArticleCategory($article_category['parent']);

			$items[$article_category['level']] = array ();

			$items[$article_category['level']]['id'] = $article_category['id'];
			$items[$article_category['level']]['href'] = ArticleCategory_UI::href(array('id' => $article_category['id']), 1);
			$items[$article_category['level']]['label'] = $article_category['label'];
			$items[$article_category['level']]['is_last'] = 0;

		}

		return $items;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetDataByArticle( $id_article ) {

		// Запрос на получение данных

		$article_dalc = new Article_DALC();

		$article = $article_dalc->GetArticle($id_article);

		//

		$items = array ();

		if ( $article['id_article_category'] > 0 ) {

			$article_category_dalc = new ArticleCategory_DALC();

			$article_category = array ();

			$article_category['parent'] = $article['id_article_category'];
			$article_category['level']  = 2;

			while ( $article_category['parent'] > 0 || $article_category['level'] > 1 ) {

				$article_category = $article_category_dalc->GetArticleCategory($article_category['parent']);

				$items[$article_category['level']] = array ();

				$items[$article_category['level']]['id']      = $article_category['id'];
				$items[$article_category['level']]['href']    = ArticleCategory_UI::href(array('id' => $article_category['id']), 1);
				$items[$article_category['level']]['label']   = $article_category['label'];
				$items[$article_category['level']]['is_last'] = 0;

			}
		}

		$items_qty = count( $items ) + 1;

		$items[$items_qty] = array ();

		$items[$items_qty]['id']      = $article['id'];
		$items[$items_qty]['href']    = Article_UI::href(array('id' => $article['id']), 1);
		$items[$items_qty]['label']   = $article['title'];
		$items[$items_qty]['is_last'] = 1;

		return $items;

	}
};

?>