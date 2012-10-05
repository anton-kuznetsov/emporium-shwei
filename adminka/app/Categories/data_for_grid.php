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

	$where = '';

	$category_dalc = new Category_DALC();

	$categories_qty = $category_dalc->Count();

	$categories = $category_dalc->GetItemsLimit(
		array(
			"label",
			"level",
			"parent"
		),
		$where,
		$start, $limit
	);

	$array = array();

	foreach ($categories as $category) {

		array_push($array, $category);

	}

	echo json_encode(Array(
	    "totalCount" => $categories_qty,
	    "items"      => $array
	));

?>