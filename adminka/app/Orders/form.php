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

	$id = 0;

	if (isset($_REQUEST['id'])) {

		$id = $_REQUEST['id'];

	} else {

		if (isset($request->params->id)) {

			$id = $request->params->id;

		}
	}

	//

	$order_dalc = new Order_DALC();

	$order = $order_dalc->GetOrder($id);

	echo json_encode(Array(
	    "success" => "true",
	    "total"   => isset( $order ) ? 1 : 0,
	    "data"    => $order
	));

?>