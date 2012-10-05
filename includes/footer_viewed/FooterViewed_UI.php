<?php

class FooterViewed_UI {

	protected $folder_class = '';

	protected $title = '<span><span class="color">Заголовок</span></span>';

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/footer_viewed/';

	}

	public function render() {

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>