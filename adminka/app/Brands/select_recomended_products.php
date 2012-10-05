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

	$id_brand = 0;

	if (isset($_REQUEST['id_brand'])) {

		$id_brand = $_REQUEST['id_brand'];

	} else {

		if (isset($request->params->id_brand)) {

			$id_brand = $request->params->id_brand;

		}
	}

	// Проверяю, что параметр id_brand существует

	if ( $id_brand ) {

		$where = ' id_brand = ' . $id_brand;

	}

	//

	$brand_dalc = new Brand_DALC();

	$recomended_products = $brand_dalc->GetRecomendedProducts( $id_brand, 0 );

	$recomended_products_qty = count($recomended_products);

	//

	$array = array();

	if (isset($recomended_products)) {

		foreach ($recomended_products as $recomended_product) {

			array_push($array, $recomended_product);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $recomended_products_qty,
	    "items"  => $array
	));

?>