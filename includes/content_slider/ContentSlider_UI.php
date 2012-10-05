<?php

class ContentSlider_UI {

	protected $folder_class = '';

	protected $slider = NULL;
	
	protected $data = array();

	function __construct( $data = array() ) {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/content_slider/';

		$this->data = $data;

	}

	public function render() {

		$content_slider_bllc = new ContentSlider_BLLC();

		$data = $content_slider_bllc->GetItems( $this->data );

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>