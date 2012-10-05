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

	$item['id'] = 0;

	if (isset($_REQUEST['id'])) {

		$item['id'] = $_REQUEST['id'];

	} else {

		if (isset($request->params->id)) {

			$item['id'] = $request->params->id;

		}
	}

	//

	$item['page_title'] = '';

	if (isset($_REQUEST['page_title'])) {

		$item['page_title'] = $_REQUEST['page_title'];

	} else {

		if (isset($request->params->page_title)) {

			$item['page_title'] = $request->params->page_title;

		}
	}

	$item['page_title'] = addslashes($item['page_title']);

	//

	$item['meta_desc'] = '';

	if (isset($_REQUEST['meta_desc'])) {

		$item['meta_desc'] = $_REQUEST['meta_desc'];

	} else {

		if (isset($request->params->meta_desc)) {

			$item['meta_desc'] = $request->params->meta_desc;

		}
	}

	$item['meta_desc'] = addslashes($item['meta_desc']);

	//

	$item['meta_key'] = '';

	if (isset($_REQUEST['meta_key'])) {

		$item['meta_key'] = $_REQUEST['meta_key'];

	} else {

		if (isset($request->params->meta_key)) {

			$item['meta_key'] = $request->params->meta_key;

		}
	}

	$item['meta_key'] = addslashes($item['meta_key']);

	//

	$dalc = new DALC();

	$dalc->SQL_UpdateItems(
		'brands',
		array( $item ),
		array( 'page_title', 'meta_desc', 'meta_key' )
	);

	echo json_encode(Array(
		"success" => "true"
	));

?>