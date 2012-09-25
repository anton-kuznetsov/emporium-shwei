<?php

class ContentSlider_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/content_slider/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems( $config = array() ) {

		// Запрос на получение данных

		$content_slider_dalc = new ContentSlider_DALC();

		$items = $content_slider_dalc->GetItems( $config['id_category'], $config['id_brand'] );

		return $items;

	}

};

?>