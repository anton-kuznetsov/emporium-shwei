<?php

class UI {

	protected $href_params = NULL;

	// Физическое расположение файла класса
	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/_base/';

	}

	//--------------------------------------------------------------------------
	//

	public function href ( $vars = array(), $is_return = 0 ) {

		global $site_root;

		$res = '';

		//

		foreach ($this->href_params as $p) {

			if ( array_key_exists($p['name'], $vars) ) {
				$res .= ( $res == '' ? '?' : '&') . $p['name'] . '=' . urlencode( $vars[$p['name']] );
			} else {
				$res .= ( $res == '' ? '?' : '&') . $p['name'] . '=' . urlencode( $p['value'] );
			}
		}	

		$res = $site_root . 'index.php' . $res;

		//

		if ( $is_return ) {
			return $res;
		} else {
			echo $res;
		}
	}

};

?>