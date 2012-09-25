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

	$id_brand = 0;

	if (isset($_REQUEST['id_brand'])) {

		$id_brand = $_REQUEST['id_brand'];

	} else {

		if (isset($request->params->id_brand)) {

			$id_brand = $request->params->id_brand;

		}
	}

	//

	$dalc = new DALC();

	$items = $dalc->SQL_SelectList('brand_recomended_products', NULL, ' id_brand = ' . $id_brand );

	$ids = '-1';
	$i   = 0;

	if (isset($items)) {

		foreach ($items as $item) {
	
			$ids .= ', ' . $item['id_product'];
	
		}
	}

	//

	$where = ' id NOT IN (' . $ids . ') AND id_brand = ' . $id_brand . ' ';

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