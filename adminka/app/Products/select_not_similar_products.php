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

	$id_product = 0;

	if (isset($_REQUEST['id_product'])) {

		$id_product = $_REQUEST['id_product'];

	} else {

		if (isset($request->params->id_product)) {

			$id_product = $request->params->id_product;

		}
	}

	//

	$dalc = new DALC();

	$items = $dalc->SQL_SelectList('product_relations', NULL, ' id_product = ' . $id_product );

	$ids = $id_product;
	$i   = 0;

	if (isset($items)) {

		foreach ($items as $item) {
	
			$ids .= ', ' . $item['id_accessory'];
	
		}
	}

	//

	$where = ' id NOT IN (' . $ids . ') ';

	$product_dalc = new Product_DALC(); 

	$products_qty = $product_dalc->Count($where);

	$products = $product_dalc->GetItemsLimit(array("label", "price", "articul"), $where, $start, $limit);

	//

	$array = array();

	if (isset($products)) {

		foreach ($products as $product) {

			array_push($array, $product);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $products_qty,
	    "items"  => $array
	));

?>