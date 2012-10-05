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

	$id_category = 0;

	if (isset($_REQUEST['id_category'])) {

		$id_category = $_REQUEST['id_category'];

	} else {

		if (isset($request->params->id_category)) {

			$id_category = $request->params->id_category;

		}
	}

	//

	$dalc = new DALC();

	$items = $dalc->SQL_SelectList('category_recomended_products', NULL, ' id_category = ' . $id_category );

	$ids = '-1';
	$i   = 0;

	if (isset($items)) {

		foreach ($items as $item) {
	
			$ids .= ', ' . $item['id_product'];
	
		}
	}

	//

	$where = ' id_product NOT IN (' . $ids . ') ';

	$category_dalc = new Category_DALC(); 

	$categories = $category_dalc->GetProducts( $id_category, $where );
	
	$categories_qty = count( $categories );

	//

	$array = array();

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