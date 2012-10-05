<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$start   = isset($_REQUEST['start'])  ? $_REQUEST['start']  : 0;
	$limit   = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 25;
	$sort    = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : '';
	$dir     = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'ASC';
	$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;

	//

	$item = array();

	$request = new Request(array('restful' => true));

	//

	$item['label'] = '';

	if (isset($_REQUEST['label'])) {

		$item['label'] = $_REQUEST['label'];

	} else {

		if (isset($request->params->label)) {

			$item['label'] = $request->params->label;

		}
	}

	$item['label'] = addslashes($item['label']);

	//

	$item['parent'] = 0;

	if (isset($_REQUEST['parent'])) {

		$item['parent'] = $_REQUEST['parent'];

	} else {

		if (isset($request->params->parent)) {

			$item['parent'] = $request->params->parent;

		}
	}

	//

	$dalc = new DALC();

	$product_category = $dalc->SQL_CreateItem(
		'categories',
		array(
			'label'  => $item['label'],
			'parent' => $item['parent']
		)
	);

	//

	if ( $product_category ) {

		echo json_encode(Array(
			"success" => "true",
			"id"      => $product_category["id"]
		));

	} else {

		echo json_encode(Array(
			"success" => "false",
			"msg"     => ""
		));

	}

?>