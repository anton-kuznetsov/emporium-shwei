<?php

class SearchResults_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/search_results/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetData( $config = array() ) {

		// Запрос на получение данных

		$search_results_dalc = new SearchResults_DALC();

		$data = $search_results_dalc->GetItems( $config['q'], $config['p'], $config['limit'], $config['order'] );

		return $data;

	}

};

?>