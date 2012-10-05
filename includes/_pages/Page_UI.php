<?php

class Page_UI {

	protected $modules = null;

	protected $folder_class = '';

	// Данные страницы

	protected $head = array ();

	//

	function __construct( $modules = array() ) {

		global $folder_root;

		$this->modules = $modules;
		$this->folder_class = $folder_root . '/includes/_pages/';

		$this->head = array (
			'title'    => '',
			'keywords' => '',
			'desc'     => '',
		);

	}

	public function render() {

		echo '<div></div>';

	}

};

?>