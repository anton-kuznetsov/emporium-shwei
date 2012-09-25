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

	$request = new Request(array('restful' => true));

	//

	$where = '';

	//

	$brand_dalc = new Brand_DALC();

	$brands_qty = $brand_dalc->Count($where);

	$brands = $brand_dalc->GetItemsLimit(array("label"), $where, $start, $limit);

	$array = array();

	// Первый "пустой" элемент списка

	array_push(
		$array,
		array(
			"id" => 0,
			"label" => 'Выберите бренд...'
		)
	);

	//

	if (isset($brands)) {

		foreach ($brands as $brand) {

			array_push($array, $brand);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $brands_qty,
	    "items"  => $array
	));

?>