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

	$id_order = 0;

	if (isset($_REQUEST['id_order'])) {

		$id_order = $_REQUEST['id_order'];

	} else {

		if (isset($request->params->id_order)) {

			$id_order = $request->params->id_order;

		}
	}

	// Проверяю, что параметр id_brand существует

	if ( $id_order ) {

		$where = ' id_order = ' . $id_order;

	}

	//

	$order_dalc = new Order_DALC();

	$order_items = $order_dalc->GetOrderItems( $id_order );

	$order_items_qty = count ( $order_items );

	$array = array();

	if (isset($order_items)) {

		foreach ($order_items as $order_item) {

			array_push($array, $order_item);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $order_items_qty,
	    "items"  => $array
	));

?>