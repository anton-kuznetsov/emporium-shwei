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

	$category_dalc = new Category_DALC();

	$categories_qty = $category_dalc->Count($where);

	$categories = $category_dalc->GetItemsLimit(array("label", "parent", "level"), $where, $start, $limit);

	$array = array();

	// Первый "пустой" элемент списка

	array_push(
		$array,
		array(
			"id" => 0,
			"label" => 'Выберите категорию...',
			"parent" => 0,
			"level" => 1
		)
	);

	//

	if (isset($categories)) {

		foreach ($categories as $category) {

			array_push($array, $category);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $categories_qty,
	    "items"  => $array
	));

?>