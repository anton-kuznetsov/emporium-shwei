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

	$order = $order_dalc->GetOrder( $id_order );

// 	echo json_encode(Array(
// 
// 	    "success" => "true",
// 	    "data"    => $order
// 
// 	));

	echo '{success:true,data:{"label":"Cool","type":"ComboBox","value_type":"eet"}}';

// 	echo json_encode( $order );

?>