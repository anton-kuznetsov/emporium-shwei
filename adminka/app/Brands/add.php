<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'label',       'type' => 'string' ),
			array( 'name' => 'company',     'type' => 'string' ),
			array( 'name' => 'country',     'type' => 'string' ),
			array( 'name' => 'site',        'type' => 'string' ),
			array( 'name' => 'description', 'type' => 'string' ),
		),
		$request
	);

	//

	$dalc = new DALC();

	$brand = $dalc->SQL_CreateItem(
		'brands',
		array(
			'label'       => $item['label'],
			'company'     => $item['company'],
			'country'     => $item['country'],
			'site'        => $item['site'],
			'description' => $item['description']
		)
	);

	//

	if ( $brand ) {

		echo json_encode(array(
			"success" => "true",
			"id"      => $brand["id"]
		));

	} else {

		echo json_encode(array(
			"success" => "false",
			"msg"     => ""
		));

	}

?>