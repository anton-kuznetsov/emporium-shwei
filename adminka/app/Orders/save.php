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

	$item = array();

	$request = new Request(array('restful' => true));

	//

	$item['id'] = 0;

	if (isset($_REQUEST['id'])) {

		$item['id'] = $_REQUEST['id'];

	} else {

		if (isset($request->params->id)) {

			$item['id'] = $request->params->id;

		}
	}

	//

	$item['fio'] = '';

	if (isset($_REQUEST['fio'])) {

		$item['fio'] = $_REQUEST['fio'];

	} else {

		if (isset($request->params->fio)) {

			$item['fio'] = $request->params->fio;

		}
	}

	$item['fio'] = addslashes($item['fio']);

	//

	$item['email'] = '';

	if (isset($_REQUEST['email'])) {

		$item['email'] = $_REQUEST['email'];

	} else {

		if (isset($request->params->email)) {

			$item['email'] = $request->params->email;

		}
	}

	$item['email'] = addslashes($item['email']);

	//

	$item['phone'] = '';

	if (isset($_REQUEST['phone'])) {

		$item['phone'] = $_REQUEST['phone'];

	} else {

		if (isset($request->params->phone)) {

			$item['phone'] = $request->params->phone;

		}
	}

	$item['phone'] = addslashes($item['phone']);

	//

	$item['dt'] = '';

	if (isset($_REQUEST['dt'])) {

		$item['dt'] = $_REQUEST['dt'];

	} else {

		if (isset($request->params->dt)) {

			$item['dt'] = $request->params->dt;

		}
	}

	// Преобразование даты

	$d = explode(".", $item['dt']); 
    
    $dt = new DateTime(); 
    $dt->setDate($d[2], $d[1], $d[0]);
    $dt->setTime(0, 0, 0);
    
    $item['dt'] = $dt->format('Y/m/d H:i:s'); 

	//

	$dalc = new DALC();

	$dalc->SQL_UpdateItems(
		'orders',
		array( $item ),
		array( 'fio', 'email', 'phone', 'dt' )
	);

	echo json_encode(Array(
		"success" => "true"
	));

?>