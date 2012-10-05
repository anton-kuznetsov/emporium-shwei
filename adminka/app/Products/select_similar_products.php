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

	// Проверяю, что параметр id_product существует

	if ( $id_product ) {

		$where = ' id_product = ' . $id_product;

	}

	//

	$product_dalc = new Product_DALC();

	$similar_products = $product_dalc->GetAccessories($id_product, 0, 0);

	$similar_products_qty = count($similar_products);

	//

	$array = array();

	if (isset($similar_products)) {

		foreach ($similar_products as $similar_product) {

			array_push($array, $similar_product);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $similar_products_qty,
	    "items"  => $array
	));

?>