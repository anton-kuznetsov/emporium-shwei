<?php

class Article_DALC extends DALC {

	protected $folder_class = '';

	private $TABLE_NAME = 'articles';

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

		$data = $this->SQL_SelectItem($this->TABLE_NAME, NULL, $id_article );

		return $data;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		global $site_root;

		$items = $this->SQL_SelectAll($this->TABLE_NAME, NULL);

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

		$items = $this->SQL_SelectAllByIds($this->TABLE_NAME, $ids);

		//

		return $items;

	}
	
	//--------------------------------------------------------------------------
	// 

	public function GetItemsByCategory($id_article_category = 0) {

		$items = $this->SQL_SelectList(
			$this->TABLE_NAME,
			null,
			'id_article_category = ' . $id_article_category
		);

		//

		return $items;

	}

	//--------------------------------------------------------------------------
	//

	public function Count() {

		$count = $this->SQL_SelectCount( $this->TABLE_NAME );

		return $count;

	}

	//--------------------------------------------------------------------------
	//

	public function GetItemsLimit($fields = NULL, $where = '', $start = 0, $limit = 0) {

		$items = $this->SQL_SelectList($this->TABLE_NAME, $fields, $where, '', $limit, $start);

		return $items;

	}

};

?>