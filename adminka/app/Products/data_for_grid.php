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

	$product_dalc = new Product_DALC();
	
	$product_category_dalc = new Category_DALC();

	$products_qty = $product_dalc->Count($where);

	$products = $product_dalc->GetItemsLimit(array("label", "price", "articul", "id_category"), $where, $start, $limit);

	$array = array();

	if (isset($products)) {

		foreach ($products as $product) {

			$category = $product_category_dalc->GetCategory( $product["id_category"] );
			
			if (
				count($category) &&
				array_key_exists('label', $category)
			) {
	
				$product['category'] = $category['label'];
	
			} else {
	
				$product['category'] = '';
	
			}

			array_push($array, $product);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $products_qty,
	    "items"  => $array
	));

?>