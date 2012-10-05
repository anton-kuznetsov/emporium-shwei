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

	$send_message_dalc = new SendMessage_DALC();

	$send_messages = $send_message_dalc->GetItemsLimit(array("fio", "subject", "status", "dt"), $where, $start, $limit);

	$array = array();

	$send_messages_qty = 0;

	if (isset($send_messages)) {

		$send_messages_qty = count( $send_messages );

		foreach ($send_messages as $send_message) {
	
			array_push($array, $send_message);
	
		}
	}

	echo json_encode(Array(

	    "totalCount" => $send_messages_qty,
	    "items"      => $array

	));

?>