<?php

class InfoPageContent_UI {

	protected $folder_class = '';

	protected $current_page_label = 'default';

	function __construct( $data = array () ) {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/info_page_content/';

		if ( array_key_exists('page_label', $data) ) {

			$this->current_page_label = $data['page_label'];

		}

	}

	public function render() {

		//$info_page_content_bllc = new InfoPageContent_BLLC();

		include $this->folder_class . 'tmp/' . $this->current_page_label . '.tmp';

	}

};

?>