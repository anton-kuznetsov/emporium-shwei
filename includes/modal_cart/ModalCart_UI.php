<?php

class ModalCart_UI {

	protected $folder_class = '';
	protected $slider       = NULL;

	// В модуле применяется вывод модальных форм
	public $is_use_modal = 1;

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/modal_cart/';

	}

	//
	public function render() {

		$modal_cart_bllc = new ModalCart_BLLC();

		$data = $modal_cart_bllc->GetData();

		include $this->folder_class . 'tmp/default.tmp';

	}

	// Вывод наполнения модальных форм и скриптов управления
	public function render_modals() {

		global $site_root;

		$modal_cart_bllc = new ModalCart_BLLC();

		$data = $modal_cart_bllc->GetData();

		include $this->folder_class . 'tmp/modal.tmp';

	}

};

?>