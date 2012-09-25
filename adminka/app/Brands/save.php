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

	$item['company'] = '';

	if (isset($_REQUEST['company'])) {

		$item['company'] = $_REQUEST['company'];

	} else {

		if (isset($request->params->company)) {

			$item['company'] = $request->params->company;

		}
	}

	$item['company'] = addslashes($item['company']);

	//

	$item['country'] = '';

	if (isset($_REQUEST['country'])) {

		$item['country'] = $_REQUEST['country'];

	} else {

		if (isset($request->params->country)) {

			$item['country'] = $request->params->country;

		}
	}

	$item['country'] = addslashes($item['country']);

	//

	$item['site'] = '';

	if (isset($_REQUEST['site'])) {

		$item['site'] = $_REQUEST['site'];

	} else {

		if (isset($request->params->site)) {

			$item['site'] = $request->params->site;

		}
	}

	$item['site'] = addslashes($item['site']);

	//

	$item['description'] = '';

	if (isset($_REQUEST['description'])) {

		$item['description'] = $_REQUEST['description'];

	} else {

		if (isset($request->params->description)) {

			$item['description'] = $request->params->description;

		}
	}

	$item['description'] = addslashes($item['description']);

	//

	$dalc = new DALC();

	$dalc->SQL_UpdateItems(
		'brands',
		array( $item ),
		array( 'label', 'company', 'country', 'site', 'description' )
	);

	echo json_encode(Array(
		"success" => "true"
	));

?>