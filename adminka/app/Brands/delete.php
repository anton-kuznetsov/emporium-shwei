<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'ids', 'type' => 'string', 'default' => '-1' ),
		),
		$request
	);

	//

	$dalc = new DALC();

	$dalc->SQL_DeleteItems(
		'brands',
		' id IN (' . $item['ids'] . ') '
	);

	echo json_encode(array(
		"success" => "true"
	));

?>