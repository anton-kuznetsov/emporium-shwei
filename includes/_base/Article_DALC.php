<?php

class Article_DALC extends DALC {

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

	public function GetArticle( $id_article ) {

		global $site_root;

		$data = $this->SQL_SelectItem('articles', NULL, $id_article );

		return $data;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		global $site_root;

		$items = $this->SQL_SelectAll('articles', NULL);

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

		$items = $this->SQL_SelectAllByIds('articles', $ids);

		//

		return $items;

	}
	
	//--------------------------------------------------------------------------
	// 

	public function GetItemsByCategory($id_article_category = 0) {

		$items = $this->SQL_SelectList(
			'articles',
			null,
			'id_article_category = ' . $id_article_category
		);

		//

		return $items;

	}
};

?>