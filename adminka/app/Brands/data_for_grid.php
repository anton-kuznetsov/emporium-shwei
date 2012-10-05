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

	$brand_dalc = new Brand_DALC();

	$brands_qty = $brand_dalc->Count();

	$brands = $brand_dalc->GetItemsLimit(
		array(
			"label",
			"company",
			"country"
		),
		$where,
		$start, $limit
	);

	$array = array();

	foreach ($brands as $brand) {

		array_push($array, $brand);

	}

	//

	echo json_encode(array(
	    "totalCount" => $brands_qty,
	    "items"      => $array
	));

?>