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
		'categories',
		' id IN (' . $item['ids'] . ') '
	);

	echo json_encode(Array(
		"success" => "true"
	));

?>