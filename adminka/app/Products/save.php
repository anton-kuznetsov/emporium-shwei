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

	$item['articul'] = '';

	if (isset($_REQUEST['articul'])) {

		$item['articul'] = $_REQUEST['articul'];

	} else {

		if (isset($request->params->articul)) {

			$item['articul'] = $request->params->articul;

		}
	}

	$item['articul'] = addslashes($item['articul']);

	//

	$item['label'] = '';

	if (isset($_REQUEST['label'])) {

		$item['label'] = $_REQUEST['label'];

	} else {

		if (isset($request->params->label)) {

			$item['label'] = $request->params->label;

		}
	}

	$item['label'] = addslashes($item['label']);

	//

	$item['id_brand'] = 0;

	if (isset($_REQUEST['id_brand'])) {

		$item['id_brand'] = $_REQUEST['id_brand'];

	} else {

		if (isset($request->params->id_brand)) {

			$item['id_brand'] = $request->params->id_brand;

		}
	}

	//

	$item['id_category'] = 0;

	if (isset($_REQUEST['id_category'])) {

		$item['id_category'] = $_REQUEST['id_category'];

	} else {

		if (isset($request->params->id_category)) {

			$item['id_category'] = $request->params->id_category;

		}
	}

	//

	$item['price'] = 0;

	if (isset($_REQUEST['price'])) {

		$item['price'] = $_REQUEST['price'];

	} else {

		if (isset($request->params->price)) {

			$item['price'] = $request->params->price;

		}
	}

	//

	$item['overview'] = '';

	if (isset($_REQUEST['overview'])) {

		$item['overview'] = $_REQUEST['overview'];

	} else {

		if (isset($request->params->overview)) {

			$item['overview'] = $request->params->overview;

		}
	}

	$item['overview'] = addslashes($item['overview']);

	//

	$item['description'] = '';

	if (isset($_REQUEST['description'])) {

		$item['description'] = $_REQUEST['description'];

	} else {

		if (isset($request->params->description)) {

			$item['description'] = $request->params->description;

		}
	}

	$item['description'] = addslashes($item['description']);	

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
		'products',
		array( $item ),
		array( 'articul', 'label', 'id_brand', 'id_category', 'price', 'overview', 'description', 'dt' )
	);

	echo json_encode(Array(
		"success" => "true"
	));

?>