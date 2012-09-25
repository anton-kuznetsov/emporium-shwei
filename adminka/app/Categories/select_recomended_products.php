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

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id_category', 'type' => 'int' ),
		),
		$request
	);

	//

	$where = '';

	// Проверяю, что параметр уществует

	if ( $item['id_category'] ) {

		$where = ' id_category = ' . $item['id_category'];

	}

	//

	$category_dalc = new Category_DALC();

	$recomended_products = $category_dalc->GetRecomendedProducts( $item['id_category'], 0 );

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