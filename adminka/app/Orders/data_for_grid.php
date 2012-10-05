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

	//

	$where = '';

	$order_dalc = new Order_DALC();

	$orders_qty = $order_dalc->Count();

	$orders = $order_dalc->GetItemsLimit(array("fio", "email", "phone", "dt", "amount_received"), $where, $start, $limit);

	$array = array();

	foreach ($orders as $order) {

		$order_items = $order_dalc->GetOrderItems( $order["id"] );

		$order_total = 0;

		if ( count($order_items) ) {

			foreach ($order_items as $order_item) {

				$order_total += $order_item["subtotal"];

			}
		}

		$order["total"] = $order_total;

		array_push($array, $order);

	}

	echo json_encode(Array(

	    "totalCount" => $orders_qty,
	    "items"      => $array

	));

?>