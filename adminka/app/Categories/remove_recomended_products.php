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

	$item['id'] = '0';

	if (isset($_REQUEST['id'])) {

		$item['id'] = $_REQUEST['id'];

	} else {

		if (isset($request->params->id)) {

			$item['id'] = $request->params->id;

		}
	}

	//

	$item['ids'] = '-1';

	if (isset($_REQUEST['ids'])) {

		$item['ids'] = $_REQUEST['ids'];

	} else {

		if (isset($request->params->ids)) {

			$item['ids'] = $request->params->ids;

		}
	}

	//

	$dalc = new DALC();

	$dalc->SQL_DeleteItems(
		'category_recomended_products',
		' id_category = ' . $item['id'] . ' AND id_product IN (' . $item['ids'] . ') '
	);

	echo json_encode(Array(
		"success" => "true"
	));

?>