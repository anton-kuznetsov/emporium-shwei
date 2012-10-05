<?php

class ArticleCategory_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/_base/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetArticleCategory( $id_article_category ) {

		global $site_root;

		$data = $this->SQL_SelectItem('article_categories', NULL, $id_article_category );

		return $data;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		global $site_root;

		$items = $this->SQL_SelectAll('article_categories', NULL);

		//

		foreach ($items as $item) {

			$id = $item['id'];

		}

		//

		return $items;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItemsByIds($ids) {

		global $site_root;

		$items = $this->SQL_SelectAllByIds('article_categories', $ids);

		//

		foreach ($items as $item) {

			$id = $item['id'];

		}

		//

		return $items;

	}
};

?>